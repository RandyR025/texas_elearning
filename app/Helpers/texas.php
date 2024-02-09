<?php

use App\Models\DetailHasil;
use App\Models\HasilPilihan;
use App\Models\HasilText;
use App\Models\Jadwal;
use App\Models\Pertanyaan;

function hasilPilihan($pilihan,$user,$tanggal){
    $query = HasilPilihan::where([
        ['user_id','=',$user],
        ['jawaban_id','=',$pilihan],
        ['jadwal_id','=',$tanggal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}
function cekhasilPilihan($pertanyaan,$user,$tanggal){
    $query = HasilPilihan::where([
        ['user_id','=',$user],
        ['pertanyaan_id','=',$pertanyaan],
        ['jadwal_id','=',$tanggal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}
function cekhasilPilihanAkhir($pertanyaan,$user,$tanggal){
    $query = HasilPilihan::where([
        ['user_id','=',$user],
        ['pertanyaan_id','=',$pertanyaan],
        ['jadwal_id','=',$tanggal],
    ])->count();
    $queryy = HasilPilihan::join('jawabanpertanyaan','hasilpilihan.jawaban_id','=','jawabanpertanyaan.id')->where([
        ['user_id','=',$user],
        ['hasilpilihan.pertanyaan_id','=',$pertanyaan],
        ['jadwal_id','=',$tanggal],
    ])->first();
    if ($query == 1 && $queryy->point == 1) {
        return true;
    }else {
        return false;
    }
}
// function nomorsoal($id,$jadwal){
//     $kotakquiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal]])->orderBy('order_column', 'asc')->get();
//     return $kotakquiz;
// }
function cekQuiz($quiz, $user, $jadwal){
    $query = DetailHasil::where([
        ['user_id','=',$user],
        ['quiz_id','=',$quiz],
        ['jadwal_id','=',$jadwal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}
function cekQuizPrevious($user, $jadwal){
    $model = Jadwal::where('id', '=', $jadwal)->first();
    $query = DetailHasil::where([
        ['user_id','=',$user],
        ['jadwal_id','=',$model->prev_quiz],
    ])->count();
    if ($model->prev_quiz == null) {
        return true;
    }else {
        if ($query == 1) {
            return true;
        }else {
            return false;
        }
    }
}
function hasilText($jawaban,$user,$tanggal){
    $query = HasilText::where([
        ['user_id','=',$user],
        ['jawaban_id','=',$jawaban],
        ['jadwal_id','=',$tanggal],
    ])->first();
    // dd($query->jawaban);
    if (isset($query)) {
        $hasiltext = $query->jawaban;
        return $hasiltext;
    }
}
function cekhasilTeks($pertanyaan,$user,$tanggal){
    $query = HasilText::where([
        ['user_id','=',$user],
        ['pertanyaan_id','=',$pertanyaan],
        ['jadwal_id','=',$tanggal],
    ])->count();
    $query2 = HasilText::where([
        ['user_id','=',$user],
        ['pertanyaan_id','=',$pertanyaan],
        ['jadwal_id','=',$tanggal],
    ])->first();
    if ($query == 1 && $query2->jawaban !== null) {
        return true;
    }else {
        return false;
    }
}
// function cekhasilText($jawaban,$user,$tanggal){
//     $query = HasilText::where([
//         ['user_id','=',$user],
//         ['jawaban_id','=',$jawaban],
//         ['jadwal_id','=',$tanggal],
//     ])->count();
//     $query2 = HasilText::where([
//         ['user_id','=',$user],
//         ['jawaban_id','=',$jawaban],
//         ['jadwal_id','=',$tanggal],
//     ])->first();
//     if ($query == 1 && $query2->jawaban == null) {
//         return 0;
//     } elseif ($query == 1 && $query2->jawaban !== null) {
//         return 1;
//     } else {
//         return 0;
//     }
// }
