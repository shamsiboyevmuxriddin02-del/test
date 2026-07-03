<?php
// =====================================================
//  KROY mahsulotini kiritish (saqlash)
//  Modal formadan FormData qabul qiladi, rasmni yuklaydi
//  va cutting_products jadvaliga yozadi.
// =====================================================

// Warning/notice'lar JSON javobni buzmasligi uchun ekranga chiqarilmaydi,
// lekin log faylga yoziladi (xatolarni diagnostika qilish uchun).
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

$response = ['status' => 'error', 'message' => 'Xatolik yuz berdi'];

try {
    // --- Forma qiymatlarini olish (?? bilan undefined key warning oldini olamiz) ---
    $kroy_number  = trim($_POST['kroy_number'] ?? '');
    $layer_length = ($_POST['layer_length'] ?? '') !== '' ? (float)$_POST['layer_length'] : null;
    $layer_count  = ($_POST['layer_count']  ?? '') !== '' ? (int)$_POST['layer_count']    : null;
    $composition  = trim($_POST['composition'] ?? '');
    $percentage   = trim($_POST['percentage']  ?? '');
    $gramm        = ($_POST['gramm'] ?? '') !== '' ? (int)$_POST['gramm'] : null;
    $width        = ($_POST['width'] ?? '') !== '' ? (int)$_POST['width'] : null;
    $model_name   = trim($_POST['model_name'] ?? '');
    $sizes        = trim($_POST['sizes'] ?? '');
    $quantity     = ($_POST['quantity'] ?? '') !== '' ? (int)$_POST['quantity'] : null;
    $cut_date     = trim($_POST['date'] ?? date('Y-m-d'));

    // --- Oddiy validatsiya ---
    if ($kroy_number === '') {
        echo json_encode(['status' => 'error', 'message' => 'Kroy raqamini kiriting']);
        exit;
    }
    if ($model_name === '') {
        echo json_encode(['status' => 'error', 'message' => 'Model nomini kiriting']);
        exit;
    }

    // --- Rasm yuklash (ixtiyoriy) ---
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Rasm formati notogri (jpg, png, webp)']);
            exit;
        }

        // Hajm cheklovi: 5 MB
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Rasm hajmi 5 MB dan oshmasligi kerak']);
            exit;
        }

        $upload_dir = "../../uploads/cutting/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name = "kroy_" . time() . "_" . mt_rand(1000, 9999) . "." . $ext;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Rasmni yuklashda xatolik']);
            exit;
        }
    }

    // --- Bazaga yozish (prepared statement) ---
    $sql = "INSERT INTO cutting_products
                (kroy_number, layer_length, layer_count, composition, percentage,
                 gramm, width, model_name, sizes, quantity, image, cut_date)
            VALUES
                (:kroy_number, :layer_length, :layer_count, :composition, :percentage,
                 :gramm, :width, :model_name, :sizes, :quantity, :image, :cut_date)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':kroy_number'  => $kroy_number,
        ':layer_length' => $layer_length,
        ':layer_count'  => $layer_count,
        ':composition'  => $composition,
        ':percentage'   => $percentage,
        ':gramm'        => $gramm,
        ':width'        => $width,
        ':model_name'   => $model_name,
        ':sizes'        => $sizes,
        ':quantity'     => $quantity,
        ':image'        => $image_name,
        ':cut_date'     => $cut_date,
    ]);

    $response = ['status' => 'success', 'message' => 'Kroy muvaffaqiyatli saqlandi'];

} catch (Throwable $e) {
    $response = ['status' => 'error', 'message' => 'Xatolik: ' . $e->getMessage()];
}

echo json_encode($response);
