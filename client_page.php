<?php
require './auth/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/home.css">
    <style>
        /* <?php
            require './assets/home.css';
        ?> */
        <?php
            require './assets/input.css';
        ?> 
    </style>
</head>
<body>
    <div class="content_header">
        <h4 class="text-center p-0 m-0">Merganteks</h4>
        <div class="search_box">
            <i class="bi bi-search mt-1"></i>
            <input type="text" id="searchInput" class="form-control mx-2" placeholder="Ism yoki telefon bo‘yicha qidirish...">
        </div>
        
        <div class="header-navbar d-flex">
            <button class="btn-header btn btn-add-device px-2">+ Yangi mijoz</button>
        </div>
    </div>
    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">+ Yangi mijoz</button> -->
    <div class="container mt-5">
    <h4 class="mb-4">Mijozlar ro'yxati</h4>
        <div class="modal fade " id="addClientModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="clientForm" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Yangi mijoz qo‘shish</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Ism</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rasm</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Manzil</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Passport</label>
                                <input type="text" name="passport" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Izoh</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Saqlash</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editClientModal" tabindex="-1" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editClientForm" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Mijozni tahrirlash</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">

                            <div class="mb-2">
                                <label>Ism</label>
                                <input type="text" class="form-control" name="name" id="edit_name">
                            </div>

                            <div class="mb-2">
                                <label>Telefon</label>
                                <input type="text" class="form-control" name="phone" id="edit_phone">
                            </div>

                            <div class="mb-2">
                                <label>Rasm</label>
                                <input type="file" class="form-control" name="image" id="edit_image">
                            </div>

                            <div class="mb-2">
                                <labesl>Manzil</label>
                                <input type="text" class="form-control" name="address" id="edit_address">
                            </div>

                            <div class="mb-2">
                                <label>Passport</label>
                                <input type="text" class="form-control" name="passport" id="edit_passport">
                            </div>

                            <div class="mb-2">
                                <label>Izoh</label>
                                <textarea class="form-control" name="note" id="edit_note"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="bi bi-clipboard-check-fill"></i>&ensp;Saqlash</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content_body1" id="content_body1">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Korxona nomi</th>
                        <th>Mijoz </th>
                        <th>Telefon</th>
                        <th>Manzil</th>
                        <th>Passport</th>
                        <th>Izoh</th>
                        <th>Sana</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody id="clientsTableBody">
                    
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pagination">
                            <!-- AJAX orqali to‘ldiriladi -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
    </div>
        
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        // $(document).on('click', '.btn-add-device', function () {
        //     new bootstrap.Modal(document.getElementById('addClientModal')).show();
        // });
        $(document).on('click', '.btn-add-device', function () {
            const modalEl = document.getElementById('addClientModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        $(document).on('click', '.btn-close', function () {
            const modalEl = document.getElementById('addClientModal');
            const modal = bootstrap.Modal.getInstance(modalEl); // Faqat mavjud modal
            if (modal) modal.hide();
        });

        if (!sessionStorage.getItem('reloaded')) {
            sessionStorage.setItem('reloaded', 'true');
            location.reload();
        }
        document.getElementById('clientForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('api/add_client.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                alert(data);
                form.reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById('addClientModal'));
                modal.hide();
                location.reload();
                // refresh client list if needed here
            })
            .catch(err => console.error('Xatolik:', err));
        });
        
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('editBtn')) {
                const id = e.target.dataset.id;
                fetch('./get_client.php?id=' + id)
                .then(res => res.json())
                .then(client => {
                    document.getElementById('edit_id').value = client.id;
                    document.getElementById('edit_name').value = client.name;
                    document.getElementById('edit_phone').value = client.phone;
                    document.getElementById('edit_address').value = client.address;
                    document.getElementById('edit_passport').value = client.passport;
                    document.getElementById('edit_note').value = client.note;

                    let modal = new bootstrap.Modal(document.getElementById('editClientModal'));
                    modal.show();
                });  
            }
        });
        

        // Qidiruv inputiga real-time event qo‘shish
        document.getElementById('searchInput').addEventListener('input', function() {
            if (this.value.length >= 2 || this.value.length === 0) {
                currentPage = 1; // Qidiruv boshlanganda sahifa 1 ga qaytadi
                fetchClients();
            }
        });
       

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('deleteBtn')) {
                const id = e.target.dataset.id;
                if (confirm("Haqiqatan ham o‘chirmoqchimisiz?")) {
                    fetch('./delete.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id_client=' + id
                    })
                    .then(res => res.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    });
                }
            }
        });


        document.getElementById('editClientForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('./update_client.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                let modal = bootstrap.Modal.getInstance(document.getElementById('editClientModal'));
                modal.hide();
                alert(data);
                location.reload(); // ro‘yxatni yangilash
            });
        });

        fetchClients();
        
         // faqat sahifa to‘liq yuklangandan so‘ng chaqiriladi
        
    </script>

</body>
</html>