@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Keaktifan') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('keaktifan.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="nim" class="col-md-4 col-form-label text-md-right">{{ __('NIM') }}</label>

                            <div class="col-md-6">
                                <select id="nim" class="form-control @error('nim') is-invalid @enderror" name="nim" required>
                                    <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                                    @foreach($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->nim }}" {{ old('nim') == $mahasiswa->nim ? 'selected' : '' }}>{{ $mahasiswa->nim }} - {{ $mahasiswa->nama }}</option>
                                    @endforeach
                                </select>

                                @error('nim')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kode_pertemuan" class="col-md-4 col-form-label text-md-right">{{ __('Kode Pertemuan') }}</label>

                            <div class="col-md-6">
                                <select id="kode_pertemuan" class="form-control @error('kode_pertemuan') is-invalid @enderror" name="kode_pertemuan" required>
                                    <option value="" disabled selected>-- Pilih Kode Pertemuan --</option>
                                    @foreach($pertemuans as $pertemuan)
                                    <option value="{{ $pertemuan->kode_pertemuan }}" {{ old('kode_pertemuan') == $pertemuan->kode_pertemuan ? 'selected' : '' }}>{{ $pertemuan->kode_pertemuan }}</option>
                                    @endforeach
                                </select>

                                @error('kode_pertemuan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan" class="col-md-4 col-form-label text-md-right">{{ __('Keterangan') }}</label>

                            <div class="col-md-6">
                                <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" required>{{ old('keterangan') }}</textarea>

                                @error('keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Simpan') }}
                                </button>
                                <a href="{{ route('keaktifan.index') }}" class="btn btn-secondary">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection