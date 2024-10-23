@extends('layout.main')

@section('content')
<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
    <!-- row 1 -->
    <div class="flex flex-wrap -mx-3">
        <!-- cards 1 edit pengajuan -->
        <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:w-2/3 lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <div class="flex flex-wrap mt-0 -mx-3">
                        <div class="flex-none w-full max-w-full px-3 mt-0 lg:w-full lg:flex-none">
                            <h6 class="text-xl font-bold">Detail Pengajuan</h6>
                            <p class="mb-0 text-sm leading-normal">
                                <span class="ml-1 font-semibold">Pengajuan</span> #No Pengajuan
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Diajukan pada DD-MM-YYYY HH:MM:SS</p>
                        </div>
                    </div>
                    <!-- Garis oranye -->
                    <div class="mt-2 border-orange-line"></div>
                </div>
                <div class="flex-auto p-6">
                    <!-- Tampilkan Detail Pengajuan -->
                    <div class="mb-4">
                        <h6 class="text-sm font-semibold">Nama Pengaju: <span class="font-normal">John Doe</span></h6>
                        <h6 class="text-sm font-semibold">Tanggal Pengajuan: <span class="font-normal">01-01-2023</span></h6>
                        <h6 class="text-sm font-semibold">Tempat Kegiatan: <span class="font-normal">Auditorium</span></h6>
                    </div>
                    <button onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center text-sm">
                        <i class="fa fa-pencil-alt mr-2"></i> EDIT PENGAJUAN
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengajuan -->
<div id="editPengajuanModal" class="modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
    <div class="modal-content border-4 border-blue-500 bg-white rounded-3xl p-6 w-2/5"> <!-- Adjusted width and border -->
        <div class="flex justify-between items-center">
            <h5 class="font-bold">Edit Pengajuan</h5>
        </div>
        <hr class="my-3">
        <form class="space-y-4">
            <!-- Updated Input Field Layout -->
            <div class="flex items-center mb-4">
                <label for="nama-kegiatan" class="w-1/4 text-right pr-4 text-sm font-medium">Nama Kegiatan</label>
                <input type="text" id="nama-kegiatan" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="tanggal-kegiatan" class="w-1/4 text-right pr-4 text-sm font-medium">Tanggal Kegiatan</label>
                <input type="date" id="tanggal-kegiatan" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="tempat-kegiatan" class="w-1/4 text-right pr-4 text-sm font-medium">Tempat Kegiatan</label>
                <input type="text" id="tempat-kegiatan" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="kategori-kegiatan" class="w-1/4 text-right pr-4 text-sm font-medium">Kategori Kegiatan</label>
                <input type="text" id="kategori-kegiatan" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="nama-pengaju" class="w-1/4 text-right pr-4 text-sm font-medium">Nama Pengaju</label>
                <input type="text" id="nama-pengaju" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="kontak" class="w-1/4 text-right pr-4 text-sm font-medium">Kontak</label>
                <input type="text" id="kontak" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
            <div class="flex items-center mb-4">
                <label for="ormawa" class="w-1/4 text-right pr-4 text-sm font-medium">Ormawa</label>
                <input type="text" id="ormawa" class="w-3/4 p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300 outline-none text-sm" />
            </div>
           <!-- Tombol Simpan dan Batal -->
            <div class="flex justify-end mt-6 space-x-4"> <!-- Added space between buttons -->
                <button type="button" class="px-4 py-2 bg-orange-400 text-white rounded-full hover:bg-orange-500 transition flex items-center text-xs font-bold">
                    <i class="fa fa-times mr-2"></i>
                    BATALKAN
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition flex items-center text-xs font-bold">
                    <i class="fa fa-save mr-2"></i>
                    SIMPAN
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    function openModal() {
        document.getElementById('editPengajuanModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editPengajuanModal').classList.add('hidden');
    }
</script>

<!-- CSS for Modal and Styling -->
<style>
    .modal {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 24px; /* Rounded corners for the modal */
        width: 40%; /* Adjust modal width */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); /* Softer shadow */
        border: 4px solid #2563eb; /* Blue border for the modal */
    }

    .border-orange-line {
        border-bottom: 2px solid #f97316;
        margin-top: 10px;
    }

    .space-y-4 > * + * {
        margin-top: 16px;
    }

    .bg-orange-400 {
        background-color: #f97316;
    }

    .bg-blue-700 {
        background-color: #1d4ed8;
    }

    button {
        padding: 8px 16px;
        font-size: 12px;
        border-radius: 12px;
    }

    button:hover {
        opacity: 0.9;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .flex.justify-end {
        display: flex;
        justify-content: flex-end;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .space-x-4 > * + * {
        margin-left: 16px; /* Added spacing between buttons */
    }
</style>
@endsection
