@extends('layout.main')
@section('content')

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border" style="width: 175%; height: auto;">
                <div class="flex-auto p-4">
                    <div class="container mx-auto px-6 py-6">
                        <h3 class="text-center text-xl font-semibold mb-4">Form Pengajuan Sarana dan Prasarana</h3>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('pengajuan.form') }}">
                            @csrf <!-- CSRF token for security -->

                            <div class="mb-4">
                                <label class="block text-gray-700">Ormawa Pengaju:</label>
                                <input type="text" name="ormawa" placeholder="Organisasi Mahasiswa" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Nama Pengaju:</label>
                                <input type="text" name="nama_pengaju" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Tanggal Peminjaman:</label>
                                <input type="date" name="tanggal_peminjaman" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Tanggal Berakhir:</label>
                                <input type="date" name="tanggal_berakhir" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Waktu:</label>
                                <input type="time" name="waktu" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Nama Kegiatan:</label>
                                <input type="text" name="nama_kegiatan" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Tempat Peminjaman:</label>
                                <input type="text" name="tempat_peminjaman" class="w-full border-gray-300 rounded-md p-2" required>
                            </div>

                            <!-- File inputs for documents -->
                            <div class="mb-4">
                                <label class="block text-gray-700">Dokumen 1:</label>
                                <input type="file" name="dokumen1" class="w-full border-gray-300 rounded-md p-2" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Dokumen 2:</label>
                                <input type="file" name="dokumen2" class="w-full border-gray-300 rounded-md p-2" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Dokumen 3:</label>
                                <input type="file" name="dokumen3" class="w-full border-gray-300 rounded-md p-2" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Dokumen 4:</label>
                                <input type="file" name="dokumen4" class="w-full border-gray-300 rounded-md p-2" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Dokumen 5:</label>
                                <input type="file" name="dokumen5" class="w-full border-gray-300 rounded-md p-2" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg">
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="flex justify-center mt-6">
                                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md mr-4">Simpan</button>
                                @if(session('success'))
                                    <div class="bg-green-500 text-white p-2 rounded mb-4">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <a href="{{ route('pengajuan.index') }}" class="bg-orange-600 text-white py-2 px-4 rounded-md">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
