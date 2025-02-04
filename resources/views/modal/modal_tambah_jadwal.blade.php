<div class="modal fade overflow-y-auto" id="jadwalModal" tabindex="-1" aria-labelledby="jadwalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gedungModalLabel">Form Tambah Jadwal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="tipe_ujian" class="form-label">Tipe Ujian</label>
                        <select name="tipe_ujian" id="tipe_ujian" class="form-control" required>
                            <option value="" disabled selected>Pilih Tipe Ujian</option>
                            <option value="ets">ETS</option>
                            <option value="eas">EAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mulai_ujian" class="form-label">Mulai Ujian</label>
                        <input type="date" name="mulai_ujian" id="mulai_ujian" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="akhir_ujian" class="form-label">Akhir Ujian</label>
                        <input type="date" name="akhir_ujian" id="akhir_ujian" class="form-control" required>
                    </div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>