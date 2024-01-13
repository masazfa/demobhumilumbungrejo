<body>
    <style>
.sidebar-wrapper .menu .submenu li a {
    padding:0.52rem 3rem;
}

.navbar-expand .navbar-collapse {
    margin-bottom:-13px;
}

        @media screen and (max-width: 770px) {
        .navbar.navbar-header li {
        display: none;
    }
}

        @media screen and (min-width: 560px) {
            .navbar-brand{
                font-size: 28px;
            }
        }

        @media screen and (max-width: 560px) {
            .navbar-brand{
                font-size: 25px;
            }
        }

        @media screen and (max-width: 380px) {
            .logo1, .logo2 {
        display: none;
            }
        }

        @media screen and (max-width: 360px) {
            .logo3 {
        display: none;
            }
        }

        @media screen and (max-width: 313px) {
            .navbar-brand{
                display:none;
            }
        }

        @media screen and (max-width: 775px) {
            .navbar-nav .nav-item {
                display: block;
                width: 100%;
            }
        }
    </style>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div style="margin-top:20px;margin-bottom:-20px;">
                    <!-- <h1 style="font-size:70px;"><b>SIIPS</b></h1> -->
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class='sidebar-title'>Main Menu</li>
                        <li class="sidebar-item">
                            <a href="<?= base_url('home') ?>" class='sidebar-link'>
                                <i data-feather="map" width="20"></i>
                                <span>WebGIS</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="settings" width="20"></i>
                                <span>Zoom Feature</span>
                            </a>
                            <ul class="submenu ">
                                <li>
                                    <a href="/home/searchpagar/">Layer Pagar PPLS</a>
                                </li>
                                <li>
                                    <a href="/home/searchrambu/">Layer Rambu PPLS</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchsaluran') ?>">Layer Saluran</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchbangunanaset') ?>">Layer Aset Bangunan</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchjalaninspeksi') ?>">Layer Jalan Inspeksi</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchpossatpam') ?>">Layer Pos Satpam</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchrumahpompa') ?>">Layer Rumah Pompa</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchrumahjagapompa') ?>">Layer Rumah Jaga Pompa</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchasetmarker') ?>">Layer Aset Kursi Taman</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchasetline') ?>">Layer Aset Pagar</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchasetkolam') ?>">Layer Aset Kolam</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchasetrumput') ?>">Layer Aset Rumput</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('home/searchasethalamanrumahpompa') ?>">Layer Aset Halaman Rumah Pompa</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">

                            <a href="#" target="_blank" class='sidebar-link'>
                                <i data-feather="user" width="20"></i>
                                <span>Login</span>
                            </a>

                        </li>

                    </ul>
                </div>
                <!-- <div class="sidebar-header" style="display:flex;margin-top:162px;margin-left:34px;gap:20px;">
                    <img src="<?= base_url() ?>assets/styletempla/assets/images/pupr.png" style="margin-top:4px;width:52px;height:55px;">
                    <img src="<?= base_url() ?>assets/styletempla/assets/images/ugm.png" style="width:62px;height:62px;">
                </div> -->
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3 class="title-page">
                    </h3>
                    <p class="text-subtitle text-muted"></p>