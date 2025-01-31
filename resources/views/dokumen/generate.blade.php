<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Peminjaman Sarana dan Prasarana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
        }

        .header-table td {
            padding: 0;
            text-align: left;
            vertical-align: top;
        }

        .header-table .logo {
            width: 5%;
            padding: 10px;
        }

        .header-table .kop {
            width: 90%;
            text-align: center;
            padding: 10px 0;
        }

        .kop h3.kemendikbud {
            margin: 2px 0;
            /* Kurangi dari 5px */
            font-size: 14pt;
            line-height: 1.2;
            /* Tambahkan line-height */
        }

        .kop h3.polban {
            margin: 2px 0;
            /* Kurangi dari 5px */
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .kop p.address {
            margin: 1px 0;
            /* Kurangi dari 2px */
            font-size: 12pt;
            line-height: 1.2;
            /* Kurangi dari 1.3 */
        }

        .content {
            margin-bottom: 20px;
        }

        .berita-acara-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .table th,
        .table td {
            border: 1px solid white;
            padding: 4px 8px;
            text-align: left;
        }

        .table th {
            background-color: transparent;
            font-weight: normal;
        }

        .table td {
            background-color: transparent;
        }

        .table td:last-child {
            width: 30%;
        }

        .signature-section {
            display: flex;
            justify-content: center;
            /* Ubah dari 'right' */
            margin-top: 10px;
        }

        .signature-block {
            text-align: center;
            width: 200px;
        }

        .signature-block p {
            margin: 5px 0;
            /* Reduced margin between paragraphs */
        }

        .tembusan {
            margin-top: 30px;
            font-size: 0.9em;
        }

        .usage-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12pt;
            text-align: left;
        }

        .usage-table th,
        .usage-table td {
            border: 1px solid black; /* Menambahkan border */
            padding: 8px; /* Memberikan padding */
        }

        .usage-table th {
            background-color: #f2f2f2; /* Warna latar untuk header tabel */
            font-weight: bold; /* Menonjolkan teks header */
        }

        .usage-table td {
            background-color: #ffffff; /* Warna latar untuk data */
        }

    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ public_path('assets/img/logo-polban.png') }}" alt="Polban Logo"
                    style="width: 100px; height: auto;">
            </td>
            <td class="kop">
                <h3 class="kemendikbud">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
                <h3 class="kemendikbud">DAN TEKNOLOGI</h3>
                <h3 class="polban">POLITEKNIK NEGERI BANDUNG</h3>
                <p class="address">Jalan Gegerkalong Hilir, Desa Ciwaruga, Kecamatan Parongpong,</p>
                <p class="address">Kabupaten Bandung Barat 40559, Kotak Pos 1234 Telepon: (022) 2013789,</p>
                <p class="address">Faksimile: (022) 2013889, Laman: www.polban.ac.id, Pos elektronik: polban@polban.ac.id</p>
            </td>
        </tr>
    </table>

    <div class="content">
        <p class="berita-acara-title">BERITA ACARA PEMINJAMAN SARANA DAN PRASARANA</p>
        <p>Pada tanggal {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}, pukul
            {{ \Carbon\Carbon::now()->format('H:i') }} WIB, yang bertanda tangan dibawah ini. Saya selaku
            ketua pelaksana kegiatan {{ $nama_kegiatan }}, meminjam sarana dengan detail sebagai berikut:</p>

        <table class="table">
            <tr>
                <th>Nama Kegiatan</th>
                <td>: {{ $nama_kegiatan }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Nama Ketua Pelaksana</th>
                <td>: {{ $nama_ketua_pelaksana }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Nama Ormawa</th>
                <td>: {{ $nama_ormawa }}</td>
                <td></td>
            </tr>
        </table>
        <table class="usage-table">
            <thead>
                <tr>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usage_details as $index => $usage)
                    <tr>
                        <td>{{ $usage['ruangan'] }}, {{ $usage['gedung'] }}</td>
                        <td>{{ $usage['tanggal_mulai'] }} - {{ $usage['tanggal_akhir'] }}</td>
                        <td>{{ $usage['waktu_mulai'] }} - {{ $usage['waktu_akhir'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Adapun berita acara ini sudah divalidasi dan disetujui oleh beberapa pihak, yaitu :</p>
        <table class="table">
            <tr>
                <th>BEM</th>
                <td>: {{ $sekum_bem }}</td>
                <td></td>
            </tr>
            <tr>
                <th>KLI</th>
                <td>: {{ $kli }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Wakil Direktur 3</th>
                <td>: {{ $wd3 }}</td>
                <td></td>
            </tr>
        </table>

        <p>Demikian Berita Acara ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="signature-section">
            <div class="signature-block">
                <p>Bandung, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                <p>Bukti Validasi</p>
                <p style="margin-top: 10px;">
                <img src="{{ $qr_code_path }}" alt="QR Code" width="100" height="100" />
                </p>
                <br>
            </div>
        </div>
    </div>
</body>

</html>
