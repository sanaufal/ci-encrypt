<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5 class="card-title">Division</h5>
                </div>
                <div class="col-4">
                    <h5 class="card-title">Add Division</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <table id="table" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Division Name</th>
                                <th>Status</th>
                                <th class="contain-action sm-action">Action</th>
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
                                    <label>Division Name</label>
                                    <input class="form-control" id="name" name="name" type="text">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Division Detail</label>
                                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control digits valid" id="status">
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