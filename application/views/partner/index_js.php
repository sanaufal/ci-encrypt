<div class="modal fade" id="modalInputPartner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Input Partner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-user">
                    <div class="form-group">
                        <input type="hidden" class="form-control d-none" id="partner_id">
                    </div>
                    <div class="form-group">
                        <label for="namaSekolah">Nama Sekolah</label>
                        <input type="text" class="form-control" id="partner_sekolah" placeholder="Masukkan Nama Sekolah">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="partner_address" placeholder="Masukkan Alamat">
                    </div>
                    <div class="form-group">
                        <label for="pic">PIC</label>
                        <input type="text" class="form-control" id="partner_pic" placeholder="Masukkan PIC">
                    </div>
                    <div class="form-group">
                        <label for="telp">Nomor Telp</label>
                        <input type="number" class="form-control form-number-custom" id="partner_phone" placeholder="Masukkan Nomor Telpon" data-only="number" min="0">
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <div class="input-button" data-button="right">
                            <input type="file" class="form-control" readonly placeholder="Upload File" id="partner_img">
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
                <button class="btn btn-primary" type="button" id="tambah">Tambah</button>
                <button class="btn btn-primary d-none" type="button" id="update">Update</button>
                <button type="reset" class="btn btn-danger d-none">Reset</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var url = "<?= base_url('partner/index'); ?>";
        var index = $("#tableData").DataTable({
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
                    'data': 'partner_sekolah'
                },
                {
                    'data': 'partner_address'
                },
                {
                    'data': 'partner_pic',
                    render: function(data, meta, row) {
                        if (row.partner_phone != 0) {
                            return '<b>' + data + '</b><br>' + row.partner_phone;
                        }
                    }
                },
                {
                    'data': 'partner_img',
                    render: function(data, meta, row) {
                        if (data != null) {
                            return '<img class="img-fluid rounded-circle" width="40" height="40" src="<?php echo base_url('assets/media/image/logo/'); ?>' + data + '" alt="alt"/>';
                        } else {
                            return '<img class="img-fluid rounded-circle" width="40" height="40" src="<?php echo base_url('assets/media/image/logo/logodefault.png'); ?>" alt="alt"/>';
                        }
                    },
                },
                {
                    'data': 'partner_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        disp += '<a class="btn btn-sm btn-floating btn-primary edit-data" data-id="' + data + '">';
                        disp += '<i class="ti-pencil"></i>';
                        disp += '</a>';

                        disp += '<a class="btn btn-sm btn-floating btn-light view-data" data-id="' + data + '">';
                        disp += '<i class="ti-eye"></i>';
                        disp += '</a>';
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action xs-action'
                }
            ]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $('#btnTambahPartner').on('click', function() {
            $('#modalInputPartner').modal('show');
            $('#tambah').removeClass('d-none');
            $('#update').addClass('d-none');
            $('input').removeAttr('readonly');
            $('textarea').removeAttr('readonly');
            $('#preview').attr('src', '');
            document.getElementById("form-user").reset();
        });

        if ($("partner_id").val() == '' || $("partner_id").val() == 0) {
            $('#update').addClass('d-none');
        } else {
            $('#update').addClass('d-none');
            $('#tambah').removeClass('d-none');
        }

        $(document).on("click", "#tambah", function(e) {
            e.preventDefault();
            var next = true;
            if (next) {
                if ($("#partner_sekolah").val() == '') {
                    notif(0, "Sekolah harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#partner_address").val() == '') {
                    notif(0, "Alamat harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#partner_pic").val() == '') {
                    notif(0, "Pic harus diisi");
                    next = false;
                }
            }
            if (next) {
                if ($("#partner_phone").val() == '') {
                    notif(0, "No harus diisi");
                    next = false;
                }
            }
            if (next == true) {
                var formData = new FormData();
                formData.append('action', 'save');
                formData.append('partner_id', $("#partner_id").val());
                formData.append('partner_sekolah', $("#partner_sekolah").val());
                formData.append('partner_address', $("#partner_address").val());
                formData.append('partner_pic', $("#partner_pic").val());
                formData.append('partner_phone', $("#partner_phone").val());
                formData.append('partner_img', $("#file_upload").val());
                formData.append('upload', $('#partner_img')[0].files[0]);
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
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            $('#update').hide();
                            document.getElementById("form-user").reset();
                            $('#tambah').removeClass('d-none');
                            index.ajax.reload();
                            notif(1, "Data berhasil ditambahkan");
                        }else if(parseInt(data.stat) === 0){
                            notif(0, "Data tidak berhasil ditambahkan");
                        }
                    }
                });
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
                        notif(1, "Berhasil Mendapatkan data");
                        $('#modalInputPartner').modal('show');
                        $("#partner_id").val(data.result['partner_id']);
                        $("#partner_sekolah").val(data.result['partner_sekolah']);
                        $("#partner_address").val(data.result['partner_address']);
                        $("#partner_pic").val(data.result['partner_pic']);
                        $("#partner_phone").val(data.result['partner_phone']);
                        $("#preview").attr('src', '<?php echo site_url('assets/media/image/logo/'); ?>' + data.result['partner_img'] + '');
                        $('#tambah').addClass('d-none');
                        $('#update').removeClass('d-none');
                        $('input').removeAttr('readonly');
                        $('textarea').removeAttr('readonly');
                    }else if(ParseInt(data.stat) === 0){
                        notif(0, "Gagal mendapatkan data");
                    }
                }
            });

        });
        $(document).on("click", "#update", function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('action', 'update');
            formData.append('partner_id', $("#partner_id").val());
            formData.append('partner_sekolah', $("#partner_sekolah").val());
            formData.append('partner_address', $("#partner_address").val());
            formData.append('partner_pic', $("#partner_pic").val());
            formData.append('partner_phone', $("#partner_phone").val());
            formData.append('partner_img', $("#file_upload").val());
            formData.append('upload', $('#partner_img')[0].files[0]);
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
                success: function(data) {
                    if (parseInt(data.stat) === 1) {
                        $('#update').addClass('d-none');
                        document.getElementById("form-user").reset();
                        $('#tambah').removeClass('d-none');
                        $('#modalInputPartner').modal('hide');
                        index.ajax.reload();
                        notif(1, data.mesg);
                    }else if(parseInt(data.stat) === 0){
                        notif(0, data.mesg);
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
                    console.log(data);
                    if (parseInt(data.stat) === 1) {
                        notif(1, "Berhasil mendapatkan data");
                        $('#modalInputPartner').modal('show');

                        $("#partner_id").val(data.result['partner_id']);
                        $("#partner_sekolah").val(data.result['partner_sekolah']);
                        $("#partner_address").val(data.result['partner_address']);
                        $("#partner_pic").val(data.result['partner_pic']);
                        $("#partner_phone").val(data.result['partner_phone']);
                        $("#preview").attr('src', '<?php echo site_url('assets/media/image/logo/'); ?>' + data.result['partner_img'] + '');
                        $('#tambah').addClass('d-none');
                        $('#update').addClass('d-none');
                        $('#form-user .form-control').attr('readonly', true);
                        $('textarea').attr('readonly', true);
                    }else if(parseInt(data.stat) === 1){
                        notif(0, "Gagal mendapatkan data");
                    }
                }
            });

        });
        $('#partner_img').change(function(e) {
            var fileName = e.target.files[0].name;
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#file_upload').val(fileName);
            };
            reader.readAsDataURL(this.files[0]);
        });
        $("select.input-sm").select2({
            minimumResultsForSearch: -1
        });
    });
</script>