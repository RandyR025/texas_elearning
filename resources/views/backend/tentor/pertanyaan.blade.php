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
                        <form id="datapertanyaantentor_form" action="{{ route('datapertanyaantentor.tambah')}}" method="post">
                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$modelquiz->id}}">
                            <textarea id="summernote" name="pertanyaan">Masukkan <em>pertanyaan</em> <u>kamu</u> <strong>disini</strong>
                            </textarea>
                            <span class="text-danger error-text pertanyaan_error"></span>
                            <div class="form-group">
                                <label>Tipe Pertanyaan</label>
                                <select class="form-control tipe_pertanyaan" style="width: 50%;" name="tipe_pertanyaan" id="tipe_pertanyaan">
                                    <option value="Pilihan">Pilihan Ganda</option>
                                    <option value="Teks">Teks</option>
                                    <option value="Blank_Teks">Blank Teks</option>
                                    <option value="Custom Banner">Custom Banner</option>
                                </select>
                                <span class="text-danger error-text tipe_pertanyaan_error"></span>
                            </div>
                            <div class="form-group" id="text_input" hidden>
                                <div class="input-group">
                                    <input type="text" class="form-control col-md-1" id="textbobot" name="textbobot" placeholder="Bobot" value="0" oninput="validasiInputText()">
                                    <textarea name="textjawaban" id="textjawaban" cols="30" rows="2" class="form-control col-md-5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="tambahpilihan">
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
                        <table id="datapertanyaantentor" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Tipe Pertanyaan</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
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
                        <form action="" id="datapertanyaantentoredit_form">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <textarea id="summernote2" name="editpertanyaan">Masukkan <em>pertanyaan</em> <u>kamu</u> <strong>disini</strong></textarea>
                                    <span class="text-danger error-text editpertanyaan_error"></span>

                                    <div class="form-group">
                                        <label>Tipe Pertanyaan</label>
                                        <select class="form-control edittipe_pertanyaan" style="width: 50%;" name="edittipe_pertanyaan" id="edittipe_pertanyaan">
                                            <option value="Pilihan">Pilihan Ganda</option>
                                            <option value="Teks">Teks</option>
                                            <option value="Blank_Teks">Blank Teks</option>
                                            <option value="Custom Banner">Custom Banner</option>
                                        </select>
                                        <span class="text-danger error-text edittipe_pertanyaan_error"></span>
                                    </div>
                                    <div class="form-group" id="text_inputedit" hidden>
                                        <div class="input-group">
                                            <input type="text" class="form-control col-md-1" id="edittextbobot" name="edittextbobot" placeholder="Bobot" value="0" oninput="validasiInputTextedit()">
                                            <textarea name="edittextjawaban" id="edittextjawaban" cols="30" rows="2" class="form-control col-md-5"></textarea>
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
                                    <div id="container-input-db">
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
        $("#tipe_pertanyaan").change(function() {
            var selectedValue = $(this).val();

            if (selectedValue == "Pilihan" || selectedValue == "Blank_Teks") {
                $('#tambahpilihan').prop("hidden", false);
                $('#container-input-dinamis').prop("hidden", false);
                $('#text_input').prop("hidden", true);
                $('#container-input-dinamis').empty();
                tambahInput();
                if (selectedValue == "Blank_Teks") {
                    $('#submitBtn').prop('disabled', false);
                }
            } else if (selectedValue == "Teks") {
                $('#tambahpilihan').prop("hidden", true);
                $('#container-input-dinamis').prop("hidden", true);
                $('#text_input').prop("hidden", false);
                $('#container-input-dinamis').empty();
                $('#submitBtn').prop('disabled', false);
            } else if (selectedValue == "Custom Banner") {
                $('#tambahpilihan').prop("hidden", true);
                $('#container-input-dinamis').prop("hidden", true);
                $('#text_input').prop("hidden", false);
                $('#container-input-dinamis').empty();
                $('#submitBtn').prop('disabled', false);
            }
        });
        $("#edittipe_pertanyaan").change(function() {
            var selectedValue = $(this).val();

            if (selectedValue == "Pilihan") {
                $('#tambahpilihanedit').prop("hidden", false);
                $('#container-input-d').prop("hidden", false);
                $('#container-input-db').prop("hidden", true)
                $('#text_inputedit').prop("hidden", true);
                if ($('#container-input-d').children().length > 1) {
                    // tambahInputedit();
                }
                validasiInputedit();
            } else if (selectedValue == "Blank_Teks") {
                $('#tambahpilihanedit').prop("hidden", false);
                $('#container-input-d').prop("hidden", true);
                $('#container-input-db').prop("hidden", false);
                $('#text_inputedit').prop("hidden", true);
                if ($('#container-input-db').children().length > 1) {
                    // tambahInputedit();
                }
                $('#submitBtnedit').prop('disabled', false);
            }else if (selectedValue == "Teks") {
                $('#tambahpilihanedit').prop("hidden", true);
                $('#container-input-d').prop("hidden", true);
                $('#container-input-db').prop("hidden", true);
                $('#text_inputedit').prop("hidden", false);
                $('#submitBtnedit').prop('disabled', false);
            } else if (selectedValue == "Custom Banner") {
                $('#tambahpilihanedit').prop("hidden", true);
                $('#container-input-d').prop("hidden", true);
                $('#container-input-db').prop("hidden", true);
                $('#text_inputedit').prop("hidden", false);
                $('#submitBtnedit').prop('disabled', false);
            }
        });
    });

    function tambahInput() {
        var nomorInput = $('#container-input-dinamis .form-group').length + 1;
        if ($('#tipe_pertanyaan').val() == "Blank_Teks" ) {
            var inputBaru = '<div class="form-group">' +
            '<div class="input-group">' +
            '<input type="text" class="form-control col-md-1" id="bobot' + nomorInput + '" name="bobot[]" placeholder="Bobot" oninput="validasiInput(' + nomorInput + ')" value="1">' +
            '<input type="text" class="form-control col-md-5" id="jawaban' + nomorInput + '" name="jawaban[]" oninput="validasiInput(' + nomorInput + ')" value="{blank_'+ nomorInput +'}">' +
            '<span class="input-group-btn">' +
            '<button type="button" class="btn btn-danger" onclick="hapusInput(this)"><i class="fa fa-trash"></i></button>' +
            '</span>' +
            '</div>' +
            '<span class="text-danger error-text bobot' + nomorInput + '_error"></span>' +
            '<span class="text-danger error-text jawaban' + nomorInput + '_error"></span>' +
            '</div>';
        '</div>';    
        $('#container-input-dinamis').append(inputBaru);
        } else{
            var inputBaru = '<div class="form-group">' +
                '<div class="input-group">' +
                '<input type="text" class="form-control col-md-1" id="bobot' + nomorInput + '" name="bobot[]" placeholder="Bobot" oninput="validasiInput(' + nomorInput + ')" value="0">' +
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
    }

    function tambahInputedit() {
        var nomorInput = $('#container-input-d .form-group').length + 1;
        var nomorInput = $('#container-input-db .form-group').length + 1;
        if ($('#edittipe_pertanyaan').val() == "Blank_Teks" ) {
            var inputBaru = '<div class="form-group">' +
                '<div class="input-group">' +
                '<input type="text" class="form-control col-md-1" id="editbobotblank' + nomorInput + '" name="editbobottambahblank[]" placeholder="Bobot" oninput="validasiInputedit(' + nomorInput + ')" value="1">' +
                '<input type="text" class="form-control col-md-5" id="editjawabanblank' + nomorInput + '" name="editjawabantambahblank[]" oninput="validasiInputedit(' + nomorInput + ')" value="{blank_'+ nomorInput +'}">' +
                '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-danger" onclick="hapusInput1(this)"><i class="fa fa-trash"></i></button>' +
                '</span>' +
                '</div>' +
                '<span class="text-danger error-text jawaban' + nomorInput + '_error"></span>' +
                '</div>';
                $('#container-input-db').append(inputBaru);    
        } else{
            var inputBaru = '<div class="form-group">' +
                '<div class="input-group">' +
                '<input type="text" class="form-control col-md-1" id="editbobot' + nomorInput + '" name="editbobottambah[]" placeholder="Bobot" oninput="validasiInputedit(' + nomorInput + ')" value="0">' +
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

    function validasiInputText() {
        var semuaInputTerisi = true;
        $('[id^="textbobot"]').each(function() {
            var textbobotInput = $(this).val();
            if (textbobotInput === '') {
                semuaInputTerisi = false;
                return false;
            }
        });
        $('#submitBtn').prop('disabled', !semuaInputTerisi);
        return semuaInputTerisi;
    }

    function validasiInputTextedit() {
        var semuaInputTerisi = true;
        $('[id^="edittextbobot"]').each(function() {
            var textbobotInput = $(this).val();
            if (textbobotInput === '') {
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


    $(document).ready(function() {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']],
                ['chords', ['chord']],
            ],
            buttons: {
                chord: function(context) {
                    var ui = $.summernote.ui;

                    var button = ui.button({
                        contents: '<i class="fa fa-music"/> Chord',
                        tooltip: 'Insert Chord',
                        click: function() {
                            // Mendapatkan teks terpilih
                            var selectedText = context.invoke('editor.getSelectedText');

                            // Mengecek apakah ada teks yang dipilih
                            if (selectedText && selectedText.trim() !== "") {
                                // Mengambil nilai chord dari pengguna
                                var chordValue = prompt("Masukkan nilai chord:", "");
                                if (chordValue !== null && chordValue.trim() !== "") {
                                    // Insert custom chord syntax with the selected text
                                    var chordNode = createChordNode(selectedText, chordValue);
                                    context.invoke('editor.insertNode', chordNode);
                                }
                            }
                        }
                    });

                    return button.render(); // return button as jQuery object
                }
            },
            callbacks: {
                onInit: function() {
                    // Ketika Summernote diinisialisasi, cek teks di dalamnya
                    $('#summernote').summernote('code', parseChords($('#summernote').summernote('code')));
                },
                onChange: function(contents) {
                    // Update the preview area with the parsed content
                    $('#preview').html(parseChords(contents));
                }
            }
        });

        function createChordNode(text, chordValue) {
            var chordNode = document.createElement('span');
            chordNode.className = 'chord';
            chordNode.setAttribute('data-chord', chordValue);
            chordNode.innerHTML = text;

            return chordNode;
        }

        function parseChords(content) {
            var chordsRegex = /<span class="chord" data-chord="(.*?)">(.*?)<\/span>/g;
            return content.replace(chordsRegex, '{$1}');
        }
    });

    $(document).ready(function() {
        $('#summernote2').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']],
                ['chords', ['chord']],
            ],
            buttons: {
                chord: function(context) {
                    var ui = $.summernote.ui;

                    var button = ui.button({
                        contents: '<i class="fa fa-music"/> Chord',
                        tooltip: 'Insert Chord',
                        click: function() {
                            // Mendapatkan teks terpilih
                            var selectedText = context.invoke('editor.getSelectedText');

                            // Mengecek apakah ada teks yang dipilih
                            if (selectedText && selectedText.trim() !== "") {
                                // Mengambil nilai chord dari pengguna
                                var chordValue = prompt("Masukkan nilai chord:", "");
                                if (chordValue !== null && chordValue.trim() !== "") {
                                    // Insert custom chord syntax with the selected text
                                    var chordNode = createChordNode(selectedText, chordValue);
                                    context.invoke('editor.insertNode', chordNode);
                                }
                            }
                        }
                    });

                    return button.render(); // return button as jQuery object
                }
            },
            callbacks: {
                onInit: function() {
                    // Ketika Summernote diinisialisasi, cek teks di dalamnya
                    $('#summernote2').summernote('code', parseChords($('#summernote2').summernote('code')));
                },
                onChange: function(contents) {
                    // Update the preview area with the parsed content
                    $('#preview').html(parseChords(contents));
                }
            }
        });

        function createChordNode(text, chordValue) {
            var chordNode = document.createElement('span');
            chordNode.className = 'chord';
            chordNode.setAttribute('data-chord', chordValue);
            chordNode.innerHTML = text;

            return chordNode;
        }

        function parseChords(content) {
            var chordsRegex = /<span class="chord" data-chord="(.*?)">(.*?)<\/span>/g;
            return content.replace(chordsRegex, '{$1}');
        }
    });
    $('.tipe_pertanyaan').select2({
        theme: 'bootstrap4'
    });
    $('.edittipe_pertanyaan').select2({
        theme: 'bootstrap4'
    });
</script>
<script src="{{asset('js/PertanyaanTentor.js')}}"></script>
@endsection
@endsection()