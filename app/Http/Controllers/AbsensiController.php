<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class AbsensiController extends Controller
{
    public function indexapi(){
        $absensi = Absensi::all();
        return response()->json($absensi);
    }
    public function absenapi($id){
        $absensi = Absensi::where('kode_pertemuan', $id)->get();

        $absensiWithNama = $absensi->map(function ($item) {
            $mahasiswa = Mahasiswa::where('nim', $item->nim)->first();
            $item->nama = $mahasiswa->nama ?? null;
            return $item;
        });

        return response()->json($absensiWithNama);
    }
    public function getAbsenMhs($nim){
        $absensi = Absensi::where('nim',$nim)->get();
        return response()->json($absensi);
    }
    public function edit($id)
    {
        $absensi = Absensi::with('mahasiswa','pertemuan')->where('kode_pertemuan', $id)->get();
        return view('absensi.edit', compact('absensi'));
    }
    public function update(Request $request)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if (substr($key, 0, 2) === 'AB') {
                $absensi = Absensi::where('kode_absen', $key)->first();
                $absensi->status = $value;
                $absensi->save();
            }
        }
        return redirect()->route('pertemuan.index')->with('success', 'Data absensi berhasil diupdate.');
    }
    public function updateapi(Request $request){
        $input = $request->all();

        foreach ($input as $key=>$value) {
            if(substr($key, 0, 2) === 'AB') {
                $absensi = Absensi::where('kode_absen', $key)->first();
                $absensi->status = $value;
                $absensi->save();
            }
        }
        return response()->json([
            'message' => 'Absensi Berhasil Diupdate!'
        ], 201);
    }
}
