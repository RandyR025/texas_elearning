<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'pertanyaan',
        'tipe_pertanyaan',
        'quiz_id',
        'point',
        'order_column'
    ];
}
