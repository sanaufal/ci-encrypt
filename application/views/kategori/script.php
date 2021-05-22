<script>
    $(document).ready(function() {

        var url = "<?= base_url('kategori/index'); ?>";
        var index = $('#table-data').DataTable({
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
                {'data': 'categories_nama_barang'},
                {
                    'data': 'categories_id',
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

        $('#btnKategori').on('click', function() {
            $('#modalInputdata').modal('show');
            $('#add').removeClass('d-none');
            $('#update').addClass('d-none');
            $('input').removeAttr('readonly');
            $('textarea').removeAttr('readonly');
            $('#form').trigger('reset');
        });

        if ($("categories_id").val() == '' || $("categories_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#add').removeClass('d-none');
        }
        $(document).on("click", "#update", function(e) {
            e.preventDefault();

            var data = {
                categories_id: $("#categories_id").val(),
                categories_nama_barang: $("#categories_nama_barang").val(),
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
                if ($("#categories_nama_barang").val() == 0) {
                    notif(0,"Nama Barang" );

                    next = false;
                }
            }
            if (next == true) {

                var data = {
                    categories_id: $("#categories_id").val(),
                    categories_nama_barang: $("#categories_nama_barang").val(),
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
                        $("#categories_id").val(data.result['categories_id']);
                        $("#categories_nama_barang").val(data.result['categories_nama_barang']);
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