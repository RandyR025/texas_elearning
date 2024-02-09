<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuiz extends Model
{
    use HasFactory;
    protected $table = 'quiz_group';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'nama_group',
        'deskripsi',
    ];
}
