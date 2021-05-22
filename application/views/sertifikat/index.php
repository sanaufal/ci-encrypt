<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-8">
                    <h5 class="card-title">Sertifikat</h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="button" id="btnInfo">Info Magang</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <table id="tableSertifikat" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Nomor Sertifikat</th>
                                <th>Nama</th>
                                <th>Sekolah</th>
                                <th class="contain-action sm-action">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>   
                    </table>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <form id="form-data">
                        <input value="0" type="hidden" id="magang_id" />
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>NIM</label>
                                    <input class="form-control" id="magang_nim" name="Nama" type="text">
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" id="magang_user" name="Nama" type="text">
                                </div>

                                <div class="form-group">
                                    <label for="telp">Nomor Telp</label>
                                    <input type="number" class="form-control form-number-custom" id="magang_phone" data-only="number" min="0">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="magang_address" rows="10"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" name="devisi" id="magang_divisi">
                                </div>

                                <div class="form-group">
                                    <label>Sekolah</label>
                                    <input type="text" class="form-control" name="sekolah" id="magang_sekolah">
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-none" type="button" id="add">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--div class="page-header">
        <div class="row align-items-center justify-content-between">
                <div class="col-6">
                        <h3>
                                Sertifikat
                        </h3>
                </div>
                <div class="col-auto">
                        <button class="btn btn-primary" type="button" id="btnInfo">Info Magang</button>
                </div>
        </div>

</div>
<div class="row">
        <div class="col-12">
                <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                        <table id="tabel-magang" class="table w-100">
                                                <thead>
                                                        <tr>
                                                                <th>Nomor Sertifikat</th>
                                                                <th>Nama</th>
                                                                <th>Sekolah</th>
                                                                <th>Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                                <td>99245448383356789</td>
                                                                <td>Balqis Seisar Amalia</td>
                                                                <td>UDINUS</td>
                                                                <td>
                                                                        <a class="btn btn-xs btn-floating btn-primary" href="#"><i
                                                                                        class="ti-printer"></i></a>
                                                                </td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                </div>
                        </div>
                </div>
        </div>
</div-->
