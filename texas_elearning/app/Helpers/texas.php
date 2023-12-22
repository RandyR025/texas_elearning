<?php

use App\Models\DetailHasil;
use App\Models\HasilPilihan;

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
