<?php
header('Content-Type: application/json');

// Ma'lumotlar bazasiga ulanish
require './db/db_con.php';
require './auth/auth_check.php';
$response = ['success' => false, 'message' => 'Xatolik yuz berdi'];

try {
    // Jami Ijaralar
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM rentals");
    $total_rentals = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Ochiq Ijaralar
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM rentals WHERE status IN ('Yangi','Muddati o‘tgan','Qisman qaytarildi')");
    $open_rentals = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Yakunlangan Ijaralar
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM rentals WHERE status = 'Qaytarildi'");
    $completed_rentals = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Umumiy Daromad
    $stmt = $pdo->query("SELECT SUM(total_amount) as total FROM rentals");
    $total_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Bugungi Daromad
    $stmt = $pdo->prepare("SELECT SUM(total_amount) as total FROM rentals WHERE status = 'Qaytarildi' AND DATE(end_time) = CURDATE()");
    $stmt->execute();
    $today_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // So‘nggi 5 Ijara
    // $stmt = $pdo->query("SELECT id, client_id, status, total_amount FROM rentals ORDER BY created_at DESC LIMIT 5");
    // $recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("
        SELECT r.id, c.name, r.status, r.total_amount 
        FROM rentals r 
        JOIN clients c ON r.client_id = c.id 
        ORDER BY r.created_at DESC 
        LIMIT 5
    ");
    $stmt->execute();
    $recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Eng Ko‘p Ijaraga Olingan Jihozlar (Top 5)
    $stmt = $pdo->query("
        SELECT e.name, SUM(ri.quantity) as total_quantity, SUM(ri.quantity * ri.daily_price) as total_revenue
        FROM rental_items ri
        JOIN equipment e ON ri.product_id = e.id
        GROUP BY ri.product_id, e.name
        ORDER BY total_quantity DESC
        LIMIT 5
    ");
    $top_equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['stats'] = [
        'total_rentals' => $total_rentals,
        'open_rentals' => $open_rentals,
        'completed_rentals' => $completed_rentals,
        'total_revenue' => number_format($total_revenue, 0, '.', ''),
        'today_revenue' => number_format($today_revenue, 0, '.', '')
    ];
    $response['recent_rentals'] = $recent_rentals;
    $response['top_equipment'] = $top_equipment;
} catch (Exception $e) {
    $response['message'] = 'Xatolik: ' . $e->getMessage();
}

echo json_encode($response);
?>