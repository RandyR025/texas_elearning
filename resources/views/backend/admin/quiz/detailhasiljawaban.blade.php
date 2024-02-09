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
    .question-boxes {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .question-box {
        width: 30px;
        height: 30px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .bg-light {
        background-color: #fff;
    }

    .bg-success {
        background-color: #28a745;
        color: #fff;
    }
</style>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div id="countdown" class="mb-2"></div>
                        <div class="box-body" id="datapertanyaan">
                            @include('backend/admin/quiz.hasilquizpaginator')
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@section('js')

<script type="text/javascript">
    $(document).ready(function() {
        // Tangani klik pada tautan pagination
        document.getElementById("countdown").innerHTML = "{{$siswa[0]->nama}}";
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            // Dapatkan data menggunakan AJAX
            getData(myurl);

            // Tambahkan langkah navigasi ke dalam riwayat
            history.pushState({
                page: page
            }, "", myurl);
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        });

        // Tangani perubahan state saat tombol navigasi browser digunakan
        $(window).on('popstate', function(event) {
            if (event.originalEvent.state) {
                var page = event.originalEvent.state.page;
                getData(location.pathname + '?page=' + page);
            }
        });
    });

    function getData(url) {
        $.ajax({
                url: url,
                type: "get",
                datatype: "html",
            })
            .done(function(data) {
                $("#datapertanyaan").html(data);
                activateEventListeners()
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
    }
</script>
<script>
    function activateEventListeners() {
        var textareas = document.querySelectorAll('textarea[data-jawaban-id]');

        textareas.forEach(function(textarea) {
            var jawabanId = textarea.getAttribute('data-jawaban-id');
            var wordCountDisplay = document.getElementById('wordCount' + jawabanId);

            textarea.addEventListener('input', function() {
                var wordCount = countWords(textarea.value);
                wordCountDisplay.innerHTML = 'Jumlah kata: ' + wordCount;
            });

            // Inisialisasi hitung kata saat halaman dimuat
            var initialWordCount = countWords(textarea.value);
            wordCountDisplay.innerHTML = 'Jumlah kata: ' + initialWordCount;
        });

        function countWords(text) {
            var words = text.match(/\b\w+\b/g) || [];
            return words.length;
        }
    }

    // Panggil fungsi untuk mengaktifkan listener pada saat halaman dimuat
    document.addEventListener('DOMContentLoaded', activateEventListeners);
</script>
<script>
    function goToQuestion(questionNum) {
        // Hitung halaman yang sesuai dengan nomor pertanyaan
        var currentPage = Math.ceil(questionNum / {{$halaman->tampilan_soal}});

        // Ambil URL halaman sesuai dengan nomor halaman
        var url = "{{ route('detaildatahasilquiz.detail', ['id' => $modelhasilquiz->id]) }}" + "?page=" + currentPage;

        // Kirim permintaan AJAX untuk memuat halaman
        // saveToDatabase();
        getData(url);
        history.pushState({
            page: currentPage
        }, "", url);

        // Geser ke bagian atas halaman
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    }
</script>

@endsection
@endsection