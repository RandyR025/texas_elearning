<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentor extends Model
{
    use HasFactory;
    protected $table = 'tentor';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
        'tanggal_lahir',
        'no_telp',
        'alamat',
        'kursus_id',
        'user_id',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }
}
