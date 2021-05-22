<script>
    $(document).ready(function() {
        var url = "<?php echo site_url('user/user_role') ?>"
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
                "targets": []
            }, {
                'width': 'width',
                'targets': []
            }, {
                'className': 'className',
                'targets': []
            }],
            "order": [
                [0, 'asc']
            ],
            "columns": [{
                'data': 'role_name'
            }, {
                'data': 'role_user'
            }, {
                'data': 'role_status',
                render: function(data, meta, row) {
                    if (parseInt(row.role_status) === 1) {
                        return "Active";
                    } else if (parseInt(row.role_status) === 0) {
                        return "Non-Active";
                    }
                }
            }, {
                'data': 'role_id',
                render: function(data, meta, row) {
                    var disp = '';
                    disp += '<div class="btn-action">';
                    if (parseInt(row.role_status) === 1) {
                        disp += '<a href="#" class="status text-warning nonaktif" title="Non Active" data-id="' + data + '">';
                        disp += '<i class="ti-check"></i></a>';
                    } else if (parseInt(row.role_status) === 0) {
                        disp += '<a href="#" class="status text-success aktif" title="Active" data-id="' + data + '">';
                        disp += '<i class="ti-na"></i></a>';
                    }
                    disp += '<a href="#" class="text-primary edit" data-id="' + data + '">';
                    disp += '<i class="ti-pencil"></i></a>';
                    disp += '<a href="#" class="text-danger delete" data-id="' + data + '">';
                    disp += '<i class="ti-trash"></i></a>';
                    disp += '</div>';
                    return disp;
                },
                className: 'contain-action'
            }]
        });
        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            $('#form-data').trigger('reset');
            var data = {
                action: 'edit_role',
                id: $(this).attr('data-id')
            };
            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function() {},
                success: function(result) {
                    if (result['status'] == 1) {
                        var data = result['data'];
                        $('#data_id').val(data['role_id']);
                        $('#RoleName').val(data['role_name']);
                        $('#RoleUser').val(data['role_user']);
                        $('#RoleStatus').val(data['role_status']);
                    } else {

                    }
                },
                error: function(xhr, status, err) {

                }
            })
        });
        $(document).on('click', '.aktif', function(e) {
            e.preventDefault();
            var data = {
                action: 'activate_role',
                id: $(this).data('id'),
                stat: 1
            };
            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function() {},
                success: function(result) {
                    if (result['status'] == 1) {
                        notif(1, 'Berhasil Mengaktifkan!');
                        index.ajax.reload();
                    } else {

                    }
                },
                error: function(xhr, status, err) {

                }
            })
        });
        $(document).on('click', '.nonaktif', function(e) {
            e.preventDefault();
            var data = {
                action: 'deactivate_role',
                id: $(this).data('id'),
                stat: 0
            };
            $.ajax({
                url: url,
                data: data,
                dataType: "json",
                type: "post",
                beforeSend: function() {},
                success: function(result) {
                    if (result['status'] == 1) {
                        notif(1, 'Berhasil Menonaktifkan!');
                        index.ajax.reload();
                    } else {

                    }
                },
                error: function(xhr, status, err) {

                }
            })
        });
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var data = {
                action: 'delete_role',
                id: $(this).data('id'),
                stat: 4
            }
            $.confirm({
                title: "Do you want to delete this role?",
                content: '',
                theme: 'modern hidden-content',
                draggable: false,
                backgroundDismiss: function() {
                    return false;
                },
                closeAnimation: 'opacity',
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
                        keys: ['enter'],
                        action: function() {
                            $.ajax({
                                url: url,
                                data: data,
                                dataType: "json",
                                type: "post",
                                beforeSend: function() {},
                                success: function(result) {
                                    if (result['status'] == 1) {
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
        $("#form-data").validate({
            rules: {
                rolename: "required",
                rolestatus: "required",
                roleuser: "required",
            },
            messages: {
                rolename: "perlu di isi!",
                rolestatus: "perlu di isi!",
                roleuser: "perlu di isi!",
            },
        });
        $('#Create').on('click', function(e) {
            e.preventDefault();
            var id = $('#data_id').val();
            var action = '';
            if (id == '') {
                action = 'save_role';
            } else {
                action = 'update_role';
            };
            var formData = new FormData();
            formData.append('id', $('#data_id').val());
            formData.append('rolename', $('#RoleName').val());
            formData.append('rolestatus', $('#RoleStatus').val());
            formData.append('roleuser', $('#RoleUser').val());
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
                    beforeSend: function() {},
                    success: function(result) {
                        console.log(result);
                        if (result['status'] == 1) {
                            $('#form-data').trigger('reset'),
                                notif(1, 'Berhasil Menyimpan / Memperbarui User');
                            index.ajax.reload();
                        } else {
                            notif(0, 'Gagal Menyimpan / Memperbarui User')
                        }
                    },
                    error: function(xhr, status, err) {}
                });
            }
        });
        $('#Cancel').on('click', function(e) {
            e.preventDefault();
            $('#form-data').trigger('reset');
        });
    });
</script>