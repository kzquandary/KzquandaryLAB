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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pertemuan</div>
                        <div class="card-body">
                         <table class="table table-bordered">
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td>{{ $mahasiswa->no_hp }}</td>
                                <td>
                                    <form id="delete-mahasiswa-{{ $mahasiswa->nim }}" action="{{ route('mahasiswa.destroy',$mahasiswa->nim) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('mahasiswa.show',$mahasiswa->nim) }}">Show</a>
                                        <a class="btn btn-primary" href="{{ route('mahasiswa.edit', $mahasiswa->nim) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="deleteMahasiswa('{{ $mahasiswa->nim }}')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {!! $mahasiswas->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="/api/databaseupload" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file">
        <button type="submit">Import</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

function deleteMahasiswa(nim) {
    Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus mahasiswa ini?',
        text: "Anda tidak akan dapat mengembalikan data yang dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Menggunakan AJAX untuk menghapus data mahasiswa
            $.ajax({
                type: "POST",
                url: "{{ route('mahasiswa.destroy', ':nim') }}".replace(':nim', nim),
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data mahasiswa berhasil dihapus.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Melakukan pembaruan data tanpa reload halaman
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghapus data mahasiswa.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>

@endsection
