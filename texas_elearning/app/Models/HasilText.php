<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilText extends Model
{
    use HasFactory;
    protected $table = 'hasiltext';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'jadwal_id',
        'pertanyaan_id',
        'jawaban_id',
        'jawaban',
        'user_id',
    ];
}
