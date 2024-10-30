@extends('layout.main')
@section('content')
<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
    <!-- row 1 -->
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end">
            <button id="diajukanBtn" onclick="showCard('diajukan')" class="tab-button active bg-white text-gray-800 font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">Diajukan</button>
            <button id="riwayatBtn" onclick="showCard('riwayat')" class="tab-button bg-gray-200 text-gray-400 font-bold py-2 px-6 rounded-t-lg mr-2">Riwayat</button>
        </div>

        <!-- Card Diajukan -->
        <div id="diajukanCard" class="card bg-white shadow-md rounded-lg p-6">
          <!-- Tombol Pengajuan -->
          <div class="flex justify-between mb-4">
            <button class="bg-blue-600 text-white py-2 px-4 rounded-md">
              <span class="mr-2">+</span> Buat Pengajuan
            </button>
          </div>
            <!-- Sorting and Search Container with Orange Border -->
            <div class="relative">
                <div class="h-1 bg-orange-500 py-6"></div> <!-- Top Orange Line -->
                <div class="bg-gray-100 p-2 border-b border-gray-300"> <!-- Sorting and Search with light gray background -->
                    <div class="flex justify-between mb-4">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4 pr-4">
                          <div class="relative">
                              <select class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10">
                                  <option value="">Sort Status</option>
                                  <option value="diterima">Diajukan</option>
                                  <option value="direview">Direview</option>
                                  <option value="direvisi">Direvisi</option>
                              </select>
                              <!-- Custom Dropdown Icon -->
                              <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                              </div>
                          </div>
                      </div>
                        <!-- Search Box -->
                        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                          <div class="flex items-center md:ml-auto md:pr-4">
                            <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                              <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                <i class="fas fa-search"></i>
                              </span>
                              <input type="text" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Cari..." />
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Diajukan -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 mt-2 table-fixed"> <!-- Added table-fixed for fixed column width -->
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 border w-1/12">No</th>
                            <th class="py-3 px-4 border w-2/12">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 border w-3/12">Nama Kegiatan</th>
                            <th class="py-3 px-4 border w-2/12">Ormawa</th>
                            <th class="py-3 px-4 border w-1/12">Status</th>
                            <th class="py-3 px-4 border w-2/12">Keterangan</th>
                            <th class="py-3 px-4 border w-1/12">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Card Riwayat -->
        <div id="riwayatCard" class="card bg-white shadow-md rounded-lg p-6 hidden"> 
            <!-- Sorting and Search Container with Orange Border -->
            <div class="relative">
                <div class="h-1 bg-orange-500 py-6"></div> <!-- Top Orange Line -->
                <div class="bg-gray-100 p-2 border-b border-gray-300"> <!-- Sorting and Search with light gray background -->
                    <div class="flex justify-between mb-4">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4 pr-4">
                          <div class="relative">
                              <select class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10">
                                  <option value="">Sort Status</option>
                                  <option value="selesai">Diterima</option>
                                  <option value="ditolak">Ditolak</option>
                              </select>
                              <!-- Custom Dropdown Icon -->
                              <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                              </div>
                          </div>
                      </div>
                        <!-- Search Box -->
                        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                          <div class="flex items-center md:ml-auto md:pr-4">
                            <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                              <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                <i class="fas fa-search"></i>
                              </span>
                              <input type="text" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Cari..." />
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Riwayat -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 mt-2 table-fixed"> <!-- Added table-fixed for fixed column width -->
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 border w-1/12">No</th>
                            <th class="py-3 px-4 border w-2/12">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 border w-3/12">Nama Kegiatan</th>
                            <th class="py-3 px-4 border w-2/12">Ormawa</th>
                            <th class="py-3 px-4 border w-1/12">Status</th>
                            <th class="py-3 px-4 border w-2/12">Keterangan</th>
                            <th class="py-3 px-4 border w-1/12">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showCard(card) {
            // Reset all tab buttons
            document.getElementById('diajukanBtn').classList.remove('active', 'bg-white', 'text-gray-800');
            document.getElementById('diajukanBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('riwayatBtn').classList.remove('active', 'bg-white', 'text-gray-800');
            document.getElementById('riwayatBtn').classList.add('bg-gray-200', 'text-gray-400');

            // Hide all cards
            document.getElementById('diajukanCard').classList.add('hidden');
            document.getElementById('riwayatCard').classList.add('hidden');

            // Show selected card and set active tab button
            if (card === 'diajukan') {
                document.getElementById('diajukanBtn').classList.add('active', 'bg-white', 'text-gray-800');
                document.getElementById('diajukanBtn').classList.remove('bg-gray-200', 'text-gray-400');
                document.getElementById('diajukanCard').classList.remove('hidden');
            } else {
                document.getElementById('riwayatBtn').classList.add('active', 'bg-white', 'text-gray-800');
                document.getElementById('riwayatBtn').classList.remove('bg-gray-200', 'text-gray-400');
                document.getElementById('riwayatCard').classList.remove('hidden');
            }
        }

        // Set default tab as Diajukan
        document.addEventListener('DOMContentLoaded', function () {
            showCard('diajukan');
        });
    </script>
</div>

@endsection