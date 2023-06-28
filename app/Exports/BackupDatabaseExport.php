<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Keaktifan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BackupDatabaseExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $models = [
            'Mahasiswa' => Mahasiswa::query(),
            'Pertemuan' => Pertemuan::query(),
            'Absensi' => Absensi::query(),
            'Laporan' => Laporan::query(),
            'Nilai' => Nilai::query(),
            'Keaktifan' => Keaktifan::query(),
        ];

        foreach ($models as $modelName => $query) {
            $sheets[] = new class($query, $modelName) implements FromQuery, WithTitle, WithHeadings, ShouldAutoSize {
                private $query;
                private $modelName;

                public function __construct($query, $modelName)
                {
                    $this->query = $query;
                    $this->modelName = $modelName;
                }

                public function query()
                {
                    return $this->query;
                }

                public function title(): string
                {
                    return $this->modelName;
                }

                public function headings(): array
                {
                    $firstRecord = $this->query->first();

                    if ($firstRecord) {
                        return array_keys($firstRecord->toArray());
                    }

                    return [];
                }
            };
        }

        return $sheets;
    }
}
