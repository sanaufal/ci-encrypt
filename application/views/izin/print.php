<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.theme.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bundle.css" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body class="container">
        <div class="layout-wrapper">
            <h3 class="text-center">Formulir Pengajuan Cuti/Izin</h3>
        </div>
        <div>
            <ul>
                <li>Nama :</li>
                <li>Bagian :</li>
                <li>Jenis Izin :</li>
                <li>Alasan :</li>
                <li>Tanggal :</li>
                <li>Tanggal Masuk :</li>
            </ul>
            <textarea class="form-control" placeholder="Leave a comment here" style="margin-top: 0px; margin-bottom: 0px; height: 114px;"></textarea>
        </div>
    </body>
    <script type="text/javascript" src="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url('vendors'); ?>/bundle.js"></script>
</html>