<?php
header('Content-Type: application/json'); // JSON formatida javob qaytarish
require './auth/auth_check.php';
require './db/db_con.php';
date_default_timezone_set("Asia/Tashkent");
$rental_id = isset($_GET['rental_id']) ? (int)$_GET['rental_id'] : 0;
$response = ['success' => false, 'html' => ''];

try {
    if ($rental_id <= 0) {
        throw new Exception('Ijara ID kiritilmadi');
    }

    // Ma'lumotlarni olish
    $stmt = $pdo->prepare(
        "SELECT 
            r.id,
            c.name AS client_name,
            c.phone AS client_phone,
            r.total_amount,
            r.advance_amount,
            r.start_time,
            r.end_time,
            r.overdue_days,
            r.overdue_amount,
            (r.total_amount + r.overdue_amount) AS total_sum,
            r.note,
            r.status
         FROM rentals r
         JOIN clients c ON r.client_id = c.id
         WHERE r.id = ?"
    );
    $stmt->execute([$rental_id]);
    $rental = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rental) {
        throw new Exception('Ijara topilmadi');
    }

    $stmt = $pdo->prepare(
        "SELECT 
            e.name AS equipment_name,
            e.type AS equipment_type,
            e.body_price AS unit_price, -- Tan narxi
            ri.quantity AS rented_quantity,
            ri.created_at AS rented_date,
            CASE 
                WHEN e.price_type = 'kunlik' THEN e.price_day
                WHEN e.price_type = 'soatlik' THEN e.price
                ELSE 0
            END AS daily_rent_price,
            e.price_type
        FROM rental_items ri
        JOIN equipment e ON ri.product_id = e.id
        WHERE ri.rental_id = ?"
    );
    $stmt->execute([$rental_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $start_time = new DateTime($rental['start_time']);
    $end_time = $rental['end_time'] ? new DateTime($rental['end_time']) : null;
    $hours = $end_time ? $start_time->diff($end_time)->h + ($start_time->diff($end_time)->days * 24) : 'Ochiq';
    $total_rented_quantity = 0;
    $total_unit_price = 0;
    $total_rent_price = 0;

    foreach ($items as $item) {
        $unit_price = (float) $item['unit_price'];
        $quantity = (int) $item['rented_quantity'];
        $daily_price = (float) $item['daily_rent_price'];
        $price_type = $item['price_type'];

        // Jami tan narx
        $total_unit_price += $unit_price * $quantity;

        // Jami miqdor
        $total_rented_quantity += $quantity;

        // Jami ijara narxi (kunlik yoki soatlik)
        if ($price_type === 'kunlik') {
            $total_rent_price += $daily_price * $quantity;
        } elseif ($price_type === 'soatlik') {
            $total_rent_price += ($daily_price * 24) * $quantity;
        }
    }

    // HTML shablonini yaratish
    $html = '
        <p class="text-center h4">Ijara Cheki №' . $rental['id'] . '</p>
        <p><strong>Mijoz Ismi:</strong> ' . htmlspecialchars($rental['client_name']) . '</p>
        <p><strong>Telefon:</strong> ' . htmlspecialchars($rental['client_phone']) . '</p>
        <p><strong>Ijara ID:</strong> ' . $rental['id'] . '</p>
        <p><strong>Status:</strong> ' . $rental['status'] . '</p>
        <p><strong>Boshlanish vaqti:</strong> ' . $rental['start_time'] . '</p>
        <p><strong>Tugash vaqti:</strong> ' . ($rental['end_time'] ? : 'Ochiq') . '</p>
        <p><strong>Umumiy summa:</strong> ' . number_format($rental['total_amount'], 0, '.', ' ') . ' so‘m</p>
        <p><strong>Avans:</strong> ' . number_format($rental['advance_amount'], 0, '.', ' ') . ' so‘m</p>
        <p><strong>Chek vaqti: </strong>'. date("Y-m-d H:i:s") .' </p>
         </br>
        <h5>Jihozlar</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jihoz nomi</th>
                    <th>Turi</th>
                    <th>Soni</th>
                    <th>Tan narxi</th>
                    <th>Kunlik ijara narxi</th>
                    <th>Sana</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($items as $item) {
        $html .= '
            <tr>
                <td>' . htmlspecialchars($item['equipment_name']) . '</td>
                <td style="text-align: center;">' . $item['equipment_type'] . '</td>
                <td style="text-align: center;">' . $item['rented_quantity'] . '</td>
                <td style="text-align: center;">' . $item['unit_price'] . '</td>
                <td style="text-align: right;">' . number_format($item['daily_rent_price'], 0, '.', ' ') . ' so‘m ' . $item['price_type'] . '</td>
                <td style="text-align: right;"> '. $item['rented_date']  .'</td>
            </tr>
            ';
    }
    $html .= '
                <tr>
                    <td style="font-weight:bold" colspan="2">Jami: </td>
                    <td style="text-align: right;font-weight:bold">'. number_format($total_rented_quantity, 0, '.', ' ')  .' ta</td>
                    <td style="text-align: right;font-weight:bold"> '. number_format($total_unit_price, 0, '.', ' ')  .' so‘m</td>
                    <td style="text-align: right;font-weight:bold"> '. number_format($total_rent_price, 0, '.', ' ')  .' so‘m</td>
                </tr>
            </tbody>
        </table>';

    $response['success'] = true;
    $response['html'] = $html;

} catch (Exception $e) {
    $response['html'] = 'Xatolik: ' . $e->getMessage();
}

echo json_encode($response);
?>