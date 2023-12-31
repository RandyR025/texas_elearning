@extends('backend/layouts.template')
@section('titlepage')
Dashboard
@endsection
@section('titlesub')
Home
@endsection
@section('title')
Dashboard
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @if (auth()->user()->level_id == 1)
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$modeluser}}<sup style="font-size: 20px"> Users</sup></h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">informasi <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$modelsiswa}}<sup style="font-size: 20px"> Siswa</sup></h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Informasi <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$modeltentor}}<sup style="font-size: 20px"> Tentor</sup></h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Informasi <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
</div>
@endsection()