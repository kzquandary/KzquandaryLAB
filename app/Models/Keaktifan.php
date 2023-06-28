<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keaktifan extends Model
{
    use HasFactory;

    protected $table = 'tb_keaktifan';

    protected $primaryKey = 'kode_keaktifan';

    protected $fillable = [
        'kode_keaktifan', 'kode_pertemuan', 'nim', 'keterangan',
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
