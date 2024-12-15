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

                    @if (session('failed'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                            class="text-red-400 px-4 py-4 z-10" role="alert">
                            <span class="block sm:inline">{{ session('failed') }}</span>
                        </div>
                    @endif
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
                                    <td class="py-3 px-4 border flex items-center space-x-2">
                                        <!-- Button Detail -->
                                        <button 
                                            onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" 
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                            Detail
                                        </button>
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
        </div>

        <!-- Card Riwayat -->
        <div id="riwayatCard" class="tab-content bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden">
            <!-- Sorting dan Pencarian -->
            <div class="relative">
                <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                        <input type="hidden" name="active_tab" value="riwayat">

                        <!-- Sort Dropdown -->
                        <div class="w-1/4">
                            <div class="relative">
                                <select name="status_filter" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value=""> Pilih Status </option>
                                    <option value="selesai">Selesai</option>
                                    <option value="ditolak">Ditolak</option>
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
                                <td class="py-3 px-4 border">
                                    <button onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="bg-blue-600 text-white px-2 py-1 rounded-lg">Detail</button>
                                    @if ($pengajuan->status === 'selesai')
                                        <button
                                            onclick="window.location='{{ route('dokumen.generate', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'"
                                            class="bg-green-600 text-white px-2 py-1 text-sm rounded-md">Unduh</button>
                                    @endif
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
                    </table>
                </div>
            </div>
        </div>

                <!-- Modal -->
                <div class="modal fade overflow-y-auto" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pengajuanModalLabel">Form Pengajuan Sarana dan Prasarana</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf 

                            <div class="mb-3">
                                <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                                <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                            </div>

                                    <div class="mb-3">
                                        <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman</label>
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Berakhir</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir') }}" required>
                                    </div>

                            <div class="mb-3">
                                <label for="waktu" class="form-label">Waktu Kegiatan</label>
                                <input type="time" name="waktu_pinjam" id="waktu_pinjam" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="id_tempat">Tempat</label>
                                <select name="id_tempat" id="id_tempat" class="form-control" required>
                                    <option value=""> Pilih Tempat </option>
                                    @foreach($tempatList as $tempat)
                                        <option value="{{ $tempat->id_tempat }}">{{ $tempat->nama_gedung }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="activity_type" class="form-label">Jenis Kegiatan</label>
                                <select name="activity_type" id="activity_type" class="form-control" required onchange="showFileInputs()">
                                    <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                                    <option value="proker">Program Kerja</option>
                                    <option value="pergerakan">Pergerakan</option>
                                </select>
                                <p class="text-gray-500 text-sm mt-1">File maksimal 2 MB</p>
                            </div>

                                    <div id="program_kerja_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen1" class="form-label">Proposal</label>
                                            <input type="file" name="dokumen1" id="dokumen1" class="form-control"
                                                accept=".pdf">
                                        </div>
                                    </div>

                                    <div id="pergerakan_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen2" class="form-label">Term of Reference</label>
                                            <input type="file" name="dokumen2" id="dokumen2" class="form-control"
                                                accept=".pdf">
                                        </div>
                                    </div>

                                    <div id="common_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen3" class="form-label">Surat Peminjaman Sarana
                                                Prasarana</label>
                                            <input type="file" name="dokumen3" id="dokumen3" class="form-control"
                                                accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen4" class="form-label">Surat Izin Berkegiatan</label>
                                            <input type="file" name="dokumen4" id="dokumen4" class="form-control"
                                                accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen5" class="form-label">Surat Pernyataan Ketua Ormawa</label>
                                            <input type="file" name="dokumen5" id="dokumen5" class="form-control"
                                                accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen6" class="form-label">Surat Pendampingan Pembina</label>
                                            <input type="file" name="dokumen6" id="dokumen6" class="form-control"
                                                accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen7" class="form-label">Lampiran Daftar Peserta</label>
                                            <input type="file" name="dokumen7" id="dokumen7" class="form-control"
                                                accept=".pdf">
                                        </div>
                                    </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Link Surat Izin Orang Tua</label>
                                <input type="url" name="link_gdrive" id="link_gdrive" class="form-control" placeholder="https://drive.google.com/drive/folders/surat_izin_orang_tua">
                            </div>

                                    <div class="flex justify-center mt-6 space-x-4">
                                        <button type="submit"
                                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            style="background-color: #2563eb !important;">Simpan</button>
                                        <button type="button"
                                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                            onclick="window.location.href='{{ route('pengajuan.index') }}'">Batal</button>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <!-- Card Riwayat -->
            <div id="riwayatCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden ? {{ ($activeTab ?? '') === 'riwayat' }}">

                <!-- Sorting dan Pencarian -->
                <div class="relative">
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
                                <input type="text" name="riwayat_search" value="{{ request('riwayat_search') }}" class="pl-8.75 text-sm border border-gray-300 rounded-md p-2 w-full" placeholder=" Cari">
                                @if(request('riwayat_search') || request('riwayat_sort_status'))
                                    <a href="{{ route('pengajuan.index', ['active_tab' => 'riwayat']) }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
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
                                @foreach ($pengajuanRiwayat as $key => $pengajuan)
                                    <tr>
                                        <td class="py-3 px-4 border">{{ $pengajuanRiwayat->firstItem() + $key }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? '-' }}</td>
                                        <td class="py-3 px-4 border">
                                            <span class="inline-block py-1 px-3 rounded-lg 
                                                @if($pengajuan->status == 'selesai')
                                                bg-green-200 text-green-800
                                                @elseif($pengajuan->status == 'ditolak')
                                                bg-red-200 text-red-800
                                                @else
                                                bg-gray-200 text-gray-800
                                                @endif">{{ ucfirst($pengajuan->status) }}
                                            </span>   
                                        </td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                                        <td class="py-3 px-4 border">
                                            <button onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($pengajuanRiwayat->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pengajuan</td>
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
                        
                        </table>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const namaKegiatanInput = document.getElementById("nama_kegiatan");

        namaKegiatanInput.addEventListener("input", function () {
            const maxLength = 100; // Batas maksimal karakter
            const errorMessage = document.getElementById("error_nama_kegiatan");

            if (namaKegiatanInput.value.length > maxLength) {
                if (!errorMessage) {
                    const errorDiv = document.createElement("div");
                    errorDiv.id = "error_nama_kegiatan";
                    errorDiv.style.color = "red";
                    errorDiv.textContent = "Nama kegiatan tidak boleh lebih dari 100 karakter.";
                    namaKegiatanInput.parentNode.appendChild(errorDiv);
                }
            } else {
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const alertMessage = "{{ session('alert') }}";
        if (alertMessage) {
            alert(alertMessage);
        }
    });

    function checkFileSize(inputId) {
        const input = document.getElementById(inputId);
        input.addEventListener("change", function () {
            const file = input.files[0];
            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert("File yang diunggah tidak boleh lebih dari 2MB!");
                    input.value = "";
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        checkFileSize("dokumen1");
        checkFileSize("dokumen2");
        checkFileSize("dokumen3");
        checkFileSize("dokumen4");
        checkFileSize("dokumen5");
        checkFileSize("dokumen6");
        checkFileSize("dokumen7");
    });

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
        commonFiles.style.display = "block"; 

        if (activityType === "proker") {
            programKerjaFiles.style.display = "block";
        } else if (activityType === "pergerakan") {
            pergerakanFiles.style.display = "block";
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        showFileInputs();
    });

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