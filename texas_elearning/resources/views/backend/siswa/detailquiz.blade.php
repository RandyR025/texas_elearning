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
    
</style>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div id="countdown" class="mb-2"></div>
                    <?php if (!cekQuiz($quiz[0]->quiz_id, Auth::user()->id, $quiz[0]->jadwal)) {?>
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

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            // Dapatkan data menggunakan AJAX
            getData(myurl);

            // Tambahkan langkah navigasi ke dalam riwayat
            history.pushState({ page: page }, "", myurl);
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
                waktuHabis(quiz_id,jadwal_id);
            }
        }, 1000);
    </script>
<script src="{{asset('js/HasilPilihanQuiz.js')}}"></script>

@endsection
@endsection