<?php
// =====================================================
//  KROY diagnostika fayli
//  Brauzerda oching: .../api/cutting/test_connection.php
//  Muammoni topgach, bu faylni o'chirib tashlang.
// =====================================================

error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/plain; charset=utf-8');

echo "===== KROY DIAGNOSTIKA =====\n\n";

// 1. db_con.php faylini tekshirish
$db_path = "../../db/db_con.php";
echo "1) db_con.php yo'li: " . realpath($db_path) . "\n";
if (!file_exists($db_path)) {
    echo "   ❌ XATO: db_con.php topilmadi! Yo'l noto'g'ri.\n";
    echo "   >>> api/cutting/ papkasidan db/ gacha yo'lni tekshiring.\n";
    exit;
}
echo "   ✅ db_con.php topildi\n\n";

require_once $db_path;

// 2. PDO ulanishni tekshirish
echo "2) Ma'lumotlar bazasi ulanishi:\n";
if (!isset($pdo)) {
    echo "   ❌ XATO: \$pdo o'zgaruvchisi mavjud emas.\n";
    echo "   >>> db_con.php ichida ulanish \$pdo nomida bo'lishi kerak.\n";
    exit;
}
try {
    $pdo->query("SELECT 1");
    echo "   ✅ Bazaga ulanish muvaffaqiyatli\n\n";
} catch (Throwable $e) {
    echo "   ❌ ULANISH XATOSI: " . $e->getMessage() . "\n";
    exit;
}

// 3. cutting_products jadvali mavjudligini tekshirish
echo "3) cutting_products jadvali:\n";
try {
    $exists = $pdo->query("SHOW TABLES LIKE 'cutting_products'")->fetch();
    if (!$exists) {
        echo "   ❌ XATO: cutting_products jadvali mavjud emas!\n";
        echo "   >>> cutting_table.sql faylini phpMyAdmin orqali import qiling.\n";
        exit;
    }
    echo "   ✅ Jadval mavjud\n\n";

    // Ustunlarni ko'rsatish
    echo "   Ustunlar:\n";
    $cols = $pdo->query("SHOW COLUMNS FROM cutting_products")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $c) {
        echo "     - " . $c['Field'] . " (" . $c['Type'] . ")\n";
    }
    echo "\n";

    // Yozuvlar soni
    $count = $pdo->query("SELECT COUNT(*) FROM cutting_products")->fetchColumn();
    echo "   Jadvaldagi yozuvlar soni: " . $count . "\n\n";

} catch (Throwable $e) {
    echo "   ❌ XATO: " . $e->getMessage() . "\n";
    exit;
}

// 4. Sinov yozuvini qo'shib ko'rish
echo "4) Sinov yozuvini qo'shish (INSERT test):\n";
try {
    $stmt = $pdo->prepare("
        INSERT INTO cutting_products
            (kroy_number, layer_length, layer_count, composition, percentage,
             gramm, width, model_name, sizes, quantity, image, cut_date)
        VALUES
            ('TEST-DELETE', 10.5, 5, 'Cotton 100%', '100', 180, 150,
             'TEST MODEL', 'S,M,L', 20, NULL, CURDATE())
    ");
    $stmt->execute();
    $new_id = $pdo->lastInsertId();
    echo "   ✅ Sinov yozuvi qo'shildi (id = $new_id)\n";

    // O'chirib qo'yamiz (test yozuvi bazada qolmasin)
    $pdo->prepare("DELETE FROM cutting_products WHERE id = ?")->execute([$new_id]);
    echo "   ✅ Sinov yozuvi o'chirildi (baza toza qoldi)\n\n";

    echo "===== NATIJA: HAMMASI ISHLAYAPTI =====\n";
    echo "Baza va jadval to'g'ri. Agar modal orqali saqlanmayotgan bo'lsa,\n";
    echo "muammo frontend (kroy.php) tomonida — brauzer Network (F12) ni tekshiring.\n";

} catch (Throwable $e) {
    echo "   ❌ INSERT XATOSI: " . $e->getMessage() . "\n";
    echo "   >>> Jadval ustunlari SQL bilan mos kelmayapti.\n";
}
