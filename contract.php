<?php
date_default_timezone_set("Asia/Tashkent");
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
    <link rel="stylesheet" href="./assets/home.css">
    <style>
        <?php
            require './assets/home.css';
        ?> 
    </style>
</head>
<body>
<div class="content_header">
    <h4 class="text-center p-0 m-0">Merganteks</h4>
    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">+ Yangi mijoz</button> -->
</div>
<div class="container mt-5 bg_white ">
        <h4 class="mb-4">Shartnoma yaratish</h4>
        <form action="generate_contract.php" method="post">
             <!-- Mijoz qidirish -->
            <div class="row mt-3">
                <div class="col-3">
                    <label class="fw-bold">Mijoz:</label> <br>
                    <input type="text" class="form-control" id="clientSearch" name="client_name" autocomplete="off" placeholder="">
                    <ul id="clientSuggestions" class="list-group position-absolute z-3"></ul>
                    <!-- <input type="hidden" name="client_id" id="clientId"> -->
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Umumiy summasi:</label> <br>
                    <input type="text" class="form-control" name="total_sum" autocomplete="off" placeholder="" >
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Tashkilot rahbari:</label> <br>
                    <input type="text" class="form-control" name="leader_name" autocomplete="off" value="Nazarov Nodir Nemat O'g'li" >
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label class="fw-bold">Passpurt :</label> <br>
                    <input type="text" class="form-control" name="client_paspurt" autocomplete="off" placeholder="" >
                </div>
                <div class="col-1">

                </div>
                <div class="col-3">
                    <label class="fw-bold">Jihozlar sutkalik narxi:</label> <br>
                    <input type="text" class="form-control" name="days_sum" autocomplete="off" placeholder="" >
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Tashkilot raqami:</label> <br>
                    <input type="text" class="form-control" name="firm_tel" autocomplete="off" value="+99891-408-08-91" >
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label class="fw-bold">Telefon raqam:</label> <br>
                    <input type="text" class="form-control" name="client_tel" autocomplete="off" placeholder="" >
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Shartnoma sanasi:</label> <br>
                    <input type="datetime-local" class="form-control" name="contract_date" id="timeInput">
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Tashkilot manzili:</label> <br>
                    <input type="text" class="form-control" name="firm_adress" autocomplete="off" value="Qorako'l tumani " >
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label class="fw-bold">Mijoz manzili:</label> <br>
                    <input type="text" class="form-control" name="client_adress" autocomplete="off" placeholder="" >
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label class="fw-bold">Shartnoma tuzish joyi:</label> <br>
                    <input type="text" class="form-control" name="contract_adress" autocomplete="off" value="Qorako'l tumani" >
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col-3">
                    <label for="" class="text-light">.</label> <br>
                    <input type="submit" class="btn btn-add-device w-100" value="Shartnomani yaratish">
                </div>
            </div>
            
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('clientSearch').addEventListener('input', function () {
            let query = this.value;
            if (query.length >= 2) {
                fetch('./search_clients.php?q=' + query)
                    .then(res => res.json())
                    .then(data => {
                        let ul = document.getElementById('clientSuggestions');
                        ul.innerHTML = '';
                        data.forEach(client => {
                            let li = document.createElement('li');
                            li.className = 'list-group-item list-group-item-action';
                            li.textContent = client.name;
                            li.dataset.id = client.id;
                            ul.appendChild(li);
                        });
                    });
            }
        });

        document.getElementById('clientSuggestions').addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                document.getElementById('clientSearch').value = e.target.textContent;
                // document.getElementById('clientId').value = e.target.dataset.id;
                this.innerHTML = '';
            }
        });


        // Hozirgi vaqtni qo‘yish:
        window.addEventListener('DOMContentLoaded', function () {
            const now = new Date();

            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // 0-based
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const formatted = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('timeInput').value = formatted;
        });
    </script>
</body>
</html>
