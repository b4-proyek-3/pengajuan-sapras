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
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#pengajuanModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Pengajuan
                </button>
            </div>

            <!-- Sorting dan Pencarian -->
            <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                        <input type="hidden" name="active_tab" value="diajukan">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4">
                            <div class="relative">
                                <select name="diajukan_sort_status" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value=""> Pilih Status </option>
                                    <option value="diajukan" {{ request('diajukan_sort_status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="direview" {{ request('diajukan_sort_status') == 'direview' ? 'selected' : '' }}>Direview</option>
                                    <option value="direvisi" {{ request('diajukan_sort_status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                    <option value="diedit" {{ request('diajukan_sort_status') == 'diedit' ? 'selected' : '' }}>Diedit</option>
                                </select>

                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
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
                                    <a href="{{ route('pengajuan.index', ['active_tab' => 'diajukan']) }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
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
                            @foreach ($pengajuanDiajukan as $key => $pengajuan)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $pengajuanDiajukan->firstItem() + $key }}</td>
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
                                            @else
                                                bg-gray-200 text-gray-800
                                            @endif">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->latestReview->first()->catatan ?? '-' }}</td>
                                    <td class="py-3 px-4 border items-center space-y-2">
                                        <!-- Button Detail -->
                                        <button 
                                            onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                            Detail
                                        </button>
                                        @if ($pengajuan->status == 'diajukan')
                                        <form
                                            action="{{ route('pengajuan.destroy', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}" 
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <!-- Button Hapus -->
                                            <button
                                                type="button"
                                                data-id="{{ $pengajuan->id_pengajuan }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                class="text-white px-4 py-2 rounded-lg"
                                                style="background-color: #ff7f00 !important;"
                                                onclick="openModal('{{ $pengajuan->id_pengajuan }}')">
                                                Hapus
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade overflow-y-auto" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog flex items-center justify-center min-h-screen">
                                                    <div class="modal-content">
                                                        <!-- Header Modal -->
                                                        <div class="modal-header bg-gray-100">
                                                            <h5 class="modal-title text-xl font-bold text-gray-800" id="deleteModalLabel">
                                                               Hapus Pengajuan
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <p class="text-gray-700 text-lg">
                                                                Apakah Anda yakin ingin menghapus pengajuan ini?
                                                            </p>
                                                        </div>
                                                        
                                                        <div class="modal-footer flex justify-end space-x-4">
                                                            <button type="button"
                                                                class="text-white px-4 py-2 rounded hover:bg-gray-500" 
                                                                style="background-color: #808080 !important;"
                                                                data-bs-dismiss="modal">
                                                                Batal
                                                            </button>
                                                            
                                                            <form id="deleteForm" method="POST" action="/pengajuan/1">
                                                                <button type="submit"
                                                                    class="text-white px-4 py-2 rounded hover:bg-red-700"
                                                                    style="background-color: #ff0000 !important;">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        @endif
                                        
                                        <script>
                                            function openModal(id) {
                                                const modal = document.getElementById('deleteModal');
                                                const form = document.getElementById('deleteForm');
                                                
                                                form.action = `/pengajuan/${id}`;
                                                
                                                modal.classList.remove('hidden');
                                            }

                                            function closeModal() {
                                                const modal = document.getElementById('deleteModal');
                                                modal.classList.add('hidden');
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @endforeach

                            @if($pengajuanDiajukan->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pengajuan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-center items-center">
                        @if ($pengajuanDiajukan->currentPage() > 1)
                            <a href="{{ $pengajuanDiajukan->appends(request()->except('diajukan_page'))->previousPageUrl() }}" 
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                <span class="mr-2">&larr; Prev</span>
                            </a>
                        @endif

                        <div class="flex items-center space-x-2">
                            @if ($pengajuanDiajukan->lastPage() > 10)
                                <a href="{{ $pengajuanDiajukan->appends(request()->except('diajukan_page'))->url(1) }}" 
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                <a href="{{ $pengajuanDiajukan->appends(request()->except('diajukan_page'))->url($pengajuanDiajukan->lastPage()) }}" 
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $pengajuanDiajukan->lastPage() }}</a>
                            @else
                                @foreach ($pengajuanDiajukan->getUrlRange(1, $pengajuanDiajukan->lastPage()) as $page => $url)
                                    @if ($page == $pengajuanDiajukan->currentPage())
                                        <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                    @else
                                        <a href="{{ $pengajuanDiajukan->appends(request()->except('diajukan_page'))->url($page) }}" 
                                        class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        @if ($pengajuanDiajukan->hasMorePages())
                            <a href="{{ $pengajuanDiajukan->appends(request()->except('diajukan_page'))->nextPageUrl() }}" 
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                                <span class="mr-2">Next &rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Riwayat -->
            <div id="riwayatCard" class="tab-content bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden">
                <!-- Sorting dan Pencarian -->
                <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                    <div class="bg-gray-100 p-4 border-b border-gray-300">
                        <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                            <input type="hidden" name="active_tab" value="riwayat">

                            <!-- Sort Dropdown -->
                            <div class="w-1/4">
                                <div class="relative">
                                    <select name="riwayat_sort_status" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                        <option value=""> Pilih Status </option>
                                        <option value="selesai" {{ request('riwayat_sort_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
                                <input type="text" name="search" value="{{ request('search') }}" class="pl-8.75 text-sm border border-gray-300 rounded-md p-2 w-full" placeholder=" Cari">
                                @if(request('search') || request('sort_status'))
                                    <a href="{{ route('pengajuan.index') }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
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
                            @foreach ($pengajuanRiwayat as $pengajuan)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? '-' }}</td>
                                    <td class="py-3 px-4 border">
                                    <span class="inline-block py-1 px-3 rounded-lg
                                            @if($pengajuan->status == 'selesai')
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
                                    <td class="py-3 px-4 border items-center space-y-2">
                                        <button onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                                        @if ($pengajuan->status === 'selesai')
                                            <button
                                                onclick="window.location='{{ route('dokumen.generate', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'"
                                                class="bg-green-600 text-white px-4 py-2 text-sm rounded-lg">Unduh</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @if($pengajuanRiwayat->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pengajuan yang selesai</td>
                                </tr>
                            @endif
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
@include('modal.modal_tambah_pengajuan')

@if (session('success'))
<script>
    Swal.fire({
    position: "center",
    title: "{{session('success')}}",
    showConfirmButton: false,
    timer: 1500,
    icon: "success"
  });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        position: "center",
        title: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 1500,
        icon: "error"
    });
</script>
@endif

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
            document.getElementById('riwayatBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
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
        showCard(activeTab);
    };

    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
        const cancelButton = document.getElementById('cancelButton');
        const deleteModal = document.getElementById('deleteModal');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const form = document.getElementById('deleteForm');
                form.setAttribute('action', `/pengajuan/${id}`);
                deleteModal.classList.remove('hidden');
            });
        });

        cancelButton.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });
    });
</script>

@endsection