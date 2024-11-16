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
            </div>
        </div>

        <footer class="pt-4 w-full bg-gray-100">
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