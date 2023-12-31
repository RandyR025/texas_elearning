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

    public function kursusSiswa()
    {
        return $this->hasOne(Siswa::class, 'kursus_id', 'id');
    }
    public function kursusTentor()
    {
        return $this->hasOne(Tentor::class, 'kursus_id', 'id');
    }
}
