<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'tb_nilai';

    protected $primaryKey = 'kode_nilai';

    protected $fillable = [
        'kode_nilai', 'kode_laporan', 'kode_pertemuan', 'nilai',
    ];

    public $incrementing = false;

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'kode_laporan', 'kode_laporan');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'kode_pertemuan', 'kode_pertemuan');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
