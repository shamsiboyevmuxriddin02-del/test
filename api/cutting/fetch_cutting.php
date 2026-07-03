<?php
// =====================================================
//  KROY yozuvlarini jadval uchun chiqarish (DataTables)
// =====================================================

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

try {
    $stmt = $pdo->query("
        SELECT *
        FROM cutting_products
        WHERE is_delete = 0
        ORDER BY id DESC
    ");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sarflangan mato = qatlam uzunligi * qatlam soni
    foreach ($rows as &$r) {
        $r['fabric_used'] = round(((float)$r['layer_length']) * ((int)$r['layer_count']), 2);
    }

    echo json_encode(['data' => $rows]);

} catch (Throwable $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}
