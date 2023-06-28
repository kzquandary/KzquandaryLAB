@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Pertemuan') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('nilai.update') }}">
                        @csrf
                        @method('POST')
                        @foreach($nilais as $item)
                        <div class="form-group row">
                            <label for="kode_nilai" class="col-md-4 col-form-label text-md-right">{{ $item->mahasiswa->nama }}</label>
                            <div class="col-md-6">
                                <input id="kode_pertemuan" type="text" class="form-control @error('kode_pertemuan') is-invalid @enderror" name="{{ $item->kode_nilai }}" value="{{ $item->nilai }}" required autofocus>
                                @error('kode_pertemuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ route('laporan.index') }}" class="btn btn-danger"> Kembali </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
