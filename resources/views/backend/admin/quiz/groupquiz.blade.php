@extends('backend/layouts.template')
@section('titlepage')
Data Kategori Quiz
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Kategori Quiz
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Group Quiz</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('datagroupquiz.tambah') }}" id="datagroupquiz_form" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_group">Nama Group</label>
                                            <input type="text" class="form-control" id="nama_group" placeholder="Group" name="nama_group">
                                            <span class="text-danger error-text nama_group_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea id="" cols="5" rows="5" class="form-control" id="deskripsi" placeholder="Deskripsi" name="deskripsi"></textarea>
                                            <span class="text-danger error-text deskripsi_error"></span>
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
                        <h3 class="card-title">Data Group Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datagroupquiz" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Group</th>
                                    <th>Deskripsi</th>
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
            <div class="modal fade" id="editgroupquizmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Group</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datagroupquizedit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editnama_group">Nama Group</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editnama_group" placeholder="Nama Kategori" name="editnama_group">
                                                <span class="text-danger error-text editnama_group_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="editdeskripsi">Deskripsi</label>
                                                <textarea cols="5" rows="5" class="form-control" id="editdeskripsi" placeholder="Alamat" name="editdeskripsi"></textarea>
                                                <span class="text-danger error-text editdeskripsi_error"></span>
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
<script src="{{asset('js/GroupQuiz.js')}}"></script>
@endsection
@endsection()