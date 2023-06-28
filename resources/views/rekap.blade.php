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
    <style type="text/css">
        .keterangan-table {
            width: 40%;
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .keterangan-table th {
            border: 1px solid #000;
            padding: 2px;
            background-color: rgb(25, 171, 33);
            border-color: rgb(0, 0, 0);
            font-size: 10;
            font-weight: bold;
        }

        .keterangan-table td {
            border: 1px solid #000;
            padding: 2px;
            font-size: 10;
            font-family: sans-serif;
        }
    </style>


</head>

<body>
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
        <h5 class="tengah">REKAP NILAI LAPORAN PRAKTIKUM PEMROGRAMAN OBJEK 2</h5>
        {{-- <h5 class="tengah">{{ strtoupper($pertemuans->judul_pertemuan) }}</h5> --}}
        <div class="report-table">
            <table width="100%">
                <tr>
                    <th>NIM</th>
                    <th>NAMA</th>
                    <th>KEHADIRAN</th>
                    @for ($i = 1; $i <= 10; $i++)
                        <th>P{{ $i }}</th>
                    @endfor
                    <th>Rata-rata</th>
                    <th>Mutu</th>
                </tr>
                @php
                    $jumlah_pertemuan = $pertemuan->count();
                @endphp
                @foreach ($mahasiswa as $mahasiswas)
                    <tr>
                        <td>{{ $mahasiswas->nim }}</td>
                        <td>{{ $mahasiswas->nama }}</td>
                        <td>
                            @php
                                $absen = $absensi->where('nim', $mahasiswas->nim)->where('status', 'Hadir');
                                $kehadiran = $absen->count();
                                echo $kehadiran . '/' . $jumlah_pertemuan;
                            @endphp
                        </td>

                        @php
                            $totalNilai = 0;
                        @endphp
                        @for ($i = 1; $i <= 10; $i++)
                            <td>
                                @php
                                    $kodePertemuan = 'P' . str_pad($i, 3, '0', STR_PAD_LEFT);
                                    if ($i <= $jumlah_pertemuan) {
                                        $nilai = $nilai
                                            ->where('nim', $mahasiswas->nim)
                                            ->where('kode_pertemuan', $kodePertemuan)
                                            ->first();
                                        if ($nilai) {
                                            echo $nilai->nilai;
                                            $totalNilai += $nilai->nilai;
                                        } else {
                                            echo '0';
                                        }
                                    } else {
                                        echo '0';
                                    }
                                @endphp
                            </td>
                        @endfor
                        <td>
                            @php
                                if ($jumlah_pertemuan != 0) {
                                    $rataRata = $totalNilai / $jumlah_pertemuan;
                                    $rataRataFormatted = number_format($rataRata, 2);
                                    echo $rataRataFormatted;
                                } else {
                                    echo '0';
                                }
                            @endphp
                        </td>
                        <td>
                            @php
                                if ($jumlah_pertemuan != 0) {
                                    if ($rataRata >= 80) {
                                        echo 'A';
                                    } elseif ($rataRata >= 75) {
                                        echo 'AB';
                                    } elseif ($rataRata >= 65) {
                                        echo 'B';
                                    } elseif ($rataRata >= 60) {
                                        echo 'BC';
                                    } elseif ($rataRata >= 55) {
                                        echo 'C';
                                    } elseif ($rataRata >= 40) {
                                        echo 'D';
                                    } else {
                                        echo 'E';
                                    }
                                } else {
                                    echo '0';
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <div class="keterangan-table">
            <table width="100%">
                <tr>
                    <th colspan="3">Keterangan Nilai:</th>
                </tr>
                <tr>
                    <td>A</td>
                    <td>>= 80</td>
                    <td>Sangat Baik</td>
                </tr>
                <tr>
                    <td>AB</td>
                    <td>75-80</td>
                    <td>Baik</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>65-75</td>
                    <td>Cukup Baik</td>
                </tr>
                <tr>
                    <td>BC</td>
                    <td>60-65</td>
                    <td>Cukup</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>55-60</td>
                    <td>Kurang</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>40-55</td>
                    <td>Sangat Kurang</td>
                </tr>
                <tr>
                    <td>E</td>
                    <td>0</td>
                    <td>Tidak Lulus</td>
                </tr>
            </table>
        </div>

        <div class="tanda-tangan">
            <p style="text-align: center">Cimahi, 22 Desember 2002</p>
            <p style="text-align: center">DOSEN / INSTRUKTUR:</p>
            <br />
            <br />
            <br />
            <p style="text-align: center">Rezki Yuniarti, S.Si., M.T.</p>
            <p style="text-align: center">NID. 412174182</p>
        </div>
    </div>
    <br>
</body>

</html>
