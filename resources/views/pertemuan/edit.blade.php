@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Pertemuan') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pertemuan.update', $pertemuan->kode_pertemuan) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="kode_pertemuan" class="col-md-4 col-form-label text-md-right">{{ __('Kode Pertemuan') }}</label>

                            <div class="col-md-6">
                                <input id="kode_pertemuan" type="text" class="form-control @error('kode_pertemuan') is-invalid @enderror" name="kode_pertemuan" value="{{ $pertemuan->kode_pertemuan }}" required autocomplete="kode_pertemuan" autofocus>

                                @error('kode_pertemuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_pertemuan" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Pertemuan') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_pertemuan" type="date" class="form-control @error('tanggal_pertemuan') is-invalid @enderror" name="tanggal_pertemuan" value="{{ $pertemuan->tanggal_pertemuan }}" required autocomplete="tanggal_pertemuan">

                                @error('tanggal_pertemuan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
