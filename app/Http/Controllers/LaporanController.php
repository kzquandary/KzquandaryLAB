<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pertemuan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pertemuans = Pertemuan::paginate(10);
        return view('laporan.index', compact('pertemuans'));
    }
    public function indexapi()
    {
        $laporan = Laporan::all();
        return response()->json($laporan);
    }
    public function getDetail($nim){
        $laporan = Laporan::where('nim', $nim)->get();
        return response()->json($laporan);
    }
    public function getLaporan($id){
        $laporan = Laporan::where('kode_pertemuan', $id)->get();
        $laporanwithnama = $laporan->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });
    
        return response()->json($laporanwithnama);
    }
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pertemuan' => 'required',
            'nim' => 'required',
            'status' => 'required',
        ]);

        Laporan::create($request->all());
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = Laporan::with('mahasiswa','pertemuan')->where('kode_pertemuan', $id)->get();
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (substr($key, 0, 2) === 'LP') {
                $laporan = Laporan::where('kode_laporan', $key)->first();
                $laporan->status = $value;
                $laporan->save();
            }
        }
    
        return redirect()->route('laporan.index')->with('success', 'Data laporan berhasil diupdate.');
    }
    public function updateapi(Request $request)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (substr($key, 0, 2) === 'LP') {
                $laporan = Laporan::where('kode_laporan', $key)->first();
                $laporan->status = $value;
                $laporan->save();
            }
        }
        return response()->json(['Message' => 'Update laporan berhasil'], 201);
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}
