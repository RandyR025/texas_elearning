<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailWaktu extends Model
{
    use HasFactory;
    protected $table = 'detail_waktu';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'quiz_id',
        'jadwal_id',
        'waktu_end',
    ];
}
