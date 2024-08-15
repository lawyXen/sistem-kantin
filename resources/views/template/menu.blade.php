<div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="#">
        <span class="align-middle">Kantin IT-Del</span>
    </a>

    <ul class="sidebar-nav">
        <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard') }}">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
        </li>

        {{-- Mahasiswa --}}
        @if (in_array('Mahasiswa', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        <li class="sidebar-header">
            Pengguna
        </li>

        <li class="sidebar-item {{ Request::is('pelanggaran*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('pelanggaran.mahasiswa') }}">
                <i class="align-middle" data-feather="alert-triangle"></i> <span class="align-middle">Point
                    Pelanggaran</span>
            </a>
        </li>

        <li class="sidebar-item {{ Request::is('profile*') ? 'active' : '' }}">
            <a class="sidebar-link " href="{{ route('profile.mahasiswa', Auth::user()->username) }}">
                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('menu*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('menu.index') }}">
                <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Menu Kantin</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('kantin*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('kantin.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Kantin</span>
            </a>
        </li>
        @endif

        {{-- Petugas Kantin --}}
        @if (in_array('Kantin', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))) || in_array('SuperAdmin', array_map(function($role) { return trim($role,
        '[]"'); }, (array) json_decode(Auth::user()->role, true))))
        <li class="sidebar-header">
            Kantin
        </li>
        <li class="sidebar-item {{ Request::is('menu*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('menu.index') }}">
                <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Menu Kantin</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('pengumuman*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('pengumuman.index') }}">
                <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Pengumuman</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('barang*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('barang.index') }}">
                <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Barang</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('kantin*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('kantin.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Kantin</span>
            </a>
        </li>
        @endif

        {{-- Ketertiban --}}
        @if (in_array('Ketertiban', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        <li class="sidebar-header">
            Ketertiban
        </li>
        <li class="sidebar-item {{ Request::is('pengumuman*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('pengumuman.index') }}">
                <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Pengumuman</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('kantin*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('kantin.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Kantin</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('point*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('point.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Point Pelanggaran</span>
            </a>
        </li>
        @endif

        {{-- Asrama --}}
        @if (in_array('Asrama', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        <li class="sidebar-header">
            Keasramaan
        </li>
        <li class="sidebar-item {{ Request::is('pengumuman*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('pengumuman.index') }}">
                <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Pengumuman</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('kantin*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('kantin.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Kantin</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('point*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('point.index') }}">
                <i class="align-middle" data-feather="home"></i> <span class="align-middle">Point Pelanggaran</span>
            </a>
        </li>
        @endif

        {{-- SuperAdmin --}}
        @if (in_array('SuperAdmin', array_map(function($role) { return trim($role, '[]"'); }, (array)
        json_decode(Auth::user()->role, true))))
        <li class="sidebar-header">
            Utils
        </li>
        <li class="sidebar-item {{ Request::is('user*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('user.index') }}">
                <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">User</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::is('mahasiswa*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('mahasiswa.index') }}">
                <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Daftar Mahasiswa</span>
            </a>
        </li>
        @endif
    </ul>
</div>