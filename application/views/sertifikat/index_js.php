<div class="modal fade" id="tampilData" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tampilData">Info Magang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <div class="modal-body">
                <select class="form-control" id="magang_id">
                    <option value="0">-Pilih-</option>
                    <?php
                    foreach ($magang as $m) {
                        echo "<option value=" . $m['magang_id'] . "> " . $m['magang_user'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="tampil">Tampil</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var url = "<?= base_url('sertifikat/index'); ?>";
        var index = $("#tableSertifikat").DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "search"
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
                    'data': 'sertifikat_code'
                },
                {
                    'data': 'magang_user'
                },
                {
                    'data': 'partner_sekolah'
                },
                {
                    'data': 'sertifikat_id',
                    render: function(data, meta, row) {
                        var disp = '';
                        disp += '<div class="btn-action">';
                        disp += '<a class="btn btn-sm btn-floating btn-primary print-data" data-id="' + data + '">';
                        disp += '<i class="ti-printer"></i>';
                        disp += '<a>';
                        disp += '</div>';
                        return disp;
                    },
                    'className': 'contain-action sm-action'
                }
            ]
        });

        $('div.dataTables_wrapper input, div.dataTables_wrapper select').removeClass('form-control-sm');

        $('#btnInfo').on('click', function() {
            $('#tampilData').modal('show');
            $("#add").removeClass('d-none');
            $('#magang_id').val(0).trigger('change');
        });
        $(document).on('change', "#magang_id", function(e) {
            var a = $(this).val();
            $('#tampil').attr('data-idmagang', a);
        });
        $(document).on("click", "#add", function(e) {
            e.preventDefault();
            var next = true;
            var mesg = '';
            if (next) {
                if ($('#magang_id').val() == 0) {
                    mesg = "Harus Diisi";

                    next = false;
                }
            }
            if (next == true) {
                var data = {
                    sertifikat_code: $("#sertifikat_code").val(),
                    sertifikat_magang_id: $("#magang_id").val(),
                    action: "add"
                };
                console.log(data);
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function(data) {
                        if (parseInt(data.stat) === 1) {
                            $('#magang_id').val('0');
                            $('#form-data').trigger('reset');
                            $('#add').removeClass('d-none');
                            index.ajax.reload();
                            notif(1, data.mesg);
                        }else if(parseInt(data.stat) === 0){
                            notif(0,data.mesg); 
                       }
                    }
                });
            } else {
                alert(mesg);
            }

        });
        $(document).on("click", "#tampil", function(e) {
            e.preventDefault();
            var data = {
                id: $(this).attr('data-idmagang'),
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
                        $('#tampilData').modal('hide');

                        $("#magang_id").val(data.result['magang_id']);
                        $("#magang_nim").val(data.result['magang_nim']);
                        $("#magang_user").val(data.result['magang_user']);
                        $("#magang_phone").val(data.result['magang_phone']);
                        $("#magang_address").val(data.result['magang_address']);
                        $("#magang_divisi").val(data.result['division_name']);
                        $("#magang_sekolah").val(data.result['partner_sekolah']);
                        $('#form-data .form-control').attr('readonly', true);
                        $('textarea').attr('readonly', true);
                        $('#add').removeClass('d-none');
                    }
                }
            });
        });
        $(document).on("click", ".print-data", function(e) {
            e.preventDefault();
            // e.stopPropagation();
            var id = $(this).attr('data-id');
            var url = '<?= site_url('sertifikat/print/') ?>' + id;

            console.log(id);
            window.open(url, "_blank").print();
        });

        $("select.input-sm").select2({
            minimumResultsForSearch: -1
        });
    });
</script>