<?php
// =====================================================
//  KROY bo'limi statistikasi (KPI kartalar + trend chart)
// =====================================================

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

$response = ['status' => 'error', 'message' => 'Xatolik yuz berdi'];

try {
    // --- 1. Oxirgi oyda (30 kun) kesilgan kroylar soni ---
    $kroy_month = (int)$pdo->query("
        SELECT COUNT(*)
        FROM cutting_products
        WHERE is_delete = 0
          AND cut_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ")->fetchColumn();

    // --- 2. Oxirgi oyda ishlab chiqarilgan modellar (quantity yig'indisi) ---
    $models_month = (int)$pdo->query("
        SELECT COALESCE(SUM(quantity), 0)
        FROM cutting_products
        WHERE is_delete = 0
          AND cut_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ")->fetchColumn();

    // --- 3. Oxirgi oyda sarflangan mato (metr) = layer_length * layer_count ---
    $fabric_month = (float)$pdo->query("
        SELECT COALESCE(SUM(layer_length * layer_count), 0)
        FROM cutting_products
        WHERE is_delete = 0
          AND cut_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ")->fetchColumn();

    // --- 4. Eng ko'p kesilgan model (barcha vaqt bo'yicha) ---
    $top = $pdo->query("
        SELECT model_name, SUM(quantity) AS total
        FROM cutting_products
        WHERE is_delete = 0 AND model_name IS NOT NULL AND model_name <> ''
        GROUP BY model_name
        ORDER BY total DESC
        LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    $top_model = $top ? $top['model_name'] : '-';
    $top_model_qty = $top ? (int)$top['total'] : 0;

    // --- 5. Oxirgi 6 oy dinamikasi (trend chart) ---
    $trend_raw = $pdo->query("
        SELECT DATE_FORMAT(cut_date, '%Y-%m') AS ym,
               COUNT(*)               AS kroy_count,
               COALESCE(SUM(quantity), 0) AS models_count
        FROM cutting_products
        WHERE is_delete = 0
          AND cut_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY ym
        ORDER BY ym ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Oxirgi 6 oyni to'liq shakllantirish (bo'sh oylar 0 bilan)
    $months = [];
    for ($i = 5; $i >= 0; $i--) {
        $months[date('Y-m', strtotime("-$i month"))] = ['kroy' => 0, 'models' => 0];
    }
    foreach ($trend_raw as $t) {
        if (isset($months[$t['ym']])) {
            $months[$t['ym']]['kroy']   = (int)$t['kroy_count'];
            $months[$t['ym']]['models'] = (int)$t['models_count'];
        }
    }

    $uz_months = ['01'=>'Yan','02'=>'Fev','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Iyn',
                  '07'=>'Iyl','08'=>'Avg','09'=>'Sen','10'=>'Okt','11'=>'Noy','12'=>'Dek'];

    $labels = [];
    $kroy_series = [];
    $models_series = [];
    foreach ($months as $ym => $vals) {
        $m = substr($ym, 5, 2);
        $labels[]        = $uz_months[$m] ?? $ym;
        $kroy_series[]   = $vals['kroy'];
        $models_series[] = $vals['models'];
    }

    $response = [
        'status' => 'success',
        'kpi' => [
            'kroy_month'    => $kroy_month,
            'models_month'  => $models_month,
            'fabric_month'  => round($fabric_month, 2),
            'top_model'     => $top_model,
            'top_model_qty' => $top_model_qty,
        ],
        'trend' => [
            'labels' => $labels,
            'kroy'   => $kroy_series,
            'models' => $models_series,
        ],
    ];

} catch (Throwable $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
