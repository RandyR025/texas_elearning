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
                        <table id="detaildatahasilquizsiswa" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Quiz</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Nilai</th>
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
<script src="{{asset('js/ResultQuizSiswa.js')}}"></script>
@endsection
@endsection()