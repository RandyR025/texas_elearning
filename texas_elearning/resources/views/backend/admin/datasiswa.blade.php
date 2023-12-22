@extends('backend/layouts.template')
@section('titlepage')
Data siswa
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data siswa
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-red">
                    <div class="card-header">
                        <h3 class="card-title">Data siswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datasiswa" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama siswa</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Kelas</th>
                                    <th>Kursus</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <!-- Edit Modal -->
            <div class="modal fade" id="editsiswamodal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Siswa</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datasiswaedit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editnama">Nama siswa</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editnama" placeholder="Nama siswa" name="editnama">
                                                <span class="text-danger error-text editnama_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <div class="input-group date" id="edittanggal_lahir" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#edittanggal_lahir" name="edittanggal_lahir" id="edittanggal_lahir1" />
                                                    <div class="input-group-append" data-target="#edittanggal_lahir" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text edittanggal_lahir_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea cols="5" rows="5" class="form-control" id="editalamat" placeholder="Alamat" name="editalamat"></textarea>
                                                <span class="text-danger error-text editalamat_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No Telp</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" data-inputmask="'mask': ['9999-9999-9999', '+62 999 9999 9999']" data-mask name="editno_telp" id="editno_telp">
                                                </div>
                                                <span class="text-danger error-text editno_telp_error"></span>
                                                <!-- /.input group -->
                                            </div>
                                            <div class="form-group">
                                                <label>Kelas</label>
                                                <select class="form-control kelas" style="width: 100%;" name="editkelas" id="editkelas">
                                                    <option selected="selected" disabled>-- Pilih Kelas --</option>
                                                    @foreach($modelkelas as $kelas)
                                                    <option value="{{ $kelas->id }}">{{ $kelas->kelas}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editkelas_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Kursus</label>
                                                <select class="form-control kursus" style="width: 100%;" name="editkursus" id="editkursus">
                                                    <option selected="selected" disabled>-- Pilih Kursus --</option>
                                                    @foreach($modelkursus as $kursus)
                                                    <option value="{{ $kursus->id }}">{{ $kursus->kursus}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editkursus_error"></span>
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
    $('#tanggal_lahir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#edittanggal_lahir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#tanggalmasuk').datetimepicker({
        format: 'L'
    });
    $('[data-mask]').inputmask()
    $('.kelas').select2({
        theme: 'bootstrap4'
    })
    $('.kursus').select2({
        theme: 'bootstrap4'
    })
</script>
<script src="{{asset('js/Siswa.js')}}"></script>
@endsection
@endsection()