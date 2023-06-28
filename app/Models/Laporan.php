<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    
    protected $table = 'tb_laporan';

    protected $primaryKey = 'kode_laporan';

    protected $fillable = [
        'kode_laporan', 'kode_pertemuan', 'nim', 'status', 'nilai',
    ];

    public $incrementing = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'kode_pertemuan', 'kode_pertemuan');
    }
}
