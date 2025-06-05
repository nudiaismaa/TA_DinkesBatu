{{-- Sidebar --}}
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center w-100">
                <a href="{{ route('dashboard') }}" class="w-100">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="w-80 h-auto d-block" />
                </a>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                {{-- Dashboard --}}
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- Laporan --}}
                @role('Dinkes Kota Batu')
                    <li class="sidebar-item has-sub {{ request()->is('pemeriksaan*') ? 'submenu-open' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-earmark-ruled-fill"></i>
                            <span>Laporan Perkembangan</span>
                        </a>
                        <ul class="submenu">
                            <li
                                class="submenu-item {{ request()->routeIs('pemeriksaan.index') || request()->routeIs('pemeriksaan.show') ? 'active' : '' }}">
                                <a href="{{ route('pemeriksaan.index') }}" class="submenu-link">Daftar Laporan</a>
                            </li>

                        </ul>
                    </li>
                @endrole

                @role('Puskesmas|Posyandu')
                    <li class="sidebar-item has-sub {{ request()->is('pemeriksaan*') ? 'submenu-open' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-earmark-ruled-fill"></i>
                            <span>Laporan Perkembangan</span>
                        </a>
                        <ul class="submenu">
                            <li
                                class="submenu-item {{ request()->routeIs('pemeriksaan.index') || request()->routeIs('pemeriksaan.show') ? 'active' : '' }}">
                                <a href="{{ route('pemeriksaan.index') }}" class="submenu-link">Daftar Laporan</a>
                            </li>
                            @role('Posyandu')
                                <li class="submenu-item {{ request()->routeIs('pemeriksaan.create') ? 'active' : '' }}">
                                    <a href="{{ route('pemeriksaan.create') }}" class="submenu-link">Tambah Laporan</a>
                                </li>
                            @endrole

                        </ul>
                    </li>
                @endrole
                @role('Orang Tua')
                    {{-- Profil Anak --}}
                    <li class="sidebar-item {{ request()->routeIs('laporan*') || request()->is('pemeriksaan*') ? 'active' : '' }}">
                        <a href="{{ route('laporan.show') }}" class="sidebar-link">
                            <i class="bi bi-file-ruled"></i>
                            <span>Laporan Perkembangan</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('anak*') ? 'active' : '' }}">
                        <a href="{{ route('anak.index') }}" class="sidebar-link">
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Profil Anak</span>
                        </a>
                    </li>
                @endrole

                @role('Posyandu|Orang Tua')
                    <li class="sidebar-item {{ request()->routeIs('jadwalPosyandu*') ? 'active' : '' }}">
                        <a href="{{ route('jadwalPosyandu.index') }}" class="sidebar-link">
                            <i class="bi bi-calendar-week"></i>
                            <span>Lihat Jadwal</span>
                        </a>
                    </li>
                @endrole
                @role('Puskesmas|Posyandu')
                    <li
                        class="sidebar-item has-sub {{ request()->is('orangtua*') || request()->is('anak') ? 'submenu-open' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-ruled"></i>
                            <span>Orang Tua & Anak</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item {{ request()->routeIs('orangtua*') ? 'active' : '' }}">
                                <a href="{{ route('orangtua.index') }}" class="submenu-link">Data Orang Tua</a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('anak*') ? 'active' : '' }}">
                                <a href="{{ route('anak.index') }}" class="submenu-link">Data Anak</a>
                            </li>
                        </ul>
                    @endrole
                    @role('Super Admin|Front Office|Puskesmas')
                    <li
                        class="sidebar-item has-sub {{ request()->is('puskesmas*') || request()->is('posyandu*') || request()->is('permissions*') || request()->is('roles*') || request()->is('orangtua*') ? 'submenu-open' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-file-ruled"></i>
                            <span>Kelola Unit</span>
                        </a>
                        <ul class="submenu">
                            @can('manage puskesmas')
                                <li class="submenu-item {{ request()->routeIs('puskesmas*') ? 'active' : '' }}">
                                    <a href="{{ route('puskesmas.index') }}" class="submenu-link">Kelola Puskesmas</a>
                                </li>
                            @endcan
                            @can('manage posyandu')
                                <li class="submenu-item {{ request()->routeIs('posyandu*') ? 'active' : '' }}">
                                    <a href="{{ route('posyandu.index') }}" class="submenu-link">Kelola Posyandu</a>
                                </li>
                            @endcan
                            @role('Super Admin')
                                <li class="submenu-item {{ request()->routeIs('permissions*') ? 'active' : '' }}">
                                    <a href="{{ route('permissions.index') }}" class="submenu-link">Data Permission
                                        Pengguna</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                    <a href="{{ route('roles.index') }}" class="submenu-link">Data Role Pengguna</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}" class="submenu-link">Kelola Pengguna</a>
                                </li>
                            @endrole
                        </ul>
                    </li>
                @endrole
            </ul>
        </div>

        {{-- Footer Sidebar --}}
        <div class="sidebar-footer position-absolute bottom-0 w-100 p-3">
            @include('include.footer')
        </div>
    </div>
</div>
