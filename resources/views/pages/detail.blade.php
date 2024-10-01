@extends('layout.main')
@section('content')
<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
    <h5 class="font-bold px-1">Detail Pengajuan</h5>
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
                      0001
                    </p>
                  </div>
                  <div class="flex-none w-5/12 max-w-full px-3 my-auto text-right lg:w-1/2 lg:flex-none">
                    <div class="relative pr-6 lg:float-right">
                      <a dropdown-trigger class="cursor-pointer" aria-expanded="false">
                        <i class="fa fa-ellipsis-v text-slate-400"></i>
                      </a>
                      <p class="hidden transform-dropdown-show"></p>

                      <ul dropdown-menu class="z-100 text-sm transform-dropdown shadow-soft-3xl duration-250 before:duration-350 before:font-awesome before:ease-soft min-w-44 -ml-34 before:text-5.5 pointer-events-none absolute top-0 m-0 mt-2 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:top-0 before:right-7 before:left-auto before:z-40 before:text-white before:transition-all before:content-['\f0d8']">
                        <li class="relative">
                          <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 lg:transition-colors lg:duration-300" href="javascript:;">Action</a>
                        </li>
                        <li class="relative">
                          <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 lg:transition-colors lg:duration-300" href="javascript:;">Another action</a>
                        </li>
                        <li class="relative">
                          <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap rounded-lg border-0 bg-transparent px-4 text-left font-normal text-slate-500 lg:transition-colors lg:duration-300" href="javascript:;">Something else here</a>
                        </li>
                      </ul>
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
                    @foreach($pengajuans as $item)
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 text-sm leading-normal pr-1">Nama Pengaju</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-6" style="min-width: 20px;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $item->pengaju->nama ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                            <div class="flex px-4 py-1">
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 text-sm leading-normal">Nama Kegiatan</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-6" style="min-width: 20px;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                </div>
                                <div class="flex flex-col justify-center pl-2">
                                    <h6 class="mb-0 text-sm leading-normal">{{ $item->nama_kegiatan }}</h6>
                                </div>
                            </div>
                        </td>
                    </tr>

                      <tr>
                          <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                              <div class="flex px-4 py-1">
                                  <div class="flex flex-col justify-center">
                                      <h6 class="mb-0 text-sm leading-normal">Tanggal Mulai</h6>
                                  </div>
                                  <div class="flex flex-col justify-center pl-8" style="min-width: 20px;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                  </div>
                                  <div class="flex flex-col justify-center pl-2">
                                  <h6 class="mb-0 text-sm leading-normal">{{ $item->tanggal_pinjam }}</h6>
                                  </div>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                              <div class="flex px-4 py-1">
                                  <div class="flex flex-col justify-center">
                                      <h6 class="mb-0 text-sm leading-normal">Tanggal Berakhir</h6>
                                  </div>
                                  <div class="flex flex-col justify-center pl-4" style="min-width: 20px;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                  </div>
                                  <div class="flex flex-col justify-center pl-2">
                                  <h6 class="mb-0 text-sm leading-normal">{{ $item->tanggal_akhir }}</h6>
                                  </div>
                              </div>
                          </td>
                      </tr>
                      <tr>
                          <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                              <div class="flex px-4 py-1">
                                  <div class="flex flex-col justify-center" style="min-width: 40px;">
                                      <h6 class="mb-0 text-sm leading-normal">Tempat</h6> <!-- Replace 'tempat' with the correct field -->
                                  </div>
                                  <div class="flex flex-col justify-center pl-12" style="min-width: 20px;">
                                    <h6 class="mb-0 text-sm leading-normal">:</h6>
                                  </div>
                                  <div class="flex flex-col justify-center pl-2">
                                      <h6 class="mb-0 text-sm leading-normal">{{ $item->tempat ?? 'N/A' }}</h6>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  @endforeach
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
                    <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                      <i class="relative z-10 leading-none text-transparent ni ni-bell-55 leading-pro bg-gradient-to-tl from-green-600 to-lime-400 bg-clip-text fill-transparent"></i>
                    </span>
                    <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                      <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Review KLI</h6>
                      <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">NOW</p>
                    </div>
                  </div>
                  <div class="relative mb-4 after:clear-both after:table after:content-['']">
                    <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                        <i class="fas fa-check relative z-10 leading-none text-green-500"></i> <!-- Ganti dengan ikon centang -->
                    </span>
                    <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                        <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Review SEKUM BEM</h6>
                        <p class="mt-1 mb-0 text-xs font-semibold leading-tight text-slate-400">21 DEC 11 PM</p>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- cards row 2 -->
        <h5 class="font-bold px-4 mt-6 mb-0">Detail Dokumen</h5>
        <div class="flex flex-wrap my-6 -mx-3">
          <!-- card 1 -->

          <div class="w-full max-w-full pl-6 pr-2 md:w-1/2 md:flex-none lg:w-1/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="flex-auto p-6 px-0 pb-2">
                <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                      <tr>
                        <th class="px-6 py-3 pt-0 font-bold tracking-normal text-left align-middle bg-transparent border-b letter border-b-solid whitespace-nowrap text-slate-400">Dokumen</th>
                        <th class="px-6 py-3 pt-0 pl-2 font-bold tracking-normal text-left align-middle bg-transparent border-b letter border-b-solid whitespace-nowrap text-slate-400">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Nama Pengaju</h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Nama Kegiatan</h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Tanggal Mulai</h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Tanggal Berakhir</h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Tempat</h6>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2 align-middle bg-transparent whitespace-nowrap">
                          <div class="flex px-4 py-1">
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal">Kategori</h6>
                            </div>
                          </div>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- card 2 -->

          <div class="w-full max-w-full pr-6 pl-1 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:w-2/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="flex-auto p-4">
                <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
                <iframe src="{{ asset('assets/file/jadwal.pdf') }}" style="width:100%; height:600px;" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>

        <!-- cards row 3 -->
        <h5 class="font-bold px-4 mt-6 mb-0">Catatan</h5>
        <div class="flex flex-wrap my-6 -mx-3">
          <!-- card 2 -->
          <div class="w-full max-w-full pr-6 pl-1 mt-0 mb-6 md:mb-0 md:w-2/2 md:flex-none lg:w-3/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="flex-auto p-4">
              </div>
            </div>
          </div>
        </div>

        <footer class="pt-4">
          <div class="w-full px-6 mx-auto">
            <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
              <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                  ©
                  <script>
                    document.write(new Date().getFullYear() + ",");
                  </script>
                  made with <i class="fa fa-heart"></i> by
                  <a href="https://www.creative-tim.com" class="font-semibold text-slate-700" target="_blank">Creative Tim</a>
                  for a better web.
                </div>
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
@endsection