<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absensi;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Keaktifan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    public function backupMahasiswa()
    {
        $mahasiswas = Mahasiswa::all();

        $columns = [
            'nim',
            'nama',
            'no_hp',
            'created_at',
            'updated_at',
        ];

        $file = fopen('mahasiswa.csv', 'w');

        fputcsv($file, $columns);

        foreach ($mahasiswas as $mahasiswa) {
            $data = [
                $mahasiswa->nim,
                $mahasiswa->nama,
                $mahasiswa->no_hp,
                $mahasiswa->created_at,
                $mahasiswa->updated_at,
            ];
            fputcsv($file, $data);
        }

        fclose($file);

        return response()->download('mahasiswa.csv')->deleteFileAfterSend(true);
    }

    public function index()
    {
        $mahasiswas = Mahasiswa::paginate(10);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function indexapi()
    {
        $mahasiswas = Mahasiswa::all();
        return response()->json($mahasiswas);
    }
    public function getDetail($nim)
    {
        $mahasiswa = Mahasiswa::find($nim);

        if ($mahasiswa) {
            return response()->json($mahasiswa);
        } else {
            return response()->json(['message' => 'Data Mahasiswa Tidak Ditemukan'], 404);
        }
    }

    public function getDetailnama($nama)
    {
        // $mahasiswa = Mahasiswa::where('nama', $nama)->get();
        $mahasiswa = Mahasiswa::whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($nama) . '%'])->get();
        if ($mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Data Mahasiswa Tidak Ditemukan'], 404);
        } else {
            return response()->json($mahasiswa);
        }
    }
    public function getDetailnohp($nohp)
    {
        $mahasiswa = Mahasiswa::where('no_hp', $nohp)->get();
        if ($mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Data Mahasiswa Tidak Ditemukan'], 404);
        } else {
            return response()->json($mahasiswa);
        }
    }
    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:tb_mahasiswa',
            'nama' => 'required',
            'no_hp' => 'required',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    // public function storeapi(Request $request)
    // {
    //     $request->validate([
    //         'nim' => 'required|unique:tb_mahasiswa',
    //         'nama' => 'required',
    //         'no_hp' => 'required',
    //     ]);

    //     $mahasiswa = new Mahasiswa;
    //     $mahasiswa->nim = $request->nim;
    //     $mahasiswa->nama = $request->nama;
    //     $mahasiswa->no_hp = $request->no_hp;
    //     $mahasiswa->save();

    //     return response()->json([
    //         'message' => 'Mahasiswa berhasil ditambahkan!'
    //     ], 201);
    // }
    public function storeapi(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:tb_mahasiswa',
            'nama' => 'required',
            'no_hp' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->nama = $request->nama;
            $mahasiswa->no_hp = $request->no_hp;
            $mahasiswa->save();

            $pertemuan = Pertemuan::all();
            $jumlah_pertemuan = $pertemuan->count();

            if ($jumlah_pertemuan > 0) {
                foreach ($pertemuan as $pert) {
                    $absensiData = [];
                    $laporanData = [];

                    $absensiData[] = [
                        'kode_absen' => 'AB' . $mahasiswa->nim . $pert->kode_pertemuan,
                        'kode_pertemuan' => $pert->kode_pertemuan,
                        'nim' => $mahasiswa->nim,
                        'status' => 'Alpha',
                    ];

                    $laporanData[] = [
                        'kode_laporan' => 'LP' . $mahasiswa->nim . $pert->kode_pertemuan,
                        'kode_pertemuan' => $pert->kode_pertemuan,
                        'nim' => $mahasiswa->nim,
                        'status' => 'Telat',
                    ];

                    $pert->absensi()->createMany($absensiData);
                    $pert->laporan()->createMany($laporanData);

                    $laporanModel = Laporan::where('kode_pertemuan', $pert->kode_pertemuan)
                        ->where('nim', $mahasiswa->nim)
                        ->first();

                    $nilaiModel = new Nilai();
                    $nilaiModel->kode_nilai = 'NL' . $mahasiswa->nim . $pert->kode_pertemuan;
                    $nilaiModel->kode_laporan = $laporanModel->kode_laporan;
                    $nilaiModel->kode_pertemuan = $pert->kode_pertemuan;
                    $nilaiModel->nim = $mahasiswa->nim;
                    $nilaiModel->nilai = "0";
                    $nilaiModel->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Mahasiswa berhasil ditambahkan!'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding mahasiswa: ' . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan mahasiswa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate!');
    }
    public function updateapi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());
        return response()->json([
            'message' => 'Mahasiswa berhasil diupdate!'
        ], 201);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus!');
    }
    public function destroyapi($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return response()->json([
            'message' => 'Mahasiswa berhasil dihapus!'
        ], 201);
    }
    public function checkmhs($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
    
        if ($mahasiswa) {
            return response()->json(['message' => 'Mahasiswa ditemukan'], 201);
        } else {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }
    }
    
}
