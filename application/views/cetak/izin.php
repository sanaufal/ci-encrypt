<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets'); ?>/media/favicon-dmtekno/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets'); ?>/media/favicon-dmtekno/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets'); ?>/media/favicon-dmtekno/favicon-16x16.png">
        <link rel="manifest" href="<?php echo base_url('assets'); ?>/media/favicon-dmtekno/site.webmanifest">
        <link rel="mask-icon" href="<?php echo base_url('assets'); ?>/media/favicon-dmtekno/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="DM Tekno">
        <meta name="application-name" content="DM Tekno">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <title>
            <?php
            if (isset($_title)) {
                echo $_title;
            } else {
                echo 'DM Tekno';
            }
            ?>
        </title>
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo base_url('vendors/bundle.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/app.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/print.css'); ?>">
    </head>

    <body class="print bg-print-v1 text-lg height-100vh">
        <div class="container max-width-sm margin-x-auto position-relative">
            <div class="row">
                <div class="col-12 padding-y-sm margin-y-xl d-flex position-relative">
                    <h1 class="text-center font-medium w-100">Formulir Pengajuan Cuti/Izin</h1>
                    <img class="img-fluid position-absolute top-0" src="<?php echo base_url('assets/media/dmtekno-logo.png'); ?>" alt="logo-dmtekno" width="80" style="right: 3em;">
                </div>
            </div>
        </div>
        <div class="container max-width-sm margin-x-auto print-w-sm">
            <div class="row">
                <div class="col-12">
                    <div class="text-component mb-3">
                        <ul class="list list-seperator-x">
                            <li>
                                <span class="bg width-30%">Nama</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['user']; ?></span>
                            </li>
                            <li>
                                <span class="bg width-30%">Bagian</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['division_name']; ?></span>
                            </li>
                            <li>
                                <span class="bg width-30%">Jenis cuti/ izin</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['izin_type'] == 1 ? "Sakit" : "Izin"; ?></span>
                            </li>
                            <li>
                                <span class="bg width-30%">Alasan</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['izin_note']; ?></span>
                            </li>
                            <li>
                                <span class="bg width-30%">Tanggal</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['izin_date_start']; ?></span>
                                <span class="padding-x-xl">s.d</span>
                                <span class="padding-left-xxs"><?php echo $_izin['izin_date_end']; ?></span>
                            </li>
                            <li>
                                <span class="bg width-30%">Tanggal masuk</span>
                                <span class="bg padding-right-xxs">:</span>
                                <span class="padding-left-xxs"><?php echo $_izin['izin_date_masuk']; ?></span>
                            </li>
                        </ul>
                    </div>

                    <p class="mb-2">Keterangan: <?php echo $_izin['izin_process_note']; ?></p>
                    <div class="flex">
                        <span class="width-xl">-</span>
                        <span>Apabila sakit formulir diisi setelah karyawan tersebut masuk kembali dengan melampirkan surat sakit dari dokter.</span>
                    </div>

                    <h2 class="text-primary font-weight-700 my-5"><?php echo $_izin['izin_stat'] == 1 ? "DISETUJUI" : "DITOLAK"; ?></h2>

                    <div class="row justify-content-end">
                        <div class="col-6">
                            <ul class="list list-seperator-x list-seperator-x-dotted">
                                <li>
                                    <span class="bg width-30%">Semarang,</span>
                                    <span class="padding-left-xxs"><?php echo date('d F Y'); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row justify-content-between mt-5 mb-4">
                        <div class="col-4">
                            <div class="height-xxxl text-center d-flex flex-column justify-content-between">
                                <p class="mb-0">Diajukan Oleh,</p>
                                <p class="mb-0 pb-1" style="border-bottom: 2px dotted currentColor;"><?php echo $_izin['user']; ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="height-xxxl text-center d-flex flex-column justify-content-between">
                                <p class="mb-0">Disetujui Oleh,</p>
                                <p class="mb-0 pb-1" style="border-bottom: 2px dotted currentColor;"><?php echo $_izin['acc']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-contrast-lower p-4 radius-sm mb-5">
                        <figure class="width-40% d-inline-block">
                            <img class="img-fluid" src="<?php echo base_url('assets/media/surat/') . $_izin['izin_image']; ?>" width="300">
                            <figcaption class="text-xs text-center">Bukti Izin</figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <footer class="px-3 text-right fixed-bottom">
            <p class="text-sm color-bg">Powered by DM Tekno</p>
        </footer>
    </body>

</html>