@extends('layout.validasi')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-center items-center min-h-screen">
            <div class="w-full max-w-xl lg:max-w-2xl xl:max-w-3xl">
                <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
                    <div class="p-6 md:p-10 lg:p-12">
                        {{-- Verification Icon --}}
                        <div class="flex justify-center mb-6">
                            <div
                                class="bg-white-500 w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full flex items-center justify-center">
                                <img src="{{ asset('assets/img/logo_kemahasiswaan.png') }}" style="width: 400px; height: 150px;">
                            </div>
                        </div>

                        {{-- Section Title --}}
                        <h5 class="text-xl md:text-2xl lg:text-3xl font-bold text-center mb-6">Informasi Dokumen</h5>

                        {{-- Document Information Card --}}
                        <div class="bg-gray-100 rounded-xl p-4 md:p-6 lg:p-8">
                            <table class="w-full text-sm md:text-base lg:text-lg">
                                <tbody>
                                    {{-- Document Status --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">Status Dokumen</td>
                                        <td class="py-2 text-right">
                                            <span
                                                class="{{ $status_dokumen === 'Aktif' ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $status_dokumen }}
                                            </span>
                                        </td>
                                    </tr>

                                    {{-- Submission Information Section --}}
                                    <tr>
                                        <td colspan="2" class="py-3 text-base font-bold text-gray-800">Info Pengajuan
                                        </td>
                                    </tr>

                                    {{-- Activity Name --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">Nama Kegiatan</td>
                                        <td class="py-2 text-right">
                                            {{ $pengajuan->nama_kegiatan }}
                                        </td>
                                    </tr>

                                    {{-- Location --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">Tempat</td>
                                        <td class="py-2 text-right">
                                            @foreach ($pengajuan->ruangan as $ruangan)
                                                {{ $ruangan->nama_ruangan }}, {{ $ruangan->gedung->nama_gedung }}
                                                @unless ($loop->last)<br>@endunless
                                            @endforeach
                                        </td>
                                    </tr>

                                    {{-- Date --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">Tanggal</td>
                                        <td class="py-2 text-right">
                                            @foreach ($pengajuan->menggunakanRuangan as $menggunakan)
                                                @php
                                                    $tanggalMulai = \Carbon\Carbon::parse($menggunakan->tanggal_mulai);
                                                    $tanggalAkhir = \Carbon\Carbon::parse($menggunakan->tanggal_akhir);

                                                    // Logika Format Tanggal
                                                    if ($tanggalMulai->format('F Y') === $tanggalAkhir->format('F Y')) {
                                                        // Bulan dan tahun sama
                                                        echo $tanggalMulai->format('d') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    } elseif ($tanggalMulai->year === $tanggalAkhir->year) {
                                                        // Tahun sama, tapi bulan berbeda
                                                        echo $tanggalMulai->format('d F') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    } else {
                                                        // Tahun berbeda
                                                        echo $tanggalMulai->format('d F Y') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    }
                                                @endphp
                                                @unless ($loop->last)<br>@endunless
                                            @endforeach
                                        </td>
                                    </tr>

                                    {{-- Time --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">Waktu</td>
                                        <td class="py-2 text-right">
                                            @foreach ($pengajuan->menggunakanRuangan as $menggunakan)
                                                {{ $menggunakan->waktu_mulai ?? 'N/A' }} - {{ $menggunakan->waktu_akhir ?? 'N/A' }}
                                                @unless ($loop->last)<br>@endunless
                                            @endforeach
                                        </td>
                                    </tr>

                                    {{-- Signature Information Section --}}
                                    <tr>
                                        <td colspan="2" class="py-3 text-base font-bold text-gray-800">Info
                                            Penandatanganan</td>
                                    </tr>

                                    {{-- BEM Secretary --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">BEM</td>
                                        <td class="py-2 text-right">
                                            {{ $sekum->user->name }}
                                        </td>
                                    </tr>

                                    {{-- KLI --}}
                                    <tr class="border-b border-gray-200">
                                        <td class="py-2 font-medium text-gray-700">KLI</td>
                                        <td class="py-2 text-right">
                                            {{ $kli->user->name }}
                                        </td>
                                    </tr>

                                    {{-- WD-3 --}}
                                    <tr>
                                        <td class="py-2 font-medium text-gray-700">WD-3</td>
                                        <td class="py-2 text-right">
                                            {{ $wd3->user->name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
