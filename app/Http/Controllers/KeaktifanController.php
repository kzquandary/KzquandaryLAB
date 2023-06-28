<?php

namespace App\Http\Controllers;

use App\Models\Keaktifan;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class KeaktifanController extends Controller
{
    public function index()
    {
        $keaktifans = Keaktifan::paginate(10);
        return view('keaktifan.index', compact('keaktifans'));
    }
    public function getDetail($nim){
        $keaktifan = Keaktifan::where('nim',$nim)->get();
        $absensiWithNama = $keaktifan->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });
        return response()->json($absensiWithNama);    
    }
    public function indexapi(){
        $keaktifan = Keaktifan::all();
        $absensiWithNama = $keaktifan->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });
        return response()->json($absensiWithNama);
    }
    public function create()
    {
        $mahasiswas = Mahasiswa::all();
        $pertemuans = Pertemuan::all();
        return view('keaktifan.create', compact('mahasiswas','pertemuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pertemuan' => 'required',
            'nim' => 'required',
            'keterangan' => 'required',
        ]);


        $request->merge(['kode_keaktifan' => 'KF' . $request->nim . $request->kode_pertemuan ]);

        Keaktifan::create($request->all());
        return redirect()->route('keaktifan.index')->with('success', 'Data keaktifan berhasil ditambahkan!');
    }
    public function storeapi(Request $request)
    {
        $request->validate([
            'kode_pertemuan' => 'required',
            'nim' => 'required',
            'keterangan' => 'required',
        ]);
    
        $baseKodeKeaktifan = 'KF' . $request->nim . $request->kode_pertemuan;
    
        $existingKeaktifan = Keaktifan::where('kode_keaktifan', 'like', $baseKodeKeaktifan . '%')->orderBy('kode_keaktifan', 'desc')->first();
        if ($existingKeaktifan) {
            $lastNumber = intval(substr($existingKeaktifan->kode_keaktifan, strlen($baseKodeKeaktifan)));
            $newNumber = $lastNumber + 1;
            $newKodeKeaktifan = $baseKodeKeaktifan . $newNumber;
            $request->merge(['kode_keaktifan' => $newKodeKeaktifan]);
        } else {
            $request->merge(['kode_keaktifan' => $baseKodeKeaktifan]);
        }
    
        Keaktifan::create($request->all());
        return response()->json([
            'message' => 'Keaktifan berhasil ditambahkan!'
        ], 201);
    }

    public function edit($id)
    {
        $mahasiswas = Mahasiswa::all();
        $pertemuans = Pertemuan::all();
        $keaktifan = Keaktifan::findOrFail($id);
        return view('keaktifan.edit', compact('keaktifan','mahasiswas','pertemuans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_pertemuan' => 'required',
            'nim' => 'required',
            'keterangan' => 'required',
        ]);

        $keaktifan = Keaktifan::findOrFail($id);
        $keaktifan->update($request->all());
        return redirect()->route('keaktifan.index')->with('success', 'Data keaktifan berhasil diupdate!');
    }
    public function updateapi(Request $request, $id)
    {
        $request->validate([
            'kode_pertemuan' => 'required',
            'nim' => 'required',
            'keterangan' => 'required',
        ]);

        $keaktifan = Keaktifan::findOrFail($id);
        $keaktifan->update($request->all());
        return response()->json([
            'message' => 'Keaktifan berhasil dihapus!'
        ], 201);
    }

    public function destroy($id)
    {
        $keaktifan = Keaktifan::findOrFail($id);
        $keaktifan->delete();
        return redirect()->route('keaktifan.index')->with('success', 'Data keaktifan berhasil dihapus!');
    }
    public function destroyapi($id)
    {
        $keaktifan = Keaktifan::findOrFail($id);
        $keaktifan->delete();
        return response()->json([
            'message' => 'Keaktifan berhasil dihapus!'
        ], 201);
    }
}
