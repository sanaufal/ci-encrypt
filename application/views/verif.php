
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php
        if (isset($_title)) {
            echo $_title;
        } else {
            echo 'DM Tekno Sertifikat';
        }
        ?>
    </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets'); ?>/media/image/favicon.png"/>
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bundle.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/app.min.css" type="text/css">
</head>
<body class="form-membership">

<!-- begin::preloader-->
<div class="preloader">
    <div class="preloader-icon"></div>
</div>
<!-- end::preloader -->

<div class="form-wrapper">

    <!-- logo -->
    <nav class="center" brand-white="on">
        <div class="navbar-brand center navbar-brand-custom" href="<?php echo base_url('assets/media/dmtekno-logo.png'); ?>" target="_blank">
            <img class="mr-2 center" src="<?php echo base_url('assets/media/dmtekno-logo.png') ?>" width="50" height="50" alt="dmtekno-logo">
        </div>
    </nav>
    <!-- ./ logo -->

    
    <h5>Verifikasi</h5>

    <!-- form -->
    <form>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nomor" required autofocus>
        </div>
        <div class="form-group">
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <button class="btn btn-primary btn-block">Proses</button>
    </form>
    <!-- ./ form -->


</div>

<!-- Plugin scripts -->
<script src="<?php echo base_url('vendors'); ?>/bundle.js"></script>

<!-- App scripts -->
<script src="<?php echo base_url('assets'); ?>/js/app.min.js"></script>
</body>
</html>
