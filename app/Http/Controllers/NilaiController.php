<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with('laporan','mahasiswa')->get();
        return view('nilai.index', compact('nilais'));
    }
    public function indexapi()
    {
        $nilai = Nilai::all();
        $nilais = $nilai->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });
        return response()->json($nilais);  
    }
    
    public function detailNilai($id)
    {
        $nilai = Nilai::where('kode_pertemuan', $id)->get();
        $nilais = $nilai->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });
        return response()->json($nilais);  
    }
    public function getDetails($nim){
        $nilai = Nilai::where('nim',$nim)->get();
        return response()->json($nilai);
    }
    public function edit($id)
    {
        $nilais = Nilai::with('laporan','mahasiswa')->where('kode_pertemuan', $id)->get();
        return view('nilai.edit', compact('nilais'));
    }

    public function update(Request $request)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (substr($key, 0, 2) === 'NL') {
                $nilais = Nilai::where('kode_nilai', $key)->first();
                $nilais->nilai = $value;
                $nilais->save();
            }
        }
    
        return redirect()->route('laporan.index')->with('success', 'Data nilai berhasil diupdate.');
    }
    public function updateapi(Request $request)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (substr($key, 0, 2) === 'NL') {
                $nilais = Nilai::where('kode_nilai', $key)->first();
                $nilais->nilai = $value;
                $nilais->save();
            }
        }
    
        return response()->json([
            'message' => 'Keaktifan berhasil ditambahkan!'
        ], 201);
    }

}
