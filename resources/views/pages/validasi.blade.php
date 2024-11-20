@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Status Dokumen: 
        <span class="{{ $status_dokumen === 'Aktif' ? 'text-green-500' : 'text-red-500' }}">
            {{ $status_dokumen }}
        </span>
    </h2>

    <div class="bg-gray-100 p-6 rounded-lg shadow-lg mb-6">
        <h3 class="text-xl font-semibold">Informasi Pengajuan</h3>
        <p><strong>Nama Kegiatan:</strong> {{ $pengajuan->nama_kegiatan }}</p>
        <p><strong>Tempat:</strong> {{ $pengajuan->tempat->nama_tempat }}</p>
        <p><strong>Tanggal Mulai:</strong> {{ $pengajuan->tanggal_pinjam }}</p>
        <p><strong>Tanggal Akhir:</strong> {{ $pengajuan->tanggal_akhir }}</p>
        <p><strong>Waktu:</strong> {{ $pengajuan->waktu_pengajuan }}</p>
    </div>

    <div class="bg-gray-100 p-6 rounded-lg shadow-lg mb-6">
        <h3 class="text-xl font-semibold">Info Penandatangan</h3>
        <p><strong>Sekretaris Umum:</strong> {{ $sekum->nama ?? 'Belum Ada' }}</p>
        <p><strong>KLI:</strong> {{ $kli->nama ?? 'Belum Ada' }}</p>
        <p><strong>WD-3:</strong> {{ $wd3->nama ?? 'Belum Ada' }}</p>
    </div>

    <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold">Review Dokumen</h3>
        @foreach($reviews as $review)
            <div class="border-b border-gray-300 py-2">
                <p><strong>Reviewer:</strong> {{ $review->reviewer->nama }}</p>
                <p><strong>Status:</strong> {{ ucfirst($review->status) }}</p>
                <p><strong>Review:</strong> {{ $review->review ?? 'Tidak ada review' }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
