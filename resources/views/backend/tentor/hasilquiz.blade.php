@extends('backend/layouts.template')
@section('titlepage')
Data Hasil Quiz
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Hasil Quiz
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-red">
                    <div class="card-header">
                        <h3 class="card-title">Data Hasil Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datahasilquiz" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Quiz</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Waktu Quiz</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


</section>
</div>
@section('js')
<script>
    $('#tanggal_mulai').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#tanggal_berakhir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#edittanggal_mulai').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#edittanggal_berakhir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('.nama_quiz').select2({
        theme: 'bootstrap4'
    })
    $('.editnama_quiz').select2({
        theme: 'bootstrap4'
    })
    $('.tentor').select2({
        theme: 'bootstrap4'
    })
    $('.edittentor').select2({
        theme: 'bootstrap4'
    })
    $('.kelas').select2({
        theme: 'bootstrap4'
    })
    $('.editkelas').select2({
        theme: 'bootstrap4'
    })

    function validateInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>
<script src="{{asset('js/ResultQuizTentor.js')}}"></script>
@endsection
@endsection()