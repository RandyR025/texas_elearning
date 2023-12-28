<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'judul_quiz',
        'kategori_id',
        'gambar_quiz',
        'audio_quiz',
    ];
}
