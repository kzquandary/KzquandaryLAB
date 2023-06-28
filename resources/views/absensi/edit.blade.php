@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Edit Absensi</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('absensi.update') }}">
                        @csrf
                        @method('POST')
                        @foreach ($absensi as $item)
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ $item->mahasiswa->nama }}</label>
                            <div class="col-md-6 d-flex flex-row align-items-center">
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_absen }}" id="hadir{{ $item->kode_absen }}" value="Hadir" {{ $item->status == 'Hadir' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_absen }}">
                                        Hadir
                                    </label>
                                </div>
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_absen }}" id="sakit{{ $item->kode_absen }}" value="Sakit" {{ $item->status == 'Sakit' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_absen }}">
                                        Sakit
                                    </label>
                                </div>
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_absen }}" id="izin{{ $item->kode_absen }}" value="Izin" {{ $item->status == 'Izin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_absen }}">
                                        Izin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_absen }}" id="alpa{{ $item->kode_absen }}" value="Alpha" {{ $item->status == 'Alpha' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_absen }}">
                                        Alpa
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a href="{{ route('pertemuan.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection