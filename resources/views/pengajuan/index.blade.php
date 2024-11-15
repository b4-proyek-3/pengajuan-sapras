@extends('layout.main')
@section('content')

<!-- Cards -->
<div class="w-full px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end -mb-px">
            <button id="diajukanBtn" onclick="showCard('diajukan')" class="tab-button bg-white text-gray-800 font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">Diajukan</button>
            <button id="riwayatBtn" onclick="showCard('riwayat')" class="tab-button bg-gray-200 text-gray-400 font-bold py-2 px-6 rounded-t-lg border-b-0 mr-2">Riwayat</button>
        </div>

        <!-- Card Diajukan -->
        <div id="diajukanCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative">
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#pengajuanModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Pengajuan
                </button>
                @if (session('success'))
                    <div x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)" 
                        class="text-green-400 px-4 py-4 z-10"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('failed'))
                    <div x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)" 
                        class="text-red-400 px-4 py-4 z-10"
                        role="alert">
                        <span class="block sm:inline">{{ session('failed') }}</span>
                    </div>
                @endif
            </div>

            <!-- Sorting dan Pencarian -->
            <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4">
                            <div class="relative">
                                <select name="status_filter" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value=""> Pilih Status </option>
                                    <option value="diajukan">Diajukan</option>
                                    <option value="direview">Direvisi</option>
                                    <option value="direvisi">Ditolak</option>
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
                            @foreach ($pengajuanList as $pengajuan)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? '-' }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->status }}</td>
                                    <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                                    <td class="py-3 px-4 border">
                                    <button onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pengajuanModalLabel">Form Pengajuan Sarana dan Prasarana</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf <!-- CSRF token for security -->
                                    
                                    <!-- Form fields -->
                                    <!-- <div class="mb-3">
                                        <label for="ormawa">Ormawa</label>
                                        <select name="ormawa" id="ormawa" class="form-control" required>
                                            <option value=""> Pilih Ormawa </option>
                                            @foreach ($ormawaList as $ormawa)
                                                <option value="{{ $ormawa->id_ormawa }}">{{ $ormawa->nama_ormawa }}</option>
                                            @endforeach
                                        </select>
                                    </div> -->

                                    <div class="mb-3">
                                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu Kegiatan</label>
                                        <input type="time" name="waktu_pengajuan" id="waktu_pengajuan" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
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
                                            <option value="program_kerja">Program Kerja</option>
                                            <option value="pergerakan">Pergerakan</option>
                                        </select>
                                        <p class="text-gray-500 text-sm mt-1">File maksimal 2 MB</p>
                                    </div>

                                    <!-- File upload field khusus untuk Program Kerja (Proposal) -->
                                    <div id="program_kerja_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen1" class="form-label">Proposal</label>
                                            <input type="file" name="dokumen1" id="dokumen1" class="form-control" accept=".pdf">
                                        </div>
                                    </div>

                                    <!-- File upload field khusus untuk Pergerakan (Term of Reference) -->
                                    <div id="pergerakan_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen2" class="form-label">Term of Reference</label>
                                            <input type="file" name="dokumen2" id="dokumen2" class="form-control" accept=".pdf">
                                        </div>
                                    </div>

                                    <!-- File upload fields yang sama untuk kedua jenis kegiatan -->
                                    <div id="common_files" style="display: none;">
                                        <div class="mb-3">
                                            <label for="dokumen3" class="form-label">Surat Peminjaman Sarana Prasarana</label>
                                            <input type="file" name="dokumen3" id="dokumen3" class="form-control" accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen4" class="form-label">Surat Izin Berkegiatan</label>
                                            <input type="file" name="dokumen4" id="dokumen4" class="form-control" accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen5" class="form-label">Surat Pernyataan Ketua Ormawa</label>
                                            <input type="file" name="dokumen5" id="dokumen5" class="form-control" accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen6" class="form-label">Surat Pendampingan Pembina</label>
                                            <input type="file" name="dokumen6" id="dokumen6" class="form-control" accept=".pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokumen7" class="form-label">Lampiran Daftar Peserta</label>
                                            <input type="file" name="dokumen7" id="dokumen7" class="form-control" accept=".pdf">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link Surat Izin Orang Tua</label>
                                        <input type="url" name="link_gdrive" id="link_gdrive" class="form-control" placeholder="https://drive.google.com/drive/folders/surat_izin_orang_tua">
                                    </div>

                                    <!-- Submit and Cancel buttons -->
                                    <div class="flex justify-center mt-6 space-x-4">
                                        <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" style="background-color: #2563eb !important;">Simpan</button>
                                        <button type="button" class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400" onclick="window.location.href='{{ route('pengajuan.index') }}'">Batal</button>
                                    </div>
                                    <!-- Setelah form pengajuan -->
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

            <!-- Card Riwayat -->
            <div id="riwayatCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden">
                
                <!-- Sorting dan Pencarian -->
                <div class="relative">
                    <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                    <div class="bg-gray-100 p-4 border-b border-gray-300">
                        <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                            <!-- Sort Dropdown -->
                            <div class="w-1/4">
                                <div class="relative">
                                    <select name="status_filter" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                        <option value=""> Pilih Status </option>
                                        <option value="diterima">Diterima</option>
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
                                @foreach ($pengajuanList as $pengajuan)
                                    <tr>
                                        <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa ?? '-' }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->status }}</td>
                                        <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                                        <td class="py-3 px-4 border">
                                            <button onclick="window.location='{{ route('pengajuan.show', ['id_pengajuan' => $pengajuan->id_pengajuan]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
</div>


<script>
    $(document).ready(function() {
        $('#ormawa').select2({
            placeholder: "Pilih Organisasi Mahasiswa"
        });
    });

    document.getElementById("link").addEventListener("blur", function() {
        // Ambil nilai link dari form
        var linkValue = document.getElementById("link").value;

        // Validasi apakah input adalah URL yang benar
        if (!linkValue.startsWith("http://") && !linkValue.startsWith("https://")) {
            alert("Harap masukkan URL yang valid (dimulai dengan http:// atau https://)");
        } else {
            // Jika valid, otomatis submit form
            alert("Link berhasil disubmit: " + linkValue);
            document.getElementById("linkForm").submit(); // Kirim form secara otomatis
        }
    });

    function showCard(card) {
        // Sembunyikan kedua card terlebih dahulu
        document.getElementById('diajukanCard').classList.add('hidden');
        document.getElementById('riwayatCard').classList.add('hidden');
        
        // Atur ulang button style
        document.getElementById('diajukanBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        document.getElementById('diajukanBtn').classList.add('bg-gray-200', 'text-gray-400');
        document.getElementById('riwayatBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        document.getElementById('riwayatBtn').classList.add('bg-gray-200', 'text-gray-400');
        
        // Tampilkan card sesuai tombol yang diklik
        if (card === 'diajukan') {
            document.getElementById('diajukanCard').classList.remove('hidden');
            document.getElementById('diajukanBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('diajukanBtn').classList.remove('bg-gray-200', 'text-gray-400');
        } else if (card === 'riwayat') {
            document.getElementById('riwayatCard').classList.remove('hidden');
            document.getElementById('riwayatBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('riwayatBtn').classList.remove('bg-gray-200', 'text-gray-400');
        }
    }

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