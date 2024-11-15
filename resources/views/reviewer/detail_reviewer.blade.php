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
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">{{ $review->reviewer->role ?? 'N/A' }}</h6>
                            <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ $pengajuan->status ?? 'N/A' }}</p>
                            <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ $review->tanggal_review ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                  @endif
                  </div>
                  <div class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                      <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                          <i class="relative z-10 leading-none text-transparent ni ni-time-alarm bg-gradient-to-tl from-blue-600 to-indigo-400 
                            leading-pro bg-clip-text fill-transparent"></i>
                      </span>
                      <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                          <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Pengajuan Dibuat</h6>
                          <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">{{ $pengajuan->tanggal_pengajuan ?? 'N/A' }}</p>
                      </div>
                  </div>
              </div>
              <div class="flex-none w-1/2 max-w-full px-3 text-right">
                    <button class="inline-block w-full px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-fuchsia-500 text-fuchsia-500 hover:opacity-75">View All</button>
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
                                <a href="javascript:void(0);" class="dokumen-link" data-file="{{ asset(str_replace('public/', '', $dokumen->path ?? 'N/A')) }}">
                                  {{ $dokumen->nama_dokumen }}
                                </a>
                              </h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- card 2 -->

          <div class="w-full max-w-full pr-6 md:w-1/2 md:flex-none lg:w-2/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="flex-auto p-2">
                <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
                  <iframe id="dokumen-frame" src="{{ asset(str_replace('public/', '', $pengajuan->dokumen->first()->path  ?? 'N/A' )) }}" style="width:100%; height:500px;" frameborder="0"></iframe>
                </div>
              </div>
            </div>
          </div>

        <!-- cards row 3 -->
        <h5 class="font-bold px-6 mt-6 mb-0">Catatan</h5>
        <div class="w-full max-w-full px-6 mb-6 mt-6">           
          <form action="{{ route('store_review', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => $id_reviewer]) }}" method="POST">
            @csrf
            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
                    <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                        <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                      <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6"/>
                                  </svg>
                                <span class="sr-only">Attach file</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                      <path d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                                  </svg>
                                <span class="sr-only">Embed map</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                      <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z"/>
                                      <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                                  </svg>
                                <span class="sr-only">Upload image</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                      <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                                      <path d="M14.067 0H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.933-2ZM6.709 13.809a1 1 0 1 1-1.418 1.409l-2-2.013a1 1 0 0 1 0-1.412l2-2a1 1 0 0 1 1.414 1.414L5.412 12.5l1.297 1.309Zm6-.6-2 2.013a1 1 0 1 1-1.418-1.409l1.3-1.307-1.295-1.295a1 1 0 0 1 1.414-1.414l2 2a1 1 0 0 1-.001 1.408v.004Z"/>
                                  </svg>
                                  <span class="sr-only">Format code</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm-7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm3.5 9.5A5.5 5.5 0 0 1 4.6 11h10.81A5.5 5.5 0 0 1 10 15.5Z"/>
                                  </svg>
                                <span class="sr-only">Add emoji</span>
                            </button>
                        </div>
                        <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 18">
                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 3h9.563M9.5 9h9.563M9.5 15h9.563M1.5 13a2 2 0 1 1 3.321 1.5L1.5 17h5m-5-15 2-1v6m-2 0h4"/>
                                  </svg>
                                <span class="sr-only">Add list</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                                  </svg>
                                <span class="sr-only">Settings</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z"/>
                                      <path d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z"/>
                                  </svg>
                                <span class="sr-only">Timeline</span>
                            </button>
                            <button type="button" class="p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                      <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                  </svg>
                                <span class="sr-only">Download</span>
                            </button>
                        </div>
                    </div>
                    <button type="button" data-tooltip-target="tooltip-fullscreen" class="p-2 text-gray-500 rounded cursor-pointer sm:ms-auto hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 19">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 1h5m0 0v5m0-5-5 5M1.979 6V1H7m0 16.042H1.979V12M18 12v5.042h-5M13 12l5 5M2 1l5 5m0 6-5 5"/>
                          </svg>
                        <span class="sr-only">Full screen</span>
                    </button>
                    <div id="tooltip-fullscreen" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Show full screen
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                    <label for="editor" class="sr-only">Publish post</label>
                    <textarea 
                      name="catatan" 
                      id="editor" 
                      rows="8" 
                      class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" 
                      placeholder="Write an article..."
                      @if ($hasReviewed && $pengajuan->edited != 'true') readonly @endif ></textarea>
                </div>
            </div>
            @if (!$hasReviewed || $pengajuan->edited == 'true')
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

        <footer class="pt-4">
          <div class="w-full px-6 mx-auto">
            <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
              <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
              </div>
              <div class="w-full max-w-full px-3 mt-0 shrink-0 lg:w-1/2 lg:flex-none">
                <ul class="flex flex-wrap justify-center pl-0 mb-0 list-none lg:justify-end">
                  <li class="nav-item">
                    <a href="https://www.creative-tim.com" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">Creative Tim</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://www.creative-tim.com/presentation" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">About Us</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://creative-tim.com/blog" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">Blog</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://www.creative-tim.com/license" class="block px-4 pt-0 pb-1 pr-0 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">License</a>
                  </li>
                </ul>
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