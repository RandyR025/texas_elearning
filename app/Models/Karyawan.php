<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $PrimaryKey = 'nik';
    protected $fillable = [
        'nik',
        'nama_pegawai',
        'jabatan_id',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }
}
