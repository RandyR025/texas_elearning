<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriQuiz extends Model
{
    use HasFactory;
    protected $table = 'quiz_kategori';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'nama_kategori',
        'deskripsi',
    ];
}
