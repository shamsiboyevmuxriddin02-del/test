<?php
// require './db/db_con.php';

// $id = $_GET['id'];
// $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
// $stmt->execute([$id]);

// echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));

require_once "./db/db_con.php";
require './auth/auth_check.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($client);
}
?>
