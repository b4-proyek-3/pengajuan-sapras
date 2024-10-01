@extends('layout.main')
@section('content')

<!-- <?php
session_start();
$_SESSION['username'] = "NamaPengguna"; // Simpan username saat login
?> -->

<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
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
                <button data-bs-toggle="modal" data-bs-target="#pengajuanModal" style="background-color: #3B3BBD; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
                    <span class="mr-2">+</span>Tambah Pengajuan
                </button>
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
                                    <option value="diterima" {{ request('sort_status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="direview" {{ request('sort_status') == 'direview' ? 'selected' : '' }}>Direview</option>
                                    <option value="direvisi" {{ request('sort_status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                    <option value="ditolak" {{ request('sort_status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Search Input -->
                        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                          <div class="flex items-center md:ml-auto md:pr-4">
                            <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                                <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Cari...">
                            </div>
                            <!-- Tombol reset hanya muncul jika ada pencarian atau sorting -->
                            @if(request('search') || request('sort_status'))
                                <a href="{{ route('pengajuan.index') }}" class="bg-gray-600 text-white py-2 px-4 rounded-md ml-4">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

                <!-- Main Data Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 mt-2 table-fixed">
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
                        @foreach ($pengajuanList as $pengajuan)
                            <tr>
                                <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->created_at }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->nama_kegiatan }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->ormawa }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->status }}</td>
                                <td class="py-3 px-4 border">{{ $pengajuan->keterangan }}</td>
                                <td class="py-3 px-4 border">
                                    <a href="" class="bg-purple-600 text-white px-2 py-1 style='border-radius: 5px;">Details</a>
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
                                <form method="POST" enctype="multipart/form-data" action="{{ route('pengajuan.form') }}">
                                    @csrf <!-- CSRF token for security -->
                                    
                                    <!-- Form fields -->
                                    <div class="mb-3">
                                        <label for="ormawa" class="form-label">Ormawa Pengaju</label>
                                        <select name="ormawa" id="ormawa" class="form-control" required>
                                            <option value="" disabled selected>Pilih Organisasi Mahasiswa</option>
                                            <option value="MPM">Majelis Perwakilan Mahasiswa (MPM)</option>
                                            <option value="BEM">Badan Eksekutif Mahasiswa (BEM)</option>
                                            <option value="HMAN">HMJ_Administrasi Niaga</option>
                                            <option value="HMAK">HMJ_Akuntansi</option>
                                            <option value="HIMARIS">HMJ_Bahasa Inggris</option>
                                            <option value="HME">HMJ_Teknik Elektro</option>
                                            <option value="HMJTK">HMJ_Teknik Kimia</option>
                                            <option value="HIMAKOM">HMJ_Teknik Komputer dan Informatika</option>
                                            <option value="HMTE">HMJ_Teknik Konversi Energi</option>
                                            <option value="HMM">HMJ_Teknik Mesin</option>
                                            <option value="HMRA">HMJ_Teknik Refrigerasi dan Tata Udara</option>
                                            <option value="HIMAS">HMJ_Teknik Sipil</option>
                                            <option value="UKM_Assalam">UKM_Asosiasi Mahasiswa Islam (Assalam)</option>
                                            <option value="UKM_BelaDiri">UKM_BELA DIRI</option>
                                            <option value="UKM_BolaBaske">UKM_BOLA BASKET</option>
                                            <option value="UKM_BolaVoli">UKM_BOLA VOLI</option>
                                            <option value="UKM_Bulutangkis">UKM_BULUTANGKIS</option>
                                            <option value="UKM_Catur">UKM_CATUR</option>
                                            <option value="UKM_FlagFootball">UKM_Flag Football</option>
                                            <option value="UKM_Kabayan">UKM_Kebudayaan Baraya Sunda (Kabayan)</option>
                                            <option value="UKM_KMK">UKM_Keluarga Mahasiswa Katholik (KMK)</option>
                                            <option value="UKM_KEWIRAUSAHAAN">UKM_KEWIRAUSAHAAN</option>
                                            <option value="UKM_KSR">UKM_KSR</option>
                                            <option value="UKM_MusikDanTeater">UKM_MUSIK DAN TEATER</option>
                                            <option value="UKM_Otomotif">UKM_OTOMOTIF</option>
                                            <option value="UKM_PSM">UKM_Paduan Suara Mahasiswa (PSM)</option>
                                            <option value="UKM_SAGA">UKM_Perhimpunan Penempuh Rimba dan Pendaki Gunung (PPRPG) SAGA</option>
                                            <option value="UKM_PMK">UKM_Persekutuan Mahasiswa Kristen (PMK)</option>
                                            <option value="UKM_Pramuka">UKM_Pramuka</option>
                                            <option value="UKM_Robotika">UKM_ROBOTIKA</option>
                                            <option value="UKM_USF">UKM_SEPAK BOLA & FUTSAL</option>
                                            <option value="UKM_TenisMeja">UKM_TENIS MEJA</option>
                                            <option value="UKM_ELTRAS">UKM_The Education and Entertainment Line Transmitter Radio Stations (ELTRAS)</option>
                                            <option value="UKM_UBSU">UKM_Unit Budaya dan Seni Sumatera Utara (UBSU)</option>
                                            <option value="UKM_UKB">UKM_Unit Kesenian B</option>
                                        </select>
                                    </div>

                                    <!-- <div class="mb-3">
                                        <label for="nama_pengaju" class="form-label">Nama Pengaju</label>
                                        <input type="text" name="nama_pengaju" id="nama_pengaju" class="form-control" value="<?php echo $_SESSION['username']; ?>" readonly required>
                                    </div> -->


                                    <div class="mb-3">
                                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                        <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu</label>
                                        <input type="time" name="waktu" id="waktu" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tempat_peminjama" class="form-label">Tempat Peminjaman</label>
                                        <select name="tempat_peminjaman" id="tempat_peminjaman" class="form-control" required>
                                            <option value="" disabled selected>Pilih Tempat</option>
                                            <option value="H-405">Pendopo Agung</option>
                                            <option value="H-405">Ruang Kulaih H-405</option>
                                            <option value="Rapat-A">Ruang Rapat A (P2T)</option>
                                            <option value="Kelas-310">Ruang Kelas 310</option>
                                            <option value="Kelas-309">Ruang Kelas 309</option>
                                            <option value="Kelas-307">Ruang Kelas 307</option>
                                            <option value="Kelas-301">Ruang Kelas 301</option>
                                            <option value="Aula">Ruang Aula</option>
                                            <option value="Telcon">Ruang Teleconference Room </option>
                                            <option value="Conference">Ruang Conference Room</option>
                                            <option value="Rapat-E">Ruang Rapat E</option>
                                            <option value="Rapat-D">Ruang Rapat D</option>
                                            <option value="Rapat-C">Ruang Rapat C</option>
                                            <option value="Rapat-B">Ruang Rapat B (Auditorium)</option>
                                            <option value="Rapat-A">Ruang Rapat A (Direktorat)</option>
                                            <option value="Rapim">Ruang Rapim</option>
                                        </select>
                                    </div>

                                    <!-- File upload inputs -->
                                    <div class="mb-3">
                                        <label for="dokumen1" class="form-label">Proposal</label>
                                        <input type="file" name="dokumen1" id="dokumen1" class="form-control" accept=".pdf">
                                    </div>

                                    <div class="mb-3">
                                        <label for="dokumen2" class="form-label">Term of Reference</label>
                                        <input type="file" name="dokumen2" id="dokumen2" class="form-control" accept=".pdf">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="dokumen3" class="form-label"> Surat Peminjaman Sarana Prasarana</label>
                                        <input type="file" name="dokumen3" id="dokumen3" class="form-control" accept=".pdf">
                                    </div>

                                    <div class="mb-3">
                                        <label for="dokumen4" class="form-label">Surat Pernyataan Berkegiatan</label>
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
                                        <label for="dokumen7" class="form-label"> Lampiran Daftar Peserta</label>
                                        <input type="file" name="dokumen7" id="dokumen7" class="form-control" accept=".pdf">
                                    </div>

                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link Surat Izin Orang Tua</label>
                                        <input type="url" name="link_surat" id="link_surat" class="form-control" placeholder="https://drive.google.com/drive/folders/surat_izin_orang_tua" required>
                                    </div>

                                    <!-- Submit and Cancel buttons -->
                                    <div class="flex justify-center mt-6">
                                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md mr-4">Simpan</button>
                                        <button type="button" onclick="window.location.href='{{ route('pengajuan.index') }}'" class="bg-orange-600 text-white py-2 px-4 rounded-md mr-4">Batal</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Riwayat -->
            <!-- <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 mt-2 table-fixed">
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
                        <tbody>
                            <tr>
                                <td class="py-3 px-4 border">002</td>
                                <td class="py-3 px-4 border">15-09-2024</td>
                                <td class="py-3 px-4 border">Festival Budaya</td>
                                <td class="py-3 px-4 border">UKM Budaya</td>
                                <td class="py-3 px-4 border">Ditolak</td>
                                <td class="py-3 px-4 border">Keterangan Festival</td>
                                <td class="py-3 px-4 border">
                                <button class="bg-purple-600 text-white px-2 py-1" style="border-radius: 5px;">Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
    
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

    const username = "NamaPengguna"; 
    document.getElementById("nama_pengaju").value = username;

    function saveData() {
    alert("Data berhasil disimpan!");

    document.getElementById("nama_pengaju").value = "";
    }

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