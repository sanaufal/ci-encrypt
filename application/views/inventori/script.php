<script>
    $(document).ready(function() {

        var url = "<?= base_url('inventori/index'); ?>";
        var index = $('#tabel-data').DataTable({
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
                "targets": [0]
            }],
            "order": [
                [0, 'desc']
            ],
            "columns": [
                {'data': 'inventori_code'},
                {'data': 'karyawan_name'},
                {'data': 'categories_nama_barang'},
                {'data': 'brand_nama_merk'},
                {'data': 'inventori_keterangan'},
                {'data': 'inventori_jumlah'},
                {
                    'data': 'inventori_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        disp += '<a class="btn btn-sm btn-floating btn-primary edit-data" data-id="' + data + '">';
                        disp += '<i class="ti-pencil"></i>';
                        disp += '</a>';

                        disp += '<a class="btn btn-sm btn-floating btn-danger delete-data" data-id="' + data + '">';
                        disp += '<i class="ti-trash"></i>';
                        disp += '</a>';
                        
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action sm-action'
                }
            ]
        });
        
        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $('#btnInventori').on('click', function() {
            $('#modalInputdata').modal('show');
            $('#add').removeClass('d-none');
            $('#update').addClass('d-none');
            $('input').removeAttr('readonly');
            $('textarea').removeAttr('readonly');
            $('#form').trigger('reset');
        });

        if ($("inventori_id").val() == '' || $("inventori_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#add').removeClass('d-none');
        }
        $(document).on("click", "#update", function(e) {
            e.preventDefault();

            var data = {
                inventori_id: $("#inventori_id").val(),
                inventori_karyawan: $("#inventori_karyawan").val(),
                inventori_nama_barang: $("#inventori_nama_barang").val(),
                inventori_nama_merk: $("#inventori_nama_merk").val(),
                inventori_keterangan: $("#inventori_keterangan").val(),
                inventori_jumlah: $("#inventori_jumlah").val(),
                action: "update"

            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function(data) {
                    if (parseInt(data.stat) === 1) {
                        $('#karyawan_name').val('0');
                        $('#categories_nama_barang').val('0');
                        $('#brand_nama_merk').val('0');
                        $('#update').addClass('d-none');
                        $('#form').trigger("d-none");
                        $('#add').removeClass('d-none');
                        $('#modalInputdata').modal('hide');
                        index.ajax.reload();
                        notif(1, data.mesg);
                    }else if(parseInt(data.stat) === 0){
                        notif(0, data.mesg);
                    }
                }
            });

        });
        $(document).on("click", "#add", function(e) {
            e.preventDefault();

            var next = true;
            if (next) {
                if ($("#karyawan_name").val() == 0) {
                    notif(0,"Nama karyawan harus di isi " );

                    next = false;
                }
            }
            if (next) {
                if ($("#categories_nama_barang").val() == 0) {
                    notif(0,"Barang harus di isi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#brand_nama_merk").val() == 0) {
                    notif(0,"Brand harus di isi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#inventori_keterangan").val() == 0) {
                    notif(0,"Spesifikasi harus di isi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#inventor_jumlah").val() == 0) {
                    notif(0,"jumlah harus di isi" );

                    next = false;
                }
            }
            if (next == true) {

                var data = {
                    inventori_id: $("#inventori_id").val(),
                    inventori_karyawan: $("#karyawan_name").val(),
                    inventori_nama_barang: $("#categories_nama_barang").val(),
                    inventori_nama_merk: $("#brand_nama_merk").val(),
                    inventori_keterangan: $("#inventori_keterangan").val(),
                    inventori_jumlah: $("#inventori_jumlah").val(),
                    action: "add"

                };
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            $('#modalInputdata').modal('hide');
                            $('#karyawan_name').val('0');
                            $('#categories_nama_barang').val('0');
                            $('#brand_nama_merk').val('0');
                            index.ajax.reload();
                            notif(1, data.mesg);

                            $('#update').hide();
                            $('#form').trigger("reset");
                            $('#add').removeClass('d-none');
                        }else if(parseInt(data.stat) === 0){
                            notif(0, data.mesg);
                        }
                    }
                });
            } else {
                alert(mesg);
            }
        });
        $(document).on("click", ".edit-data", function(e) {
            e.preventDefault();
            var data = {
                id: $(this).attr('data-id'),
                action: "edit"
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
                        $('#modalInputdata').modal('show');
                        $("#inventori_id").val(data.result['inventori_id']);
                        $("#inventori_karyawan").val(data.result['inventori_karyawan']);
                        $("#inventori_nama_barang").val(data.result['inventori_nama_barang']);
                        $("#inventori_nama_merk").val(data.result['inventori_nama_merk']);
                        $("#inventori_keterangan").val(data.result['inventori_keterangan']);
                        $("#inventori_jumlah").val(data.result['inventori_jumlah']);
                        $('#add').addClass('d-none');
                        $('#update').removeClass('d-none');
                        $('input').removeAttr('readonly');
                        $('textarea').removeAttr('readonly');
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
                title: "Do you want to delete this barang?",
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
    });
</script>

