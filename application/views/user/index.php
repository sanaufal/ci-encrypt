<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="clearfix">
                <button id="AddUser" class="float-right ml-2 btn btn-primary">Add User</button>
                <table id="table" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="contain-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div><!-- end container-fluid -->

<!-- Modal Dialog -->
<div class="modal fade" id="ModalUser" tabindex="-1">
    <div class="modal-dialog modal-xl modal-scroll" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-data">
                    <input type="hidden" id="data_id">
                    <div class="row">
                        <div class="col-6">
                            <!-- start col left -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="FullName">Full Name</label>
                                    <input type="text" id="FullName" name="fullname" class="form-control" tabindex="1">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Username">Username</label>
                                    <input type="text" id="Username" name="username" class="form-control" tabindex="3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Gender">Gender</label>
                                    <select class="form-control" id="Gender" name="gender" tabindex="6">
                                        <option value="1">Laki-laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Role">Role</label>
                                    <select class="form-control" id="Role" name="role" tabindex="5">
                                        <?php
                                        foreach ($_role as $r) {
                                            echo '<option value="' . $r->role_user . '">' . $r->role_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Photo">Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input img-input" id="Photo">
                                        <label class="custom-file-label" for="Photo">Choose file...</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="img-container img-container-sm">
                                        <img class="img-preview" src="<?php echo base_url('assets/images/no-image.png'); ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col left -->

                        <div class="col-md-6">
                            <!-- start col right -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Email">Email</label>
                                    <input type="email" name="email" id="Email" class="form-control" tabindex="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Password">Password</label>
                                    <input type="password" name="password" id="Password" class="form-control" tabindex="4">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Address">Address</label>
                                    <textarea name="address" id="Address" class="form-control textarea-sm" rows="1"></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="City">City</label>
                                    <select name="city" id="City" class="form-control">
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Province">Province</label>
                                    <select name="province" id="Province" class="form-control" disabled="true">
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Country">Country</label>
                                    <select name="country" id="Country" class="form-control" disabled="true">
                                    </select>
                                </div>

                            </div><!-- end col right -->

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="Create" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>