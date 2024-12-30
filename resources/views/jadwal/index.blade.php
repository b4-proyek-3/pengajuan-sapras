@extends('layout.main')

@section('content')

<!-- Cards -->
<div class="w-auto px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">

        <!-- Card Diajukan -->
        <div id="jadwalCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative">
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#jadwalModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Jadwal
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
                                <th class="py-3 px-4 border">Tipe Ujian</th>
                                <th class="py-3 px-4 border">Mulai Ujian</th>
                                <th class="py-3 px-4 border">Akhir Ujian</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($jadwals as $key => $r)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ strtoupper($r->tipe_ujian) }}</td>
                                    <td class="py-3 px-4 border">{{ $r->mulai_ujian }}</td>
                                    <td class="py-3 px-4 border">{{ $r->akhir_ujian }}</td>
                                    <td class="py-3 px-4 border flex items-center space-x-2">
                                        <button
                                        data-bs-toggle="modal" data-bs-target="#jadwalEditModal"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                            Edit
                                        </button>
                                        <form id="delete-form-{{ $r->id_ujian}}" action="{{ route('jadwal.destroy', $r->id_ujian) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <!-- Button Hapus -->
                                            <button
                                                type="button"
                                                class="text-white px-4 py-2 rounded-lg"
                                                style="background-color: #ff7f00 !important;"
                                                onclick="confirmDelete({{ $r->id_ujian }})">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($jadwals->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data ruangan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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

@include('modal.modal_tambah_jadwal')
@include('modal.modal_edit_jadwal')

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

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
    };

</script>

@endsection