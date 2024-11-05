@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pengajuan</h2>

    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Kegiatan -->
        <div class="form-group">
            <label for="nama_kegiatan">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $pengajuan->nama_kegiatan) }}" class="form-control" required>
        </div>

        <!-- Tanggal Pengajuan -->
        <div class="form-group">
            <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
            <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan) }}" class="form-control" required>
        </div>

        <!-- Tempat Kegiatan -->
        <div class="form-group">
            <label for="id_tempat">Tempat Kegiatan</label>
            <input type="text" name="id_tempat" value="{{ old('id_tempat', $pengajuan->id_tempat) }}" class="form-control" required>
        </div>

        <!-- Tanggal Pinjam -->
        <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $pengajuan->tanggal_pinjam) }}" class="form-control" required>
        </div>

        <!-- Tanggal Akhir -->
        <div class="form-group">
            <label for="tanggal_akhir">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir', $pengajuan->tanggal_akhir) }}" class="form-control" required>
        </div>

        <!-- Waktu Pengajuan -->
        <div class="form-group">
            <label for="waktu_pengajuan">Waktu Pengajuan</label>
            <input type="time" name="waktu_pengajuan" value="{{ old('waktu_pengajuan', $pengajuan->waktu_pengajuan) }}" class="form-control" required>
        </div>

        <!-- Dokumen -->
        <div class="form-group">
            <label for="dokumen">Dokumen</label>
            <input type="file" name="dokumen" class="form-control">
            <!-- Jika sudah ada dokumen yang diupload sebelumnya -->
            @if($pengajuan->dokumen)
                <p>Dokumen saat ini: <a href="{{ asset('storage/'.$pengajuan->dokumen) }}" target="_blank">{{ $pengajuan->dokumen }}</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
