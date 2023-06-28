@extends('layouts.app')

@section('content')
@if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pertemuan</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Kode Pertemuan</th>
                                <th>Tanggal Pertemuan</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pertemuans as $pertemuan)
                                <tr>
                                    <td>{{ $pertemuan->kode_pertemuan }}</td>
                                    <td>{{ $pertemuan->tanggal_pertemuan }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('laporan.edit', $pertemuan->kode_pertemuan) }}">Lihat</a>
                                        <a class="btn btn-success" href="{{ route('nilai.edit', $pertemuan->kode_pertemuan) }}">Nilai</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
