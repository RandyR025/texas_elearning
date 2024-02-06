<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSkor extends Model
{
    use HasFactory;
    protected $table = 'skorsetting';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'kategori_id',
        'jumlah_benar',
        'skor',
    ];
}
