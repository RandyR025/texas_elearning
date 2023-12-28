@extends('backend/layouts.template')
@section('titlepage')
Data Quiz
@endsection
@section('titlesub')
Data Master
@endsection
@section('title')
Data Quiz
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Quiz</h3>
                    </div>
                    <div class="card-body" id="coba">
                        <form action="{{ route('dataquiz.tambah') }}" id="dataquiz_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="judul_quiz">Judul Quiz</label>
                                            <input type="text" class="form-control" id="judul_quiz" placeholder="Judul Quiz" name="judul_quiz">
                                            <span class="text-danger error-text judul_quiz_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select class="form-control kategori" style="width: 100%;" name="kategori" id="kategori">
                                                <option selected="selected" disabled>-- Pilih Kategori --</option>
                                                @foreach($modelkategori as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text kategori_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="gambar_quiz">Gambar Quiz</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="gambar_quiz" name="gambar_quiz" onchange="previewImage(this);">
                                                <label class="custom-file-label" for="gambar_quiz" id="fileLabel">Choose file</label>
                                            </div>
                                            <span class="text-danger error-text gambar_quiz_error"></span>
                                        </div>
                                        <!-- Image Preview -->
                                        <div class="form-group">
                                            <img id="image_preview" class="img-fluid" style="display: none; max-width: 200px; max-height: 200px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="audio_quiz">Audio Quiz</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" accept=".mp3, .wav" id="audio_quiz" name="audio_quiz" onchange="previewAudio();">
                                                <label class="custom-file-label" for="audio_quiz" id="fileLabel">Choose file</label>
                                            </div>
                                            <span class="text-danger error-text audio_quiz_error"></span>
                                        </div>
                                        <div id="audio_preview"></div>
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
                        <h3 class="card-title">Data Quiz</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dataquiz" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Judul Quiz</th>
                                    <th>Kategori Quiz</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <!-- Edit Modal -->
            <div class="modal fade" id="editquizmodal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h4 class="modal-title">Update Data Quiz</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="dataquizedit_form" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="editjudul_quiz">Judul Quiz</label>
                                                <input id="hidden_id" type="text" class="name form-control" value="" name="id" hidden />
                                                <input type="text" class="form-control" id="editjudul_quiz" placeholder="Judul Quiz" name="editjudul_quiz">
                                                <span class="text-danger error-text editjudul_quiz_kategori_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control editkategori" style="width: 100%;" name="editkategori" id="editkategori">
                                                    <option selected="selected" disabled>-- Pilih Kategori --</option>
                                                    @foreach($modelkategori as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text editkategori_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="editgambar_quiz">Gambar Quiz</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="editgambar_quiz" name="editgambar_quiz" onchange="editpreviewImage(this);">
                                                    <label class="custom-file-label" for="editgambar_quiz" id="fileLabeledit">Choose file</label>
                                                </div>
                                                <span class="text-danger error-text editgambar_quiz_error"></span>
                                            </div>

                                            <!-- Image Preview -->
                                            <div class="form-group">
                                                <img id="editimage_preview" class="img-fluid" style="display: none; max-width: 200px; max-height: 200px;">
                                            </div>

                                            <div class="form-group">
                                                <label for="editaudio_quiz">Audio Quiz</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="editaudio_quiz" name="editaudio_quiz" onchange="editpreviewAudio(this);">
                                                    <label class="custom-file-label" for="editaudio_quiz" id="fileLabeledit">Choose file</label>
                                                </div>
                                                <span class="text-danger error-text editaudio_quiz_error"></span>
                                            </div>
                                            <div id="editaudio_preview"></div>
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
<script>
    $('.editkategori').select2({
        theme: 'bootstrap4'
    })
    $('.kategori').select2({
        theme: 'bootstrap4'
    })

    function previewImage(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
                $('#image_preview').css('display', 'block');
            }
            reader.readAsDataURL(file);
            $('#fileLabel').html(file.name);
        } else {
            $('#image_preview').attr('src', '');
            $('#image_preview').css('display', 'none');
        }
    }

    function editpreviewImage(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#editimage_preview').attr('src', e.target.result);
                $('#editimage_preview').css('display', 'block');
            }
            reader.readAsDataURL(file);
            $('#fileLabeledit').html(file.name);
        } else {
            $('#editimage_preview').attr('src', '');
            $('#editimage_preview').css('display', 'none');
        }
    }

    function previewAudio() {
        var input = document.querySelector('input[name="audio_quiz"]');
        var audioPreview = document.getElementById('audio_preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                audioPreview.innerHTML = '<audio controls><source src="' + e.target.result + '" type="audio/' + input.files[0].type.split('/')[1] + '">Your browser does not support the audio element.</audio>';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function editpreviewAudio() {
        var input = document.querySelector('input[name="editaudio_quiz"]');
        var editaudioPreview = document.getElementById('editaudio_preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                editaudioPreview.innerHTML = '<audio controls><source src="' + e.target.result + '" type="audio/' + input.files[0].type.split('/')[1] + '">Your browser does not support the audio element.</audio>';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script src="{{asset('js/Quiz.js')}}"></script>
@endsection
@endsection()