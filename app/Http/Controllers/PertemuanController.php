<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertemuanController extends Controller
{
    public function index()
    {
        $pertemuans = Pertemuan::paginate(10);
        return view('pertemuan.index', compact('pertemuans'));
    }

    public function indexapi()
    {
        $pertemuans = Pertemuan::all();
        return response()->json($pertemuans);
    }

    public function create()
    {
        return view('pertemuan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_pertemuan' => 'required|date',
        ]);

        $jumlah_pertemuan = Pertemuan::count() + 1;
        $kode_pertemuan = 'P' . str_pad($jumlah_pertemuan, 3, '0', STR_PAD_LEFT);

        $pertemuan = Pertemuan::create([
            'kode_pertemuan' => $kode_pertemuan,
            'tanggal_pertemuan' => $validatedData['tanggal_pertemuan'],
        ]);

        $mahasiswa = Mahasiswa::all();

        $absensi = [];
        $jumlah_pertemuan = Pertemuan::count();
        foreach ($mahasiswa as $mhs) {
            $absensi[] = [
                'kode_absen' => 'AB' . $mhs->nim . $jumlah_pertemuan,
                'kode_pertemuan' => $pertemuan->kode_pertemuan,
                'nim' => $mhs->nim,
                'status' => 'Alpha',
            ];
        }
        $laporan = [];
        foreach ($mahasiswa as $mhs) {
            $laporan[] = [
                'kode_laporan' => 'LP' . $mhs->nim . $jumlah_pertemuan,
                'kode_pertemuan' => $pertemuan->kode_pertemuan,
                'nim' => $mhs->nim,
                'status' => 'Telat',
            ];
        }
        $nilai = [];
        foreach ($mahasiswa as $mhs) {
            $nilai[] = [
                'kode_nilai' => 'NL' . $mhs->nim . $jumlah_pertemuan,
                'kode_laporan' => 'LP' . $mhs->nim . $jumlah_pertemuan,
                'kode_pertemuan' => $pertemuan->kode_pertemuan,
                'nim' => $mhs->nim,
                'nilai' => "0",
            ];
        }
        Absensi::insert($absensi);
        Laporan::insert($laporan);
        Nilai::insert($nilai);
        return redirect()->route('pertemuan.index')->with('success', 'Data pertemuan dan absensi berhasil disimpan.');
    }

    public function storeapi(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_pertemuan' => 'required|date',
            'judul_pertemuan' => 'string',
        ]);

        $jumlah_pertemuan = Pertemuan::count() + 1;
        $kode_pertemuan = 'P' . str_pad($jumlah_pertemuan, 3, '0', STR_PAD_LEFT);
        $nomor_pertemuan = Pertemuan::count() + 1;
        $judul_pertemuan = "Pertemuan {$nomor_pertemuan} : " . $validatedData['judul_pertemuan'];

        $pertemuan = Pertemuan::create([
            'kode_pertemuan' => $kode_pertemuan,
            'tanggal_pertemuan' => $validatedData['tanggal_pertemuan'],
            'judul_pertemuan' => $judul_pertemuan,
        ]);

        $mahasiswa = Mahasiswa::all();

        $jumlah_pertemuan = Pertemuan::count();
        $mahasiswa = Mahasiswa::all();

        $pertemuan->absensi()->createMany(
            collect($mahasiswa)->map(function ($mhs) use ($pertemuan, $jumlah_pertemuan) {
                return [
                    'kode_absen' => 'AB' . $mhs->nim . $jumlah_pertemuan,
                    'kode_pertemuan' => $pertemuan->kode_pertemuan,
                    'nim' => $mhs->nim,
                    'status' => 'Alpha',
                ];
            })
        );

        $pertemuan->laporan()->createMany(
            collect($mahasiswa)->map(function ($mhs) use ($pertemuan, $jumlah_pertemuan) {
                return [
                    'kode_laporan' => 'LP' . $mhs->nim . $jumlah_pertemuan,
                    'kode_pertemuan' => $pertemuan->kode_pertemuan,
                    'nim' => $mhs->nim,
                    'status' => 'Telat',
                ];
            })
        );

        $nilai = [];
        foreach ($mahasiswa as $mhs) {
            $laporanModel = Laporan::where('kode_pertemuan', $pertemuan->kode_pertemuan)
                ->where('nim', $mhs->nim)
                ->first();

            $nilaiModel = new Nilai();
            $nilaiModel->kode_nilai = 'NL' . $mhs->nim . $jumlah_pertemuan;
            $nilaiModel->kode_laporan = $laporanModel->kode_laporan;
            $nilaiModel->kode_pertemuan = $pertemuan->kode_pertemuan;
            $nilaiModel->nim = $mhs->nim;
            $nilaiModel->nilai = "0";
            $nilaiModel->save();
            $nilai[] = $nilaiModel;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pertemuan berhasil ditambahkan!'
        ], 201);
    }


    public function show($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        return view('pertemuan.show', compact('pertemuan'));
    }

    public function edit($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);
        return view('pertemuan.edit', compact('pertemuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pertemuan' => 'required',
            'judul_pertemuan' => 'required',
        ]);

        $pertemuan = Pertemuan::findOrFail($id);
        $pertemuan->update($request->all());
        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil diupdate!');
    }
    public function updateapi(Request $request, $id)
    {
        $request->validate([
            'tanggal_pertemuan' => 'required',
            'judul_pertemuan' => 'required',
        ]);

        $pertemuan = Pertemuan::findOrFail($id);
        $pertemuan->update($request->all());
        return response()->json([
            'message' => 'Pertemuan berhasil diupdate!'
        ], 201);
    }

    public function destroy($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);

        $latestPertemuan = Pertemuan::latest()->first();
        if ($pertemuan->id < $latestPertemuan->id) {
            return response()->json([
                'message' => 'Tidak diizinkan menghapus pertemuan di bawah pertemuan terbaru!'
            ], 400);
        }

        Absensi::where('kode_pertemuan', $id)->delete();
        Nilai::where('kode_pertemuan', $id)->delete();
        $pertemuan->delete();
        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil dihapus!');
    }
    public function destroyapi($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);

        $latestPertemuan = Pertemuan::latest()->first();
        if ($pertemuan->id < $latestPertemuan->id) {
            return response()->json([
                'message' => 'Tidak diizinkan menghapus pertemuan di bawah pertemuan terbaru!'
            ], 400);
        }

        Absensi::where('kode_pertemuan', $id)->delete();
        Nilai::where('kode_pertemuan', $id)->delete();
        $pertemuan->delete();
        return response()->json([
            'message' => 'Pertemuan berhasil dihapus!'
        ], 201);
    }
}
