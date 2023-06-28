@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Mahasiswa</h1>
        <hr>
        @if ($errors->has('nim')) 
        <div class="alert alert-danger">
         <p>Username telah terdaftar.</p>
        </div>
        @endif 
        <form method="POST" action="{{ route('mahasiswa.store') }}">
            @csrf

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" name="nim" class="form-control" id="nim">
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama">
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
@endsection
