@extends('backend/layouts.template')
@section('titlepage')
Quiz
@endsection
@section('titlesub')
Menus
@endsection
@section('title')
Quiz
@endsection
@section('css')
<style>
    /* CSS Khusus untuk square-card */
    .square-card {
        width: 100%;
        padding-top: 150%;
        /* Sesuaikan tinggi card dengan nilai yang diinginkan */
        position: relative;
        overflow: hidden;
    }

    @media (min-width: 800px) {
        .square-card .card {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 75% !important;
            /* Set tinggi card menjadi 100% */
        }
    }

    .square-card .card {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80%;
        /* Set tinggi card menjadi 100% */
    }

    .card-footer-btn {
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    /* Menambahkan word-wrap pada card-text */
    .card-text {
        word-wrap: break-word;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }
</style>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        @if(Request::is('quizsiswa'))
        <div class="row">
            @foreach($modelquiz as $keyyy => $quizzz)
            @if($keyyy != '')
            @foreach($quizzz as $keyy => $quiz)
            <div class="col-md-4">
                <div class="square-card">
                    <!-- Ujian Card 1 -->
                    <div class="card">
                        <div class="card-header bg-gradient-red">
                            <h5 class="card-title">{{$quiz[0]->nama_group}}</h5>
                        </div>
                        <div class="card-body text-center">
                            @if(isset($quiz[0]->gambar_quiz))
                            <img style="width: 50vh; height: 30vh" src="{{asset('images_quiz/'.$quiz[0]->gambar_quiz)}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @else
                            <img style="width: 50vh; height: 30vh" src="{{asset('assets/dist/img/logoOnly.png')}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @endif
                            <p class="card-text">
                                <br>
                                <strong>Tanggal Mulai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz[0]->tanggal_mulai))}}<br>
                                <strong>Tanggal Selesai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz[0]->tanggal_berakhir))}}
                            </p>
                        </div>
                        <div class="card-footer card-footer-btn">
                            <a href="{{route('quizsiswacover',[$quiz[0]->group_id,$quiz[0]->tanggal_mulai])}}" class="btn btn-primary btn-block">Masuk Ujian</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            @foreach($quizzz as $key => $quizz)
            @foreach($quizz as $key => $quiz)
            <div class="col-md-4">
                <div class="square-card">
                    <!-- Ujian Card 1 -->
                    <div class="card">
                        <div class="card-header bg-gradient-red">
                            <h5 class="card-title">{{$quiz->judul_quiz}}</h5>
                        </div>
                        <div class="card-body text-center">
                            @if(isset($quiz->gambar_quiz))
                            <img style="width: 50vh; height: 30vh" src="{{asset('images_quiz/'.$quiz->gambar_quiz)}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @else
                            <img style="width: 50vh; height: 30vh" src="{{asset('assets/dist/img/logoOnly.png')}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @endif
                            <p class="card-text">
                                <strong>Jumlah Soal:</strong> {{$jumlahsoal[$key]}}<br>
                                <strong>Tanggal Mulai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz->tanggal_mulai))}}<br>
                                <strong>Tanggal Selesai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz->tanggal_berakhir))}}
                            </p>
                        </div>
                        <div class="card-footer card-footer-btn">
                            <?php

                            if (cekQuiz($quiz->id, Auth::user()->id, $quiz->id_jadwal)) {
                                ?>
                                <a href="#" class="btn btn-primary btn-block disabled">Anda Sudah Memulai</a>
                                <?php
                                } else {
                                    if ($now < $quiz->tanggal_mulai) { ?>
                                    <a href="#" class="btn btn-primary btn-block disabled">Belum Di Buka</a>
                                <?php } elseif ($now > $quiz->tanggal_berakhir) { ?>
                                    <a href="#" class="btn btn-primary btn-block disabled">Sudah Lewat</a>
                                    <?php } elseif ($now >= $quiz->tanggal_mulai && $now <= $quiz->tanggal_berakhir) {
                                            if ($key > 0) {
                                                $prevousQuiz = $quizz[$key - 1]->id_jadwal;
                                                if (cekQuizPrevious(Auth::user()->id, $prevousQuiz)) { ?>
                                            <a href="{{route('quizsiswadetail',[$quiz->id,$quiz->id_jadwal])}}" class="btn btn-primary btn-block">Mulai Ujian</a>
                                        <?php } else { ?>
                                            <a href="#" class="btn btn-primary btn-block disabled">Kerjakan Ujian Sebelumnya</a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a href="{{route('quizsiswadetail',[$quiz->id,$quiz->id_jadwal])}}" class="btn btn-primary btn-block">Mulai Ujian</a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
            @endif
            @endforeach
        </div>
        @else
        <div class="row">
            @foreach($modelquiz as $key => $quiz)
            <div class="col-md-4">
                <div class="square-card">
                    <!-- Ujian Card 1 -->
                    <div class="card">
                        <div class="card-header bg-gradient-red">
                            <h5 class="card-title">{{$quiz->judul_quiz}}</h5>
                        </div>
                        <div class="card-body text-center">
                            @if(isset($quiz->gambar_quiz))
                            <img style="width: 50vh; height: 30vh" src="{{asset('images_quiz/'.$quiz->gambar_quiz)}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @else
                            <img style="width: 50vh; height: 30vh" src="{{asset('assets/dist/img/logoOnly.png')}}" alt="Gambar Matematika" class="img-fluid rounded">
                            @endif
                            <p class="card-text">
                                <strong>Jumlah Soal:</strong> {{$jumlahsoal[$key]}}<br>
                                <strong>Tanggal Mulai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz->tanggal_mulai))}}<br>
                                <strong>Tanggal Selesai Ujian:</strong> {{strftime('%d %B %Y', strtotime($quiz->tanggal_berakhir))}}
                            </p>
                        </div>
                        <div class="card-footer card-footer-btn">
                            <?php

                            if (cekQuiz($quiz->id, Auth::user()->id, $quiz->id_jadwal)) {
                                ?>
                                <a href="#" class="btn btn-primary btn-block disabled">Anda Sudah Memulai</a>
                                <?php
                                } else {
                                    if ($now < $quiz->tanggal_mulai) { ?>
                                    <a href="#" class="btn btn-primary btn-block disabled">Belum Di Buka</a>
                                <?php } elseif ($now > $quiz->tanggal_berakhir) { ?>
                                    <a href="#" class="btn btn-primary btn-block disabled">Sudah Lewat</a>
                                    <?php } elseif ($now >= $quiz->tanggal_mulai && $now <= $quiz->tanggal_berakhir) {
                                            if ($key > 0) {
                                                $prevousQuiz = $modelquiz[$key - 1]->id_jadwal;
                                                if (cekQuizPrevious(Auth::user()->id, $prevousQuiz)) { ?>
                                            <a href="{{route('quizsiswadetail',[$quiz->id,$quiz->id_jadwal])}}" class="btn btn-primary btn-block">Mulai Ujian</a>
                                        <?php } else { ?>
                                            <a href="#" class="btn btn-primary btn-block disabled">Kerjakan Ujian Sebelumnya</a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a href="{{route('quizsiswadetail',[$quiz->id,$quiz->id_jadwal])}}" class="btn btn-primary btn-block">Mulai Ujian</a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
</div>
@section('js')
<script>
    $('.editkategori').select2({
        theme: 'bootstrap4'
    })
    $('.kategori').select2({
        theme: 'bootstrap4'
    })
</script>
<script src="{{asset('js/Quiz.js')}}"></script>
@endsection
@endsection()