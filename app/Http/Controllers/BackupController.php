<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Keaktifan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Exports\BackupDatabaseExport;
use App\Exports\DownloadReport;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    public function report()
    {
        $pertemuan = Pertemuan::All();
        $mahasiswa = Mahasiswa::All();
        $absensi = Absensi::All();
        $laporan = Laporan::All();
        $nilai = Nilai::All();
        $keaktifan = Keaktifan::All();
        return view("pdf", compact('pertemuan', 'mahasiswa', 'absensi', 'laporan', 'nilai', 'keaktifan'));
    }
    public function rekap()
    {
        $pertemuan = Pertemuan::All();
        $mahasiswa = Mahasiswa::All();
        $absensi = Absensi::All();
        $laporan = Laporan::All();
        $nilai = Nilai::All();
        $keaktifan = Keaktifan::All();
        return view("rekap", compact('pertemuan', 'mahasiswa', 'absensi', 'laporan', 'nilai', 'keaktifan'));
    }
    public function downloadreport()
    {
        $pertemuan = Pertemuan::all();
        $mahasiswa = Mahasiswa::all();

        $export = new DownloadReport($pertemuan, $mahasiswa);
        return Excel::download($export, 'report.xlsx');
    }
    public function truncateData()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Keaktifan::truncate();
        Nilai::truncate();
        Laporan::truncate();
        Absensi::truncate();
        Pertemuan::truncate();
        Mahasiswa::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return response()->json(['Sukses' => 'Data Mahasiswa Berhasil Dikosongkan'], 200);
    }
    public function backupDatabase()
    {
        $fileName = 'database_backup_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new BackupDatabaseExport(), $fileName)->deleteFileAfterSend(true);
    }
    public function batchstore(Request $request)
    {
        $data = $request->all();


        $errors = [];
        foreach ($data as $item) {
            $validator = Validator::make($item, [
                'nim' => 'required|unique:tb_mahasiswa',
                'nama' => 'required',
                'no_hp' => 'required',
            ]);

            if ($validator->fails()) {
                $errors[] = $validator->errors();
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $errors,
            ], 400);
        }


        foreach ($data as $item) {
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $item['nim'];
            $mahasiswa->nama = $item['nama'];
            $mahasiswa->no_hp = $item['no_hp'];
            $mahasiswa->save();
        }

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan!'
        ], 201);
    }
    public function importData(Request $request)
    {
        $data = $request->json()->all();

        foreach ($data['Mahasiswa'] as $mahasiswaData) {
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nim = $mahasiswaData['nim'];
            $mahasiswa->nama = $mahasiswaData['nama'];
            $mahasiswa->no_hp = $mahasiswaData['no_hp'];
            $mahasiswa->updated_at = $mahasiswaData['updated_at'];
            $mahasiswa->created_at = $mahasiswaData['created_at'];
            $mahasiswa->save();
        }

        foreach ($data['Pertemuan'] as $pertemuanData) {
            $pertemuan = new Pertemuan();
            $pertemuan->kode_pertemuan = $pertemuanData['kode_pertemuan'];
            $pertemuan->tanggal_pertemuan = $pertemuanData['tanggal_pertemuan'];
            $pertemuan->judul_pertemuan = $pertemuanData['judul_pertemuan'];
            $pertemuan->updated_at = $pertemuanData['updated_at'];
            $pertemuan->created_at = $pertemuanData['created_at'];
            $pertemuan->save();
        }

        foreach ($data['Absensi'] as $absensiData) {
            $absensi = new Absensi();
            $absensi->nim = $absensiData['nim'];
            $absensi->kode_absen = $absensiData['kode_absen'];
            $absensi->kode_pertemuan = $absensiData['kode_pertemuan'];
            $absensi->status = $absensiData['status'];
            $absensi->updated_at = $absensiData['updated_at'];
            $absensi->created_at = $absensiData['created_at'];
            $absensi->save();
        }

        foreach ($data['Laporan'] as $laporanData) {
            $laporan = new Laporan();
            $laporan->nim = $laporanData['nim'];
            $laporan->kode_pertemuan = $laporanData['kode_pertemuan'];
            $laporan->kode_laporan = $laporanData['kode_laporan'];
            $laporan->status = $laporanData['status'];
            $laporan->updated_at = $laporanData['updated_at'];
            $laporan->created_at = $laporanData['created_at'];
            $laporan->save();
        }

        foreach ($data['Nilai'] as $nilaiData) {
            $nilai = new Nilai();
            $nilai->nim = $nilaiData['nim'];
            $nilai->kode_nilai = $nilaiData['kode_nilai'];
            $nilai->kode_pertemuan = $nilaiData['kode_pertemuan'];
            $nilai->kode_laporan = $nilaiData['kode_laporan'];
            $nilai->nilai = $nilaiData['nilai'];
            $nilai->updated_at = $nilaiData['updated_at'];
            $nilai->created_at = $nilaiData['created_at'];
            $nilai->save();
        }

        foreach ($data['Keaktifan'] as $keaktifanData) {
            $keaktifan = new Keaktifan();
            $keaktifan->kode_keaktifan = $keaktifanData['kode_keaktifan'];
            $keaktifan->kode_pertemuan = $keaktifanData['kode_pertemuan'];
            $keaktifan->nim = $keaktifanData['nim'];
            $keaktifan->keterangan = $keaktifanData['keterangan'];
            $keaktifan->updated_at = $keaktifanData['updated_at'];
            $keaktifan->created_at = $keaktifanData['created_at'];
            $keaktifan->save();
        }

        return response()->json(['message' => 'Data berhasil ditambahkan'], 200);
    }
}
