<div class="container-fluid px-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="card-title">Brand</h5>
                </div>
                <div class="card-body card-body-table">
                    <div class="clearfix">
                        <button type="button" id="btnBrand" class="float-right ml-2 btn btn-primary">Add Kategori</button>
                        <table id="tabel-data" class="table table-custom table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Merk</th>
                                    <th class="contain-action sm-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <th>Advan</th>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DIALOG -->
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
                    <input type="hidden" class="form-control d-none" id="brand_id">
                    <div class="form-group">
                        <label for="nim">Nama Brand</label>
                        <input type="text" class="form-control" id="brand_nama_merk" placeholder="Masukkan Nama Barang">
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
