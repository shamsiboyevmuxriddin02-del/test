<?php
require './statistic.php';
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
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        <?php
            require './assets/home.css';
        ?>  

        .card {
            border-radius: 16px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
        .card-title {
         font-weight: bold;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        .stat-icon {
            font-size: 2rem;
            padding: 10px;
            border-radius: 0.5rem;
            color: #fff;
        }

        <?php
            require './assets/mobile.css';
        ?> 
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="card_debtor_name h250">      
            <h1 class="fw-bold fs-5 d-flex justify-content-between">
                <span>Umumiy raqamlar</span>
            </h1>
            <hr>
            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-5 gap-6 px-2 py-3">
                <!-- Jami mijozlar -->
                <div class="bg-gradient-to-tr from-zinc-400 to-gray-600 text-white rounded-2xl p-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-wide font-semibold">Jami pryaja</div>
                    <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h3.5a.5.5 0 010 1H7a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1v-1.5a.5.5 0 011 0V18a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="mt-3 text-3xl font-bold">000</div>
                <div class="text-sm opacity-90 mt-2">Barcha buyurtmalar soni</div>
                </div>

                <!-- Faol ijaralar -->
                <div class="bg-gradient-to-tr from-gray-500 to-gray-700 text-white rounded-2xl p-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-wide font-semibold">Jami xom mato</div>
                    <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 17v-2a2 2 0 0 1 2-2h2m4 0h2a2 2 0 0 1 2 2v2m-4 4h2a2 2 0 0 0 2-2v-2m-6 6h-2a2 2 0 0 1-2-2v-2"/>
                    </svg>
                </div>
                <div class="mt-3 text-3xl font-bold">000</div>
                <div class="text-sm opacity-90 mt-2"> ta yangi buyurtma</div>
                </div>

                <!-- Tugaydigan ijaralar -->
                <div class="bg-gradient-to-tr from-zinc-400 to-zinc-600 text-white rounded-2xl p-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-wide font-semibold">Jami tayyor mato</div>
                    <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4m1 4a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="mt-3 text-3xl font-bold"> 000 </div>
                <div class="text-sm opacity-90 mt-2">....</div>
                </div>

                <!-- Tugaydigan ijaralar -->
                <div class="bg-gradient-to-tr from-sky-400 to-sky-700 text-white rounded-2xl p-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-wide font-semibold">Jami mijozlar</div>
                    <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m3-5a3 3 0 100-6 3 3 0 000 6zm6 3a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                </div>
                <div class="mt-3 text-3xl font-bold">00 </div>
                <div class="text-sm opacity-90 mt-2">Bugun 00 ta yangi mijoz</div>
                </div>

                <!-- Tugaydigan ijaralar -->
                <div class="bg-gradient-to-tr from-indigo-400 to-indigo-700 text-white rounded-2xl p-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm uppercase tracking-wide font-semibold">Jami mahsulot</div>
                    <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4a2 2 0 001-1.73z" />
                    </svg>
                </div>
                <div class="mt-3 text-3xl font-bold">00</div>
                <div class="text-sm opacity-90 mt-2">Mavjud mahsulotlar soni</div>
                </div>
            </div>
        </div>
    </div>




    <!-- <div class="container-fluid mt-4">
    <div class="card_debtor_name h200">      
        <h1 class="fw-bold fs-5 d-flex justify-content-between">
            <span>Bugun umumiy</span>
        </h1>
        <hr>
        <div class="row mt-4">
            <div class="col-3">
                <div class="d-flex justify-content-center align-items-center p-4  bg-opacity-15 rounded-3 bg-gradient-to-tr from-zinc-100 to-zinc-200" style="background-color:#f8f9fa;">
                    <span class="display-6 lh-1 mb-0 " style="color: #32746d"><i class="bi bi-code-square"></i></span>
                    <div class="ms-4 h6 fw-normal mb-0">
                        <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold " data-purecounter-start="0" data-purecounter-end="10" data-purecounter-delay="200" data-purecounter-duration="0">
                            00
                            </h5>
                            <span class="mb-0 h6">&nbsp; so'm </span>
                        </div>
                        <p class="mb-0 pb-2">Bugun tushim avans</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex justify-content-center align-items-center p-4 bg-blue bg-opacity-10 rounded-3 bg-gradient-to-tr from-zinc-100 to-zinc-200" style="background-color: #f8f9fa;">
                    <span class="display-6 lh-1 text-blue mb-0"><i class="bi bi-laptop"></i></span>
                    <div class="ms-4 h6 fw-normal mb-0">
                        <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="200" data-purecounter-delay="200" data-purecounter-duration="0">
                                00
                            </h5>
                            <span class=" h5"> ta</span>
                        </div>
                        <p class="mb-0">Bugun yopilgan ijaralar</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex justify-content-center align-items-center p-4  bg-opacity-10 rounded-3 bg-gradient-to-tr from-zinc-100 to-zinc-200" style="background-color: #f8f9fa;">
                    <span class="display-6 lh-1 text-purple mb-0" style="color: #7952B3"><i class="bi bi-type"></i></span>
                    <div class="ms-4 h6 fw-normal mb-0">
                        <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="60" data-purecounter-delay="200" data-purecounter-duration="0">
                            000
                            </h5>
                        </div>
                        <p class="mb-0"> Qarz</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex justify-content-center align-items-center p-4 rounded-3 bg-gradient-to-tr from-zinc-100 to-zinc-200" style="background-color: #f8f9fa;">
                    <span class="display-6 lh-1 text-info mb-0"><i class="bi bi-calculator-fill"></i></span>
                    <div class="ms-4 h6 fw-normal mb-0">
                        <div class="d-flex">
                            <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="6" data-purecounter-delay="300" data-purecounter-duration="0">
                            000
                            </h5>
                            <span class="mb-0 h5">ta</span>
                        </div>
                        <p class="mb-0">Muddati o'tgan ijaralar soni</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="container-fluid mt-4">
        <div class="card_debtor_name h450">      
            <h1 class="fw-bold fs-5 d-flex justify-content-between">
                <span>Top (5)</span>
            </h1>
            <hr>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">So‘nggi 5 ta buyurtma</div>
                        <div class="card-body">
                            <table class="table table-bordered" id="recentRentalsTable">
                                <thead>
                                    <tr>
                                        <th>Ijara ID</th>
                                        <th>Mijoz</th>
                                        <th>Status</th>
                                        <th>Umumiy Summa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Eng Ko‘p olingan buyurtmalar (Top 5)</div>
                        <div class="card-body">
                            <table class="table table-bordered" id="topEquipmentTable">
                                <thead>
                                    <tr>
                                        <th>Jihoz Nomi</th>
                                        <th>Miqdor</th>
                                        <th>Umumiy Daromad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


  
            <div class="row" id="statsSection">
                <!-- JavaScript orqali to‘ldiriladi -->
            </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>