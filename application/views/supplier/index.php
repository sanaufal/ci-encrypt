<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="clearfix">
                        <button type="button" id="btnSupplier" class="float-right ml-2 btn btn-primary">Add Supplier</button>
                        <table id="table-data" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Supplier</th>
                                    <th>PIC Name</th>
                                    <th class="contain-action sm-action">Action</th>
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
<div class="modal fade" id="modalSupplier"">
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
                            <label for="NPWP">NPWP</label>
                            <input type="text" id="npwp" name="npwp" class="form-control" placeholder="00.000.000.0-000.000">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Namr">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Phone1">Number Phone 1</label>
                            <input type="number" id="phone1" name="phone1" class="form-control form-number-custom" data-only="number" min="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="Phone2">Number Phone 2</label>
                            <input type="number" id="phone2" class="form-control form-number-custom" data-only="number" min="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="PIC">PIC Name</label>
                            <input type="text" id="pic_name" name="pic_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="NumberPIC">Number Phone PIC</label>
                            <input type="number" id="phone_pic" name="phone_pic" class="form-control form-number-custom" data-only="number" min="0">
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
                            <select name="country" id="country" class="form-control" disabled="true">
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