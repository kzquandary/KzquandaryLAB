<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Keaktifan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DownloadReport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        $pertemuans = Pertemuan::all();
        $mahasiswa = Mahasiswa::all();

        foreach ($pertemuans as $pertemuan) {
            $sheet = new PertemuanSheet($pertemuan, $mahasiswa);
            $sheets[] = $sheet;
        }

        return $sheets;
    }
}

class PertemuanSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    private $pertemuan;
    private $mahasiswa;

    public function __construct($pertemuan, $mahasiswa)
    {
        $this->pertemuan = $pertemuan;
        $this->mahasiswa = $mahasiswa;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->mahasiswa as $mahasiswa) {
            $absensi = $this->pertemuan->absensi
                ->where('nim', $mahasiswa->nim)
                ->where('kode_pertemuan', $this->pertemuan->kode_pertemuan)
                ->first();

            $laporan = $this->pertemuan->laporan
                ->where('nim', $mahasiswa->nim)
                ->where('kode_pertemuan', $this->pertemuan->kode_pertemuan)
                ->first();

            $nilai = $this->pertemuan->nilai
                ->where('nim', $mahasiswa->nim)
                ->where('kode_pertemuan', $this->pertemuan->kode_pertemuan)
                ->first();

            $keaktifanCount = $this->pertemuan->keaktifan
                ->where('nim', $mahasiswa->nim)
                ->where('kode_pertemuan', $this->pertemuan->kode_pertemuan)
                ->count();

            $keaktifan = $keaktifanCount > 0 ? $keaktifanCount : 0;

            $data[] = [
                'NIM' => $mahasiswa->nim,
                'NAMA' => $mahasiswa->nama,
                'ABSEN' => $absensi ? $absensi->status : '-',
                'LAPORAN' => $laporan ? $laporan->status : '-',
                'NILAI' => $nilai ? $nilai->nilai : '-',
                'KEAKTIFAN' => $keaktifan
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NIM',
            'NAMA',
            'ABSEN',
            'LAPORAN',
            'NILAI',
            'KEAKTIFAN'
        ];
    }

    public function title(): string
    {
        return 'Pertemuan ' . $this->pertemuan->kode_pertemuan;
    }
}
