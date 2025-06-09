{{-- header --}}

<header>
    <div class="container-fluid">
        <div class="row align-items-center mx-2 my-3 p-3 rounded-4 bg-white shadow-sm">
            <div class="col-auto d-xl-none">
                <a href="#" id="burger-btn" class="burger-btn text-black">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
            <div class="col text-start">
                <h5 class="mb-0">Selamat Datang Kembali, {{ Auth::user()->name }} </h5>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex align-items-center">
                            <div class="user-img">
                                <div class="avatar avatar-md text-black">
                                    <i class="bi bi-person-fill fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">
                                Hello, {{ Auth::user()->name }}
                            </h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
