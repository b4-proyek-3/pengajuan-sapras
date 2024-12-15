@extends('layout.main')
@section('content')
<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
        <h5 class="font-bold">Detail Pengajuan</h5>
        <!-- cards row 1 -->
        <div class="flex flex-wrap my-6 -mx-3">
          <!-- card 1 -->

          <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:w-2/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                <div class="flex flex-wrap mt-0 -mx-3">
                  <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                    <h6>Pengajuan</h6>
                    <p class="mb-0 text-sm leading-normal">
                    <i class="fa fa-calendar text-cyan-500"></i>
                      <span class="ml-1 font-semibold">No Pengajuan #</span>
                      {{ $pengajuan->id_pengajuan ?? 'N/A' }}
                    </p>
                  </div>
                  <div class="flex-none w-1/12 max-w-full px-3 my-auto text-right lg:w-1/2 lg:flex-none">
                    <div class="relative pr-6 lg:float-right">
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex-auto p-6 px-0 pb-2">
                <div class="overflow-x-auto">
                  <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <td class="p-0 align-middle bg-transparent border-b whitespace-nowrap">
                    <td class="p-0 align-middle bg-transparent border-b whitespace-nowrap">
                    <td class="p-0 align-middle bg-transparent border-b whitespace-nowrap">
                    <td class="p-0 align-middle bg-transparent border-b whitespace-nowrap">
                    <tbody>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Nama Pengaju</h6>
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->pengaju->user->name ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Ormawa</h6>
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Nama Kegiatan</h6>
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->nama_kegiatan ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Tanggal Kegiatan</h6>
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                  <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->tanggal_pinjam ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Tanggal Berakhir</h6>
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                  <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->tanggal_akhir ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Waktu Kegiatan</h6> <!-- Replace 'tempat' with the correct field -->
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                  <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->waktu_pinjam ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center" style="min-width: 150px;">
                                    <h6 class="mb-0 text-sm leading-normal">Tempat</h6> <!-- Replace 'tempat' with the correct field -->
                                </div>
                                <div class="flex flex-col justify-center" style="min-width: 10px; text-align: right;">
                                  <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $pengajuan->tempat->nama_ruangan ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        
          <!-- card 2 -->

          <div class="w-full max-w-full pr-4 md:w-1/2 md:flex-none lg:w-1/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                <h6>Status Pengajuan</h6>
                <p class="text-sm leading-normal">
                </p>
              </div>
              <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <td class="p-0 align-middle bg-transparent border-b whitespace-nowrap">                
              </table>
              <div class="flex-auto p-4">
                <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
                  <div class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                  @if($pengajuan->latestReview->isNotEmpty())
                    @foreach ($pengajuan->latestReview as $index => $review)
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="relative z-10 leading-none text-transparent 
                              {{ $index === 0 ? 'ni ni-bell-55 bg-gradient-to-tl from-green-600 to-lime-400' : 'ni ni-time-alarm bg-gradient-to-tl from-blue-600 to-indigo-400' }} 
                              leading-pro bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">{{ $review->reviewer->role_name ?? 'N/A' }}</h6>
                            <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ ucfirst($review->status ?? 'N/A') }}</p>
                            <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ $review->tanggal_review ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                  @endif
                  </div>
                  <div class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                      <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                          <i class="relative z-10 leading-none text-transparent ni ni-bell-55 bg-gradient-to-tl from-green-600 to-lime-400
                            leading-pro bg-clip-text fill-transparent"></i>
                      </span>
                      <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                          <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Pengajuan Dibuat</h6>
                          <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ $pengajuan->tanggal_pengajuan ?? 'N/A' }}</p>
                      </div>
                  </div>
              </div>
              <div class="flex-none w-1/2 max-w-full px-3 text-right">
                    <button onclick="window.location='{{ route('tracking.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="inline-block w-full px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-fuchsia-500 text-fuchsia-500 hover:opacity-75">View All</button>
              </div>
            </div>
          </div>
        </div>


        <!-- cards row 2 -->
        <h5 class="font-bold px-3 mt-6 mb-0">Detail Dokumen</h5>
        <div class="flex flex-wrap my-6 -mx-3">
          <!-- card 1 -->

          <div class="w-full max-w-full pl-6 pr-3 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:w-1/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                <div class="flex flex-wrap mt-0 -mx-3">
                  <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                    <h6>Dokumen</h6>
                  </div>
                </div>
              </div>
              <table class="items-center w-full mb-2 mt-2 align-top border-gray-200 text-slate-500">
                <td class="p-0 mb-4 mt-4 align-middle bg-transparent border-b whitespace-nowrap">
                <tbody>
                    @foreach ($pengajuan->dokumen as $dokumen)
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <!-- Link dokumen untuk Card 1 -->
                              <h6 class="mb-0 text-sm leading-normal">
                                <a href="javascript:void(0);" class="dokumen-link" data-file="{{ asset('storage/' . $dokumen->path ?? 'N/A') }}">
                                  {{ $dokumen->nama_dokumen }}
                                </a>
                              </h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <!-- Link dokumen untuk Card 1 -->
                              <h6 class="mb-0 text-sm leading-normal">
                              <a href="{{ $pengajuan->link_drive }}" target="_blank" rel="noopener noreferrer">
                                  Surat Izin Orang Tua
                              </a>
                              </h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- card 2 -->

          <div class="w-full max-w-full pr-6 md:w-1/2 md:flex-none lg:w-2/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="flex-auto p-2">
                <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
                  <iframe id="dokumen-frame" src="{{ asset('storage/' . $pengajuan->dokumen->first()->path  ?? 'N/A' ) }}" style="width:100%; height:500px;" frameborder="0"></iframe>
                </div>
              </div>
            </div>
          </div>

        <!-- cards row 3 -->
        <h5 class="font-bold px-6 mt-6 mb-0">Catatan</h5>
        <div class="w-full max-w-full px-6 mb-6 mt-6">           
          <form action="{{ route('update.review', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => $id_reviewer]) }}" method="POST">
            @csrf
            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                    <label for="catatan" class="sr-only">Publish post</label>
                    <textarea name="catatan" id="catatan" rows="8"
                      class="block w-full px-2 mt-2 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                      placeholder="Masukkan Catatan.."
                      @if ($hasReviewed && $pengajuan->edited != 'true')  @endif >{{ $pengajuan->latestReview->first()->catatan ?? '-' }}</textarea>
                </div>
            </div>
            @if (!$hasReviewed || $pengajuan->status == 'diedit')
              <div class="flex justify-end">
                  <button type="submit" name="status" value="diterima" class="mt-2 bg-gradient-to-tl from-blue-600 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                      terima
                  </button>
                  <button type="submit" name="status" value= "direvisi" class="mt-2 bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white ml-2">
                      revisi
                  </button>
                  <button type="submit" name="status" value= "ditolak" class="mt-2 bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white ml-2">
                      tolak
                  </button>
              </div>
            @endif
          </form>
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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dokumenLinks = document.querySelectorAll('.dokumen-link');

    // Loop melalui setiap link dokumen
    dokumenLinks.forEach(function (link) {
      // Tambahkan event listener 'click'
      link.addEventListener('click', function () {
        // Ambil URL file dari atribut data-file
        const fileUrl = link.getAttribute('data-file');
        
        // Ambil elemen iframe dan ubah src-nya
        const iframe = document.getElementById('dokumen-frame');
        iframe.src = fileUrl;
      });
    });
  });
</script>
@endsection