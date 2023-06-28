<!-- resources/views/absensi/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Absensi Pertemuan {{$pertemuan->nama}}</h1>
    <form>
        <div class="form-group">
            <label>Pilih Mahasiswa:</label>
            <select class="form-control" id="mahasiswa">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswa as $mhs)
                <option value="{{ $mhs->id }}">{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" class="btn btn-primary" id="submitBtn">Simpan</button>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Status Kehadiran</th>
            </tr>
        </thead>
        <tbody id="absensiList">
            <!-- Data Absensi akan ditampilkan oleh AJAX -->
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk mengambil data absensi melalui AJAX
        function loadData(mahasiswa_id) {
            $.ajax({
                type: 'GET',
                url: '{{ route("absensi.show", $pertemuan->id) }}',
                data: {
                    mahasiswa_id: mahasiswa_id
                },
                success: function(data) {
                    $('#absensiList').html(data);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Ketika tombol Simpan diklik, maka kirim data melalui AJAX
        $('#submitBtn').click(function() {
            var mahasiswa_id = $('#mahasiswa').val();
            if (mahasiswa_id == '') {
                alert('Mohon pilih mahasiswa terlebih dahulu.');
                return;
            }
            loadData(mahasiswa_id);
        });
    });
</script>
@endsection
