<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                <!-- <span class="badge badge-danger navbar-badge">3</span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body ">
                            <h3 class="dropdown-item-title" id="login_nama">
                            @if (auth()->user()->level_id == 1)
                                {{ Auth::user()->UserTentor->nama }}
                            @endif
                            @if (auth()->user()->level_id == 2)
                                {{ Auth::user()->UserTentor->nama }}
                            @endif
                            @if (auth()->user()->level_id == 3)
                                {{ Auth::user()->UserSiswa->nama }}
                            @endif
                            </h3>
                            <p class="text-sm">
                                <i class="fa fa-crown">{{ Auth::user()->userLevel->level }}</i></p>
                            <!-- <p class="text-sm text-muted"><i class="fas fa-map-marker-alt"></i></p> -->
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <div class="d-flex flex-row ">
                    <div class="p-2 "><button data-toggle="modal" data-target="#modal-ubahpass" class="dropdown-item dropdown-footer ubahpassword"><i class="fa fa-key"></i> Ubah Password</button></div>
                    <div class="p-2 ">
                        <a href="{{route('keluarlogout')}}" class="dropdown-item dropdown-footer" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off mr-1"></i>Logout
                        </a>
                        <form action="{{route('keluarlogout')}}" method="POST" id="logout-form">
                            {{ csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
<div class="modal fade" id="modal-ubahpass">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="formubahpassword" action="javascript:void(0)">
                <div class="modal-body">
                    <span id="informasi" class="ml-3 text-danger"></span>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="passwordlama" class="col-sm-5 col-form-label">Password Lama</label>
                            <div class="col-sm-7">
                                <input type="password" name="passwordlama" class="form-control" id="passwordlama" placeholder="Password Lama">
                                <span id="passwordlama_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passwordbaru" class="col-sm-5 col-form-label">Password Baru</label>
                            <div class="col-sm-7">
                                <input type="password" name="passwordbaru" class="form-control" id="passwordbaru" placeholder="Password Baru">
                                <span id="passwordbaru_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirmpassword" class="col-sm-5 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-7">
                                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" placeholder="Password Baru">
                                <span id="confirmpassword_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="ubahpassword">Update</button>
                </div>
            </form>
        </div>

    </div>

</div>
<!-- /.navbar -->