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
                    <input type="hidden" class="form-control d-none" id="izin_id">
                    <div class="form-group">
                        <label>Jenis</label>
                        <select class="form-control" id="izin_type">
                            <option selected="">Pilih</option>
                            <option value="1"> Sakit </option> 
                            <option value="2"> Izin </option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="izin_date_start">Mulai Izin</label>
                        <div class="input-icon" data-icon="right">
                            <input type="text" class="form-control" id="izin_date_start" READONLY>
                            <span class="icon-addon">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="izin_date_end">Selesai izin</label>
                        <div class="input-icon" data-icon="right">
                            <input type="text" class="form-control" id="izin_date_end" readonly>
                            <span class="icon-addon">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Keterangan</label>
                        <textarea id="izin_note" rows="4" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="logo">Surat Keterangan</label>
                        <div class="input-button" data-button="right">
                            <input type="file" class="form-control" readonly placeholder="Upload File" id="izin_image">
                            <input type="text" name="file" class="file" id="file_upload" hidden>
                            <span class="btn-addon">
                                <a href="#" id="browse_file">
                                    <i class="ti-folder text-muted"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Preview</label>
                        <div class="preview-container input-preview mt-0">
                            <img id="preview" class="img-fluid">
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
    $(document).ready(function () {
        var url = "<?= base_url('izin/index'); ?>";
        var index = $('#tabelForm').DataTable({
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
                data: function (d) {
                    d.action = 'load';

                },
                dataSrc: function (data) {
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
                    'targets': [0]
                }],
            "order": [
                [0, 'desc']
            ],
            "columns": [
                {'data': 'izin_code'},
                {'data': 'user_full_name'},
                {'data': 'izin_date'},
                {'data': 'izin_type',
                    render: function (data, meta, row) {
                        if (parseInt(data) === 1) {
                            return 'Sakit'
                        } else {
                            return 'Izin'
                        }
                    }
                },
                {'data': 'izin_date_start',
                    render: function (data, meta, row) {
                        return data + '<br>' + row.izin_date_end;
                    }
                },
                {'data': 'izin_stat',
                    render: function (data, meta, row) {
                        if (parseInt(row.izin_stat) === 1) {
                            return 'Disetujui';
                        } else if (parseInt(row.izin_stat) == 0) {
                            return 'Diajukan';
                        } else if (parseInt(row.izin_stat) == 2) {
                            return 'Ditolak';
                        }
                    }
                },
                {
                    'data': 'izin_id',
                    render: function (data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-id="' + data + '">';
                        disp += '<i class="ti-eye"></i>';
                        disp += '</a>';

                        return disp;
                    },
                    'className': 'contain-action sm-action'
                }
            ]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $('#btnTambah').on('click', function () {
            $('#modalInputdata').modal('show');
            $('#add').removeClass('d-none');
            $('#update').addClass('d-none');
//            $('input').removeAttr('readonly');
            $('textarea').removeAttr('readonly');
//            $('#form').trigger('reset');
        });

        if ($("izin_id").val() == '' || $("izin_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#add').removeClass('d-none');
        }
        $('#izin_image').change(function (e) {
            var fileName = e.target.files[0].name;
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#file_upload').val(fileName);
            };
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on("click", "#update", function (e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('action', 'update');
            formData.append('izin_id', $("#izin_id").val());
            formData.append('izin_user', $("#izin_user").val());
            formData.append('izin_type', $("#izin_type").val());
            formData.append('izin_date_start', $("#izin_date_start").val());
            formData.append('izin_date_end', $("#izin_date_end").val());
            formData.append('izin_note', $("#izin_note").val());
            formData.append('izin_image', $("#file_upload").val());
            formData.append('upload', $('#izin_image')[0].files[0]);
            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }

            $.ajax({
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('#modalInputdata').modal('hide');
                        $('#update').addClass('d-none');
                        $('#form').trigger("reset");
                        $('#add').removeClass('d-none');
                        index.ajax.reload();
                        notif(1, data.mesg);
                    } else if (parseInt(data.stat) === 0) {
                        notif(0, data.mesg);
                    }
                }
            });


        });
        $(document).on("click", "#add", function (e) {
            e.preventDefault();
            var next = true;
            if (next) {
                if ($("#izin_user").val() == '') {
                    notif(0, "Nama Harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#izin_type").val() == '') {
                    notif(0, "Type Harus Diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#izin_date").val() == '') {
                    notif(0, "Tanggal Harus Diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#izin_date_start").val() == '') {
                    notif(0, "Tanggal Izin Harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#izin_date_end").val() == '') {
                    notif(0, "Tanggal berakhir harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#izin_note").val() == '') {
                    notif(0, "Keterangan Harus diisi");
                    next = false;
                }
            }
            if (next == true) {
                var formData = new FormData();
                formData.append('action', 'add');
                formData.append('izin_id', $("#izin_id").val());
                formData.append('izin_type', $("#izin_type").val());
                formData.append('izin_date_start', $("#izin_date_start").val());
                formData.append('izin_date_end', $("#izin_date_end").val());
                formData.append('izin_note', $("#izin_note").val());
                formData.append('izin_image', $("#file_upload").val());
                formData.append('upload', $('#izin_image')[0].files[0]);
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }
                $.ajax({
                    url: url,
                    data: formData,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    cache: 'false',
                    success: function (data) {
                        if (parseInt(data.stat) === 1) {
                            $('#modalInputdata').modal('hide');
                            $('#update').hide();
                            document.getElementById("form").reset();
                            $('#add').removeClass('d-none');
                            index.ajax.reload();
                            notif(1, "Data berhasil ditambahkan");
                        } else if (parseInt(data.stat) === 0) {
                            notif(0, "Data tidak berhasil ditambahkan");
                        }
                    }
                });
            }
        });
        $(document).on("click", ".view-data", function (e) {
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
                success: function (data) {

                    if (parseInt(data.stat) === 1) {
                        notif(1, "Berhasil mendapatkan data");
                        $('#modalInputdata').modal('show');
                        $('#izin_id').val(data.result['izin_id']).attr('disabled', true);
                        $("#izin_type").val(data.result['izin_type']).attr('disabled', true);
                        $("#izin_date_start").val(data.result['izin_date_start']).attr('disabled', true);
                        $("#izin_date_end").val(data.result['izin_date_end']).attr('disabled', true);
                        $("#izin_note").val(data.result['izin_note']).attr('disabled', true);
                        $(".suket-img").addClass('d-none');
                        var img = "<?php echo site_url('assets/media/surat/') ?>" + data.result.izin_image;
                        $('#preview').attr('src', img);
                        $('#add').addClass('d-none');
                        $('#update').addClass('d-none');
                        $('#form .form-control').attr('disabled', true);
                    } else if (parseInt(data.stat) === 1) {
                        notif(0, "Gagal mendapatkan data");
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

        $('#izin_date_start').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            dateFormat: 'dd-mm-yyyy',
            timePicker: false,
            timePicker24Hour: false,
            timePickerSeconds: false,
            singleDatePicker: true,
            minDate: today
        }, function (start, end, label) {
            $("#izin_date_start").val(start.format("YYYY-MM-DD"));
        });
        $('#izin_date_end').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            dateFormat: 'dd-mm-yyyy',
            timePicker: false,
            timePicker24Hour: false,
            timePickerSeconds: false,
            singleDatePicker: true,
            minDate: today
        }, function (start, end, label) {
            $("#izin_date_end").val(start.format("YYYY-MM-DD"));
        });
    });
</script>

