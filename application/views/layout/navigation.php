<div class="navigation">
    <div class="navigation-header">
        <span>Navigation</span>
        <a href="javascript:void();">
            <i class="ti-close"></i>
        </a>
    </div>
    <div class="navigation-menu-body">
        <ul>
            <li>
                <a class="<?php echo $_menu == 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="home"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'supplier' ? 'active' : ''; ?>" href="<?php echo base_url('supplier'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="users"></i>
                    </span>
                    <span>Supplier</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'karyawan' ? 'active' : ''; ?>" href="<?php echo base_url('karyawan'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="user"></i>
                    </span>
                    <span>Karyawan</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'user' ? 'active' : ''; ?>" href="<?php echo base_url('user'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="user"></i>
                    </span>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'user role' ? 'active' : ''; ?>" href="<?php echo base_url('user/user_role'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="user"></i>
                    </span>
                    <span>User Role</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'division' ? 'active' : ''; ?>" href="<?php echo base_url('division'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="briefcase"></i>
                    </span>
                    <span>Division</span>
                </a>
            </li>
            <li class="<?php echo $_menu == 'programmagang' ? 'open' : ''; ?>">
                <a href="#">
                    <span class="nav-link-icon">
                        <i data-feather="briefcase"></i>
                    </span>
                    <span>Program Magang</span>
                </a>
                <ul>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'magang'){echo 'active'; }}?>" href="<?php echo base_url('magang'); ?>">Magang</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'partner'){echo 'active'; }}?>" href="<?php echo base_url('partner'); ?>">Partner</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'sertifikat'){echo 'active'; }}?>" href="<?php echo base_url('sertifikat'); ?>">Sertifikat</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $_menu == 'marketing' ? 'open' : ''; ?>">
                <a href="#">
                    <span class="nav-link-icon">
                        <i data-feather="book-open"></i>
                    </span>
                    <span>Marketing</span>
                </a>
                <ul>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'prospek'){echo 'active'; }}?>" href="<?php echo base_url('prospek'); ?>">Prospek</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'client'){echo 'active'; }}?>" href="<?php echo base_url('client'); ?>">Client</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $_menu == 'formpersetujuan' ? 'open' : ''; ?>">
                <a href="#">
                    <span class="nav-link-icon">
                        <i data-feather="briefcase"></i>
                    </span>
                    <span>Form Persetujuan</span>
                </a>
                <ul>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'izin'){echo 'active'; }}?>" href="<?php echo base_url('izin'); ?>">Form Pengajuan</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'approved'){echo 'active'; }}?>" href="<?php echo base_url('izin/approved'); ?>">Form Approved</a>
                    </li>
                </ul>   
            </li>
            <li class="<?php echo $_menu == 'asset' ? 'open' : ''; ?>">
                <a href="#">
                    <span class="nav-link-icon">
                        <i data-feather="briefcase"></i>
                    </span>
                    <span>Asset</span>
                </a>
                <ul>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'kategori'){echo 'active'; }}?>" href="<?php echo base_url('kategori'); ?>">Kategori</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'brand'){echo 'active'; }}?>" href="<?php echo base_url('brand'); ?>">Brand</a>
                    </li>
                    <li>
                        <a class="<?php if(isset($_submenu)){ if($_submenu == 'inventori'){echo 'active'; }}?>" href="<?php echo base_url('inventori'); ?>">Inventori</a>
                    </li>
                </ul>   
            </li>
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i data-feather="menu"></i>
                    </span>
                    <span>Menu Level</span>
                </a>
                <ul>
                    <li>
                        <a href="#">Menu Level</a>
                        <ul>
                            <li>
                                <a href="#">Menu Level </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="disabled">
                    <span class="nav-link-icon">
                        <i data-feather="mouse-pointer"></i>
                    </span>
                    <span>Disabled</span>
                </a>
            </li>
            <li>
                <a class="<?php echo $_menu == 'settings' ? 'active' : ''; ?>" href="<?php echo base_url('settings/menu'); ?>">
                    <span class="nav-link-icon">
                        <i data-feather="settings"></i>
                    </span>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>