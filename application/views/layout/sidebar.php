<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img class="rounded-circle" src="<?= base_url() ?>assets/img/logo/android-icon-48x48.png" alt="...">
        </div>
        <div class="sidebar-brand-text"><?= $title; ?> <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url() ?>dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <?php if ($this->session->userdata('role') === 'admin') : ?>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>/kelola_anggota">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelola Data Anggota</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>/kelola_pengunduran">
                <i class="fas fa-fw fa-table"></i>
                <span>Kelola Data Pengunduran</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>/struktur_spsi">
                <i class="fas fa-fw fa-table"></i>
                <span>Struktur SPSI</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>/kelola_kegiatan">
                <i class="fas fa-fw fa-table"></i>
                <span>Kelola Kegiatan</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin') ?>/kelola_informasi">
                <i class="fas fa-fw fa-table"></i>
                <span>Kelola Informasi Terkini</span></a>
        </li>
    <?php else : ?>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-table"></i>
                <span>Lihat Kegiatan</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-table"></i>
                <span>Lihat Informasi Terkini</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-users"></i>
                <span>Lihat Struktur SPSI</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-user"></i>
                <span>Pengunduran Anggota</span></a>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->