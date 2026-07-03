<?php
    require 'auth/auth_check.php';
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        <?php
            require './assets/home.css';
            require './assets/input.css';
        ?>

        .content_menu li a.active {
            /* background-color: #0000002c;
            color: #fff;
            border-radius: 6px; */
        }

        .content_menu li a.active i {
            color: rgb(29, 135, 193);
        }

        /* Mobile: sidebar yashirish */
        @media (max-width: 768px) {
            .menu_box {
                position: fixed;
                top: 0;
                left: -100px; /* Boshlanishda yashirin */
                width: 100px;
                height: 100%;
                background-color: #061d33;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .menu_box.active {
                left: 0; /* ko‘rinadi */
            }

            .home_box .content {
                margin-left: 0; /* desktopdagi kabi emas */
                transition: margin-left 0.3s ease;
            }

            .home_box .content.shifted {
                margin-left: 250px; /* sidebar ochilganda contentni surish */
            }

            .mobile-header {
                display: flex;
                background-color: #212529;
                color: #fff;
                height: 50px;
            }
        }

        

    </style>
</head>
<body>
    <div id="loadingOverlay" style="display: none;">
        <div class="spinner-border text-info" role="status">
            <span class="visually-hidden">Yuklanmoqda...</span>
        </div>
    </div>

    <!-- <div class="">
        <h5></h5>
           
    </div> -->
    
    <div class="home_box layout">
        
        <div class="menu_box" id="sidebar">
            <div class="users_name d-flex justify-content-center align-items-center">
                <h6>User</h6>
            </div>
            <div class="content_menu p-1">
                <ul class="p-0">
                    <li> 
                        <a href="#dashboard">
                            <i class="bi bi-ui-checks-grid"></i> 
                            <span>Dashboart</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pages/pryaja" class="nav-link" >
                        <i class="bi bi-disc"></i>   
                            <span>Pryaja</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pages/raw/raw_material" class="nav-link" >
                            <i class="bi bi-stack"></i>
                            <span>Xom mato</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pages/fabric/fabric" class="nav-link" >
                            <i class="bi bi-check2-square"></i>
                            <span>Tayyor mato</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pages/chemical/chemical" >
                            <i class="bi bi-droplet"></i>
                            <span>Ximikat</span>
                        </a>
                    </li>
                    <li onclick="fetchClients()">
                        <a href="#client_page" >
                            <i class="bi bi-person-vcard" ></i>
                            <span >Mijoz</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pages/kroy/kroy" >
                            <i class="bi bi-scissors"></i>
                            <span>KROY</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="bi bi-journal-check"></i>
                            <span>Xizmat ko'rs</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#contract" >
                            <i class="bi bi-journal-check"></i>
                            <span>Shartnoma</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="content scroll-container">
            <div class="content_header text-center mobile-header  d-flex justify-content-between align-items-center p-2 bg-dark text-light" id="globalHeader">
                <h4 class="p-0 m-0" id="">Merganteks</h4>

                <div class="d-flex justify-content-center gap-2 my-1" id="pageActions">
                    <!-- tugmalar JS orqali keladi -->
                </div>

                <!-- <a href="" class="text-light text-decoration-none mt-1">Chiqish</a> -->
                <i class="bi bi-list fs-1" id="menuToggle"></i> 
            </div>
            <div class="content_body" id="content_body">
                
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/fetchClients.js"></script>

    
    <script>
       function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
        showLoading();
        
       $(document).ready(function() {
            hideLoading();
            
            function loadContent(page) {
                showLoading(); // Yuklashni boshlaganda ko‘rsatamiz
                $('#content_body').load(page + '.php', function () {
                    hideLoading(); // Yuklash tugagach yashiramiz
                });
            }

            function handleHashChange() {
                let hash = window.location.hash.substring(1) || 'dashboard';

                loadContent(hash);
                setActiveMenu(hash);

                if (hash === 'client_page') {
                    fetchClients();
                }

                switch (hash) {
                    case 'dashboard':
                        updateHeader({
                            title: 'Dashboard'
                        });
                        break;

                    case 'pages/pryaja':
                        updateHeader({
                            title: 'Merganteks',
                            buttons: [
                                { text: 'Kirim', class: 'btn text-light btn-sm fs-6', toggle: 'modal', target: '#addProduckModal' },
                                { text: 'Chiqim', class: 'btn text-light btn-sm fs-6', toggle: 'modal', target: '#outProduckModal' }
                            ]
                        });
                        break;

                    case 'pages/raw/raw_material':
                        updateHeader({
                            title: 'Xom Mato',
                            buttons: [
                                { text: "+ Mahsulot qo'shish", class: 'btn btn-sm fs-6 color_33ADFF', toggle: 'modal', target: '#add_product_raw_modal' },
                                // { text: 'Chiqim', class: 'btn-danger', toggle: 'modal', target: '#outProduckModal' }
                            ]
                        });
                        break;

                    case 'pages/fabric/fabric':
                        updateHeader({
                            title: 'Tayyor Mato',
                            buttons: [
                                { text: "+ Mahsulot qo'shish", class: 'btn btn-sm fs-6  color_33ADFF', toggle: 'modal', target: '#add_product_raw_modal' },
                                // { text: 'Chiqim', class: 'btn-danger', toggle: 'modal', target: '#outProduckModal' }
                            ]
                        });
                        break;

                    case 'pages/chemical/chemical':
                        updateHeader({
                            title: 'Ximikat',
                            buttons: [
                                { text: "+ Mahsulot qo'shish", class: 'btn btn-sm fs-6  color_33ADFF', toggle: 'modal', target: '#add_product_chemical_modal' },
                                // { text: 'Chiqim', class: 'btn-danger', toggle: 'modal', target: '#outProduckModal' }
                            ]
                        });
                        loadInventory(1);
                        break;

                    case 'pages/kroy/kroy':
                        updateHeader({
                            title: 'KROY',
                            buttons: [
                                { text: "+ Mahsulot qo'shish", class: 'btn btn-sm fs-6  color_33ADFF', toggle: 'modal', target: '#add_product_kroy_modal' },
                                // { text: 'Chiqim', class: 'btn-danger', toggle: 'modal', target: '#outProduckModal' }
                            ]
                        });
                        break;

                    case 'client_page':
                        updateHeader({
                            title: 'Mijozlar'
                        });
                        fetchClients();
                        break;
                }
            }


            // Sahifa yuklanganda yoki hash o‘zgarganda ishga tushadi
            $(window).on('hashchange', handleHashChange);
            handleHashChange(); // birinchi yuklashda
            

            // Boshqa nav-link bosilganda hashni o‘zgartiramiz
            $('.nav-link').on('click', function(e) {
                e.preventDefault();
                
                const target = $(this).attr('href');
                window.location.hash = target;
            });

            function setActiveMenu(hash) {
                $('.content_menu a').removeClass('active');

                if (!hash) hash = 'dashboard';

                $('.content_menu a[href="#' + hash + '"]').addClass('active');
            }



            const $sidebar = $('#sidebar');
            const $content = $('#mainContent');
            const $menuToggle = $('#menuToggle');

            // Hamburger toggle
            $menuToggle.on('click', function (e) {
                e.stopPropagation(); // document click ishlamasligi uchun
                $sidebar.toggleClass('active');
                $content.toggleClass('shifted');
            });

            // Sidebar ichiga bosilganda yopilmasin
            $sidebar.on('click', function (e) {
                e.stopPropagation();
            });

            // Istalgan boshqa joy bosilganda yopilsin
            $(document).on('click', function () {
                if ($sidebar.hasClass('active')) {
                    $sidebar.removeClass('active');
                    $content.removeClass('shifted');
                }
            });

        });
        
        fetchClients();


        function updateHeader(config) {
            $('#pageTitle').text(config.title || '');

            const $actions = $('#pageActions');
            $actions.empty();

            if (config.buttons) {
                config.buttons.forEach(btn => {
                    $actions.append(`
                        <button class="btn btn-sm ${btn.class}"
                                data-bs-toggle="${btn.toggle || ''}"
                                data-bs-target="${btn.target || ''}">
                            ${btn.text}
                        </button>
                    `);
                });
            }
        }
    </script>

</body>
</html>