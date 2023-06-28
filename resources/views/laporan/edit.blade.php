@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Edit Laporan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('laporan.update') }}">
                        @csrf
                        @method('POST')
                        @foreach ($laporan as $item)
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ $item->mahasiswa->nama }}</label>
                            <div class="col-md-6 d-flex flex-row align-items-center">
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_laporan }}" id="hadir{{ $item->kode_laporan }}" value="Mengumpulkan" {{ $item->status == 'Mengumpulkan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_laporan }}">
                                    Mengumpulkan
                                    </label>
                                </div>
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_laporan }}" id="sakit{{ $item->kode_laporan }}" value="Telat" {{ $item->status == 'Telat' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_laporan }}">
                                        Telat
                                    </label>
                                </div>
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="{{ $item->kode_laporan }}" id="izin{{ $item->kode_laporan }}" value="Tidak Mengumpulkan" {{ $item->status == 'Tidak Mengumpulkan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $item->kode_laporan }}">
                                        Tidak Mengumpulkan
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