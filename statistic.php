<?php
header('Content-Type: application/json');
require './db/db_con.php';
require './auth/auth_check.php';
// Jami ijaralar
function getTotalRentalsCount($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM rentals");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Faol ijaralar
function getActiveRentalsCount($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rentals WHERE status != :status");
        $stmt->execute(['status' => 'Qaytarildi']);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

//  Bugun tugaydigan faol ijaralar soni funksiyasi
function getTodayEndingRentalsCount($pdo) {
    try {
        $today = date('Y-m-d'); // Bugungi sana (format: 2025-05-07)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rentals WHERE DATE(end_time) = :today AND status != :status");
        $stmt->execute([
            'today' => $today,
            'status' => 'Qaytarildi'
        ]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Jami mijozlar soni funksiyasi
function getTotalClientsCount($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM clients");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Jami jihozlar soni funksiyasi:
function getTotalEquipmentsCount($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM equipment");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Bugun yaratilgan ijaralar soni
function getTodayActiveRentalsCount($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rentals WHERE DATE(start_time) = CURDATE()");
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Bugun ro‘yxatdan o‘tgan mijozlar soni
function getTodayNewClientsCount($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE DATE(created_at) = CURDATE()");
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}

// Bugun yaratilgan yoki yangilangan ijaralardagi avanslar jami
function getTodayAdvanceAmountSum($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT SUM(advance_amount) FROM rentals WHERE DATE(created_at) = CURDATE() OR DATE(updated_at) = CURDATE()");
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}


// Bugun yopilgan ijaralar soni
function getTodayClosedRentalsCount($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM rentals WHERE status = :status AND DATE(updated_at) = CURDATE()");
        $stmt->execute(['status' => 'Qaytarildi']);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}


// Bugun qaytarilmagan ijaralar soni
// function getTodayOverdueRentalsCount($pdo) {
//     try {
//         $stmt = $pdo->prepare("
//             SELECT COUNT(*) 
//             FROM rentals 
//             WHERE DATE(end_date) = CURDATE() 
//             AND status != :status
//         ");
//         $stmt->execute(['status' => 'Qaytarildi']);
//         return $stmt->fetchColumn();
//     } catch (PDOException $e) {
//         echo "Xatolik: " . $e->getMessage();
//         return 0;
//     }
// }

function getTodayOverdueRentalsCount($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM rentals 
            WHERE DATE(end_time) = CURDATE() 
            AND end_time <= NOW() 
            AND status != :status
        ");
        $stmt->execute(['status' => 'Qaytarildi']);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Xatolik: " . $e->getMessage();
        return 0;
    }
}