<div class="page-header">
    <div>
        <h3>Setting Profiles</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profileContent" role="tab" aria-controls="profile-tab" aria-selected="true">Profile</a>
                    <a class="nav-link" id="password-tab" data-toggle="pill" href="#passwordContent" role="tab" aria-controls="password-tab" aria-selected="false">Password</a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="profileContent" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Profile</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="d-flex">
                                        <figure class="mr-3">
                                            <img class="rounded-pill border border-contrast-lower" id="imgProfile" src="<?php echo base_url('assets'); ?>/media/image/user/women_avatar1.jpg" alt="profile-image" width="100" height="100">
                                        </figure>
                                        <div>
                                            <p class="fullname">test</p>
                                            <div class="file-upload">
                                                <label for="Upload" class="btn btn-outline-primary">
                                                    Change Avatar
                                                    <input type="file" id="Upload" class="sr-only" tabindex="-1">
                                                </label>
                                            </div>
                                            <button type="button" id="Remove" class="btn btn-outline-danger">Remove Avatar</button>
                                            <p class="small text-muted mt-3">
                                                For best results, use an image at least
                                                512px by 512px in either .jpg or .png format
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="solid">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fullName">Full Name</label>
                                                <input type="text" id="fullName" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Username">Username</label>
                                                <input type="text" id="Username" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Gender">Gender</label>
                                                <select class="form-control valid" id="Gender" name="gender" tabindex="6" aria-invalid="false">
                                                    <option value="1">Laki-laki</option>
                                                    <option value="2">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Role">User Role</label>
                                                <select class="form-control" id="Role" name="role" tabindex="5">
                                                    <?php
                                                    foreach ($_role as $r) {
                                                        echo '<option value="' . $r->role_user . '">' . $r->role_name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Status">Status</label>
                                                <select id="Status" class="form-control">
                                                    <option value="1" selected="">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Department">Division</label>
                                                <select class="form-control" id="Division" name="role" tabindex="5">
                                                    <?php
                                                    foreach ($_division as $d) {
                                                        echo '<option value="' . $d['division_id'] . '">' . $d['division_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="solid">
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                    <button id="SvProfile" type="button" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Contact</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" id="Phone" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Email">Email Address</label>
                                                <input type="text" id="Email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="Address">Address</label>
                                                <textarea id="Address" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="City">City</label>
                                                <select name="city" id="City" class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Province">State</label>
                                                <select name="province" id="Province" class="form-control" disabled="true">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Country">Country</label>
                                                <select name="country" id="Country" class="form-control" disabled="true">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="solid">
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                    <button id="SvContact" type="button" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="passwordContent" role="tabpanel" aria-labelledby="password-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Password</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="oldPassword">Old Password</label>
                                                <div class="input-button input-password" data-button="right">
                                                    <input type="password" id="oldpwd" class="form-control">
                                                    <span class="btn-addon">
                                                        <a href="javascript: void(0);" class="btn-icon btn-circle btnshowPass" tabindex="-1">
                                                            <i data-feather="eye" class="icon stroke-2"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="newPassword">New Password</label>
                                                <div class="input-button input-password" data-button="right">
                                                    <input type="password" id="pass" class="form-control">
                                                    <span class="btn-addon">
                                                        <a href="javascript: void(0);" class="btn-icon btn-circle btnshowPass" tabindex="-1">
                                                            <i data-feather="eye" class="icon stroke-2"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="newPasswordrepeat">New Password Repeat</label>
                                                <div class="input-button input-password" data-button="right">
                                                    <input type="password" id="conf_pass" class="form-control">
                                                    <span id="message"></span>
                                                    <span class="btn-addon">
                                                        <a href="javascript: void(0);" class="btn-icon btn-circle btnshowPass" tabindex="-1">
                                                            <i data-feather="eye" class="icon stroke-2"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="solid">
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                    <button id="btnPass" type="button" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>