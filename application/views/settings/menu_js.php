<!-- Modal Edit Menu -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="editLabel">Menu Label</label>
                        <input type="text" id="editMenu" class="form-control" placeholder="Menu Label">
                    </div>
                    <div class="form-group">
                        <label for="editUrl">Link URL</label>
                        <div class="input-icon" data-icon="left">
                            <input type="text" id="editUrl" class="form-control">
                            <span class="icon-addon">
                                <i data-feather="link"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="box">
                                    <i data-feather="image" id="editPreview" class="icon icon-xl"></i>
                                </div>
                            </div>
                            <div class="col">
                                <label for="editIcon">Icon Name</label>
                                <input type="text" id="editIcon" class="form-control" placeholder="e.g. circle, arrow-right">
                                <span class="mt-1 small">source icon: <a class="a-custom-v2" href="https://feathericons.com/" target="_blank">feathericons.com</a></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button id="updateMenu" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Sub Menu -->
<div class="modal fade" id="modalSubmenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sub Menu</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="editParentmenu">Parent Menu</label>
                        <select id="editParentMenu" class="form-control">
                            <?php
                            foreach ($_option as $opt) {
                                echo '<option value="' . $opt->menu_id . '">' . $opt->menu_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editSublabel">Sub Menu Label</label>
                        <input type="text" id="editSubMenu" class="form-control" placeholder="Sub Menu Label">
                    </div>
                    <div class="form-group">
                        <label for="editSuburl">Link URL</label>
                        <div class="input-icon" data-icon="left">
                            <input type="text" id="editSubUrl" class="form-control">
                            <span class="icon-addon">
                                <i data-feather="link"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button id="updateSubMenu" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        feather.replace({
            'stroke-width': 1
        });
        var url = "<?php echo site_url('Settings/menu'); ?>"
        var iEdit = feather.icons['edit-2'].toSvg({
            class: 'icon'
        });
        var iDefaulticon = feather.icons['image'].toSvg();
        var iPlus = feather.icons['plus-circle'].toSvg({
            class: 'icon'
        });
        var iOption = feather.icons['more-vertical'].toSvg({
            class: 'icon'
        });
        var iMenu = feather.icons['image'].toSvg({
            class: 'mr-3 icon icon-lg'
        });
        function loadData() {
            var data = {
                action: 'loadMenu'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('.list-menu').remove();
                        var disp = '';
                        $.each(data.data, function (i, v) {
                            disp += '<li class="list-group-item list-menu">';
                            disp += '' + iMenu + '';
                            disp += '<div class="list-group-item-text">';
                            disp += '<h6>' + v.menu_name + '</h6>';
                            disp += '<div class="color-contrast-medium">Link:' + v.menu_url + '</div>';
                            disp += '</div>';
                            disp += '<div class="dropdown dropdown-icon dropdown-v2 ml-auto">';
                            disp += '<button class="btn btn-light dropdown-toggle btn-icon btn-circle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                            disp += '' + iOption + '';
                            disp += '</button>';
                            disp += '<div class="dropdown-menu dropdown-menu-right">';
                            disp += '<h6 class="dropdown-header">Action:</h6>';
                            disp += '<a class="dropdown-item editMenu" href="javascript: void(0);" data-id="' + v.menu_id + '">Edit</a>';
                            disp += '<a class="dropdown-item Inactive" href="javascript: void(0);" data-id="' + v.menu_id + '">Inactive</a>';
                            disp += '<a class="dropdown-item Active d-none" href="javascript: void(0);" data-id="' + v.menu_id + '">Active</a>';
                            disp += '<a class="dropdown-item text-danger deleteMenu" href="javascript: void(0);" data-id="' + v.menu_id + '" data-name="' + v.menu_name + '">Delete</a>';
                            disp += '</div>';
                            disp += '</div>';
                            $.each(v.submenu, function (i, v) {
                                disp += '<ul class="list-group">';
                                disp += '<li class="list-group-item">';
                                disp += '<div class="list-group-item-text">';
                                disp += '<p>' + v.menu_name + '</p>';
                                disp += '<div class="color-contrast-medium">Link: ' + v.menu_url + '</div>';
                                disp += '</div>';
                                disp += '<div class="dropdown dropdown-icon dropdown-v2 ml-auto">';
                                disp += '<button class="btn btn-light dropdown-toggle btn-icon btn-circle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                                disp += '' + iOption + '';
                                disp += '</button>';
                                disp += '<div class="dropdown-menu dropdown-menu-right">';
                                disp += '<h6 class="dropdown-header">Action:</h6>';
                                disp += '<a class="dropdown-item editSubmenu" href="javascript: void(0);" data-id="' + v.menu_id + '">Edit</a>';
                                disp += '<a class="dropdown-item Inactive" href="javascript: void(0);" data-id="' + v.menu_id + '">Inactive</a>';
                                disp += '<a class="dropdown-item Active d-none" href="javascript: void(0);" data-id="' + v.menu_id + '">Active</a>';
                                disp += '<a class="dropdown-item text-danger deleteMenu" href="javascript: void(0);" data-id="' + v.menu_id + '" data-name="' + v.menu_name + '">Delete</a>';
                                disp += '</div>';
                                disp += '</div>';
                                disp += '</li>';
                                disp += '</ul>';
                            });
                            disp += '</li>'
                        });
                        return $('.container-content').append(disp);
                        notif(1, data.mesg);
                    }
                }
            });
        }
        loadData();
        // Icon Preview
        $('#iconMenu').on('change keyup', function () {
            var nameIcon = $(this).val().toLowerCase();
            $('#iconPreview').replaceWith(feather.icons[nameIcon].toSvg({
                id: 'iconPreview',
                class: 'icon icon-xl',
                'stroke-width': 1,
            }));
            console.clear();
        });
        $('#editIcon').on('change keyup', function () {
            var nameIcon = $(this).val().toLowerCase();
            $('#editPreview').replaceWith(feather.icons[nameIcon].toSvg({
                id: 'iconPreview',
                class: 'icon icon-xl',
                'stroke-width': 1,
            }));
            console.clear();
        });

        //Save Menu
        $('#btnSave').on('click', function () {
            var next = true;
            if (next) {
                if ($('#menuName').val().length === '') {
                    next = false;
                    notif(0, "Nama Menu Diperlukan!");
                }
            }
            if (next) {
                if ($('#urlMenu').val().length === '') {
                    next = false;
                    notif(0, "Link Menu Diperlukan!");
                }
            }
            if (next) {
                if ($('#iconMenu').val().length === '') {
                    next = false;
                    notif(0, "Icon Menu Diperlukan!");
                }
            }
            var data = {
                name: $('#menuName').val(),
                url: $('#urlMenu').val(),
                icon: $('#iconMenu').val(),
                action: 'add-menu'
            };
            if (next) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function (data) {
                        console.log(data.data);
                        if (parseInt(data.stat) === 1) {
                            $('#menuName').val('');
                            $('#urlMenu').val('');
                            $('#iconMenu').val('');
                            $("#parentMenu").append('<option value="' + data.data.menu_id + '">' + data.data.menu_name + '</option>');
                            $("#editParentMenu").append('<option value="' + data.data.menu_id + '">' + data.data.menu_name + '</option>');
                            notif(data.stat, data.mesg);
                            loadData();
                        } else {
                            notif(data.stat, data.mesg);
                        }
                    }
                });
            }

        });
        $('#btnSaveSub').on('click', function () {
            var next = true;
            if (next) {
                if ($('#subName').val().length === '') {
                    next = false;
                    notif(0, "Nama Sub Menu Diperlukan!");
                }
            }
            if (next) {
                if ($('#subUrl').val().length === '') {
                    next = false;
                    notif(0, "Link Sub Menu Diperlukan!");
                }
            }
            var data = {
                parent_id: $('#parentMenu').val(),
                name: $('#subName').val(),
                url: $('#subUrl').val(),
                action: 'add-sub'
            };
            if (next) {
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    success: function (data) {
                        console.log(data.data);
                        if (parseInt(data.stat) === 1) {
                            $('#parentMenu').val('1');
                            $('#subName').val('');
                            $('#subUrl').val('');
                            notif(data.stat, data.mesg);
                            loadData();
                        } else {
                            notif(data.stat, data.mesg);
                        }
                    }
                });
            }

        });

        // Button edit menu
        $(document).on('click', '.editMenu', function () {
            $('#modalMenu').modal('show');
            var data = {
                id: $(this).data('id'),
                action: 'get-menu'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    console.log(data.data)
                    if (parseInt(data.stat) === 1) {
                        $('#updateMenu').attr('data-id', data.data.menu_id);
                        $('#editMenu').val(data.data.menu_name);
                        $('#editUrl').val(data.data.menu_url);
                        $('#editIcon').val(data.data.menu_icon);
                        $('#editPreview').replaceWith(feather.icons[data.data.menu_icon].toSvg({
                            id: 'editPreview',
                            class: 'icon icon-xl',
                            'stroke-width': 1,
                        }));
                    }
                }
            });
        });
        $(document).on('click', '#updateMenu', function () {
            var data = {
                id: $(this).data('id'),
                menu: $('#editMenu').val(),
                url: $('#editUrl').val(),
                icon: $('#editIcon').val(),
                action: 'update-menu'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('#modalMenu').modal('hide');
                        $('#editMenu').val('');
                        $('#editUrl').val('');
                        $('#editIcon').val('');
                        loadData();
                        notif(data.stat, data.mesg);
                    }
                }
            });
        });

        // Button edit sub menu
        $(document).on('click', '.editSubmenu', function () {
            $('#modalSubmenu').modal('show');
            var data = {
                id: $(this).data('id'),
                action: 'get-menu'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    console.log(data.data);
                    if (parseInt(data.stat) === 1) {
                        $('#updateSubMenu').attr('data-id', data.data.menu_id);
                        $('#editSubMenu').val(data.data.menu_name);
                        $('#editSubUrl').val(data.data.menu_url);
                        $('#editParentMenu').val(data.data.menu_parent_id).trigger('change');
                    }
                }
            });
        });
        $(document).on('click', '#updateSubMenu', function () {
            var data = {
                id: $(this).data('id'),
                parent: $('#editParentMenu').val(),
                menu: $('#editSubMenu').val(),
                url: $('#editSubUrl').val(),
                action: 'update-sub-menu'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        $('#modalSubmenu').modal('hide');
                        $('#editSubMenu').val('');
                        $('#editSubUrl').val('');
                        $('#editParentMenu').val('');
                        loadData();
                        notif(data.stat, data.mesg);
                    }
                }
            });
        });

        // Button inactive menu
        $(document).on('click', '.Inactive', function () {
            $(this).closest('li').addClass('disabled');
            $(this).addClass('d-none');
            $(this).next('.Active').removeClass('d-none');
            var data = {
                stat: 0,
                id: $(this).data('id'),
                action: 'update-stat'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        notif(data.stat, 'Berhasil Mengaktifkan Menu');
                    }
                }
            });
        });

        // Button active menu
        $(document).on('click', '.Active', function () {
            $(this).closest('li').removeClass('disabled');
            $(this).addClass('d-none');
            $(this).prev('.Inactive').removeClass('d-none');
            var data = {
                stat: 1,
                id: $(this).data('id'),
                action: 'update-stat'
            };
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                success: function (data) {
                    if (parseInt(data.stat) === 1) {
                        notif(data.stat, 'Berhasil Mengaktifkan Menu');
                    }
                }
            });
        });

        //Button Delete Menu
        $(document).on('click', '.deleteMenu', function () {
            var name = $(this).data('name');
            var data = {
                stat: 4,
                id: $(this).data('id'),
                action: 'update-stat'
            };
            $.confirm({
                title: 'Hapus menu ' + name + '?',
                content: '',
                theme: 'modern blur',
                draggable: false,
                backgroundDismiss: function () {
                    return false;
                },
                closeAnimation: 'opacity',
                buttons: {
                    Tidak: {
                        text: 'Tidak',
                        btnClass: 'btn-green',
                        action: function () {}
                    },
                    Ya: {
                        text: 'Ya',
                        btnClass: 'btn-red',
                        keys: ['enter'],
                        action: function () {
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                dataType: 'json',
                                cache: 'false',
                                success: function (data) {
                                    if (parseInt(data.stat) === 1) {
                                        notif(data.stat, data.mesg);
                                        loadData();
                                    }
                                }
                            });
                        }
                    }
                }
            });
        });
        //Button Cancel
        $('.btn-cancel').on('click', function () {
            $('#menuName').val('');
            $('#urlMenu').val('');
            $('#iconMenu').val('');
            $('#parentMenu').val('1');
            $('#subName').val('');
            $('#subUrl').val('');
        });
    });
</script>