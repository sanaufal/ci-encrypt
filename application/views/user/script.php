<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
        var url = "<?php echo site_url('user/manage') ?>"
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
                url: url,
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
        function ResetForm() {
            $('#form-data').trigger('reset');
            $('#City').val(null).trigger('change');
//            $('#Role').val(null).trigger('change');//
            $('#Province').find('option').remove().end().append('<option value="">Auto From City</option>').val('');
            $('#Country').find('option').remove().end().append('<option value="">Auto From City</option>').val('');
//            $('.img-preview').removeProp('src').hide().prop('assets/images/no-image.png');
            $('.img-preview').attr('src', 'assets/images/no-image.png');
        }
        var index = $("#table").DataTable({
            "responsive": true,
            "language": {
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            "serverSide": true,
            "autoWidth": true,
            ajax: {
                url: url,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                data: function (d) {
                    d.action = 'load_users';
                },
                dataSrc: function (data) {
                    return data.data;
                }
            },
            "columnDefs": [{
                    "searchable": false,
                    "orderable": true,
                    "targets": [0]
                }, {
                    "searchable": false,
                    "orderable": false,
                    "targets": [1, 2, 3, 4, 5]
                }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                    'data': 'user_full_name',
                }, {
                    'data': 'user_name',
                }, {
                    'data': 'user_email',
                }, {
                    'data': 'role_name',
                }, {
                    'data': 'user_date',
                }, {
                    'data': 'user_stat',
                    render: function (data, meta, row) {
                        if (parseInt(row.user_stat) === 1) {
                            return "Active";
                        } else if (parseInt(row.user_stat) === 0) {
                            return "Non-Active";
                        }
                    }
                }, {
                    'data': 'user_id',
                    render: function (data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        if (parseInt(row.user_stat) === 1) {
                            disp += '<a href="#" class="status text-warning nonaktif" title="Non Active" data-id="' + data + '"><i class="ti-check"></i></a>';
                        } else if (parseInt(row.user_stat) === 0) {
                            disp += '<a href="#" class="status text-success aktif" title="Active" data-id="' + data + '"><i class="ti-na"></i></a>';
                        }
                        disp += '<a href="#" class="text-primary edit" title="Edit" data-id="' + data + '"><i class="ti-pencil"></i></a></a>';
                        disp += '<a href="#" class="text-danger delete" title="Delete" data-id="' + data + '"><i class="ti-trash"></i></a>';
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action'
                }]
        });
        // Action Edit
        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            $('#ModalUser').modal('show');
            $('.modal-title').text('Edit User');
            $('#form-data').trigger('reset');
            var data = {
                action: 'edit_users',
                id: $(this).attr('data-id')
            };

            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function () {},
                success: function (result) {
                    if (result['status'] == 1) {
                        var data = result['data'];
                        var country = new Option(data['country_name'], data['user_country'], false, false);
                        var province = new Option(data['state_name'], data['user_state'], false, false);
                        var city = new Option(data['city_name'], data['user_city'], false, false);
                        var url = '<?= base_url('resources/uploads/photo/') ?>' + data['user_photo'];
                        if (data['user_photo'] !== null) {
                            $('.img-preview').attr('src', url);
                            $('.custom-file').attr('src', data['user_photo']);
                        }
                        $('.custom-file').val(data['user_photo']);
                        $('#data_id').val(data['user_id']);
                        $('#FullName').val(data['user_full_name']);
                        $('#Username').val(data['user_name']);
                        $('#Email').val(data['user_email']);
                        $('#Role').val(data['user_role']);
                        $('#Gender').val(data['user_gender']);
                        $('#Address').val(data['user_addr']);
                        $('#Country').append(country).trigger('change');
                        $('#Province').append(province).trigger('change');
                        $('#City').append(city).trigger('change');
                    } else {

                    }
                },
                error: function (xhr, status, err) {

                }
            })
        });
        $(document).on('click', '.aktif', function (e) {
            e.preventDefault();
            var data = {
                action: 'activate_user',
                id: $(this).data('id'),
                stat: 1
            };
            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function () {},
                success: function (result) {
                    if (result['status'] == 1) {
                        notif(1, 'Berhasil Mengaktifkan!');
                        index.ajax.reload();
                    } else {

                    }
                },
                error: function (xhr, status, err) {

                }
            })
        });
        $(document).on('click', '.nonaktif', function (e) {
            e.preventDefault();
            var data = {
                action: 'deactivate_user',
                id: $(this).data('id'),
                stat: 0
            };
            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function () {},
                success: function (result) {
                    if (result['status'] == 1) {
                        notif(1, 'Berhasil Menonaktifkan!');
                        index.ajax.reload();
                    } else {

                    }
                },
                error: function (xhr, status, err) {

                }
            })
        });
        // Action Delete
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var data = {
                action: 'delete_users',
                id: $(this).data('id'),
                stat: 4
            }
            $.confirm({
                title: "Do you want to delete this user?",
                content: '',
                theme: 'modern hidden-content',
                draggable: false,
                backgroundDismiss: function () {
                    return false;
                },
                animateFromElement: false,
                animation: 'zoom',
                closeAnimation: 'zoom',
                buttons: {
                    Tidak: {
                        text: 'Cancel',
                        btnClass: 'btn-light',
                        key: ['Escape'],
                        action: function () {
                            notif(2, 'Batal menghapus');
                        }
                    },
                    Ya: {
                        text: 'Yes',
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function () {
                            $.ajax({
                                url: url,
                                data: data,
                                dataType: "json",
                                type: "post",
                                beforeSend: function () {},
                                success: function (result) {
                                    if (result['status'] == 1) {
                                        notif(1, "Berhasil Menghapus");
                                        index.ajax.reload();
                                    } else {
                                        notif(0, 'Gagal di hapus!');
                                    }
                                },
                                error: function (xhr, status, err) {

                                }
                            });
                        }
                    }
                }
            });
        });
        // Action Add User
        $(document).on('click', '#AddUser', function (e) {
            e.preventDefault();
            $('#ModalUser').modal('show');
            $('.modal-title').text('Add User');
            ResetForm();
        });
        $("#form-data").validate({
            rules: {
                fullname: "required",
                username: "required",
                email: "required",
                role: "required",
                gender: "required",
                address: "required",
                country: "required",
                province: "required",
                city: "required",
            },
            messages: {
                fullname: "perlu di isi!",
                username: "perlu di isi!",
                email: "perlu di isi!",
                role: "perlu di isi!",
                gender: "perlu di isi!",
                address: "perlu di isi!",
                country: "perlu di isi!",
                province: "perlu di isi!",
                city: "perlu di isi!",
            },
        });
        $('#Create').on('click', function (e) {
            e.preventDefault();
            var id = $('#data_id').val();
            var action = '';
            if (id == '') {
                action = 'save_user';
            } else {
                action = 'update';
            }
            ;
            var formData = new FormData();
            formData.append('photo', $('#Photo')[0].files[0]);
            formData.append('id', $('#data_id').val());
            formData.append('fullname', $('#FullName').val());
            formData.append('username', $('#Username').val());
            formData.append('password', $('#Password').val());
            formData.append('email', $('#Email').val());
            formData.append('role', $('#Role').val());
            formData.append('gender', $('#Gender').val());
            formData.append('address', $('#Address').val());
            formData.append('country', $('#Country').val());
            formData.append('province', $('#Province').val());
            formData.append('city', $('#City').val());
            formData.append('action', action);
            if ($('#form-data').valid() == true) {
                $.ajax({
                    url: url,
                    data: formData,
                    dataType: "json",
                    type: "post",
                    cache: 'false',
                    contentType: false,
                    processData: false,
                    beforeSend: function () {},
                    success: function (result) {
                        console.log(result);
                        if (result['status'] == 1) {
                            $('#form-data').trigger('reset'),
                                    $('#ModalUser').modal('hide'),
                                    notif(1, 'Berhasil Menyimpan / Memperbarui User');
                            index.ajax.reload();
                        } else {
                            notif(0, 'Gagal Menyimpan / Memperbarui User')
                        }
                    },
                    error: function (xhr, status, err) {}
                });
            }
        });
        
        // Image Preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.img-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        $(".img-input").change(function () {
            readURL(this);
        });
    });
</script>