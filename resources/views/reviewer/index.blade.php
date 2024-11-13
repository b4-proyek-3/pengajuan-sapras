@extends('layout.main')
@section('content')

<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end">
            <button id="diajukanBtn" onclick="showCard('diajukan')" class="tab-button active bg-white text-gray-800 font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">Diajukan</button>
            <button id="riwayatBtn" onclick="showCard('riwayat')" class="tab-button bg-gray-200 text-gray-400 font-bold py-2 px-6 rounded-t-lg mr-2">Riwayat</button>
        </div>

        <!-- Card Diajukan -->
        <div id="diajukanCard" class="bg-white shadow-md rounded-lg p-6 max-w-sm mx-auto">

            <div class="container mx-auto">
                <!-- Notifikasi sukses -->
                @if (session('success'))
                    <div x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)" 
                        class="fixed top-10 left-1/2 transform -translate-x-1/2 bg-green-500 bg-opacity-100 text-black text-center px-4 py-2 rounded shadow-lg z-50"
                        style="width: 350px; text-align: center;"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button @click="show = false" class="absolute top-1 right-1 text-white">
                            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" role="button">
                                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 8.586l-2.936 2.936a1 1 0 001.414 1.414L10 9.828l2.936 2.936a1 1 0 001.414-1.414L11.414 8.586l2.936-2.936z"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Notifikasi gagal -->
                @if (session('failed'))
                    <div x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)" 
                        class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-red-600 bg-opacity-100 text-black px-6 py-4 rounded shadow-lg z-50"
                        style="width: 300px; text-align: center;"
                        role="alert">
                        <span class="block sm:inline">{{ session('failed') }}</span>
                        <button @click="show = false" class="absolute top-1 right-1 text-white">
                            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" role="button">
                                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 8.586l-2.936 2.936a1 1 0 001.414 1.414L10 9.828l2.936 2.936a1 1 0 001.414-1.414L11.414 8.586l2.936-2.936z"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Sorting dan Pencarian -->
            <div class="relative">
                <div class="h-1 bg-orange-500 py-6"></div> <!-- Top Orange Line -->
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <form method="GET" action="{{ route('pengajuan.index') }}" class="flex justify-between items-center">
                        <!-- Sort Dropdown -->
                        <div class="w-1/4">
                            <div class="relative">
                                <select name="sort_status" class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10" onchange="this.form.submit()">
                                    <option value="">Sort Status</option>
                                    <option value="diajukan" {{ request('sort_status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="direview" {{ request('sort_status') == 'direview' ? 'selected' : '' }}>Direview</option>
                                    <option value="direvisi" {{ request('sort_status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Search Input -->
                        <div class="flex items-center mt-2 lg:flex-1">
                            <div class="relative flex items-stretch w-full transition-all rounded-lg ease-soft">
                                <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-gray-500 transition-all">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-full leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Cari...">
                            </div>

                            <!-- Tombol reset hanya muncul jika ada pencarian atau sorting -->
                            @if(request('search') || request('sort_status'))
                            <a href="{{ route('pengajuan.index') }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Data Pengajuan -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 mmt-2 max-w-full">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="py-3 px-4 border w-1/12">No</th>
                                <th class="py-3 px-4 border w-1/12">Tanggal Pengajuan</th>
                                <th class="py-3 px-4 border w-1/12">Nama Kegiatan</th>
                                <th class="py-3 px-4 border w-1/12">Ormawa</th>
                                <th class="py-3 px-4 border w-1/12">Status</th>
                                <th class="py-3 px-4 border w-1/12">Keterangan</th>
                                <th class="py-3 px-4 border w-1/12">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($pengajuanDiajukan as $pengajuan)
                            <tr>
                                <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->status }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                                <td class="py-3 px-4 border">
                                <button onclick="window.location='{{ route('reviewer.detail_reviewer', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => auth()->user()->reviewer->id_reviewer]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
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
                                <form method="POST" enctype="multipart/form-data" action="{{ route('pengajuan.store') }}">
                                    @csrf <!-- CSRF token for security -->
                                    
                                    <!-- Form fields -->
                                    <div class="mb-3">
                                    <label for="ormawa">Pilih Ormawa</label>
                                        <select name="ormawa" id="ormawa" class="form-control" required>
                                            <option value="">-- Pilih Ormawa --</option>
                                            @foreach ($ormawaList as $ormawa)
                                                <option value="{{ $ormawa->id_ormawa }}">{{ $ormawa->nama_ormawa }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM Pengaju</label>
                                        <input type="text" name="nim" id="nim" class="form-control" required>
                                    </div>

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
                                        <label for="id_tempat">Pilih Tempat</label>
                                        <select name="id_tempat" id="id_tempat" class="form-control" required>
                                            <option value="">-- Pilih Tempat --</option>
                                            @foreach($tempatList as $tempat)
                                                <option value="{{ $tempat->id_tempat }}">{{ $tempat->nama_tempat }}</option>
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
                                    <div class="flex justify-center mt-6">
                                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md mr-4">Simpan</button>
                                        <button type="button" class="bg-orange-600 text-white py-2 px-4 rounded-md mr-4" onclick="window.location.href='{{ route('pengajuan.index') }}'">Batal</button>
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
        </div>

        <!-- Card Riwayat -->
        <div id="riwayatCard" class="bg-white shadow-md rounded-lg p-6 max-w-sm mx-auto hidden"> 
            <div class="relative">
                <div class="h-1 bg-orange-500 py-6"></div>
                <div class="bg-gray-100 p-2 border-b border-gray-300">
                    <div class="flex justify-between mb-4">

                        <!-- Sort Dropdown -->
                        <div class="w-1/4 pr-4">
                          <div class="relative">
                              <select class="appearance-none border border-gray-300 rounded-md p-2 w-full pr-10">
                                  <option value="">Sort Status</option>
                                  <option value="selesai">Selesai</option>
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
                <table class="min-w-full bg-white border border-gray-200 mmt-2 max-w-full">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 border w-1/12">No</th>
                            <th class="py-3 px-4 border w-1/12">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 border w-1/12">Nama Kegiatan</th>
                            <th class="py-3 px-4 border w-1/12">Ormawa</th>
                            <th class="py-3 px-4 border w-1/12">Status</th>
                            <th class="py-3 px-4 border w-1/12">Keterangan</th>
                            <th class="py-3 px-4 border w-1/12">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($pengajuanRiwayat as $pengajuan)
                        <tr>
                            <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->tanggal_pengajuan }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->pengaju->ormawa->nama_ormawa }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->status }}</td>
                            <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                            <td class="py-3 px-4 border">
                            <button onclick="window.location='{{ route('reviewer.detail_reviewer', ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_reviewer' => auth()->user()->reviewer->id_reviewer]) }}'" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Detail</button>
                            </td>
                        </tr>
                    @endforeach

                    @if($pengajuanRiwayat->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pengajuan selain yang diajukan</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
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

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .container {
        max-width: 90%;
        margin: auto;
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    th, td {
        text-align: center;
    }

    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    .bg-blue-600 {
        background-color: #3B82F6;
    }

    .bg-orange-500 {
        background-color: #F97316;
    }

    .bg-gray-200 {
        background-color: #E5E7EB;
    }

    .bg-yellow-400 {
        background-color: #FBBF24;
    }

    .bg-green-400 {
        background-color: #34D399;
    }

    .bg-red-400 {
        background-color: #F87171;
    }

    .text-gray-500, .text-gray-600 {
        color: #6B7280;
    }

    .rounded-md {
        border-radius: 0.375rem;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .h-8 {
        height: 2rem;
    }

    .overflow-x-auto {
        overflow-x: auto;
    }

    button {
        z-index: 10;
        display: inline-block;
    }
</style>
@endsection
