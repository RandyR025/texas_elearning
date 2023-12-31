<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailHasil extends Model
{
    use HasFactory;
    protected $table = 'detailhasil';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'quiz_id',
        'jadwal_id',
        'totals',
    ];
}
