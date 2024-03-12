@extends('backend/layouts.template')
@section('titlepage')
Data Jadwal Quiz
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Jadwal Quiz
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Jadwal Quiz</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('datajadwalquiztentor.tambah') }}" id="datajadwalquiztentor_form" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Quiz</label>
                                            <select class="form-control nama_quiz" style="width: 100%;" name="nama_quiz" id="nama_quiz">
                                                <option selected="selected" disabled>-- Pilih Quiz --</option>
                                                @foreach($modelquiz as $quiz)
                                                <option value="{{ $quiz->id }}">{{ $quiz->judul_quiz}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text nama_quiz_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select class="form-control kelas" style="width: 100%;" name="kelas" id="kelas">
                                                <option selected="selected" disabled>-- Pilih Kelas --</option>
                                                @foreach($modelkelas as $kelas)
                                                <option value="{{ $kelas->id }}">{{ $kelas->kelas}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text kelas_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Siswa</label>
                                            <select class="form-control siswa" multiple="multiple" data-placeholder=" --Pilih Siswa-- " name="siswa[]" id="siswa" style="width: 100%;">
                                                <!-- <option value="all">Semua</option> -->
                                            </select>
                                            <span class="text-danger error-text siswa_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Mulai Quiz</label>
                                            <div class="input-group date" id="tanggal_mulai" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggal_mulai" name="tanggal_mulai" id="tanggal_mulai1" />
                                                <div class="input-group-append" data-target="#tanggal_mulai" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <span class="text-danger error-text tanggal_mulai_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Berakhir Quiz</label>
                                            <div class="input-group date" id="tanggal_berakhir" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggal_berakhir" name="tanggal_berakhir" id="tanggal_berakhir" />
                                                <div class="input-group-append" data-target="#tanggal_berakhir" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            <span class="text-danger error-text tanggal_berakhir_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="waktu_quiz">Waktu Quiz</label>
                                            <input type="text" class="form-control" id="waktu_quiz" placeholder="Waktu Quiz" name="waktu_quiz" oninput="validateInput(this)">
                                            <span class="text-danger error-text waktu_quiz_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="tampilan_soal">Tampilan Soal/Halaman</label>
                                            <input type="text" class="form-control" id="tampilan_soal" placeholder="Tampilan Soal" name="tampilan_soal" oninput="validateInput(this)">
                                            <span class="text-danger error-text tampilan_soal_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Group Quiz</label>
                                            <select class="form-control group" style="width: 100%;" name="group" id="group">
                                                <option selected="selected" value="">-- Pilih Group --</option>
                                                @foreach($modelgroup as $group)
                                                <option value="{{ $group->id }}">{{ $group->nama_group}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text group_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Quiz Sebelumnya</label>
                                            <select class="form-control quiz_sebelumnya" style="width: 100%;" name="quiz_sebelumnya" id="quiz_sebelumnya">
                                                <!-- <option hidden>Pilih Quiz</option> -->
                                                <option value="" selected>Pilih Quiz</option>
                                            </select>
                                            <span class="text-danger error-text quiz_sebelumnya_error"></span>
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

            <div class="col-md-8">
                <div class="card card-red">
                    <div class="card-header">
                        <h3 class="card-title">Data Jadwal Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datajadwalquiztentor" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Quiz</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Waktu Quiz</th>
                                    <th>Tampilan Soal</th>
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
            <div class="modal fade" id="editjadwalquizmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Jadwal Quiz</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datajadwalquiztentoredit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Quiz</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <select class="form-control editnama_quiz" style="width: 100%;" name="editnama_quiz" id="editnama_quiz">
                                                    <option selected="selected" disabled>-- Pilih Quiz --</option>
                                                    @foreach($modelquiz as $quiz)
                                                    <option value="{{ $quiz->id }}">{{ $quiz->judul_quiz}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editnama_quiz_error"></span>
                                            </div>
                                            <div class="form-group" hidden>
                                                <label>Tentor</label>
                                                <select class="form-control edittentor" multiple="multiple" data-placeholder=" --Pilih Tentor-- " name="edittentor[]" id="edittentor" style="width: 100%;">
                                                    <option value="all">Semua</option>
                                                    <option value="Default">Default</option>
                                                    @foreach($modeltentor as $tentor)
                                                    <option value="{{ $tentor->user_id }}">{{ $tentor->nama}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text edittentor_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Kelas</label>
                                                <select class="form-control editkelas" style="width: 100%;" name="editkelas" id="editkelas">
                                                    <option selected="selected" disabled>-- Pilih Kelas --</option>
                                                    @foreach($modelkelas as $kelas)
                                                    <option value="{{ $kelas->id }}">{{ $kelas->kelas}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editkelas_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Siswa</label>
                                                <select class="form-control editsiswa" multiple="multiple" data-placeholder=" --Pilih Siswa-- " name="editsiswa[]" id="editsiswa" style="width: 100%;">
                                                <!-- <option value="all">Semua</option> -->
                                                </select>
                                                <span class="text-danger error-text editsiswa_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Mulai Quiz</label>
                                                <div class="input-group date" id="edittanggal_mulai" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#edittanggal_mulai" name="edittanggal_mulai" id="edittanggal_mulai1" />
                                                    <div class="input-group-append" data-target="#edittanggal_mulai" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text edittanggal_mulai_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Berakhir Quiz</label>
                                                <div class="input-group date" id="edittanggal_berakhir" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#edittanggal_berakhir" name="edittanggal_berakhir" id="edittanggal_berakhir1" />
                                                    <div class="input-group-append" data-target="#edittanggal_berakhir" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text edittanggal_berakhir_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="editwaktu_quiz">Waktu Quiz</label>
                                                <input type="text" class="form-control" id="editwaktu_quiz" placeholder="Waktu Quiz" name="editwaktu_quiz" oninput="validateInput(this)">
                                                <span class="text-danger error-text editwaktu_quiz_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="edittampilan_soal">Tampilan Soal/Halaman</label>
                                                <input type="text" class="form-control" id="edittampilan_soal" placeholder="Waktu Quiz" name="edittampilan_soal" oninput="validateInput(this)">
                                                <span class="text-danger error-text edittampilan_soal_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Group Quiz</label>
                                                <select class="form-control editgroup" style="width: 100%;" name="editgroup" id="editgroup">
                                                    <option selected="selected" value="">-- Pilih Group --</option>
                                                    @foreach($modelgroup as $group)
                                                    <option value="{{ $group->id }}">{{ $group->nama_group}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editgroup_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Quiz Sebelumnya</label>
                                                <select class="form-control editquiz_sebelumnya" style="width: 100%;" name="editquiz_sebelumnya" id="editquiz_sebelumnya">
                                                    <!-- <option hidden>Pilih Quiz</option> -->
                                                    <option value="" selected>Pilih Quiz</option>
                                                </select>
                                                <span class="text-danger error-text quiz_sebelumnya_error"></span>
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
    $('#tanggal_mulai').datetimepicker({
        format: 'YYYY-MM-DD HH:mm', 
        icons: { time: 'far fa-clock' }
    });
    $('#tanggal_berakhir').datetimepicker({
        format: 'YYYY-MM-DD HH:mm', 
        icons: { time: 'far fa-clock' }
    });
    $('#edittanggal_mulai').datetimepicker({
        format: 'YYYY-MM-DD HH:mm', 
        icons: { time: 'far fa-clock' }
    });
    $('#edittanggal_berakhir').datetimepicker({
        format: 'YYYY-MM-DD HH:mm', 
        icons: { time: 'far fa-clock' }
    });
    $('.nama_quiz').select2({
        theme: 'bootstrap4'
    })
    $('.editnama_quiz').select2({
        theme: 'bootstrap4'
    })
    $('.kelas').select2({
        theme: 'bootstrap4'
    })
    $('.editkelas').select2({
        theme: 'bootstrap4'
    })
    $('.siswa').select2({
        theme: 'bootstrap4'
    })
    $('.editsiswa').select2({
        theme: 'bootstrap4'
    })
    $('.group').select2({
        theme: 'bootstrap4'
    })
    $('.editgroup').select2({
        theme: 'bootstrap4'
    })
    $('.edittentor').select2({
        theme: 'bootstrap4'
    })
    function validateInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>
<script src="{{asset('js/JadwalTentor.js')}}"></script>
@endsection
@endsection()