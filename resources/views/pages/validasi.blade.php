@extends('layout.validasi')
@section('content')
<div class="flex justify-center items-center min-h-screen w-full lg:w-1/2 px-6 py-6 mx-auto">

    <div class="w-full max-w-lg px-3 mb-6 lg:mb-0 lg:flex-none">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
          <div class="flex-auto p-4">
              <div class="flex flex-col items-center mb-7 mt-6">
                <div class="bg-white-500 w-27 h-27 rounded-full p-6 mb-3">
                    <i class="fa-sharp fa-solid fa-badge-check fa-7x text-lime-500"></i>
                </div>
              </div>
              <div class="flex flex-col mx-4">
                <h5 class="font-bold">Informasi Dokumen</h5>
            </div>
            
            <div class="bg-gray-200 rounded-xl shadow-soft-xl mx-4 mb-4">
                <div class="p-3 mx-3">
                    <table class="table-auto w-full">
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Status Dokumen</td>
                            <td class="text-sm text-gray-700 py-1 text-left">
                                <span class="{{ $status_dokumen === 'Aktif' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $status_dokumen }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Nomor Surat</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $nomor_surat ?? 'Tidak tersedia'}}</td>
                        </tr>
                    <!-- Info Pengajuan -->
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium"><b>Info Pengajuan</b></td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Nama Kegiatan</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $pengajuan->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Tempat</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $pengajuan->tempat->nama_ruangan }} {{ $pengajuan->tempat->nama_gedung }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Tanggal Mulai</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $pengajuan->tanggal_pinjam }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Tanggal Akhir</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $pengajuan->tanggal_akhir }}</td>
                        </tr>
            
                        <hr class="border-t-2 border-gray-700 my-2">
            
                    <!-- Info Penandatanganan -->
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium"><b>Info Penandatanganan</b></td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">Sekretaris BEM</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $sekum->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">KLI</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $kli->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm text-gray-700 py-1 font-medium">WD-3</td>
                            <td class="text-sm text-gray-700 py-1 text-left">{{ $wd3->user->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
              
              
              <a class="mt-auto text-sm font-semibold leading-normal group text-slate-500" href="javascript:;">
              </a>
          </div>
      </div>
  </div>
</div>
@endsection
