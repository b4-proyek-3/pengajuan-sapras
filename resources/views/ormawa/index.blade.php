@extends('layout.main')
@section('content')

<!-- Cards -->
<div class="w-auto px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">

        <!-- Card Diajukan -->
        <div id="ormawaCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative">
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#ormawaModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Ormawa
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
                                <th class="py-3 px-4 border">Nama Ormawa</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ormawas as $key => $r)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $r->nama_ormawa }}</td>
                                    <td class="py-3 px-4 border flex items-center space-x-2">
                                        <button
                                        data-bs-toggle="modal" data-bs-target="#ormawaEditModal"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                            data-id="{{ $r->id_ormawa }}"
                                            data-name="{{ $r->nama_ormawa }}">
                                            Edit
                                        </button>
                                        <form id="delete-form-{{ $r->id_ujian}}" action="{{ route('ormawa.destroy', $r->id_ormawa) }}" method="POST">
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

                            @if($ormawas->isEmpty())
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

@include('modal.modal_tambah_ormawa')
@include('modal.modal_edit_ormawa')

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

    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll('button[data-bs-target="#ormawaEditModal"]');
        const modal = document.getElementById('ormawaEditModal');

        editButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');

                // Set nilai ke input di modal
                modal.querySelector("#nama_ormawa").value = name;
                // Update form action URL
                const form = modal.querySelector('#ormawaEditModal');
                form.action = form.action.replace(/\/\d+$/, `/${id}`);
            });
        });
    });

</script>

@endsection