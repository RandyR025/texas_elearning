<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $table = 'jawabanpertanyaan';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'jawaban',
        'pertanyaan_id',
        'point',
    ];
}
