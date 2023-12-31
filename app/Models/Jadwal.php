<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwalquiz';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'quiz_id',
        'kelas_id',
        'tanggal_mulai',
        'tanggal_berakhir',
        'waktu_quiz',
        'tampilan_soal',
        'user_id',
    ];
}
