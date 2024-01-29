<?php

use App\Models\DetailHasil;
use App\Models\HasilPilihan;
use App\Models\HasilText;
use App\Models\Jadwal;

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
function cekhasilText($jawaban,$user,$tanggal){
    $query = HasilText::where([
        ['user_id','=',$user],
        ['jawaban_id','=',$jawaban],
        ['jadwal_id','=',$tanggal],
    ])->count();
    // dd($query->jawaban);
    return $query;
}
