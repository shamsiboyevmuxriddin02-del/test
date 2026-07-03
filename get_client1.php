<?php
header('Content-Type: application/json');

require './db/db_con.php';
require './auth/auth_check.php';
$response = ['success' => false, 'message' => 'Xatolik yuz berdi'];

try {
    // Parametrlarni olish va butun songa aylantirish
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['per_page']) ? intval($_GET['per_page']) : 15;
    $searchQuery = isset($_GET['query']) ? '%' . $_GET['query'] . '%' : '%';

    // Pagination uchun offset hisoblash
    $offset = ($page - 1) * $perPage;

    // Umumiy mijozlar sonini hisoblash
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM clients WHERE name LIKE ? OR phone LIKE ?");
    $stmt->execute([$searchQuery, $searchQuery]);
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Mijozlar ro‘yxatini olish
    $stmt = $pdo->prepare("
        SELECT id, name, phone, image, address, passport, created_at, note 
        FROM clients 
        WHERE name LIKE ? OR phone LIKE ? 
        ORDER BY created_at DESC 
        LIMIT ? OFFSET ?
    ");
    // Parametrlarni aniq bog‘lash
    $stmt->bindParam(1, $searchQuery, PDO::PARAM_STR);
    $stmt->bindParam(2, $searchQuery, PDO::PARAM_STR);
    $stmt->bindParam(3, $perPage, PDO::PARAM_INT);
    $stmt->bindParam(4, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['clients'] = $clients;
    $response['total'] = $total;
} catch (Exception $e) {
    $response['message'] = 'Xatolik: ' . $e->getMessage();
}

echo json_encode($response);
?>