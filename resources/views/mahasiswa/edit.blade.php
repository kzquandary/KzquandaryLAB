@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Mahasiswa</h1>
        <hr>

        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->nim) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" name="nim" class="form-control" id="nim" value="{{ $mahasiswa->nim }}">
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" value="{{ $mahasiswa->nama }}">
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp" value="{{ $mahasiswa->no_hp }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
@endsection
