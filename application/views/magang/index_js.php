<div class="modal fade" id="modalInputdata" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" class="form-control d-none" id="magang_id">
                    <div class="form-group">
                        <label for="nim">Nim</label>
                        <input type="text" class="form-control" id="magang_nim" placeholder="Masukkan NIM">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="magang_user" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                        <label for="telp">Nomor Telp</label>
                        <input type="number" class="form-control form-number-custom" id="magang_phone" placeholder="Masukkan Nomor Telpon" data-only="number" min="0">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="magang_address" rows="4" class="form-control" placeholder="Masukkan Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Divisi</label>
                        <select class="form-control" id="division_name">
                            <option selected >Pilih</option>
                            <?php
                            foreach ($divisions as $d) {
                                echo " <option value=" . $d['division_id'] . "> " . $d['division_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sekolah</label>
                        <select class="form-control" id="partner_sekolah">
                            <option selected >Pilih</option>
                            <?php
                            foreach ($partner as $p) {
                                echo " <option value=" . $p['partner_id'] . "> " . $p['partner_sekolah'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="magang_tglm">Mulai magang</label>
                        <div class="input-icon" data-icon="right">
                            <input type="text" class="form-control" id="magang_tglm" READONLY>
                            <span class="icon-addon">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="magang_tglk">Selesai magang</label>
                        <div class="input-icon" data-icon="right">
                            <input type="text" class="form-control" id="magang_tglk" readonly>
                            <span class="icon-addon">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="add">Tambah</button>
                <button class="btn btn-primary d-none" type="button" id="update">Update</button>
                <button type="reset" class="btn btn-danger d-none">Reset</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var url = "<?= base_url('magang/index'); ?>";
        var index = $('#tabel-magang').DataTable({
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
            }, {
                'width': 'width',
                'targets': []
            }, {
                'className': 'className',
                'targets': []
            }],
            "order": [
                [0, 'desc']
            ],
            "columns": [{
                    'data': 'magang_nim',
                    render: function(data, meta, row) {
                        if (parseInt(row.magang_stat) == 1) {
                            return row.magang_nim + '<br>' + 'Aktif';
                        } else if (parseInt(row.magang_stat) == 0) {
                            return row.magang_nim + '<br>' + 'Tidak Aktif';
                        }
                    }
                },
                {
                    'data': 'magang_user',
                    render: function(data, meta, row) {
                        if (row.magang_phone == 0) {
                            return data;
                        } else {
                            return data + '<br>' + row.magang_phone;
                        }
                    }
                },
                {
                    'data': 'division_name'
                },
                {
                    'data': 'partner_sekolah'
                },
                {
                    'data': 'magang_tglm',
                    render: function(data, meta, row) {
                        return data + '<br>' + row.magang_tglk;
                    }
                },
                {
                    'data': 'magang_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        disp += '<a class="btn btn-sm btn-floating btn-primary edit-data" data-id="' + data + '">';
                        disp += '<i class="ti-pencil"></i>';
                        disp += '</a>';

                        disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-id="' + data + '">';
                        disp += '<i class="ti-eye"></i>';
                        disp += '</a>';

                        if (row.magang_stat == 1) {
                            disp += '<a class="btn btn-sm btn-floating btn-warning btn-icon nonaktif-akses" data-id="' + data + '" >';
                            disp += '<i class="ti-na"></i>';
                            disp += '</a>';
                        } else {
                            disp += '<a class="btn btn-sm btn-floating btn-warning btn-icon aktif-akses" data-id="' + data + '">';
                            disp += '<i class="ti-check"></i>';
                            disp += '</a>';
                        }
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action sm-action'
                }
            ]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $('#btnTambah').on('click', function() {
            $('#modalInputdata').modal('show');
            $('#add').removeClass('d-none');
            $('#update').addClass('d-none');
            $('input').removeAttr('readonly');
            $('textarea').removeAttr('readonly');
            $('#form').trigger('reset');
        });

        if ($("magang_id").val() == '' || $("magang_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#add').removeClass('d-none');
        }
        $(document).on("click", "#update", function(e) {
            e.preventDefault();

            var data = {
                magang_id: $("#magang_id").val(),
                magang_nim: $("#magang_nim").val(),
                magang_user: $("#magang_user").val(),
                magang_phone: $("#magang_phone").val(),
                magang_address: $("#magang_address").val(),
                magang_divisi: $("#magang_divisi").val(),
                magang_sekolah: $("#magang_sekolah").val(),
                magang_tglm: $("#magang_tglm").val(),
                magang_tglk: $("#magang_tglk").val(),
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
                if ($("#magang_nim").val() == 0) {
                    notif(0,"Nim harus diisi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#magang_user").val() == 0) {
                    notif(0,"Nama harus diisi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#magang_phone").val() == 0) {
                     notif(0,"Nomor harus diisi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#magang_address").val() == 0) {
                     notif(0,"Alamat harus diisi" );

                    next = false;
                }
            }
            if (next) {
                if ($("#division_name").val() == 0) {
                     notif(0,"Divisi harus ipilih" );

                    next = false;
                }
            }
            if (next) {
                if ($("#partner_sekolah").val() == 0) {
                   notif(0,"Sekolah harus dipilih");

                    next = false;
                }
            }
            if (next) {
                if ($("#magang_tglm").val() == 0) {
                    notif(0,"Tanggal masuk harus diisi");

                    next = false;
                }
            }
            if (next) {
                if ($("#magang_tglk").val() == 0) {
                    notif(0,"Tanggal keluar harus diisi" );

                    next = false;
                }
            }
            if (next == true) {

                var data = {
                    magang_id: $("#magang_id").val(),
                    magang_nim: $("#magang_nim").val(),
                    magang_user: $("#magang_user").val(),
                    magang_phone: $("#magang_phone").val(),
                    magang_address: $("#magang_address").val(),
                    magang_divisi: $("#division_name").val(),
                    magang_sekolah: $("#partner_sekolah").val(),
                    magang_tglm: $("#magang_tglm").val(),
                    magang_tglk: $("#magang_tglk").val(),
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
                            $('#division_name').val('0');
                            $('#partner_sekolah').val('0');
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
                        $("#magang_id").val(data.result['magang_id']);
                        $("#magang_nim").val(data.result['magang_nim']);
                        $("#magang_user").val(data.result['magang_user']);
                        $("#magang_phone").val(data.result['magang_phone']);
                        $("#magang_address").val(data.result['magang_address']);
                        $("#magang_divisi").val(data.result['magang_divisi']);
                        $("#magang_sekolah").val(data.result['magang_sekolah']);
                        $("#magang_tglm").val(data.result['magang_tglm']);
                        $("#magang_tglk").val(data.result['magang_tglk']);
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
        $(document).on("click", ".view-data", function(e) {
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
                        notif(1, "Berhasil mendapatkan data");
                        $('#modalInputdata').modal('show');

                        $("#magang_id").val(data.result['magang_id']);
                        $("#magang_nim").val(data.result['magang_nim']);
                        $("#magang_user").val(data.result['magang_user']);
                        $("#magang_phone").val(data.result['magang_phone']);
                        $("#magang_address").val(data.result['magang_address']);
                        $("#magang_divisi").val(data.result['magang_divisi']);
                        $("#magang_sekolah").val(data.result['magang_sekolah']);
                        $("#magang_tglm").val(data.result['magang_tglm']);
                        $("#magang_tglk").val(data.result['magang_tglk']);
                        $('#add').addClass('d-none');
                        $('#update').addClass('d-none');
                        $('#form .form-control').attr('readonly', true);
                    } else if (parseInt(data.stat) === 1) {
                        notif(0, "Gagal mendapatkan data");
                    }
                }
            });

        });
        $(document).on("click", ".aktif-akses", function(e) {
            e.preventDefault();
            var data = {
                id: $(this).attr('data-id'),
                action: "aktif"
            };
            
            $.confirm({
                title: "Do you want to Aktif ?",
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
                            notif(2, 'Batal Aktif');
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
                                type: 'post',
                                dataType: 'json',
                                cache: 'false',
                                success: function (data) {
                                    if (parseInt(data.stat) === 1) {
                                        notif(1, "Berhasil Aktif");
                                        index.ajax.reload();
                                    } else {
                                        notif(0, 'Gagal Aktif');
                                    }
                                }
                            });
                        }
                    }
                }
            });
        });
        $(document).on("click", ".nonaktif-akses", function(e) {
            e.preventDefault();
            var data = {
                id: $(this).attr('data-id'),
                action: "nonaktif"
            };

            $.confirm({
                title: "Do you want to Non Aktif ?",
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
                            notif(2, 'Batal Non Aktif');
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
                                type: 'post',
                                dataType: 'json',
                                cache: 'false',
                                success: function (data) {
                                    if (parseInt(data.stat) === 1) {
                                        notif(1, "Berhasil Non Aktif ");
                                        index.ajax.reload();
                                    } else {
                                        notif(0, 'Gagal Non Aktif');
                                    }
                                }
                            });
                        }
                    }
                }
            });
        });

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0! 
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        var today = dd + '-' + mm + '-' + yyyy;

        // Date Picker
        $('#magang_tglm').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            dateFormat: 'dd-mm-yyyy',
            timePicker: false,
            timePicker24Hour: false,
            timePickerSeconds: false,
            singleDatePicker: true,
            minDate: today
        }, function(start, end, label) {
            $("#magang_tglm").val(start.format("YYYY-MM-DD"));
        });
        $('#magang_tglk').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            dateFormat: 'dd-mm-yyyy',
            timePicker: false,
            timePicker24Hour: false,
            timePickerSeconds: false,
            singleDatePicker: true,
            minDate: today
        }, function(start, end, label) {
            $("#magang_tglk").val(start.format("YYYY-MM-DD"));
        });
    });
</script>