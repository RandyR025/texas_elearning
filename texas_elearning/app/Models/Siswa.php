<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
        'tanggal_lahir',
        'no_telp',
        'alamat',
        'kursus_id',
        'kelas_id',
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
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id', 'id');
    }
}
