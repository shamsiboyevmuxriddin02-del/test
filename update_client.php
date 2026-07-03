<?php
require './db/db_con.php';
require './auth/auth_check.php';
// $id = $_POST['id'];
// $name = $_POST['name'];
// $phone = $_POST['phone'];
// $address = $_POST['address'];
// $passport = $_POST['passport'];
// $note = $_POST['note'];

// $stmt = $pdo->prepare("UPDATE clients SET name=?, phone=?, address=?, passport=?, note=? WHERE id=?");
// $stmt->execute([$name, $phone, $address, $passport, $note, $id]);

// echo "✅ Ma'lumotlar yangilandi!";


$id = $_POST['id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$passport = $_POST['passport'];
$note = $_POST['note'];

// Asosiy ma'lumotlarni yangilash
$stmt = $pdo->prepare("UPDATE clients SET name=?, phone=?, address=?, passport=?, note=? WHERE id=?");
$stmt->execute([$name, $phone, $address, $passport, $note, $id]);

// Agar rasm tanlangan bo‘lsa
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "./uploads/";
        $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
    
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $imagePath = 'uploads/' . $fileName;
        }
    }

    // Eski rasmni o‘chirish (ixtiyoriy)
    $stmt = $pdo->prepare("SELECT image FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $oldImage = $stmt->fetchColumn();

    if ($oldImage && file_exists('uploads/' . $oldImage)) {
        unlink('uploads/' . $oldImage);
    }

    // Yangi rasm nomini bazaga yozish
    $stmt = $pdo->prepare("UPDATE clients SET image = ? WHERE id = ?");
    $stmt->execute([$imagePath, $id]);
}

echo "✅ Ma'lumotlar yangilandi!";
