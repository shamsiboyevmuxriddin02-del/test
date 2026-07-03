<?php
require './db/db_con.php';

$stmt = $pdo->query("SELECT * FROM equipment ORDER BY id DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Kategoriya</th>
            <th>Nomi</th>
            <th>Turi</th>
            <th>Holati</th>
            <th>Narx</th>
            <th>Narx turi</th>
            <th>Izoh</th>
            <th>Qo‘shilgan</th>
            <th>Amallar</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($items) > 0): $i = 1; ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($item['category']) ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['type']) ?></td>
                    <td><?= $item['status'] ?></td>
                    <td><?= $item['price'] ?> so‘m</td>
                    <td><?= $item['price_type'] ?></td>
                    <td><?= htmlspecialchars($item['note']) ?></td>
                    <td><?= date("d.m.Y", strtotime($item['created_at'])) ?></td>
                    <td>
                        <button class="btn btn-sm btn-update btnEdit mx-1" data-id="<?= $item['id'] ?>"><i class="bi bi-pencil-square editBtn"></i></button>
                        <button class="btn btn-sm btn-delete btnDelete" data-id="<?= $item['id'] ?>"><i class="bi bi-trash3-fill deleteBtn"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11" class="text-center">Ma'lumot topilmadi</td></tr>
        <?php endif; ?>
    </tbody>
</table>
