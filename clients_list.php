<?php
require_once "./db/db_con.php";
$clients = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Rasm</th>
            <th>Ism</th>
            <th>Telefon</th>
            <th>Manzil</th>
            <th>Passport</th>
            <th>Izoh</th>
            <th>Sana</th>
            <th>Amallar</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($clients) > 0): $i = 1; ?>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    Merganteks
                </td>
                <td><?= htmlspecialchars($client['name']) ?></td>
                <td><?= htmlspecialchars($client['phone']) ?></td>
                <td><?= htmlspecialchars($client['address']) ?></td>
                <td><?= htmlspecialchars($client['passport']) ?></td>
                <td class="class_note"><?= htmlspecialchars($client['note']) ?></td>
                <td><?= date('d.m.Y', strtotime($client['created_at'])) ?></td>
                <td>
                    <button class="btn btn-sm btn-update editBtn mx-1" data-id="<?= $client['id'] ?>"><i class="bi bi-pencil-square editBtn"></i></button>
                    <button class="btn btn-sm btn-delete deleteBtn" data-id="<?= $client['id'] ?>"><i class="bi bi-trash3-fill deleteBtn"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11" class="text-center">Ma'lumot topilmadi</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center" id="pagination">
        <!-- AJAX orqali to‘ldiriladi -->
    </ul>
</nav>


            