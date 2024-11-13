@extends('layout.main')
@section('content')
<!-- cards -->
    <!-- cards row 2 -->
    <div class="flex justify-center items-center min-h-screen w-full lg:w-1/2 px-6 py-6 mx-auto">

    <div class="w-full max-w-lg px-3 mb-6 lg:mb-0 lg:flex-none">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
          <div class="flex-auto p-4">
              <div class="flex flex-col items-center mb-7 mt-6">
                <div class="bg-green-500 w-24 h-24 rounded-full p-6 mb-3">
                    <i class="fa-sharp fa-solid fa-badge-check fa-7x text-lime-500"></i>
                </div>
              </div>
              <div class="flex flex-col mx-4">
                  <h5 class="font-bold">Informasi Dokumen</h5>
              </div>
              
              <!-- Kotak Abu-abu -->
              <div class="bg-gray-200 rounded-xl p-5 shadow-soft-xl mx-4 mb-4">
                  <div class="p-4 mx-4 pt-6">
                      <p class="text-sm text-gray-700">Status Dokumen</p>
                      <p class="text-sm text-gray-700">Nomor Surat</p>
                      
                      <!-- Garis pembatas setelah Nomor Surat -->
                      <hr class="border-t-2 border-gray-700 my-2">
                      
                      <!-- Info Pengajuan dengan teks tebal -->
                      <p class="text-sm font-bold text-gray-700 mt-2">Info Pengajuan</p>
                      <p class="text-sm text-gray-700">Nama Kegiatan</p>
                      <p class="text-sm text-gray-700">Tempat</p>
                      <p class="text-sm text-gray-700">Tanggal Mulai</p>
                      <p class="text-sm text-gray-700">Tanggal Akhir</p>
                      
                      <!-- Garis pembatas antara Tanggal Akhir dan Info Penandatanganan -->
                      <hr class="border-t-2 border-gray-700 my-2">

                      <!-- Info Penandatanganan dengan teks tebal -->
                      <p class="text-sm font-bold text-gray-700 mt-2">Info Penandatanganan</p>
                      <p class="text-sm text-gray-700">Sekretaris BEM</p>
                      <p class="text-sm text-gray-700">KLI</p>
                      <p class="text-sm text-gray-700">WD-3</p>
                  </div>
              </div>
              
              <a class="mt-auto mb-0 text-sm font-semibold leading-normal group text-slate-500" href="javascript:;">
              </a>
          </div>
      </div>
  </div>
</div>
@endsection