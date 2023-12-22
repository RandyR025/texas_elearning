@extends('backend/layouts.template')
@section('titlepage')
Data Pertanyaan {{$modelquiz->judul_quiz}}
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Pertanyaan
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pertanyaan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="coba">
                        <form id="datapertanyaan_form" action="{{ route('datapertanyaan.tambah')}}" method="post">
                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$modelquiz->id}}">
                            <textarea id="summernote" name="pertanyaan">Masukkan <em>pertanyaan</em> <u>kamu</u> <strong>disini</strong>
                            </textarea>
                            <span class="text-danger error-text pertanyaan_error"></span>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" onclick="tambahInput()">Tambah Jawaban</button>
                            </div>
                            <div id="container-input-dinamis">
                                <!-- Input dinamis akan ditambahkan di sini -->
                            </div>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-red">
                    <div class="card-header">
                        <h3 class="card-title">Data Pertanyaan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="datapertanyaan" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>Tipe Pertanyaan</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="modal fade" id="editpertanyaanmodal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Pertanyaan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" id="datapertanyaanedit_form">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <textarea id="summernote2" name="editpertanyaan">Masukkan <em>pertanyaan</em> <u>kamu</u> <strong>disini</strong></textarea>
                                    <span class="text-danger error-text editpertanyaan_error"></span>

                                    <div class="form-group form1">
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
        </div>
</section>
</div>
@section('js')
<script>
    $(document).ready(function() {
        tambahInput();
        validasiInputedit();
    });

    function tambahInput() {
        var nomorInput = $('#container-input-dinamis .form-group').length + 1;

        var inputBaru = '<div class="form-group">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control col-md-1" id="bobot' + nomorInput + '" name="bobot[]" placeholder="Bobot" oninput="validasiInput(' + nomorInput + ')">' +
            '<input type="text" class="form-control col-md-5" id="jawaban' + nomorInput + '" name="jawaban[]" oninput="validasiInput(' + nomorInput + ')">' +
            '<span class="input-group-btn">' +
            '<button type="button" class="btn btn-danger" onclick="hapusInput(this)"><i class="fa fa-trash"></i></button>' +
            '</span>' +
            '</div>' +
            '<span class="text-danger error-text bobot' + nomorInput + '_error"></span>' +
            '<span class="text-danger error-text jawaban' + nomorInput + '_error"></span>' +
            '</div>';
        '</div>';
        $('#container-input-dinamis').append(inputBaru);
        $('#submitBtn').prop('disabled', true);
    }

    function tambahInputedit() {
        var nomorInput = $('#container-input-d .form-group').length + 1;

        var inputBaru = '<div class="form-group">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control col-md-1" id="editbobot' + nomorInput + '" name="editbobottambah[]" placeholder="Bobot" oninput="validasiInputedit(' + nomorInput + ')">' +
            '<input type="text" class="form-control col-md-5" id="editjawaban' + nomorInput + '" name="editjawabantambah[]" oninput="validasiInputedit(' + nomorInput + ')">' +
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

    function validasiInput() {
        var semuaInputTerisi = true;
        $('[id^="bobot"]').each(function() {
            var nomorInput = this.id.match(/\d+/)[0];
            var bobotInput = $(this).val();
            var jawabanInput = $('#jawaban' + nomorInput).val();

            $('.error-text.bobot' + nomorInput + '_error').text('');
            $('.error-text.jawaban' + nomorInput + '_error').text('');
            if (bobotInput === '' || jawabanInput === '') {
                semuaInputTerisi = false;
                return false;
            }
        });
        $('#submitBtn').prop('disabled', !semuaInputTerisi);
        return semuaInputTerisi;
    }

    function validasiInputedit() {
        var semuaInputTerisi = true;
        $('[id^="editbobot"]').each(function() {
            var nomorInput = this.id.match(/\d+/)[0];
            var bobotInput = $(this).val();
            var jawabanInput = $('#editjawaban' + nomorInput).val();

            $('.error-text.editbobot' + nomorInput + '_error').text('');
            $('.error-text.editjawaban' + nomorInput + '_error').text('');
            if (bobotInput === '' || jawabanInput === '') {
                semuaInputTerisi = false;
                return false;
            }
        });
        $('#submitBtnedit').prop('disabled', !semuaInputTerisi);
        return semuaInputTerisi;
    }


    function hapusInput(element) {
        $(element).closest('.form-group').remove();
    }

    function ubahJenisInput(select) {
        var jenisInput = $(select).val();
        var inputText = $(select).siblings('input[type="text"]');

        if (jenisInput === 'esai') {
            inputText.attr('type', 'text');
        } else {
            inputText.attr('type', 'hidden');
        }
    }


    $(function() {
        $('#summernote').summernote()
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
    })
    $(function() {
        $('#summernote2').summernote()
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
    })
</script>
<script src="{{asset('js/Pertanyaan.js')}}"></script>
@endsection
@endsection()