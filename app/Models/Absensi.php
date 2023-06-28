<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    
    protected $table = 'tb_absensi';

    protected $primaryKey = 'kode_absen';

    protected $fillable = [
        'kode_absen', 'kode_pertemuan', 'nim', 'status',
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
