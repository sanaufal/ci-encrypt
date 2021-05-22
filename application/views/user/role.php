<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>Role Lists</h5>
                </div>
                <div class="col-4">
                    <h5>Add Roles</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <table id="table" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Role User</th>
                                <th>Role Status</th>
                                <th class="contain-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <form id="form-data">
                        <input type="hidden" id="data_id" />
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input class="form-control" id="RoleName" name="rolename" type="text">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Role User</label>
                                    <input class="form-control" id="RoleUser" name="roleuser" type="text">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Role Status</label>
                                    <select class="form-control digits" name="rolestatus" id="RoleStatus">
                                        <option value="1">Active</option>
                                        <option value="0">Non-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button id="Cancel" class="btn btn-pill btn-light mr-2" type="button">Cancel</button>
                        <button id="Create" class="btn btn-pill btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>