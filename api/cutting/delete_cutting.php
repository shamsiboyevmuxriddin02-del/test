<?php
// =====================================================
//  KROY yozuvini o'chirish (soft delete: is_delete = 1)
// =====================================================

header('Content-Type: application/json; charset=utf-8');

require_once "../../db/db_con.php";
require_once "../../auth/auth_check.php";

try {
    // ID GET yoki POST orqali kelishi mumkin
    $id = 0;
    if (isset($_POST['id'])) {
        $id = (int)$_POST['id'];
    } elseif (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
    }

    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID notogri']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE cutting_products SET is_delete = 1 WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Kroy ochirildi']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Yozuv topilmadi']);
    }

} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
