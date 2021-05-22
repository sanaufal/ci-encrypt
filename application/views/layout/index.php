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

    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.theme.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bundle.css" type="text/css">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/sweetalert2/dist/sweetalert2.min.css">

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/datepicker/daterangepicker.css" type="text/css">

    <!-- DataTable -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/dataTable/datatables.min.css" type="text/css">

    <!-- Prim -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/prism/prism.css" type="text/css">

    <!-- DatePicker css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bootstrap-datepicker/bootstrap-datepicker.min.css" type="text/css">

    <!-- Select2 css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/select2/css/select2.min.css" type="text/css">

    <!-- Select2 css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/jquery-confirm/css/jquery-confirm.css" type="text/css">

    <!-- Icon -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/fontawesome/css/all.min.css">

    <!-- DateTimePicker css -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" type="text/css">

    <!-- Croppie -->
    <link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/croppie/croppie.css">

    <!-- App css -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/app.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/custom.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/component.css" type="text/css">
</head>

<body class="scrollable-layout">
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-icon"></div>
        <span>Loading...</span>
    </div>
    <!-- ./ Preloader -->

    <!-- Sidebar group -->
    <div class="sidebar-group">

        <!-- BEGIN: Settings -->
        <div class="sidebar" id="settings">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title d-flex justify-content-between">
                        Settings
                        <a class="btn-sidebar-close" href="javascript:void();">
                            <i class="ti-close"></i>
                        </a>
                    </h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                <label class="custom-control-label" for="customSwitch1">Allow notifications.</label>
                            </div>
                        </li>
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">Hide user requests</label>
                            </div>
                        </li>
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3" checked>
                                <label class="custom-control-label" for="customSwitch3">Speed up demands</label>
                            </div>
                        </li>
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch4" checked>
                                <label class="custom-control-label" for="customSwitch4">Hide menus</label>
                            </div>
                        </li>
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch5">
                                <label class="custom-control-label" for="customSwitch5">Remember next visits</label>
                            </div>
                        </li>
                        <li class="list-group-item pl-0 pr-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch6">
                                <label class="custom-control-label" for="customSwitch6">Enable report
                                    generation.</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Settings -->

        <!-- BEGIN: Chat List -->
        <div class="sidebar" id="chat-list">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title d-flex justify-content-between">
                        Chats
                        <a class="btn-sidebar-close" href="javascript:void();">
                            <i class="ti-close"></i>
                        </a>
                    </h6>
                    <div class="list-group list-group-flush">
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-danger">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/women_avatar3.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow- 1">
                                <h6 class="mb-1">Cass Queyeiro</h6>
                                <span class="text-muted">
                                    <i class="fa fa-image mr-1"></i> Photo
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Yesterday</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-warning">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/man_avatar4.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Evered Asquith</h6>
                                <span class="text-muted">
                                    <i class="fa fa-video-camera mr-1"></i> Video
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Last week</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item px-0 d-flex align-items-start">
                            <div class="pr-3">
                                <div class="avatar avatar-state-danger">
                                    <span class="avatar-title bg-success rounded-circle">F</span>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">Francisco Ubsdale</h6>
                                <span class="text-muted">Hello how are you?</span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">2:32 PM</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item px-0 d-flex align-items-start">
                            <div class="pr-3">
                                <div class="avatar avatar-state-success">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/women_avatar1.jpg" class="rounded-circle" alt="image">
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">Natale Janu</h6>
                                <span class="text-muted">Hi!</span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="badge badge-primary badge-pill ml-auto mb-2">3</span>
                                <span class="small text-muted">08:27 PM</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-warning">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/women_avatar2.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow- 1">
                                <h6 class="mb-1">Orelie Rockhall</h6>
                                <span class="text-muted">
                                    <i class="fa fa-image mr-1"></i> Photo
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Yesterday</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-info">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/man_avatar1.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Barbette Bolf</h6>
                                <span class="text-muted">
                                    <i class="fa fa-video-camera mr-1"></i> Video
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Last week</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-secondary">
                                    <span class="avatar-title bg-warning rounded-circle">D</span>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Dudley Laborde</h6>
                                <span class="text-muted">Hello how are you?</span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">2:32 PM</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-success">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/man_avatar2.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Barbaraanne Riby</h6>
                                <span class="text-muted">Hi!</span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">08:27 PM</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-danger">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/women_avatar3.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow- 1">
                                <h6 class="mb-1">Mariana Ondrousek</h6>
                                <span class="text-muted">
                                    <i class="fa fa-image mr-1"></i> Photo
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Yesterday</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-warning">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/man_avatar4.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Ruprecht Lait</h6>
                                <span class="text-muted">
                                    <i class="fa fa-video-camera mr-1"></i> Video
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Last week</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-info">
                                    <img src="<?php echo base_url(); ?>assets/media/image/user/man_avatar1.jpg" class="rounded-circle" alt="image">
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Cosme Hubbold</h6>
                                <span class="text-muted">
                                    <i class="fa fa-video-camera mr-1"></i> Video
                                </span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">Last week</span>
                            </div>
                        </a>
                        <a href="chat.html" class="list-group-item d-flex px-0 align-items-start">
                            <div class="pr-3">
                                <span class="avatar avatar-state-secondary">
                                    <span class="avatar-title bg-secondary rounded-circle">M</span>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1">Mallory Darch</h6>
                                <span class="text-muted">Hello how are you?</span>
                            </div>
                            <div class="text-right ml-auto d-flex flex-column">
                                <span class="small text-muted">2:32 PM</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Chat List -->

    </div>
    <!-- ./ Sidebar group -->

    <!-- Layout wrapper -->
    <div class="layout-wrapper">

        <!-- Header -->
        <?php include_once 'header.php' ?>
        <!-- ./ Header -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- begin::navigation -->
            <?php include_once 'navigation.php' ?>
            <!-- end::navigation -->

            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content ">
                    <?php
                    if (isset($_view) && !empty($_view)) {
                        $this->load->view($_view);
                    }
                    ?>
                </div>
                <!-- ./ Content -->

                <!-- Footer -->
                <?php include_once 'footer.php' ?>
                <!-- ./ Footer -->
            </div>
            <!-- ./ Content body -->
        </div>
        <!-- ./ Content wrapper -->
    </div>
    <!-- ./ Layout wrapper -->

    <!-- Main scripts -->
    <script type="text/javascript" src="<?php echo base_url('vendors'); ?>/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url('vendors'); ?>/bundle.js"></script>

    <!-- Notify scripts -->
    <script src="<?php echo base_url('vendors'); ?>/notify/notify.min.js"></script>

    <!-- SweetAlert2 scripts -->
    <script src="<?php echo base_url('vendors'); ?>/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Form Validation scripts -->
    <script src="<?php echo base_url('assets'); ?>/js/examples/form-validation.js"></script>

    <!-- Jquery Validate scripts -->
    <script src="<?php echo base_url('vendors'); ?>/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?php echo base_url('vendors'); ?>/jquery-validation/dist/additional-methods.min.js"></script>

    <!-- Prim scripts -->
    <script src="<?php echo base_url('vendors'); ?>/prism/prism.js"></script>

    <!-- Apex chart -->
    <script src="<?php echo base_url('vendors'); ?>/charts/apex/apexcharts.min.js"></script>

    <!-- Daterangepicker -->
    <script src="<?php echo base_url('vendors'); ?>/datepicker/daterangepicker.js"></script>

    <!-- DataTable -->
    <script src="<?php echo base_url('vendors'); ?>/dataTable/datatables.min.js"></script>

    <!-- Select2 scripts -->
    <script src="<?php echo base_url('vendors'); ?>/select2/js/select2.min.js"></script>

    <!-- Jquery Confirm scripts -->
    <script src="<?php echo base_url('vendors'); ?>/jquery-confirm/js/jquery-confirm.js"></script>

    <!-- Bs Custom File Input scripts -->
    <script src="<?php echo base_url('vendors'); ?>/bs-custom-file-input/bs-custom-file-input.js"></script>

    <!-- Icon -->
    <script src="<?php echo base_url('vendors'); ?>/fontawesome/js/all.min.js"></script>

    <!-- DateTimePicker scripts -->
    <script src="<?php echo base_url('vendors'); ?>/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Croppie -->
    <script src="<?php echo base_url('vendors'); ?>/croppie/croppie.min.js"></script>

    <!-- App scripts -->
    <script src="<?php echo base_url('assets'); ?>/js/app.min.js"></script>
    <script src="<?php echo base_url('assets'); ?>/js/custom.js"></script>

    <script>
        function notif($type, $msg) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
            if (parseInt($type) === 1) {
                Toast.fire({
                    type: 'success',
                    icon: 'success',
                    timerProgressBar: 'true',
                    title: $msg
                });
            } else if (parseInt($type) === 0) {
                Toast.fire({
                    type: 'error',
                    icon: 'error',
                    timerProgressBar: 'true',
                    title: $msg
                });
            } else if (parseInt($type) === 2) {
                Toast.fire({
                    type: 'info',
                    icon: 'info',
                    timerProgressBar: 'true',
                    title: $msg
                });
            }
        }
    </script>
    <?php
    if (isset($_script) && !empty($_script)) {
        $this->load->view($_script);
    }
    ?>
</body>

</html>