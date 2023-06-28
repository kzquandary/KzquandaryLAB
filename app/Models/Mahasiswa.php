<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'tb_mahasiswa';

    protected $primaryKey = 'nim';

    protected $fillable = [
        'nim', 'nama', 'no_hp',
    ];

    public $incrementing = false;

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nim', 'nim');
    }

    public function keaktifan()
    {
        return $this->hasMany(Keaktifan::class, 'nim', 'nim');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'nim', 'nim');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'nim', 'nim');
    }
}
