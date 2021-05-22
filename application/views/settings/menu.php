<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add Menu</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="menuLabel">Menu Label</label>
                            <input id="menuName" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="linkUrl">Link URL</label>
                            <div class="input-icon" data-icon="left">
                                <input type="text" id="urlMenu" class="form-control" placeholder="Controller/function">
                                <span class="icon-addon">
                                    <i data-feather="link"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <div class="box">
                                        <i data-feather="image" id="iconPreview" class="icon icon-xl"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="iconName">Icon Name</label>
                                    <input type="text" id="iconMenu" class="form-control" placeholder="e.g. circle, arrow-right">
                                    <span class="mt-1 small">source icon: <a class="a-custom-v2" href="https://feathericons.com/" target="_blank">feathericons.com</a></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-light mr-2 btn-cancel">Cancel</button>
                    <button id="btnSave" type="button" class="btn btn-primary">Add Menu</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add Sub Menu</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="parentMenu">Parent Menu</label>
                            <select id="parentMenu" class="form-control">
                                <?php
                                foreach ($_option as $opt) {
                                    echo '<option value="' . $opt->menu_id . '">' . $opt->menu_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subLabel">Sub Menu Label</label>
                            <input type="text" id="subName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="linkUrlsub">Link URL</label>
                            <div class="input-icon" data-icon="left">
                                <input type="text" id="subUrl" class="form-control">
                                <span class="icon-addon">
                                    <i data-feather="link"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-light mr-2 btn-cancel">Cancel</button>
                    <button id="btnSaveSub" type="button" class="btn btn-primary">Add Sub Menu</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Structure Menu
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-v2 container-content">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>