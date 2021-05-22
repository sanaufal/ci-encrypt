<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="clearfix">
                        <button type="button" id="btnKrywn" class="float-right ml-2 btn btn-primary">Add Karyawan</button>
                        <table id="tableKrywn" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Divisi</th>
                                    <th>Role</th>
                                    <th class="contain-action xs-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DIALOG -->
<div class="modal fade" id="modalKrywn"">
    <div class=" modal-dialog modal-lg modal-scroll" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
            <form id="form-data">
                <input type="hidden" id="data_id">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="NIK">NIK</label>
                            <input type="number" id="nik" name="nik" class="form-control form-number-custom" data-only="number" min="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" id="code" name="code" class="form-control" disabled="true" placeholder="automatic">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" id="phone" name="phone" class="form-control form-number-custom" data-only="number" min="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="divisi" id="divisi" class="form-control">
                                <option selected disabled>Choice</option>
                                <?php foreach ($divisi as $d) {
                                    echo '<option value="' . $d['division_id'] . '">' . $d['division_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <?php foreach ($role as $r) {
                                    echo '<option value="' . $r['role_id'] . '">' . $r['role_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="Address">Address</label>
                            <textarea id="address" name="address" class="form-control" cols="5"></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>City</label>
                            <select name="city" id="city" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>State</label>
                            <select name="state" id="state" class="form-control" disabled="true">
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Country</label>
                            <select name="state" id="country" class="form-control" disabled="true">
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="Cancel" class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
            <button id="Create" class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</div>
</div>