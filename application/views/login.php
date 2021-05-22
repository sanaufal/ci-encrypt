<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($_title)) {
            echo $_title;
        } else {
            echo 'DM Tekno';
        }
        ?>
    </title>
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

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendors/bundle.css" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/component.css" type="text/css">
</head>

<body class="bg-image vh-100" data-animation="on">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
        <span>Loading...</span>
    </div>
    <!-- end::preloader -->

    <nav class="navbar" brand-white="on">
        <div class="navbar-brand d-flex align-items-center navbar-brand-custom" href="<?php echo base_url('assets/media/dmtekno-logo.png'); ?>" target="_blank">
            <img class="mr-2" src="<?php echo base_url('assets/media/dmtekno-logo.png') ?>" width="25" height="25" alt="dmtekno-logo">
            DM Tekno
        </div>
    </nav>

    <div class="row justify-content-center h-100">
        <div class="col-lg-4">
            <div class="card mt-3 mb-2 shadow-md card-login">
                <div class="card-logo">
                    <img src="<?php echo base_url('assets/media/dmtekno-logo.png'); ?>" alt="dmtekno-logo" width="40" height="40">
                </div>
                <h2 class="mb-0 px-3 py-5 my-5 text-white">
                    Welcome <br>
                    Back
                </h2>
                <div class="card-body py-5">
                    <form class="mt-3">
                        <div class="form-group">
                            <div class="input-wrapper icon-left">
                                <input type="text" id="user_name" class="form-control" placeholder="Username">
                                <span class="icon-addon">
                                    <i data-feather="user" class="icon stroke-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper icon-left password">
                                <input type="password" id="user_password" class="form-control password-input" placeholder="Password">
                                <span class="icon-addon">
                                    <i data-feather="lock" class="icon stroke-2"></i>
                                </span>
                                <button type="button" class="password-btn" tabindex="-1">
                                    <span class="password-btn-label" aria-label="Show password" title="Show password">
                                        Show
                                    </span>
                                    <span class="password-btn-label" aria-label="Hide password" title="Show password">
                                        Hide
                                    </span>
                                </button>
                            </div>
                        </div>
                        <button type="submit" id="user_login" class="btn btn-primary btn-block mt-3 py-2 btn-loader">
                            <span>Login</span>
                            <div class="loader-wrapper">
                                <svg class="icon icon-is-spinning mr-2" aria-hidden="true" viewBox="0 0 16 16">
                                    <title>Loading</title>
                                    <g stroke-width="1" fill="currentColor" stroke="currentColor">
                                        <path d="M.5,8a7.5,7.5,0,1,1,1.91,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-white text-center d-flex align-items-end justify-content-center">
                <svg class="tea" width="17" height="28" viewBox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="currentColor" stroke-width="2"></path>
                    <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="currentColor" stroke-width="2"></path>
                    <path id="teabag" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
                    <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"></path>
                    <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="ml-2">
                    &copy; 2020 <a class="a-custom" href="https://dmtekno.com/" target="_blank">DM Tekno</a> .All rights reserved.
                </span>
            </div>
        </div>
    </div>

    <!-- Plugin scripts -->
    <script src="<?php echo base_url(); ?>vendors/bundle.js"></script>

    <!-- App scripts -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/util.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/component.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#user_login', function(e) {
                e.preventDefault();
                $(this).addClass('running');
                if ($('#user_name').val() !== '' && $('#user_password').val() !== '') {
                    var ini = $(this);
                    var data = {
                        user_name: $('#user_name').val(),
                        user_pass: $('#user_password').val()
                    };

                    $.ajax({
                        url: '<?= base_url('login/auth'); ?>',
                        data: data,
                        type: 'post',
                        dataType: 'json',
                        cache: 'false',
                        success: function(data) {
                            if (parseInt(data.stat) === 1) {
                                window.location.replace('<?= base_url() ?>');
                            } else {
                                alert('username/password salah');
                                $(this).removeClass('running');
                            }
                        }
                    });
                } else {
                    alert('username/password tidak boleh kosong');
                    $(this).removeClass('running');
                }
            });

            $('form').on('focusin', function() {
                $('.card-login').addClass('focused');
            }).on('focusout', function() {
                $('.card-login').removeClass('focused');
            });
        });
    </script>
</body>

</html>