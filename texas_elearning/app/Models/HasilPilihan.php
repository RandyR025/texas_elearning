<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPilihan extends Model
{
    use HasFactory;
    protected $table = 'hasilpilihan';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'jadwal_id',
        'pertanyaan_id',
        'jawaban_id',
        'user_id',
    ];
}
