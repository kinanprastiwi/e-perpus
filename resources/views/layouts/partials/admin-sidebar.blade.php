<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Perpus</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management Data
    </div>

    <!-- Nav Item - Buku -->
    <li class="nav-item {{ request()->is('admin/buku*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.buku.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span>
        </a>
    </li>

    <!-- Nav Item - Anggota -->
    <li class="nav-item {{ request()->is('admin/anggota*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.anggota.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Anggota</span>
        </a>
    </li>

    <!-- Nav Item - Kategori -->
    <li class="nav-item {{ request()->is('admin/kategori*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Data Kategori</span>
        </a>
    </li>

    <!-- Nav Item - Penerbit -->
    <li class="nav-item {{ request()->is('admin/penerbit*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.penerbit.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Data Penerbit</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    <!-- Nav Item - Peminjaman -->
    <li class="nav-item {{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Peminjaman</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->