<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link" style="text-align:center;">
        <img src="{{asset('assets/dist/img/logoOnly.png')}}" alt="texas Logo" style="width:20%;">
        <span style="font-size:70%;">
            EXAS E-Learning
        </span>
        <!-- <span class="brand-text font-weight-light" style="font-size:60%;">Daily Activity Monitoring System</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                @if (auth()->user()->level_id == 1)
                <a href="#" class="d-block">{{ Auth::user()->userTentor->nama }}</a>
                @endif
                @if (auth()->user()->level_id == 2)
                <a href="#" class="d-block">{{ Auth::user()->userTentor->nama }}</a>
                @endif
                @if (auth()->user()->level_id == 3)
                <a href="#" class="d-block">{{ Auth::user()->userSiswa->nama }}</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    @if (auth()->user()->level_id == 1)
                    <a href="{{route('dashboardadmin')}}" class="nav-link {{ Route::is('dashboardadmin') ? 'active' : '' }}">
                        @endif
                        @if (auth()->user()->level_id == 2)
                        <a href="{{route('dashboardpegawai')}}" class="nav-link {{ Route::is('dashboardpegawai') ? 'active' : '' }}">
                            @endif
                            @if (auth()->user()->level_id == 3)
                            <a href="{{route('dashboardsiswa')}}" class="nav-link {{ Route::is('dashboardsiswa') ? 'active' : '' }}">
                                @endif
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                </li>
                @if (auth()->user()->level_id == 1)
                <li class="nav-header">Data Master</li>
                <li class="nav-item">
                    <a href="{{route('datauser')}}" class="nav-link {{ Route::is('datauser') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Data User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('datasiswa')}}" class="nav-link {{ Route::is('datasiswa') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('datatentor')}}" class="nav-link {{ Route::is('datatentor') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Tentor</p>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('datakategoriquiz')||Route::is('dataquiz')||Route::is('datajadwalquiz')||Route::is('dataquiz.pertanyaan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('datakategoriquiz')||Route::is('dataquiz')||Route::is('datajadwalquiz')||Route::is('dataquiz.pertanyaan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Quizezz
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('datakategoriquiz')}}" class="nav-link {{ Route::is('datakategoriquiz') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Quiz</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('dataquiz')}}" class="nav-link {{ Route::is('dataquiz')||Route::is('dataquiz.pertanyaan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Quiz</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('datajadwalquiz')}}" class="nav-link {{ Route::is('datajadwalquiz') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Quiz</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (auth()->user()->level_id == 3)
                <li class="nav-header">Menus</li>
                <li class="nav-item">
                    <a href="{{route('quizsiswa')}}" class="nav-link {{ Route::is('quizsiswa')||Route::is('quizsiswadetail') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>