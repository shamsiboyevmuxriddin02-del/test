<?php
// =====================================================
//  KROY yozuvini yangilash (rasm ixtiyoriy)
// =====================================================

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

$response = ['status' => 'error', 'message' => 'Xatolik yuz berdi'];

try {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID notogri']);
        exit;
    }

    // Eski yozuvni olish (rasm nomi uchun)
    $old = $pdo->prepare("SELECT * FROM cutting_products WHERE id = :id AND is_delete = 0");
    $old->execute([':id' => $id]);
    $old_row = $old->fetch(PDO::FETCH_ASSOC);
    if (!$old_row) {
        echo json_encode(['status' => 'error', 'message' => 'Yozuv topilmadi']);
        exit;
    }

    $kroy_number  = trim($_POST['kroy_number']  ?? '');
    $layer_length = $_POST['layer_length'] !== '' ? (float)$_POST['layer_length'] : null;
    $layer_count  = $_POST['layer_count']  !== '' ? (int)$_POST['layer_count']    : null;
    $composition  = trim($_POST['composition']  ?? '');
    $percentage   = trim($_POST['percentage']   ?? '');
    $gramm        = $_POST['gramm']  !== '' ? (int)$_POST['gramm'] : null;
    $width        = $_POST['width']  !== '' ? (int)$_POST['width'] : null;
    $model_name   = trim($_POST['model_name'] ?? '');
    $sizes        = trim($_POST['sizes'] ?? '');
    $quantity     = $_POST['quantity'] !== '' ? (int)$_POST['quantity'] : null;
    $cut_date     = trim($_POST['date'] ?? date('Y-m-d'));

    if ($kroy_number === '') {
        echo json_encode(['status' => 'error', 'message' => 'Kroy raqamini kiriting']);
        exit;
    }

    // --- Yangi rasm yuklangan bo'lsa ---
    $image_name = $old_row['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Rasm formati notogri']);
            exit;
        }
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

        // Eski rasmni o'chirish
        if (!empty($old_row['image']) && file_exists($upload_dir . $old_row['image'])) {
            @unlink($upload_dir . $old_row['image']);
        }
    }

    $sql = "UPDATE cutting_products SET
                kroy_number  = :kroy_number,
                layer_length = :layer_length,
                layer_count  = :layer_count,
                composition  = :composition,
                percentage   = :percentage,
                gramm        = :gramm,
                width        = :width,
                model_name   = :model_name,
                sizes        = :sizes,
                quantity     = :quantity,
                image        = :image,
                cut_date     = :cut_date
            WHERE id = :id";

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
        ':id'           => $id,
    ]);

    $response = ['status' => 'success', 'message' => 'Kroy muvaffaqiyatli yangilandi'];

} catch (Throwable $e) {
    $response = ['status' => 'error', 'message' => 'Xatolik: ' . $e->getMessage()];
}

echo json_encode($response);
