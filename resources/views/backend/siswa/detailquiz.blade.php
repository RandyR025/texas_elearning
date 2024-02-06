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
                    <audio id="audioQuiz" controls>
                        <source src="{{asset('audios_quiz/'.$quiz[0]->audio_quiz)}}" type="audio/mp3">
                        Maaf, browser Anda tidak mendukung tag audio.
                    </audio>
                    <div id="countdown" class="mb-2"></div>
                    <?php if (!cekQuiz($quiz[0]->quiz_id, Auth::user()->id, $quiz[0]->jadwal)) { ?>
                        <div class="box-body" id="datapertanyaan">
                            @include('backend/siswa.quizpaginator')
                        </div>
                    <?php } ?>
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
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            saveToDatabase();

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
    var waktuBatas = new Date("{{ $datawaktu->waktu_end }}").getTime();

    var x = setInterval(function() {
        var sekarang = new Date().getTime();
        var selisihWaktu = waktuBatas - sekarang;

        var jam = Math.floor(selisihWaktu / (1000 * 60 * 60));
        var menit = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
        var detik = Math.floor((selisihWaktu % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML = jam + "h " + menit + "m " + detik + "s ";

        if (selisihWaktu < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "Waktu sudah habis!";
            // Tambahkan kode di sini untuk menangani situasi waktu habis
            var quiz_id = "{{$quiz[0]->quiz_id}}";
            var jadwal_id = "{{$quiz[0]->jadwal}}";
            waktuHabis(quiz_id, jadwal_id);
        }
    }, 1000);

    function autoSaveToCookies(textarea) {
        var jawabanId = textarea.getAttribute('data-jawaban-id');
        var jadwalId = textarea.getAttribute('data-jadwal-id');
        var expirationTime = new Date().getTime() + 24 * 60 * 60 * 1000; // Set expiration to 24 hours from now
        var dataToStore = {
            content: textarea.value,
            expiration: expirationTime
        };
        localStorage.setItem('textareaContent' + jawabanId + '_' + jadwalId, JSON.stringify(dataToStore));
    }

    function activateEventListeners() {
        var textareas = document.querySelectorAll('textarea[data-jawaban-id]');
        textareas.forEach(function(textarea) {
            var jawabanId = textarea.getAttribute('data-jawaban-id');
            var jadwalId = textarea.getAttribute('data-jadwal-id');
            var datacek = textarea.getAttribute('data-cek');
            var wordCountDisplay = document.getElementById('wordCount' + jawabanId);

            var savedData = localStorage.getItem('textareaContent' + jawabanId + '_' + jadwalId);
            if (savedData) {
                var parsedData = JSON.parse(savedData);
                if (parsedData.expiration > new Date().getTime()) {
                    textarea.value = parsedData.content;
                } else {
                    // The data has expired, clear it
                    localStorage.removeItem('textareaContent' + jawabanId + '_' + jadwalId);
                }
            }

            textarea.addEventListener('input', function() {
                var wordCount = countWords(textarea.value);
                wordCountDisplay.innerHTML = 'Jumlah kata: ' + wordCount;

                // Save content to local storage with expiration
                autoSaveToCookies(textarea);
            });

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
    var quizID = "{{$quiz[0]->quiz_id}}";
    var jadwalID = "{{$quiz[0]->jadwal}}";

    function cekKuis() {
        $.ajax({
            type: "GET",
            url: "/cekhasil/" + quizID + "/" + jadwalID,
            success: function(response) {
                if (response.user == 1) {
                    window.location.href = '/quizsiswa';
                }
            }
        });
        setTimeout(function() {
            cekKuis();
        }, 1000);
    }

    $(document).ready(function() {
        cekKuis();
    });
</script>
<script src="{{asset('js/HasilPilihanQuiz.js')}}"></script>
<script>
    // function activateEventListeners() {
    //     var textareas = document.querySelectorAll('textarea[data-jawaban-id]');

    //     textareas.forEach(function(textarea) {
    //         var jawabanId = textarea.getAttribute('data-jawaban-id');
    //         var wordCountDisplay = document.getElementById('wordCount' + jawabanId);

    //         textarea.addEventListener('input', function() {
    //             var wordCount = countWords(textarea.value);
    //             wordCountDisplay.innerHTML = 'Jumlah kata: ' + wordCount;
    //         });

    //         // Inisialisasi hitung kata saat halaman dimuat
    //         var initialWordCount = countWords(textarea.value);
    //         wordCountDisplay.innerHTML = 'Jumlah kata: ' + initialWordCount;
    //     });

    //     function countWords(text) {
    //         var words = text.match(/\b\w+\b/g) || [];
    //         return words.length;
    //     }
    // }
</script>
<script>
    function goToQuestion(questionNum) {
        // Hitung halaman yang sesuai dengan nomor pertanyaan
        var currentPage = Math.ceil(questionNum / {{$halaman->tampilan_soal}});

        // Ambil URL halaman sesuai dengan nomor halaman
        var url = "{{ route('quizsiswadetail', ['id' => $quiz[0]->quiz_id, 'jadwal' => $quiz[0]->jadwal]) }}" + "?page=" + currentPage;

        // Kirim permintaan AJAX untuk memuat halaman
        saveToDatabase();
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
<script>
    $(document).ready(function() {
    // Membuat variabel untuk menyimpan posisi terakhir audio
    var lastAudioPosition = 0;

    // Mendapatkan elemen audio
    var audio = document.getElementById("audioQuiz");

    // Memeriksa apakah sudah ada nilai posisi yang disimpan di localStorage
    if (localStorage.getItem("lastAudioPosition") !== null) {
        // Mengambil nilai posisi terakhir dari localStorage
        lastAudioPosition = parseFloat(localStorage.getItem("lastAudioPosition"));
    }

    // Menetapkan nilai posisi terakhir ke elemen audio
    audio.currentTime = lastAudioPosition;

    // Mendapatkan izin untuk menggunakan media perangkat
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function(stream) {
            // Pemutaran audio setelah mendapatkan izin
            audio.play();
        })
        .catch(function(error) {
            // Menangani kesalahan jika izin tidak diberikan
            console.error('Tidak dapat memutar audio:', error);
        });

    // Menyimpan posisi audio saat halaman ditutup atau diperbarui
    window.addEventListener("beforeunload", function() {
        // Menyimpan posisi terakhir ke localStorage
        localStorage.setItem("lastAudioPosition", audio.currentTime.toString());
    });
});
// $(document).ready(function() {
//         console.log('masuk');
//         navigator.mediaDevices.getUserMedia({
//                 audio: true
//             })
//             .then(function(stream) {
//                 // Izin diberikan, Anda dapat memulai pemutaran audio
//                 var audio = document.getElementById("audioQuiz");
//                 audio.play();
//             })
//             .catch(function(error) {
//                 // Izin tidak diberikan, berikan informasi kepada pengguna
//                 console.error('Tidak dapat memutar audio:', error);
//             });
//     });
if ('<?php echo $quiz[0]->audio_quiz  ?>') {
    document.addEventListener('keydown', function (event) {
            // Check if the key pressed is the 'F5' key (keyCode 116)
            if (event.keyCode === 116) {
                // Munculkan peringatan alert
                const confirmationMessage = 'Jika anda merefresh halaman maka audio mulai dari awal dan waktu ujian tetap berlanjut, Anda yakin ?';
                if (!confirm(confirmationMessage)) {
                    event.preventDefault(); // Mencegah refresh jika pengguna membatalkan peringatan
                }
            }
        });
}
</script>
@endsection
@endsection