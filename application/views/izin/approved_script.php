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
                            <input type="text" class="form-control" id="izin_date_start" readonly="true">
                            <span class="icon-addon">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="izin_date_end">Selesai izin</label>
                        <div class="input-icon" data-icon="right">
                            <input type="text" class="form-control" id="izin_date_end" readonly="true">
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
                        <label for="alamat">Catatan</label>
                        <textarea id="izin_process_note" rows="4" class="form-control" placeholder="Catatan"></textarea>
                    </div>
                    <div class="form-group suket-img">
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
                <button class="btn btn-success approve" type="button">Approve</button>
                <button class="btn btn-danger reject" type="button">Reject</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var url = "<?php echo base_url('izin/approved'); ?>";

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

        var index = $('#tabelForm').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search"
            },
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "<?php echo site_url('Izin') ?>",
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
                {'data': 'izin_user'},
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
                            return '<span class="badge badge-success">Disetujui</span>';
                        } else if (parseInt(row.izin_stat) === 0) {
                            return '<span class="badge badge-primary">Diajukan</span>';
                        } else if (parseInt(row.izin_stat) === 2) {
                            return '<span class="badge badge-danger">Ditolak</span>';
                        }
                    }
                },
                {
                    'data': 'izin_id',
                    render: function (data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        if (parseInt(row.izin_stat) === 1) {
                            disp += '<a class="btn btn-sm btn-floating btn-primary print-data" data-id="' + data + '">';
                            disp += '<i class="ti-printer"></i>';
                            disp += '</a>';

                            disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-stat="' + row.izin_stat + '" data-id="' + data + '">';
                            disp += '<i class="ti-eye"></i>';
                            disp += '</a>';
                        }
                        if (parseInt(row.izin_stat) === 2) {
                            disp += '<a class="btn btn-sm btn-floating btn-primary print-data" data-id="' + data + '">';
                            disp += '<i class="ti-printer"></i>';
                            disp += '</a>';

                            disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-stat="' + row.izin_stat + '" data-id="' + data + '">';
                            disp += '<i class="ti-eye"></i>';
                            disp += '</a>';
                        }
                        if (parseInt(row.izin_stat) === 0) {

                            disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-stat="' + row.izin_stat + '" data-id="' + data + '">';
                            disp += '<i class="ti-save"></i>';
                            disp += '</a>';
                        }

                        return disp;
                    },
                    'className': 'contain-action sm-action'
                }
            ]
        });
        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        if ($("izin_id").val() == '' || $("izin_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#add').removeClass('d-none');
        }

        $(document).on("click", ".view-data", function (e) {
            e.preventDefault();
            if (parseInt($(this).data('stat')) === 0) {
                $(".reject").removeClass('d-none');
                $(".approve").removeClass('d-none');
                $("#izin_process_note").attr('disabled', false);
                $("#izin_date_start").attr('disabled', false);
                $("#izin_date_end").attr('disabled', false);
            } else if (parseInt($(this).data('stat')) === 1) {
                $(".reject").addClass('d-none');
                $(".approve").addClass('d-none');
                $("#izin_process_note").attr('disabled', true);
                $("#izin_date_start").attr('disabled', true);
                $("#izin_date_end").attr('disabled', true);
            } else if (parseInt($(this).data('stat')) === 2) {
                $(".reject").addClass('d-none');
                $(".approve").addClass('d-none');
                $("#izin_process_note").attr('disabled', true);
                $("#izin_date_start").attr('disabled', true);
                $("#izin_date_end").attr('disabled', true);
            }
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
                        $("#izin_date_start").val(data.result['izin_date_start']);
                        $("#izin_date_end").val(data.result['izin_date_end']);
                        $("#izin_note").val(data.result['izin_note']).attr('disabled', true);
                        $("#izin_process_note").val(data.result['izin_process_note']);
                        $(".suket-img").addClass('d-none');
                        var img = "<?php echo site_url('assets/media/surat/') ?>" + data.result.izin_image;
                        $('#preview').attr('src', img);
                    } else if (parseInt(data.stat) === 0) {
                        notif(0, "Gagal mendapatkan data");
                    }
                }
            });

        });

        $(document).on("click", ".approve", function (e) {
            e.preventDefault();
            var data = {
                id: $("#izin_id").val(),
                stat: 1,
                action: "stat",
                date_start: $('#izin_date_start').val(),
                date_end: $('#izin_date_end').val(),
                p_note: $('#izin_process_note').val(),
            };

            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('#modalInputdata').modal('hide');
                        notif(1, "berhasil di approve");
                        index.ajax.reload();
                    }
                }
            });
        });
        $(document).on("click", ".reject", function (e) {
            e.preventDefault();
            var data = {
                id: $("#izin_id").val(),
                stat: 2,
                action: "stat",
                date_start: $('#izin_date_start').val(),
                date_end: $('#izin_date_end').val(),
                p_note: $('#izin_process_note').val(),
            };

            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('#modalInputdata').modal('hide');
                        notif(1, "berhasil di approve");
                        index.ajax.reload();
                    }
                }
            });
        });
        $(document).on("click", ".print-data", function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var type = $(this).data('type');
            $.post('<?= base_url('izin/print') ?>', {
                id: id
            }, function (res) {
                var x = screen.width / 2 - 700 / 2;
                var y = screen.height / 2 - 450 / 2;
                var myWindow = window.open("", "Print Izin", 'width=700,height=485,left=' + x + ',top=' + y + '');
                myWindow.document.write(res);
            });
        });

    });
</script>        