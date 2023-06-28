<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;
    
    protected $table = 'tb_pertemuan';

    protected $primaryKey = 'kode_pertemuan';

    protected $fillable = [
        'kode_pertemuan', 'tanggal_pertemuan', 'judul_pertemuan',
    ];

    public $incrementing = false;

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'kode_pertemuan', 'kode_pertemuan');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'kode_pertemuan', 'kode_pertemuan');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'kode_pertemuan', 'kode_pertemuan');
    }

    public function keaktifan()
    {
        return $this->hasMany(Keaktifan::class, 'kode_pertemuan', 'kode_pertemuan');
    }
}
