@extends('backend/layouts.template')
@section('titlepage')
Data User
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data User
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah User</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('datauser.tambah') }}" id="datauser_form" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                                            <span class="text-danger error-text username_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                            <span class="text-danger error-text password_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>level</label>
                                            <select class="form-control level" style="width: 100%;" name="level" id="level">
                                                <option selected="selected" disabled>-- Pilih Level --</option>
                                                @foreach($modellevel as $level)
                                                <option value="{{ $level->id }}">{{ $level->level}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text level_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" placeholder="Nama siswa" name="nama">
                                            <span class="text-danger error-text nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <div class="input-group date" id="tanggal_lahir" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggal_lahir" name="tanggal_lahir" />
                                                <div class="input-group-append" data-target="#tanggal_lahir" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <span class="text-danger error-text tanggal_lahir_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>No Telp</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask="'mask': ['9999-9999-9999', '+62 999 9999 9999']" data-mask name="no_telp">
                                            </div>
                                            <span class="text-danger error-text no_telp_error"></span>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea id="" style="height:16.5vh ;" class="form-control" id="alamat" placeholder="Alamat" name="alamat"></textarea>
                                            <span class="text-danger error-text alamat_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-red">
                    <div class="card-header">
                        <h3 class="card-title">Data User</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datauser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <!-- Edit Modal -->
            <div class="modal fade" id="editusermodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datauseredit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editusername">Username</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editusername" placeholder="Username" name="editusername">
                                                <span class="text-danger error-text editusername_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="editpassword">Password</label>
                                                <input type="password" class="form-control" id="editpassword" placeholder="Password" name="editpassword">
                                                <span class="text-danger error-text editpassword_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Level</label>
                                                <select class="form-control editlevel" style="width: 100%;" name="editlevel" id="editlevel">
                                                    <option selected="selected" disabled>-- Pilih Kategori --</option>
                                                    @foreach($modellevel as $level)
                                                    <option value="{{ $level->id }}">{{ $level->level}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editlevel_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer justify-content-between bg-red">
                            <button type="button" class="btn btn-primary bg-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary bg-white update">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal -->
        </div>


</section>
</div>
@section('js')
<script>
    $('[data-mask]').inputmask()
    $('#tanggal_lahir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('.level').select2({
        theme: 'bootstrap4'
    })
    $('.editlevel').select2({
        theme: 'bootstrap4'
    })
    $('.kelas').select2({
        theme: 'bootstrap4'
    })
    $('.kursus').select2({
        theme: 'bootstrap4'
    })
</script>
<script src="{{asset('js/User.js')}}"></script>
@endsection
@endsection()