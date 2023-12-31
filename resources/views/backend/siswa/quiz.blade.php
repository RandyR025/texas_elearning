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

    .square-card .card {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 75%;
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
                            <img style="width: 50vh; height: 30vh" src="{{asset('images_quiz/'.$quiz->gambar_quiz)}}" alt="Gambar Matematika" class="img-fluid rounded">
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
                                <?php } elseif ($now >= $quiz->tanggal_mulai && $now <= $quiz->tanggal_berakhir) { ?>
                                    <a href="{{route('quizsiswadetail',[$quiz->id,$quiz->id_jadwal])}}" class="btn btn-primary btn-block">Mulai Ujian</a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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