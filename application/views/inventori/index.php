<div class="container-fluid px-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="card-title">Inventori</h5>
                </div>
                <div class="card-body card-body-table">
                    <div class="clearfix">
                        <button type="button" id="btnInventori" class="float-right ml-2 btn btn-primary">Add Inventori</button>
                        <table id="tabel-data" class="table table-custom table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Karyawan</th>
                                    <th>Nama Barang</th>
                                    <th>Brand</th>
                                    <th>Spesifikasi</th>
                                    <th>Jumlah</th>
                                    <th class="contain-action sm-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <th>LP-0001</th>
                                <th>Yudha</th>
                                <th>Laptop</th>
                                <th>Asus</th>
                                <th>Ram 4 gb</th>
                                <th>1</th>
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
                    <input type="hidden" class="form-control d-none" id="inventori_id">
                    <div class="form-group">
                        <label for="nim">Nama Karyawan</label>
                        <select class="form-control" id="karyawan_name">
                            <option selected="">Pilih</option>
                            <?php
                            foreach ($karyawan as $d) {
                                echo " <option value=" . $d['karyawan_id'] . "> " . $d['karyawan_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nim">Nama Barang</label>
                        <select class="form-control" id="categories_nama_barang">
                            <option selected=""> Pilih </option>
                            <?php 
                            foreach ($categories as $c){
                                echo "<option value=" . $c['categories_id']. "> " . $c['categories_nama_barang'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nim">Nama Merk</label>
                        <select class="form-control" id="brand_nama_merk">
                            <option selected=""> Pilih </option>
                            <?php 
                            foreach ($brands as $b){
                                echo "<option value=" . $b['brand_id']. "> " . $b['brand_nama_merk'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nim">Spesifikasi</label>
                        <input type="text" class="form-control" id="inventori_keterangan" placeholder="Masukkan Nama Barang">
                    </div>
                    <div class="form-group">
                        <label for="nim">Jumlah</label>
                        <input type="text" class="form-control" id="inventori_jumlah" placeholder="Masukkan Nama Barang">
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
