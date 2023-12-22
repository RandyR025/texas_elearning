<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;
    protected $table = 'kursus';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'kursus',
    ];
}
