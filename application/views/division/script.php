<script>
    $(document).ready(function() {
        var url = '<?php echo site_url('division/index'); ?>'
        var index = $("#table").DataTable({
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
                "targets": [1]
            }, {
                'className': 'text-center',
                'targets': [1]
            }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                'data': 'division_name'
            }, {
                'data': 'division_stat',
                render: function(data, meta, row) {
                    if (parseInt(row.division_stat) === 1) {
                        return 'Active';
                    } else if (parseInt(row.division_stat) === 0) {
                        return 'Non-Active';
                    }
                }
            }, {
                'data': 'division_id',
                render: function(data, meta, row) {
                    var disp = '';
                    disp += '<div class="btn-action">';
                    disp += '<a href="#" class="btn btn-sm btn-floating btn-light edit-data" data-id="' + data + '">';
                    disp += '<i class="ti-eye"></i></a>';
                    disp += '<a href="#" class="btn btn-sm btn-floating btn-danger delete-data" data-id="' + data + '">';
                    disp += '<i class="ti-trash"></i></a>';
                    disp += '</div>';
                    return disp;
                },
                'className': 'contain-action sm-action'
            }]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $(document).on("click", ".edit-data", function(e) {
            e.preventDefault();
            $("#Create").html('Update');
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
                        $('#data_id').val(data['division_id']);
                        $('#name').val(data['division_name']);
                        $('#desc').val(data['division_detail']);
                        $('#status').val(data['division_stat']);
                    } else if (parseInt(result.stat) === 0) {
                        notif(0, "Gagal Mendapatkan Data");
                    }
                }
            });
        });
        $("#form-data").validate({
            rules: {
                name: "required",
                desc: "required",
            },
            messages: {
                name: "perlu di isi!",
                desc: "perlu di isi!",
            },
        });
        $("#Create").on("click", function(e) {
            e.preventDefault();
            var id = $('#data_id').val();
            var action = '';
            if (id == '') {
                action = 'save';
            } else {
                action = 'update';
            };
            var data = {
                action: action,
                id: $('#data_id').val(),
                name: $('#name').val(),
                status: $('#status').val(),
                desc: $('#desc').val(),
            };
            if ($('#form-data').valid() == true) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            notif(1, "Berhasil Menyimpan Data");
                            index.ajax.reload();
                            $('#form-data').trigger('reset');
                        } else if (parseInt(data.stat) === 0) {
                            notif(0, "Gagal Menyimpan Data");
                            $('#form-data').trigger('reset');
                        }
                    }
                });
            }
        });
        $(document).on('click', '.delete-data', function(e) {
            e.preventDefault();
            var data = {
                action: 'delete',
                id: $(this).data('id'),
                stat: 4
            };
            $.confirm({
                title: "Do you want to delete this division?",
                content: '',
                theme: 'modern',
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
                        btnClass: 'btn-danger',
                        keys: ['Enter'],
                        action: function() {
                            $.ajax({
                                url: url,
                                data: data,
                                dataType: "json",
                                type: "post",
                                beforeSend: function() {},
                                success: function(result) {
                                    if (result['stat'] == 1) {
                                        index.ajax.reload();
                                        notif(1, "Berhasil Menghapus");
                                    } else {
                                        notif(0, 'Gagal Menghapus!');
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
        $("#Cancel").on("click", function(e) {
            e.preventDefault();
            $('#form-data').trigger('reset');
            $("#Create").html('Save');
        });
    });
</script>