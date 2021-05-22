<script>
    $(document).ready(function() {
        var url = "<?php echo site_url('karyawan/index'); ?>"
        var dataLength = 10;
        var defaultTxtOnInit = '';
        var city = $('#city').select2({
            allowClear: true,
            ajax: {
                url: "<?php echo site_url('client/getCity'); ?>",
                dataType: 'json',
                type: 'post',
                delay: 250,
                global: false,
                data: function(params) {
                    params.page = params.page || 0;
                    return {
                        keyword: params.term ? params.term : defaultTxtOnInit,
                        pageSize: dataLength,
                        page: params.page,
                        id: $('#Province').val()
                    };
                },
                processResults: function(data, params) {
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
        $('#city').on('change', function() {
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
                success: function(data) {
                    if (parseInt(data.status) === 1) {
                        // $().data.result.city_name
                        // 
                        $("#country").append('' +
                            '<option value="' + data.result.country_id + '">' +
                            data.result.country_name +
                            '</option>');
                        $("#country").val(data.result.country_id).trigger('change');

                        $("#state").append('' +
                            '<option value="' + data.result.state_id + '">' +
                            data.result.state_name +
                            '</option>');
                        $("#state").val(data.result.state_id).trigger('change');

                    }
                }
            });
        });
        $(document).on('click', '#btnKrywn', function(e) {
            e.preventDefault();
            $('#Create').text('Save');
            $('#form-data').trigger('reset');
            $('#city').val(null).trigger('change');
            $('#state').val(null).trigger('change');
            $('#country').val(null).trigger('change');
            $('#data_id').val(null);
            $('#modalKrywn').modal('show');
            $('.modal-title').text('Tambah Data Karyawan');
        });
        var index = $("#tableKrywn").DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            "processing": true,
            "serverSide": true,
            ajax: {
                url: url,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                data: function(d) {
                    d.action = 'load';

                },
                dataSrc: function(data) {
                    return data.data;
                }
            },
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [4]
            }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                    'data': 'karyawan_code'
                },
                {
                    'data': 'karyawan_name'
                },
                {
                    'data': 'division_name'
                },
                {
                    'data': 'role_name'
                },
                {
                    'data': 'karyawan_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">'
                        disp += '<a href="#" class="btn btn-sm btn-floating btn-primary edit-data" data-id="' + data + '">';
                        disp += '<i class="ti-pencil"></i></a>';
                        disp += '<a href="#" class="btn btn-sm btn-floating btn-danger delete-data" data-id="' + data + '">';
                        disp += '<i class="ti-trash"></i></a>';
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action xs-action'
                }
            ]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $(document).on('click', '#Create', function(e) {
            e.preventDefault();
            var next = true;
            if (next) {
                if ($('#nik').val() == '') {
                    next = false;
                    notif(0, "Nomor NIK harus di isi!");
                }
            }
            if (next) {
                if ($('#name').val() == '') {
                    next = false;
                    notif(0, "Nama harus di isi!");
                }
            }
            if (next) {
                if ($('#phone').val() == '') {
                    next = false;
                    notif(0, "Nomor Telfon harus di isi!");
                }
            }
            if (next) {
                if ($('#address').val() == '') {
                    next = false;
                    notif(0, "Address / Alamat harus di isi!");
                }
            }
            if (next) {
                if ($('#city').val() == '') {
                    next = false;
                    notif(0, "City / Kota harus di isi!");
                }
            }
            if (next) {
                if ($('#state').val() == '') {
                    next = false;
                    notif(0, "State / Provinsi harus di isi!");
                }
            }
            if (next) {
                if ($('#country').val() == '') {
                    next = false;
                    notif(0, "Country / Negara harus di isi!");
                }
            }
            var id = $('#data_id').val();
            var action = '';
            if (id == '') {
                action = 'save';
            } else {
                action = 'update';
            };
            var data = {
                id: $('#data_id').val(),
                nik: $('#nik').val(),
                code: $('#code').val(),
                name: $('#name').val(),
                phone: $('#phone').val(),
                divisi: $('#divisi').val(),
                role: $('#role').val(),
                address: $('#address').val(),
                city: $('#city').val(),
                state: $('#state').val(),
                country: $('#country').val(),
                action: action,
            };
            if (next) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            $('data_id').val('');
                            $('#form-data').trigger('reset');
                            $('#modalKrywn').modal('hide');
                            notif(1, data.mesg);
                            index.ajax.reload();
                        } else if (parseInt(data.stat) === 0) {
                            notif(0, data.mesg);
                        }
                    }
                });
            }

        });

        $(document).on('click', '.edit-data', function(e) {
            e.preventDefault();
            $('#form-data').trigger('reset');
            $('#city').val(null).trigger('change');
            $('#state').val(null).trigger('change');
            $('#country').val(null).trigger('change');
            $('#modalKrywn').modal('show');
            $("#Create").show().html('Update');
            $('.modal-title').text('Edit Data Karyawan');
            var data = {
                action: 'edit',
                id: $(this).data('id')
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function(data) {
                    if (parseInt(data.stat) === 1) {
                        notif(1, "Berhasil Mendapatkan Data");
                        var data = data['data'];
                        var country = new Option(data['country_name'], data['karyawan_country'], false, false);
                        var state = new Option(data['state_name'], data['karyawan_state'], false, false);
                        var city = new Option(data['city_name'], data['karyawan_city'], false, false);
                        $('#data_id').val(data['karyawan_id']);
                        $('#code').val(data['karyawan_code']);
                        $('#nik').val(data['karyawan_nik']);
                        $('#phone').val(data['karyawan_phone']);
                        $('#name').val(data['karyawan_name']);
                        $('#address').val(data['karyawan_address']);
                        $('#divisi').val(data['karyawan_division']);
                        $('#role').val(data['karyawan_role']);
                        $('#city').append(city).trigger('change');
                        $('#city').val(data['karyawan_city']).trigger('change');
                        $('#state').append(state).trigger('change');
                        $('#country').append(country).trigger('change');
                    } else if (parseInt(data.stat) === 0) {
                        notif(0, "Gagal Mendapatkan Data");
                    }
                }
            });
        });

        $(document).on("click", ".delete-data", function(e) {
            e.preventDefault();
            var data = {
                action: 'delete',
                id: $(this).data('id'),
                stat: 4
            }
            $.confirm({
                title: "Do you want to delete this client?",
                content: '',
                theme: 'modern hidden-content',
                draggable: false,
                backgroundDismiss: function() {
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
                        action: function() {
                            notif(2, 'Batal menghapus');
                        }
                    },
                    Ya: {
                        text: 'Yes',
                        btnClass: 'btn-primary',
                        keys: ['Enter'],
                        action: function() {
                            $.ajax({
                                url: url,
                                data: data,
                                dataType: "json",
                                type: "post",
                                beforeSend: function() {},
                                success: function(data) {
                                    if (parseInt(data.stat) === 1) {
                                        notif(1, data.mesg);
                                        index.ajax.reload();
                                    } else if (parseInt(data.stat) === 0) {
                                        notif(0, data.mesg);
                                    }
                                },
                                error: function(xhr, status, err) {

                                }
                            });
                        }
                    }
                }
            });
        });
    });
</script>