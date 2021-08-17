    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-bell"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Notifbell</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <?php if ($role_id == 1) : ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Admin') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Nav Item - role -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Admin/role') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Role</span>
                </a>
            </li>

            <!-- Nav Item - user -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Admin/user') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($role_id == 2) : ?>
            <!-- Nav Item - Profile -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('User') ?>">
                    <i class="fas fa-fw fa-address-card"></i>
                    <span>Profile</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Manage Data
            </div>

            <!-- Nav Item - aplikasi -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('User/aplikasi') ?>">
                    <i class="far fa-fw fa-window-restore"></i>
                    <span>Aplikasi</span>
                </a>
            </li>

            <!-- Nav Item - Pages Collapse pengguna aplikasi -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#penggunaAplikasi" aria-expanded="true" aria-controls="penggunaAplikasi">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Pengguna Aplikasi</span>
                </a>
                <div id="penggunaAplikasi" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Aplikasi : </h6>
                        <a class="collapse-item" href="<?= base_url('User/pengguna/Cabriz') ?>">
                            <i class="fa fa-fw fa-clone mr-2"></i>
                            Cabriz
                        </a>
                        <a class="collapse-item" href="<?= base_url('User/pengguna/Naest') ?>">
                            <i class="fa fa-fw fa-clone mr-2"></i>
                            Na'est
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="far fa-fw fa-bell"></i>
                    <span>Notifikasi</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Aplikasi : </h6>
                        <a class="collapse-item" href="<?= base_url('User/notifikasi/Cabriz') ?>">
                            <i class="fa fa-fw fa-clone mr-2"></i>
                            Cabriz
                        </a>
                        <a class="collapse-item" href="<?= base_url('User/notifikasi/Naest') ?>">
                            <i class="fa fa-fw fa-clone mr-2"></i>
                            Na'est
                        </a>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

    </ul>
    <!-- End of Sidebar -->