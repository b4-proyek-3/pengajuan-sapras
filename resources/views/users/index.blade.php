@extends('layout.main')

@section('content')

<!-- Cards -->
<div class="w-auto px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <!-- Tabs -->
        <div class="flex justify-end -mb-px">
            <button
                id="pengajuBtn"
                onclick="showCard('pengaju')"
                class="tab-button {{ $activeTab === 'pengaju' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Pengaju
            </button>
            <button
                id="reviewerBtn"
                onclick="showCard('reviewer')"
                class="tab-button {{ $activeTab === 'reviewer' ? 'bg-white text-gray-800 shadow-md' : 'bg-gray-200 text-gray-400' }} font-bold py-2 px-6 rounded-t-lg shadow-md mr-2">
                Reviewer
            </button>
        </div>

        <!-- Card Diajukan -->
        <div id="pengajuCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative ? {{ ($activeTab ?? '') === 'pengaju' }}">
            <!-- Tombol Pengajuan -->
            <div class="flex flex-col items-start">
                <button data-bs-toggle="modal" data-bs-target="#pengajuModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                    <span class="mr-2 text-lg font-bold">+</span>Tambah Pengaju
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
                                <th class="py-3 px-4 border">Nama</th>
                                <th class="py-3 px-4 border">NIM</th>
                                <th class="py-3 px-4 border">Email</th>
                                <th class="py-3 px-4 border">Ormawa</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pengaju as $key => $p)
                                <tr>
                                    <td class="py-3 px-4 border">{{ $pengaju->firstItem() + $key }}</td>
                                    <td class="py-3 px-4 border">{{ $p->user->name }}</td>
                                    <td class="py-3 px-4 border">{{ $p->nim }}</td>
                                    <td class="py-3 px-4 border">{{ $p->user->email }}</td>
                                    <td class="py-3 px-4 border">{{ $p->ormawa->nama_ormawa }}</td>
                                    <td class="py-3 px-4 border">
                                        <div class="flex items-center space-x-2">
                                            <button
                                            data-bs-toggle="modal" data-bs-target="#editPengajuModal"
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                                data-id="{{ $p->user->id_user }}"
                                                data-name="{{ $p->user->name }}"
                                                data-nim="{{ $p->nim }}"
                                                data-id-ormawa="{{ $p->ormawa->id_ormawa }}"
                                                data-email="{{ $p->user->email }}">
                                                Edit
                                            </button>
                                            <form id="delete-form-{{ $p->id_user }}" action="{{ route('users.destroy', $p->id_user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            
                                                <!-- Button Hapus -->
                                                <button
                                                    type="button"
                                                    class="text-white px-4 py-2 rounded-lg"
                                                    style="background-color: #ff7f00 !important;"
                                                    onclick="confirmDelete({{ $p->id_user }})">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($pengaju->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pengaju</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-center items-center">
                        @if ($pengaju->currentPage() > 1)
                            <a href="{{ $pengaju->appends(request()->except('pengaju_page'))->previousPageUrl() }}"
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                <span class="mr-2">&larr; Prev</span>
                            </a>
                        @endif

                        <div class="flex items-center space-x-2">
                            @if ($pengaju->lastPage() > 10)
                                <a href="{{ $pengaju->appends(request()->except('pengaju_page'))->url(1) }}"
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                <a href="{{ $pengaju->appends(request()->except('pengaju_page'))->url($pengaju->lastPage()) }}"
                                class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">
                                    {{ $pengaju->lastPage() }}
                                </a>
                            @else
                                @foreach ($pengaju->getUrlRange(1, $pengaju->lastPage()) as $page => $url)
                                    @if ($page == $pengaju->currentPage())
                                        <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                    @else
                                        <a href="{{ $pengaju->appends(request()->except('pengaju_page'))->url($page) }}"
                                        class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        @if ($pengaju->hasMorePages())
                            <a href="{{ $pengaju->appends(request()->except('pengaju_page'))->nextPageUrl() }}"
                            class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all ml-2">
                                <span class="mr-2">Next &rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card reviewer -->
            <div id="reviewerCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative hidden ? {{ ($activeTab ?? '') === 'reviewer' }}">
                <!-- Tombol reviewer -->
                <div class="flex flex-col items-start">
                    <button data-bs-toggle="modal" data-bs-target="#reviewerModal" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 ease-in-out">
                        <span class="mr-2 text-lg font-bold">+</span>Tambah Reviewer
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                    <div class="bg-gray-100 p-4 border-b border-gray-300"></div>
                    <!-- Data reviewer -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-200 text-gray-600">
                                <tr>
                                    <th class="py-3 px-4 border">No</th>
                                    <th class="py-3 px-4 border">Nama</th>
                                    <th class="py-3 px-4 border">Email</th>
                                    <th class="py-3 px-4 border">Role</th>
                                    <th class="py-3 px-4 border">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reviewer as $key => $r)
                                    <tr>
                                        <td class="py-3 px-4 border">{{ $reviewer->firstItem() + $key }}</td>
                                        <td class="py-3 px-4 border">{{ $r->user->name }}</td>
                                        <td class="py-3 px-4 border">{{ $r->user->email }}</td>
                                        <td class="py-3 px-4 border">{{ $r->role }}</td>
                                        <td class="py-3 px-4 border">
                                            <div class="flex items-center space-x-2">
                                                <button
                                                data-bs-toggle="modal" data-bs-target="#editReviewerModal"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                                                    data-id="{{ $r->user->id_user }}"
                                                    data-name="{{ $r->user->name }}"
                                                    data-role="{{ $r->role }}"
                                                    data-email="{{ $r->user->email }}">
                                                    Edit
                                                </button>
                                                <form id="delete-form-{{ $r->id_user }}" action="{{ route('users.destroy', $r->id_user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                
                                                    <!-- Button Hapus -->
                                                    <button
                                                        type="button"
                                                        class="text-white px-4 py-2 rounded-lg"
                                                        style="background-color: #ff7f00 !important;"
                                                        onclick="confirmDelete({{ $r->id_user }})">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if($reviewer->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data reviewer</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-4 flex justify-center items-center">
                            @if ($reviewer->currentPage() > 1)
                                <a href="{{ $reviewer->appends(request()->except('reviewer_page'))->previousPageUrl() }}"
                                class="flex items-center text-blue-500 px-4 py-2 rounded-lg border border-blue-500 hover:bg-blue-500 hover:text-white transition-all mr-2">
                                    <span class="mr-2">&larr; Prev</span>
                                </a>
                            @endif

                            <div class="flex items-center space-x-2">
                                @if ($reviewer->lastPage() > 10)
                                    <a href="{{ $reviewer->appends(request()->except('reviewer_page'))->url(1) }}"
                                    class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">1</a>

                                    <span class="px-4 py-2 text-gray-500 mr-2">...</span>

                                    <a href="{{ $reviewer->appends(request()->except('reviewer_page'))->url($reviewer->lastPage()) }}"
                                    class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">
                                        {{ $reviewer->lastPage() }}
                                    </a>
                                @else
                                    @foreach ($reviewer->getUrlRange(1, $reviewer->lastPage()) as $page => $url)
                                        @if ($page == $reviewer->currentPage())
                                            <span class="px-4 py-2 rounded-lg bg-blue-500 text-white mr-2">{{ $page }}</span>
                                        @else
                                            <a href="{{ $reviewer->appends(request()->except('reviewer_page'))->url($page) }}"
                                            class="px-4 py-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-all mr-2">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            @if ($reviewer->hasMorePages())
                                <a href="{{ $reviewer->appends(request()->except('reviewer_page'))->nextPageUrl() }}"
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
@include('modal.modal_tambah_pengaju')
@include('modal.modal_tambah_reviewer')
@include('modal.modal_edit_pengaju')
@include('modal.modal_edit_reviewer')

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

    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk validasi password
        function validatePassword(formId) {
            const form = document.getElementById(formId);
            const passwordField = form.querySelector('#password');
            const passwordError = form.querySelector('#passwordError');
            const password = passwordField.value;

            if (password.length < 8) {
                passwordError.style.display = 'block'; // Menampilkan pesan error
                return false;
            } else {
                passwordError.style.display = 'none'; // Menyembunyikan pesan error
                return true;
            }
        }

        // Menambahkan event listener untuk tiap form
        const formTambahPengaju = document.getElementById('formTambahPengaju');
        const formEditPengaju = document.getElementById('formEditPengaju');
        const formTambahReviewer = document.getElementById('formTambahReviewer');
        const formEditReviewer = document.getElementById('formEditReviewer');

        // Setiap kali form dikirim, validasi password
        if (formTambahPengaju) {
            formTambahPengaju.addEventListener('submit', function(event) {
                if (!validatePassword('formTambahPengaju')) {
                    event.preventDefault(); // Menghentikan pengiriman form jika password kurang dari 8 karakter
                }
            });
        }
        if (formEditPengaju) {
            formEditPengaju.addEventListener('submit', function(event) {
                if (!validatePassword('formEditPengaju')) {
                    event.preventDefault();
                }
            });
        }
        if (formTambahReviewer) {
            formTambahReviewer.addEventListener('submit', function(event) {
                if (!validatePassword('formTambahReviewer')) {
                    event.preventDefault();
                }
            });
        }
        if (formEditReviewer) {
            formEditReviewer.addEventListener('submit', function(event) {
                if (!validatePassword('formEditReviewer')) {
                    event.preventDefault();
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        // Handle modal editPengajuModal
        const editPengajuButtons = document.querySelectorAll('button[data-bs-target="#editPengajuModal"]');
        const editPengajuModal = document.getElementById('editPengajuModal');

        editPengajuButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const nim = button.getAttribute("data-nim");
                const idOrmawa = button.getAttribute("data-id-ormawa");
                const email = button.getAttribute("data-email");

                console.log("ID User dari Tombol:", id);

                // Set nilai ke input di modal
                editPengajuModal.querySelector("#name").value = name;
                editPengajuModal.querySelector("#nim").value = nim;
                editPengajuModal.querySelector("#id_ormawa").value = idOrmawa;
                editPengajuModal.querySelector("#email").value = email;

                // Update form action URL
                const form = editPengajuModal.querySelector('#formEditPengaju');
                form.action = form.action.replace('__ID__', id);
            });
        });

        // Handle modal editReviewerModal
        const editReviewerButtons = document.querySelectorAll('button[data-bs-target="#editReviewerModal"]');
        const editReviewerModal = document.getElementById('editReviewerModal');

        editReviewerButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const role = button.getAttribute("data-role");
                const email = button.getAttribute("data-email");

                console.log("Role dari tombol:", role);

                // Set nilai ke input di modal
                editReviewerModal.querySelector("#name").value = name;
                editReviewerModal.querySelector("#email").value = email;

                // Set nilai role sebagai selected
                const roleSelect = editReviewerModal.querySelector("#role");
                if (roleSelect) {
                    for (let option of roleSelect.options) {
                        if (option.value === role) {
                            option.selected = true;
                        } else {
                            option.selected = false; // Pastikan opsi lain tidak selected
                        }
                    }
                }

                // Update form action URL
                const form = editReviewerModal.querySelector('#formEditReviewer');
                form.action = form.action.replace('__ID__', id);
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

        const pengajuCard = document.getElementById('pengajuCard');
        const reviewerCard = document.getElementById('reviewerCard');

        if (activeTab === 'pengaju') {
            pengajuCard.classList.remove('hidden');
            reviewerCard.classList.add('hidden');
            
            document.getElementById('pengajuBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('pengajuBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('reviewerBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('reviewerBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        } else if (activeTab === 'reviewer') {
            reviewerCard.classList.remove('hidden');
            pengajuCard.classList.add('hidden');
            
            document.getElementById('reviewerBtn').classList.add('bg-white', 'text-gray-800', 'shadow-md');
            document.getElementById('reviewerBtn').classList.remove('bg-gray-200', 'text-gray-400');
            
            document.getElementById('pengajuBtn').classList.add('bg-gray-200', 'text-gray-400');
            document.getElementById('pengajuBtn').classList.remove('bg-white', 'text-gray-800', 'shadow-md');
        }
    }

    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('active_tab') || 'pengaju';
        showCard(activeTab);
    };

</script>

@endsection
