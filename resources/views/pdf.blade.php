<html>

<head>
    <style type="text/css">
        body {
            font-family: arial;
            background-color: #ccc;
        }

        .rangkasurat {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            position: relative;
        }

        .tanda-tangan {
            position: absolute;
            bottom: 25px;
            right: 40px;
            text-align: right;
            font-weight: bold;
        }

        .tanda-tangan p {
            margin-bottom: 10px;
            font-size: 12;
            font-weight: bold;
        }

        .kop-table {
            border-width: 0;
            border-bottom: 5px solid #000;
            border-style: double;
            padding: 2px;
        }

        .report-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .report-table th {
            border: 1px solid #000;
            padding: 2px;
            background-color: rgb(25, 171, 33);
            border-color: rgb(0, 0, 0);
            font-size: 10;
            font-weight: bold;
        }

        .report-table td {
            border: 1px solid #000;
            padding: 2px;
            font-size: 10;
            font-family: sans-serif;
        }

        .tengah {
            text-align: center;
            line-height: 5px;
        }

        #tabeldata {
            background-color: #000;
            border: 20px solid #000;
            border-color: aqua;
        }
    </style>
</head>

<body>
    @foreach ($pertemuan as $pertemuans)
        <div class="rangkasurat">
            <div class="kop-table">
                <table width="100%">
                    <tr>
                        <td><img src="http://127.0.0.1:8000/logo.png" width="100px" /></td>
                        <td class="tengah">
                            <h4>UNIVERSITAS JENDERAL ACHMAD YANI</h4>
                            <h4>FAKULTAS SAINS DAN INFORMATIKA</h4>
                            <h4>PRODI TEKNIK INFORMATIKA</h4>
                            <p>
                                TERAKREDITASI "B" SKEP BAN-PT Nomor :
                                8040/SK/BAN-PT/Ak-PPJS/XII/2022
                            </p>
                            <p>
                                Jln. Ters. Jend. Sudirman Cimahi 40513/Gd. Lab. II F-MIPA
                                Lt.3/Tlp./Fax. (022)6631302
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <h5 class="tengah">LAPORAN PERTEMUAN PRAKTIKUM PEMROGRAMAN OBJEK 2</h5>
            <h5 class="tengah">{{ strtoupper($pertemuans->judul_pertemuan) }}</h5>
            <div class="report-table">
                <table width="100%">
                    <tr>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>ABSEN</th>
                        <th>LAPORAN</th>
                        <th>NILAI</th>
                        <th>KEAKTIFAN</th>
                    </tr>
                    @foreach ($mahasiswa as $mahasiswas)
                        <tr>
                            <td>{{ $mahasiswas->nim }}</td>
                            <td>{{ $mahasiswas->nama }}</td>
                            <td>
                                @php
                                    $absensis = $pertemuans->absensi
                                        ->where('nim', $mahasiswas->nim)
                                        ->where('kode_pertemuan', $pertemuans->kode_pertemuan)
                                        ->first();
                                    echo $absensis ? $absensis->status : '-';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $laporans = $pertemuans->laporan
                                        ->where('nim', $mahasiswas->nim)
                                        ->where('kode_pertemuan', $pertemuans->kode_pertemuan)
                                        ->first();
                                    echo $laporans ? $laporans->status : '-';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $nilais = $pertemuans->nilai
                                        ->where('nim', $mahasiswas->nim)
                                        ->where('kode_pertemuan', $pertemuans->kode_pertemuan)
                                        ->first();
                                    echo $nilais ? $nilais->nilai : '-';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $keaktifans = $pertemuans->keaktifan->where('nim', $mahasiswas->nim)->where('kode_pertemuan', $pertemuans->kode_pertemuan);
                                    echo $keaktifans->count();
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="tanda-tangan">
                <p style="text-align: center">Cimahi, {{ \Carbon\Carbon::parse($pertemuans->tanggal_pertemuan)->formatLocalized('%d %B %Y') }}</p>
                <p style="text-align: center">DOSEN / INSTRUKTUR:</p>
                <br />
                <br />
                <br />
                <p style="text-align: center">Rezki Yuniarti, S.Si., M.T.</p>
                <p style="text-align: center">NID. 412174182</p>
            </div>
        </div>
        <br>
    @endforeach
</body>

</html>
