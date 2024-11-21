<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Peminjaman Sarana dan Prasarana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4; /* Mengurangi jarak antar baris */
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            padding: 0; /* Menghapus padding untuk mengurangi jarak */
            text-align: left;
            vertical-align: top;
        }
        .header-table .logo {
            width: 20%;
            padding: 10px; /* Tambahkan padding untuk mengatur jarak logo */
        }
        .header-table .kop {
            width: 80%;
            text-align: center;
            padding: 10px; /* Tambahkan padding untuk mengatur jarak teks */
        }
        .content {
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid white;
            padding: 8px;
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
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-block {
            text-align: center;
        }
        .tembusan {
            margin-top: 30px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ $logoPath }}" alt="Polban Logo" style="width: 100px; height: auto;">
            </td>
            <td class="kop" colspan="2">
                <h3 style="margin: 5px 0;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,</h3>
                <h3 style="margin: 5px 0;">RISET, DAN TEKNOLOGI</h3>
                <h3 style="margin: 5px 0;">POLITEKNIK NEGERI BANDUNG</h3>
                <p style="margin: 2px 0;">Jln. Gegerkalong Hilir, Desa Ciwaruga, Kecamatan Parongpong,</p>
                <p style="margin: 2px 0;">Kabupaten Bandung Barat 40559, Kotak Pos 1234 Telp. (022) 2013789,</p>
                <p style="margin: 2px 0;">Faksimile: (022) 2013889, Laman: www.polban.ac.id, Pos elektronik: polban@polban.ac.id</p>
            </td>
        </tr>
    </table>

    <div class="content">
        <p style="text-align: center;">BERITA ACARA PEMINJAMAN SARANA DAN PRASARANA</p>
        <p>Pada tanggal {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}, pukul {{ \Carbon\Carbon::now()->addHours(7)->format('H:i') }} WIB, yang bertanda tangan dibawah ini. Saya selaku ketua pelaksana kegiatan {{ $nama_kegiatan }}, meminjam sarana dengan detail sebagai berikut:</p>
        
        <table class="table">
            <tr>
                <th>ID Pengajuan:</th>
                <td>{{ $id_pengajuan }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Nama Kegiatan:</th>
                <td>{{ $nama_kegiatan }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Nama Ketua Pelaksana:</th>
                <td>{{ $nama_ketua_pelaksana }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Nama Ormawa:</th>
                <td>{{ $nama_ormawa }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Tempat:</th>
                <td>{{ $nama_gedung }} - {{ $nama_ruangan }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Tanggal Mulai:</th>
                <td>{{ $tanggal_mulai }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Tanggal Akhir:</th>
                <td>{{ $tanggal_akhir }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Waktu:</th>
                <td>{{ $waktu_kegiatan }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Sekretaris BEM:</th>
                <td>{{ $sekum_bem }}</td>
                <td></td>
            </tr>
            <tr>
                <th>KLI:</th>
                <td>{{ $kli }}</td>
                <td></td>
            </tr>
            <tr>
                <th>Wadir 3:</th>
                <td>{{ $wd3 }}</td>
                <td></td>
            </tr>
        </table>

        <p>Demikian Berita Acara ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="signature-section">
            <div class="signature-block">
                <p>Bandung, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                <p>Bukti Validasi</p><br><br>
            </div>
        </div>
    </div>
</body>
</html>
