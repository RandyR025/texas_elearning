@extends('backend/layouts.template')
@section('titlepage')
Data Kursus
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Kursus
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Kursus</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('datakursus.tambah') }}" id="datakursus_form" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_kursus">Nama Kursus</label>
                                            <input type="text" class="form-control" id="nama_kursus" placeholder="Kursus" name="nama_kursus">
                                            <span class="text-danger error-text nama_kursus_error"></span>
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
                        <h3 class="card-title">Data Kursus</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datakursus" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kursus</th>
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
            <div class="modal fade" id="editkursusmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Kursus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datakursusedit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editnama_kursus">Nama Kursus</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editnama_kursus" placeholder="Nama Kelas" name="editnama_kursus">
                                                <span class="text-danger error-text editnama_kursus_error"></span>
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
<script src="{{asset('js/Kursus.js')}}"></script>
@endsection
@endsection()