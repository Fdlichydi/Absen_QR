<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['nis', 'nama', 'id_jurusan','foto', 'qrcode'];
    protected $casts = [
        'nis' => 'integer',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }
    
    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_siswa');
    }

}
