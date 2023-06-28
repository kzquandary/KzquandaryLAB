@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Mahasiswa</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>NIM</th>
                            <td>{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $mahasiswa->no_hp }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-success">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
