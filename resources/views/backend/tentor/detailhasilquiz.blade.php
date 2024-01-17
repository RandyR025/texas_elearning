@extends('backend/layouts.template')
@section('titlepage')
Detail Hasil Quiz
<?php if (isset($modelquiz->judul_quiz)) { ?>
    {{$modelquiz->judul_quiz}}
<?php } ?>
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
                        <h3 class="card-title">Detail Hasil Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="detaildatahasilquiz" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Skor</th>
                                    <th>Edit</th>
                                    <th>Detail</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="modal fade" id="editnilaimodal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Skor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datanilaiedit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editnilai">Skor</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editnilai" placeholder="Nilai" name="editnilai">
                                                <span class="text-danger error-text editnilai_error"></span>
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