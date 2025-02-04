@extends('layout.main')

@section('content')

<!-- Cards -->
<div class="w-auto px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end -mb-px">
            <button
                id="ruanganBtn"
                onclick="showCard('ruangan')"
                class="tab-button {{ $activeTab === 'ruangan' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Tempat
            </button>
            <button
                id="gedungBtn"
                onclick="showCard('gedung')"
                class="tab-button {{ $activeTab === 'gedung' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Lokasi
            </button>
        </div>

        <!-- Card Diajukan -->
        <div id="ruanganCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative ? {{ ($activeTab ?? '') === 'ruangan' }}">
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#ruanganModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Tempat
                </button>
            </div>
            <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300"></div>
                <!-- Data Pengajuan -->
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full bg-white border border-gray-200 mt-2">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="py-3 px-4 border">No</th>
                                <th class="py-3 px-4 border">Nama Tempat</th>
                                <th class="py-3 px-4 border">Lokasi</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @if ($ruangan->isNotEmpty()) 
                            @foreach ($ruangan as $key => $r)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $ruangan->firstItem() + $key }}</td>
                                    <td class="py-3 px-4 border">{{ $r->nama_ruangan }}</td>
                                    <td class="py-3 px-4 border">{{ $r->gedung->nama_gedung ?? '-' }}</td>
                                    <td class="py-3 px-4 border flex items-center space-x-2">
                                        <button
                                            data-bs-toggle="modal"
                                            data-bs-target="#ruanganEditModal"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                            data-id="{{ $r->id_ruangan }}"
                                            data-nama="{{ $r->nama_ruangan }}"
                                            data-id_gedung="{{ $r->gedung->id_gedung }}"
                                            data-kapasitas="{{ $r->kapasitas }}"
                                            data-foto="{{ $r->foto }}">
                                            Edit
                                        </button>
                                        <form id="delete-form-{{ $r->id_ruangan}}" action="{{ route('ruangan.destroy', $r) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <!-- Button Hapus -->
                                            <button
                                                type="button"
                                                class="text-white px-4 py-2 rounded-lg"
                                                style="background-color: #ff7f00 !important;"
                                                onclick="confirmDelete({{ $r->id_ruangan }})">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                            @if($ruangan->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data ruangan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-center items-center">
                        @if ($ruangan->currentPage() > 1)
                            <a href="{{ $ruangan->appends(request()->except('ruangan_page'))->previousPageUrl() }}"
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                <span class="mr-2">&larr; Prev</span>
                            </a>
                        @endif

                        <div class="flex items-center space-x-2">
                            @if ($ruangan->lastPage() > 10)
                                <a href="{{ $ruangan->appends(request()->except('ruangan_page'))->url(1) }}"
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                <a href="{{ $ruangan->appends(request()->except('ruangan_page'))->url($ruangan->lastPage()) }}"
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">
                                    {{ $ruangan->lastPage() }}
                                </a>
                            @else
                                @foreach ($ruangan->getUrlRange(1, $ruangan->lastPage()) as $page => $url)
                                    @if ($page == $ruangan->currentPage())
                                        <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                    @else
                                        <a href="{{ $ruangan->appends(request()->except('ruangan_page'))->url($page) }}"
                                        class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        @if ($ruangan->hasMorePages())
                            <a href="{{ $ruangan->appends(request()->except('ruangan_page'))->nextPageUrl() }}"
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                                <span class="mr-2">Next &rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Gedung -->
            <div id="gedungCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden ? {{ ($activeTab ?? '') === 'gedung' }}">
                <!-- Tombol Gedung -->
                <div class="flex flex-col items-start">
                    <button data-bs-toggle="modal" data-bs-target="#gedungModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                        <span class="mr-2 text-lg font-bold">+</span>Tambah Lokasi
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                    <div class="bg-gray-100 p-4 border-b border-gray-300"></div>
                    <!-- Data Gedung -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-200 text-gray-600">
                                <tr>
                                    <th class="py-3 px-4 border">No</th>
                                    <th class="py-3 px-4 border">Nama Lokasi</th>
                                    <th class="py-3 px-4 border">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($gedung as $key => $g)
                                    <tr>
                                        <td class="py-3 px-4 border">{{ $gedung->firstItem() + $key }}</td>
                                        <td class="py-3 px-4 border">{{ $g->nama_gedung }}</td>
                                        <td class="py-3 px-4 border flex items-center space-x-2">
                                            <button
                                            data-bs-toggle="modal" data-bs-target="#gedungEditModal"
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                                data-id="{{ $g->id_gedung }}"
                                                data-nama="{{ $g->nama_gedung }}">
                                                Edit
                                            </button>
                                            <form id="delete-form-{{ $g->id_gedung }}" action="{{ route('gedung.destroy', $g) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            
                                                <!-- Button Hapus -->
                                                <button
                                                    type="button"
                                                    class="text-white px-4 py-2 rounded-lg"
                                                    style="background-color: #ff7f00 !important;"
                                                    onclick="confirmDelete({{ $g->id_gedung }})">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($gedung->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data gedung</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-4 flex justify-center items-center">
                            @if ($gedung->currentPage() > 1)
                                <a href="{{ $gedung->appends(request()->except('gedung_page'))->previousPageUrl() }}"
                                class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                    <span class="mr-2">&larr; Prev</span>
                                </a>
                            @endif

                            <div class="flex items-center space-x-2">
                                @if ($gedung->lastPage() > 10)
                                    <a href="{{ $gedung->appends(request()->except('gedung_page'))->url(1) }}"
                                    class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                    <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                    <a href="{{ $gedung->appends(request()->except('gedung_page'))->url($gedung->lastPage()) }}"
                                    class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">
                                        {{ $gedung->lastPage() }}
                                    </a>
                                @else
                                    @foreach ($gedung->getUrlRange(1, $gedung->lastPage()) as $page => $url)
                                        @if ($page == $gedung->currentPage())
                                            <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                        @else
                                            <a href="{{ $gedung->appends(request()->except('gedung_page'))->url($page) }}"
                                            class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            @if ($gedung->hasMorePages())
                                <a href="{{ $gedung->appends(request()->except('gedung_page'))->nextPageUrl() }}"
                                class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
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
@include('modal.modal_tambah_ruangan')
@include('modal.modal_tambah_gedung')
@include('modal.modal_edit_ruangan')
@include('modal.modal_edit_gedung')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika pengguna mengkonfirmasi
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll('button[data-bs-target="#ruanganEditModal"]');
        const modal = document.getElementById('ruanganEditModal');

        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const idGedung = button.getAttribute('data-id_gedung');
                const kapasitas = button.getAttribute('data-kapasitas');
                const foto = button.getAttribute('data-foto');

                // Set nilai ke input di modal
                modal.querySelector('#nama_ruangan').value = nama;
                modal.querySelector('#id_gedung').value = idGedung;
                modal.querySelector('#kapasitas').value = kapasitas;

                // Update form action URL
                const form = modal.querySelector('#editRuanganForm');
                form.action = form.action.replace(/\/\d+$/, `/${id}`);
            });
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll('button[data-bs-target="#gedungEditModal"]');
        const modal = document.getElementById('gedungEditModal');

        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');

                // Set nilai ke input di modal
                modal.querySelector('#nama_gedung').value = nama;

                // Update form action URL
                const form = modal.querySelector('#editGedungForm');
                form.action = form.action.replace(/\/\d+$/, `/${id}`);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const alertMessage = "{{ session('alert') }}";
        if (alertMessage) {
            alert(alertMessage);
        }
    });

    function showCard(activeTab) {
        const url = new URL(window.location.href);
        url.searchParams.set('active_tab', activeTab);
        window.history.pushState({}, '', url);

        const ruanganCard = document.getElementById('ruanganCard');
        const gedungCard = document.getElementById('gedungCard');

        if (activeTab === 'ruangan') {
            ruanganCard.classList.remove('hidden');
            gedungCard.classList.add('hidden');
            
            document.getElementById('ruanganBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('ruanganBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('gedungBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('gedungBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        } else if (activeTab === 'gedung') {
            gedungCard.classList.remove('hidden');
            ruanganCard.classList.add('hidden');
            
            document.getElementById('gedungBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('gedungBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('ruanganBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('ruanganBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        }
    }

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('active_tab') || 'ruangan';
        showCard(activeTab);
    };

</script>

@endsection