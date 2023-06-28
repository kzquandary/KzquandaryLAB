@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="row justify-content-center">
            <a href="{{ route('keaktifan.create') }}" class="btn btn-primary ml-auto">Tambah Keaktifan</a>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pertemuan</div>
                        <div class="card-body">
                         <table class="table table-bordered">
                            <tr>
                                <th>Kode Keaktifan</th>
                                <th>Pertemuan</th>
                                <th>NIM</th>
                                <th>keterangan</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($keaktifans as $item)
                            <tr>
                                <td>{{ $item->kode_keaktifan }}</td>
                                <td>{{ $item->kode_pertemuan }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <form id="delete-item-{{ $item->nim }}" action="{{ route('keaktifan.destroy',$item->kode_keaktifan) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('keaktifan.edit', $item->kode_keaktifan) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <form action="{{ route('keaktifan.destroy', $item->kode_keaktifan) }}" method="POST" style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


@endsection
