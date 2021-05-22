<!-- Modal -->
<div class="modal fade" id="modalCrop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Profile</h5>
            </div>
            <div class="modal-body">
                <div class="upload-demo-wrapper">
                    <div id="uploadCrop"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelCrop" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveCrop" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var url = '<?php echo site_url('profile/index'); ?>'
        var dataLength = 10;
        var defaultTxtOnInit = '';
        var city = $('#City').select2({
            allowClear: true,
            ajax: {
                url: "<?= base_url('user/getCity'); ?>",
                dataType: 'json',
                type: 'post',
                delay: 250,
                global: false,
                data: function (params) {
                    params.page = params.page || 0;
                    return {
                        keyword: params.term ? params.term : defaultTxtOnInit,
                        pageSize: dataLength,
                        page: params.page,
                        id: $('#Province').val()
                    };
                },
                processResults: function (data, params) {
                    //                  console.log( params.page )
                    params.page = params.page || 1;
                    return {
                        results: data.result,
                        pagination: {
                            more: (params.page * dataLength) < data.counts
                        }
                    };
                },
                //              cache: true
            },
            placeholder: {
                id: '0', // the value of the option
                text: 'Choice of City'
            },
            width: '100%',
            //minimumInputLength: 3,
        });
        $('#City').on('change', function () {
            var data = {
                action: 'get_state_and_country',
                city_id: $(this).val()
            };
            $.ajax({
                url: "<?php echo site_url('user/manage') ?>",
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.status) === 1) {
                        // $().data.result.city_name
                        // 
                        $("#Country").append('' +
                                '<option value="' + data.result.country_id + '">' +
                                data.result.country_name +
                                '</option>');
                        $("#Country").val(data.result.country_id).trigger('change');

                        $("#Province").append('' +
                                '<option value="' + data.result.state_id + '">' +
                                data.result.state_name +
                                '</option>');
                        $("#Province").val(data.result.state_id).trigger('change');

                    }
                }
            });
        });
        // Image
        var profileDefault = '<?php echo base_url('resources/uploads/photo/profile-default.svg'); ?>';

        $('#Remove').on('click', function () {
            $('#imgProfile').attr('src', profileDefault);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $image_crop.croppie('bind', {
                        url: e.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                    $('#Upload').val(input.files[0].name);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#Upload').on('change', function () {
            readURL(this);
            $('#modalCrop').modal('show');
        });

        var opts = {
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        };

        $image_crop = $('#uploadCrop').croppie(opts);

        $('#modalCrop').on('shown.bs.modal', function () {
            $('#uploadCrop').croppie('bind', opts);
        });

        $('#saveCrop').on('click', function () {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "upload": resp,
                        'action': 'update-img'
                    },
                    success: function (data) {
                        if (parseInt(data.stat) === 1) {
                            notif(data.stat, data.mesg);
                            $('#modalUpload').modal('hide');
                            $('#Upload').val('');
                            $('#modalCrop').modal('hide');
                            loadData();
                        }
                    }
                });
            });
        });

        $('#cancelCrop').on('click', function () {
            $('#Upload').val('');
        });

        //        Update Password
        $('#pass, #conf_pass').on('keyup', function () {
            if ($('#pass').val() == $('#conf_pass').val()) {
                $('#message').html('Password Sama').css('color', 'green');
            } else
                $('#message').html('Password Tidak Sama').css('color', 'red');
        });
        $('#btnPass').on('click', function (e) {
            e.preventDefault();
            var next = true;
            if (next) {
                if ($('#oldpwd').val() == '') {
                    next = false;
                    notif(0, 'Sandi Lama harus di isi');
                }
            }
            if (next) {
                if ($("#pass").val() == '') {
                    next = false;
                    notif(0, 'Password Baru harus di isi');
                }
            }
            if (next) {
                if ($("#conf_pass").val() == '') {
                    next = false;
                    notif(0, 'Ulangi Password harus di isi');
                }
            }
            var data = {
                pass: $('#oldpwd').val(),
                passTo: $('#pass').val(),
                action: 'update-pass'
            };
            if (next) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function (data) {
                        if (parseInt(data.stat) === 1) {
                            notif(data.stat, data.mesg);
                            $('#profile-tab').trigger('click');
                            $('#oldpwd, #pass, #conf_pass').val('');
                            $('#message').remove();
                        } else {
                            notif(data.stat, data.mesg);
                        }
                    }
                });
            }
        });

//        Update Contact
        $('#SvContact').on('click', function () {
            var data = {
                phone: $('#Phone').val(),
                addr: $('#Address').val(),
                email: $('#Email').val(),
                city: $('#City').val(),
                state: $('#Province').val(),
                country: $('#Country').val(),
                action: 'save-contact'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        notif(data.stat, data.mesg);
                        loadData();
                    }
                }
            });
        });
        $('#SvProfile').on('click', function () {
            var data = {
                username: $('#Username').val(),
                fullname: $('#fullName').val(),
                gender: $('#Gender').val(),
                role: $('#Role').val(),
                stat: $('#Status').val(),
                divisi: $('#Division').val(),
                action: 'save-profile'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        notif(data.stat, data.mesg);
                        loadData();
                    }
                }
            });
        });
        // Load Data

        function loadData() {
            var data = {
                action: 'get-data'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        console.log(data.data);
                        var data = data.data;
                        var city = new Option(data.city_name, data.user_city, false, false);
                        $('#City').val(data.detail_city);
                        $('#City').append(city).trigger('change');
                        $('#imgProfile').attr('src', '<?php echo site_url('resources/uploads/photo/'); ?>' + data.user_photo);
                        $('.fullname').text(data.user_full_name);
                        $('#fullName').val(data.user_full_name);
                        $('#Username').val(data.user_name);
                        $('#Phone').val(data.user_phone);
                        $('#Email').val(data.user_email);
                        $('#Address').val(data.user_addr);
                        $('#Gender').val(data.user_gender).trigger('change');
                        $('#Role').val(data.user_role).trigger('change');
                        $('#Status').val(data.user_stat).trigger('change');
//                        $('#Division').val(data.user_gender).trigger('change');
                    }
                }
            });
        }
        loadData();
    });
</script>