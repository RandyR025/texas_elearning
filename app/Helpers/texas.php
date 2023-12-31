<?php

use App\Models\DetailHasil;
use App\Models\HasilPilihan;
use App\Models\HasilText;

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
