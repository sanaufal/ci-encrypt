<script>
    $(document).ready(function() {
        var url = "<?php echo site_url('client/index'); ?>"
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
        var index = $("#table-data").DataTable({
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
                "targets": []
            }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                'data': 'contact_code'
            }, {
                'data': 'contact_name'
            }, {
                'data': 'contact_pic_name'
            }, {
                'data': 'contact_id',
                render: function(data, meta, row) {
                    var disp = '';
                    disp += '<div class="btn-action">';
                    disp += '<a href="#" class="btn btn-sm btn-floating btn-light view-data" data-id="' + data + '">';
                    disp += '<i class="ti-eye"></i></a>';
                    disp += '<a href="#" class="btn btn-sm btn-floating btn-primary edit-data" data-id="' + data + '">';
                    disp += '<i class="ti-pencil"></i></a>';
                    disp += '<a href="#" class="btn btn-sm btn-floating btn-danger delete-data" data-id="' + data + '">';
                    disp += '<i class="ti-trash"></i></a>';
                    disp += '</div>';
                    return disp;
                },
                'className': 'contain-action sm-action'
            }]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $("#form-data").validate({
            rules: {
                npwp: "required",
                name: "required",
                phone1: "required",
                pic_name: "required",
                phone_pic: "required",
                address: "required",
                country: "required",
                state: "required",
                city: "required",
            },
            messages: {
                npwp: "perlu di isi!",
                name: "perlu di isi!",
                phone1: "perlu di isi!",
                pic_name: "perlu di isi!",
                phone_pic: "perlu di isi!",
                address: "perlu di isi!",
                country: "perlu di isi!",
                state: "perlu di isi!",
                city: "perlu di isi!",
            },
        });
        $('#Create').on('click', function(e) {
            e.preventDefault();
            var id = $('#data_id').val();
            var action = '';
            if (id == '') {
                action = 'save';
            } else {
                action = 'update';
            };
            var data = {
                id: $('#data_id').val(),
                npwp: $('#npwp').val(),
                name: $('#name').val(),
                phone1: $('#phone1').val(),
                phone2: $('#phone2').val(),
                pic_name: $('#pic_name').val(),
                phone_pic: $('#phone_pic').val(),
                address: $('#address').val(),
                state: $('#state').val(),
                city: $('#city').val(),
                country: $('#country').val(),
                action: action,
            };
            if ($('#form-data').valid() == true) {
                $.ajax({
                    url: url,
                    data: data,
                    dataType: "json",
                    type: "post",
                    cache: 'false',
                    beforeSend: function() {},
                    success: function(result) {
                        if (result['stat'] == 1) {
                            $('#modalClient').modal('hide');
                            $('#form-data').trigger('reset');
                            $('#city').val(null).trigger('change');
                            $('#state').val(null).trigger('change');
                            $('#country').val(null).trigger('change');
                            notif(1, 'Berhasil Menyimpan / Memperbarui Supplier');
                            index.ajax.reload();
                        } else {
                            notif(0, 'Gagal Menyimpan / Memperbarui Supplier')
                        }
                    },
                    error: function(xhr, status, err) {}
                });
            }
        });
        $(document).on("click", ".edit-data", function(e) {
            e.preventDefault();
            $('#form-data').trigger('reset');
            $('#city').val(null).trigger('change');
            $('#state').val(null).trigger('change');
            $('#country').val(null).trigger('change');
            $('#modalClient').modal('show');
            $("#Create").show().html('Update');
            $("#Cancel").text('Cancel');
            $('.modal-title').text('Edit Client');
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
                success: function(result) {
                    if (parseInt(result.stat) === 1) {
                        notif(1, "Berhasil Mendapatkan Data");
                        var data = result['data'];
                        var country = new Option(data['country_name'], data['contact_country'], false, false);
                        var state = new Option(data['state_name'], data['contact_state'], false, false);
                        var city = new Option(data['city_name'], data['contact_city'], false, false);
                        $('#data_id').val(data['contact_id']);
                        $('#code').val(data['contact_code']);
                        $('#npwp').val(data['contact_npwp']).attr('disabled', false);
                        $('#phone1').val(data['contact_phone_1']).attr('disabled', false);
                        $('#phone2').val(data['contact_phone_2']).attr('disabled', false);
                        $('#pic_name').val(data['contact_pic_name']).attr('disabled', false);
                        $('#phone_pic').val(data['contact_pic_phone']).attr('disabled', false);
                        $('#name').val(data['contact_name']).attr('disabled', false);
                        $('#address').val(data['contact_addr']).attr('disabled', false);
                        $('#city').append(city).trigger('change').attr('disabled', false);
                        $('#city').val(data['contact_city']).trigger('change');
                        $('#state').append(state).trigger('change').attr('disabled', true);
                        $('#country').append(country).trigger('change').attr('disabled', true);
                    } else if (parseInt(result.stat) === 0) {
                        notif(0, "Gagal Mendapatkan Data");
                    }
                }
            });
        });
        $(document).on("click", ".view-data", function(e) {
            e.preventDefault();
            $('#modalClient').modal('show');
            $("#Create").hide();
            $("#Cancel").text('Close');
            $('.modal-title').text('Detail Client');
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
                success: function(result) {
                    if (parseInt(result.stat) === 1) {
                        notif(1, "Berhasil Mendapatkan Data");
                        var data = result['data'];
                        var country = new Option(data['country_name'], data['contact_country'], false, false);
                        var state = new Option(data['state_name'], data['contact_state'], false, false);
                        var city = new Option(data['city_name'], data['contact_city'], false, false);
                        $('#data_id').val(data['contact_id']).attr('disabled', true);
                        $('#npwp').val(data['contact_npwp']).attr('disabled', true);
                        $('#phone1').val(data['contact_phone_1']).attr('disabled', true);
                        $('#phone2').val(data['contact_phone_2']).attr('disabled', true);
                        $('#pic_name').val(data['contact_pic_name']).attr('disabled', true);
                        $('#phone_pic').val(data['contact_pic_phone']).attr('disabled', true);
                        $('#name').val(data['contact_name']).attr('disabled', true);
                        $('#address').val(data['contact_addr']).attr('disabled', true);
                        $('#city').append(city).trigger('change').attr('disabled', true);
                        $('#city').val(data['contact_city']).trigger('change');
                        $('#state').append(state).trigger('change');
                        $('#country').append(country).trigger('change');
                    } else if (parseInt(result.stat) === 0) {
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
                        keys: ['enter'],
                        action: function() {
                            $.ajax({
                                url: url,
                                data: data,
                                dataType: "json",
                                type: "post",
                                beforeSend: function() {},
                                success: function(ret) {
                                    if (ret['stat'] == 1) {
                                        notif(1, "Berhasil Menghapus");
                                        index.ajax.reload();
                                    } else {
                                        notif(0, 'Gagal di hapus!');
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
        $('#btnClient').on('click', function(e) {
            e.preventDefault();
            $('.modal-title').text('Add Client');
            $("#Create").show().html('Save');
            $("#Cancel").text('Cancel');
            $('#data_id').attr('disabled', false);
            $('#code').attr('disabled', false);
            $('#npwp').attr('disabled', false);
            $('#phone1').attr('disabled', false);
            $('#phone2').attr('disabled', false);
            $('#pic_name').attr('disabled', false);
            $('#phone_pic').attr('disabled', false);
            $('#name').attr('disabled', false);
            $('#address').attr('disabled', false);
            $('#city').attr('disabled', false);
            $('#state').attr('disabled', true);
            $('#country').attr('disabled', true);
            $("label.error").remove();
            $('.form-control').removeClass('error');
            $('#modalClient').modal('show');
        });
        $("#Cancel").on("click", function(e) {
            e.preventDefault();
            $('#modalClient').modal('hide');
            $('#form-data').trigger('reset');
            $('#city').val(null).trigger('change');
            $('#state').val(null).trigger('change');
            $('#country').val(null).trigger('change');
            $("label.error").remove();
            $('.form-control').removeClass('error');
        });
    });
</script>