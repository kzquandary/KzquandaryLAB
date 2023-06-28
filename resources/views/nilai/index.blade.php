@foreach ($nilais as $item)
{{ $item->mahasiswa->nama }}

{{ $item->kode_nilai }}

{{ $item->kode_laporan }}
<br>
@endforeach