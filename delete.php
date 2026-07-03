<?php
require './db/db_con.php';
require './auth/auth_check.php';
header('Content-Type: application/json');
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM equipment WHERE id = ?");
    $success = $stmt->execute([$id]);

    echo "✅ Ma'lumot o‘chirildi!";
}




if (isset($_POST['id_client'])) {
    $id = $_POST['id_client'] ?? 0;

    $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->execute([$id]);

    echo "✅ Mijoz o‘chirildi!";
}
