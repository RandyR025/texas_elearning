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
                        <h3 class="card-title">Tambah Kategori Quiz</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('datakategoriquiz.tambah') }}" id="datakategoriquiz_form" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_kategori">Nama Kategori</label>
                                            <input type="text" class="form-control" id="nama_kategori" placeholder="Kategori" name="nama_kategori">
                                            <span class="text-danger error-text nama_kategori_error"></span>
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
                        <h3 class="card-title">Data Kategori Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datakategoriquiz" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Edit</th>
                                    <th>Skor</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <!-- Edit Modal -->
            <div class="modal fade" id="editkategoriquizmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Kategori</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="datakategoriquizedit_form">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editnama_kategori">Nama Kategori</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editnama_kategori" placeholder="Nama Kategori" name="editnama_kategori">
                                                <span class="text-danger error-text editnama_kategori_error"></span>
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

            <div class="modal fade" id="editpertanyaanmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Skor</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" id="dataskoredit_form">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <span class="text-danger error-text editpertanyaan_error"></span>
                                    <div class="form-group" id="text_inputedit" hidden>
                                        <div class="input-group">
                                            <input type="text" class="form-control col-md-1" id="edittextjumlahjawaban" name="edittextjumlahjawaban" placeholder="Bobot" value="0" oninput="validasiInputTextedit()">
                                            <textarea name="edittextskor" id="edittextskor" cols="30" rows="2" class="form-control col-5"></textarea>
                                            <input type="hidden" name="textid" id="textid">
                                            <input type="hidden" name="tipe" id="tipe">
                                        </div>
                                    </div>
                                    <div class="form-group form1" id="tambahpilihanedit">
                                        <button type="button" class="btn btn-success" onclick="tambahInputedit()">Tambah Jawaban</button>
                                    </div>

                                    <div id="container-input-d">
                                        <!-- Input dinamis akan ditambahkan di sini -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between bg-red">
                                <button type="button" class="btn btn-primary bg-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary bg-white update" id="submitBtnedit">Update</button>
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
<script src="{{asset('js/KategoriQuiz.js')}}"></script>
<script>
    function tambahInputedit() {
        var nomorInput = $('#container-input-d .form-group').length + 1;

        var inputBaru = '<div class="form-group">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control col-md-1" id="editjumlahjawaban' + nomorInput + '" name="editjumlahjawabantambah[]" placeholder="Bobot" oninput="validasiInputedit(' + nomorInput + ')">' +
            '<input type="text" class="form-control col-md-5" id="editskor' + nomorInput + '" name="editskortambah[]" oninput="validasiInputedit(' + nomorInput + ')">' +
            '<span class="input-group-btn">' +
            '<button type="button" class="btn btn-danger" onclick="hapusInput1(this)"><i class="fa fa-trash"></i></button>' +
            '</span>' +
            '</div>' +
            '<span class="text-danger error-text jawaban' + nomorInput + '_error"></span>' +
            '</div>';

        $('#container-input-d').append(inputBaru);
        $('#submitBtnedit').prop('disabled', true);
    }
    function hapusInput1(button) {
        $(button).closest('.form-group').remove();
    }
    function validasiInputedit() {
        var semuaInputTerisi = true;
        $('[id^="editjumlahjawaban"]').each(function() {
            var nomorInput = this.id.match(/\d+/)[0];
            var bobotInput = $(this).val();
            var jawabanInput = $('#editskor' + nomorInput).val();

            $('.error-text.editjumlahjawaban' + nomorInput + '_error').text('');
            $('.error-text.editskor' + nomorInput + '_error').text('');
            if (bobotInput === '' || jawabanInput === '') {
                semuaInputTerisi = false;
                return false;
            }
        });
        $('#submitBtnedit').prop('disabled', !semuaInputTerisi);
        return semuaInputTerisi;
    }
</script>
@endsection
@endsection()