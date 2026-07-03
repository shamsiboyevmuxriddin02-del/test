<?php
// =====================================================
//  Bitta KROY yozuvini olish (tahrirlash uchun)
// =====================================================

header('Content-Type: application/json; charset=utf-8');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

try {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID notogri']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM cutting_products WHERE id = :id AND is_delete = 0");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'Yozuv topilmadi']);
        exit;
    }

    echo json_encode(['status' => 'success', 'data' => $row]);

} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
