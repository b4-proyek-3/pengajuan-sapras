@extends('layout.main')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-5">Status Pengajuan</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200 text-gray-600">
                    <tr>
                        <th class="py-3 px-4 border">No</th>
                        <th class="py-3 px-4 border">Tanggal Pengajuan</th>
                        <th class="py-3 px-4 border">Nama Kegiatan</th>
                        <th class="py-3 px-4 border">Ormawa</th>
                        <th class="py-3 px-4 border">Status</th>
                        <th class="py-3 px-4 border">Keterangan</th>
                        <th class="py-3 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuanRiwayat as $pengajuan)
                        <tr>
                            <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? '-' }}</td>
                            <td class="py-3 px-4 border">{{ ucfirst($pengajuan->status) }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                            <td class="py-3 px-4 border">
                                <button
                                    onclick="window.location='{{ route('tracking.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg">Lihat</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
