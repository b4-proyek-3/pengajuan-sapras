@extends('layout.main')
@section('content')

<!-- Cards -->
<div class="w-full px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end -mb-px">
            <button 
                id="diajukanBtn" 
                onclick="showCard('diajukan')" 
                class="tab-button {{ $activeTab === 'diajukan' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Diajukan
            </button>
            <button 
                id="riwayatBtn" 
                onclick="showCard('riwayat')" 
                class="tab-button {{ $activeTab === 'riwayat' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Riwayat
            </button>
        </div>

        <!-- Card Diajukan -->
        <div id="diajukanCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative ? {{ ($activeTab ?? '') === 'diajukan' }}">

            <!-- Sorting dan Pencarian -->
            <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <form method="GET" action="{{ route('reviewer.index') }}" class="flex justify-between items-center">
                        <input type="hidden" name="active_tab" value="diajukan">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4">
                            <div class="relative">
                                <select name="diajukan_sort_status" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value=""> Pilih Status </option>
                                    <option value="diajukan">Diajukan</option>
                                    <option value="diedit">Diedit</option>
                                </select>

                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Search Input -->
                        <div class="relative flex items-center space-x-2">
                            <span class="text-sm flex items-center px-2 text-gray-500">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-8.75 text-sm border border-gray-300 rounded-md p-2 w-full" placeholder=" Cari">
                            @if(request('search') || request('diajukan_sort_status'))
                                <a href="{{ route('reviewer.index', ['active_tab' => 'diajukan']) }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Data Pengajuan -->
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full bg-white border border-gray-200 mt-2">
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
                            @foreach ($pengajuanDiajukan as $pengajuan)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa }}</td>
                                    <td class="py-3 px-4 border">
                                        <span class="inline-block py-1 px-3 rounded-lg 
                                            @if($pengajuan->status == 'diajukan' || $pengajuan->status == 'direview' )
                                                bg-blue-200 text-blue-800
                                            @elseif($pengajuan->status == 'direvisi')
                                                bg-orange-200 text-orange-800
                                            @else
                                                bg-gray-200 text-gray-800
                                            @endif">
                                            @if($pengajuan->status == 'direview')
                                                Diajukan
                                            @else
                                                {{ ucfirst($pengajuan->status ?? '-') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->latestReview->first()->catatan ?? '-' }}</td>
                                    <td class="py-3 px-4 border">
                                    <button onclick="window.location='{{ route('reviewer.detail_reviewer', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => auth()->user()->reviewer->id_reviewer]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Review</button>
                                    </td>
                                </tr>
                            @endforeach

                            @if($pengajuanDiajukan->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pengajuan yang diajukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4 flex justify-center items-center">
                        @if ($pengajuanDiajukan->currentPage() > 1)
                            <a href="{{ $pengajuanDiajukan->previousPageUrl() }}" class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                <span class="mr-2">&larr; Prev</span>
                            </a>
                        @endif

                        <div class="flex items-center space-x-2">
                            @if ($pengajuanDiajukan->lastPage() > 10)
                                <a href="{{ $pengajuanDiajukan->url(1) }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                <a href="{{ $pengajuanDiajukan->url($pengajuanDiajukan->lastPage()) }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $pengajuanDiajukan->lastPage() }}</a>
                            @else
                                @foreach ($pengajuanDiajukan->getUrlRange(1, $pengajuanDiajukan->lastPage()) as $page => $url)
                                    @if ($page == $pengajuanDiajukan->currentPage())
                                        <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        @if ($pengajuanDiajukan->hasMorePages())
                            <a href="{{ $pengajuanDiajukan->nextPageUrl() }}" class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                                <span class="mr-2">Next &rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Riwayat -->
            <div id="riwayatCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden ? {{ ($activeTab ?? '') === 'riwayat' }}">
                
                <!-- Sorting dan Pencarian -->
                <div class="relative">
                    <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                    <div class="bg-gray-100 p-4 border-b border-gray-300">
                        <form method="GET" action="{{ route('reviewer.index') }}" class="flex justify-between items-center">
                            <input type="hidden" name="active_tab" value="riwayat">

                            <!-- Sort Dropdown -->
                            <div class="w-1/4">
                                <div class="relative">
                                <select name="riwayat_sort_status" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value=""> Pilih Status </option>
                                    <option value="diterima" {{ request('riwayat_sort_status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="direvisi" {{ request('riwayat_sort_status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                    <option value="ditolak" {{ request('riwayat_sort_status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>

                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Input -->
                            <div class="relative flex items-center space-x-2">
                                <span class="text-sm flex items-center px-2 text-gray-500">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="riwayat_search" value="{{ request('riwayat_search') }}" class="pl-8.75 text-sm border border-gray-300 rounded-md p-2 w-full" placeholder=" Cari">
                                @if(request('riwayat_search') || request('riwayat_sort_status'))
                                    <a href="{{ route('reviewer.index', ['active_tab' => 'riwayat']) }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Table Riwayat Pengajuan -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 mt-2">
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
                                @forelse ($pengajuanRiwayat as $pengajuan)
                                    <tr>
                                        <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa }}</td>
                                        <td class="py-3 px-4 border">
                                            <span class="inline-block py-1 px-3 rounded-lg 
                                                @if($pengajuan->reviewers->first()->pivot->status == 'diterima')
                                                    bg-green-200 text-green-800
                                                @elseif($pengajuan->reviewers->first()->pivot->status == 'ditolak')
                                                    bg-red-200 text-red-800
                                                @else
                                                    bg-gray-200 text-gray-800
                                                @endif">
                                                {{ ucfirst($pengajuan->reviewers->first()->pivot->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->latestReview->first()->catatan ?? '-' }}</td>
                                        <td class="py-3 px-4 border">
                                            <button onclick="window.location='{{ route('reviewer.detail_reviewer', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => auth()->user()->reviewer->id_reviewer]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-gray-500">Tidak ada data pengajuan.</td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-center items-center">
                            @if ($pengajuanRiwayat->currentPage() > 1)
                                <a href="{{ $pengajuanRiwayat->previousPageUrl() }}" class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                    <span class="mr-2">&larr; Prev</span>
                                </a>
                            @endif

                            <div class="flex items-center space-x-2">
                                @if ($pengajuanRiwayat->lastPage() > 10)
                                    <a href="{{ $pengajuanRiwayat->url(1) }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                    <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                    <a href="{{ $pengajuanRiwayat->url($pengajuanRiwayat->lastPage()) }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $pengajuanRiwayat->lastPage() }}</a>
                                @else
                                    @foreach ($pengajuanRiwayat->getUrlRange(1, $pengajuanRiwayat->lastPage()) as $page => $url)
                                        @if ($page == $pengajuanRiwayat->currentPage())
                                            <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            @if ($pengajuanRiwayat->hasMorePages())
                                <a href="{{ $pengajuanRiwayat->nextPageUrl() }}" class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                                    <span class="mr-2">Next &rarr;</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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


<script>
    function showCard(activeTab) {
        const url = new URL(window.location.href);
        url.searchParams.set('active_tab', activeTab); 
        window.history.pushState({}, '', url); 

        const diajukanCard = document.getElementById('diajukanCard');
        const riwayatCard = document.getElementById('riwayatCard');

        if (activeTab === 'diajukan') {
            diajukanCard.classList.remove('hidden');
            riwayatCard.classList.add('hidden');
            
            document.getElementById('diajukanBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('diajukanBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('riwayatBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('riwayatBtn').classList.remoave('bg-white', 'text-gray-800', 'shadow-md');
        } else if (activeTab === 'riwayat') {
            riwayatCard.classList.remove('hidden');
            diajukanCard.classList.add('hidden');
            
            document.getElementById('riwayatBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('riwayatBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('diajukanBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('diajukanBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        }
    }

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('active_tab') || 'diajukan'; 
        showCard(activeTab); b
    };

    function showFileInputs() {
        const activityType = document.getElementById("activity_type").value;
        const programKerjaFiles = document.getElementById("program_kerja_files");
        const pergerakanFiles = document.getElementById("pergerakan_files");
        const commonFiles = document.getElementById("common_files");

        // Reset display styles
        programKerjaFiles.style.display = "none";
        pergerakanFiles.style.display = "none";
        commonFiles.style.display = "block"; // Show common files for both types

        if (activityType === "program_kerja") {
            programKerjaFiles.style.display = "block";
        } else if (activityType === "pergerakan") {
            pergerakanFiles.style.display = "block";
        }
    }

    // Trigger initial check on page load if activity type is preselected
    document.addEventListener("DOMContentLoaded", function () {
        showFileInputs();
    });
</script>

@endsection