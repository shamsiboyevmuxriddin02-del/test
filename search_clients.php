<?php
require './db/db_con.php'; // PDO ulanish (sizda allaqachon mavjud)
require './auth/auth_check.php';
$q = $_GET['q'] ?? '';
$stmt = $pdo->prepare("SELECT id, name, phone, address FROM clients WHERE name LIKE :q OR phone LIKE :q LIMIT 10");
$stmt->execute(['q' => "%$q%"]);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($clients);
