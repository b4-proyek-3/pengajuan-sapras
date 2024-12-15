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
                            <td class="py-3 px-4 border">
                            <span class="inline-block py-1 px-3 rounded-lg 
                                @if($pengajuan->status == 'diajukan' || $pengajuan->status == 'diedit')
                                    bg-blue-200 text-blue-800
                                @elseif($pengajuan->status == 'direview')
                                    bg-yellow-200 text-yellow-800
                                @elseif($pengajuan->status == 'direvisi')
                                    bg-orange-200 text-orange-800
                                @elseif($pengajuan->status == 'selesai')
                                            bg-green-200 text-blue-800
                                @elseif($pengajuan->status == 'ditolak')
                                    bg-red-200 text-red-800
                                @else
                                    bg-gray-200 text-gray-800
                                @endif">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                            </td>
                            <td class="py-3 px-4 border">{{ $pengajuan->latestReview->first()->catatan ?? '-' }}</td>
                            <td class="py-3 px-4 border">
                                <button
                                    onclick="window.location='{{ route('tracking.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg">Lihat</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-center items-center">
                @if ($pengajuanRiwayat->currentPage() > 1)
                    <a href="{{ $pengajuanRiwayat->appends(request()->except('riwayat_page'))->previousPageUrl() }}" 
                    class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                        <span class="mr-2">&larr; Prev</span>
                    </a>
                @endif

                <div class="flex items-center space-x-2">
                    @if ($pengajuanRiwayat->lastPage() > 10)
                        <a href="{{ $pengajuanRiwayat->appends(request()->except('riwayat_page'))->url(1) }}" 
                        class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                        <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                        <a href="{{ $pengajuanRiwayat->appends(request()->except('riwayat_page'))->url($pengajuanRiwayat->lastPage()) }}" 
                        class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $pengajuanRiwayat->lastPage() }}</a>
                    @else
                        @foreach ($pengajuanRiwayat->getUrlRange(1, $pengajuanRiwayat->lastPage()) as $page => $url)
                            @if ($page == $pengajuanRiwayat->currentPage())
                                <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                            @else
                                <a href="{{ $pengajuanRiwayat->appends(request()->except('riwayat_page'))->url($page) }}" 
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                </div>

                @if ($pengajuanRiwayat->hasMorePages())
                    <a href="{{ $pengajuanRiwayat->appends(request()->except('riwayat_page'))->nextPageUrl() }}" 
                    class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                        <span class="mr-2">Next &rarr;</span>
                    </a>
                @endif
            </div>

            <footer class="pt-4 w-full bg-transparent">
                <div class="container mx-auto px-6">
                    <div class="flex flex-wrap items-center justify-center">
                        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-1/2 text-center">
                            <p class="text-center text-sm font-normal text-slate-500">
                                Pengajuan Sarana dan Prasarana<br>
                                Politeknik Negeri Bandung
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
