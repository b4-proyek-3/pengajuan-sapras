<div class="modal fade overflow-y-auto" id="jadwalEditModal" tabindex="-1" aria-labelledby="jadwalEditModalLabel"
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
                            <option value="ets" {{ old('tipe_ujian', isset($r) && $r->tipe_ujian === 'ets' ? 'selected' : '') }}>ETS</option>
                            <option value="eas" {{ old('tipe_ujian', isset($r) && $r->tipe_ujian === 'eas' ? 'selected' : '') }}>EAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mulai_ujian" class="form-label">Mulai Ujian</label>
                        <input type="date" name="mulai_ujian" id="mulai_ujian"
                            value="{{ isset($r) ? $r->mulai_ujian : old('mulai_ujian') }}"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="akhir_ujian" class="form-label">Akhir Ujian</label>
                        <input type="date" name="akhir_ujian" id="akhir_ujian"
                            value="{{ isset($r) ? $r->akhir_ujian : old('akhir_ujian') }}"
                            class="form-control" required>
                    </div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            onclick="window.location.href='{{ route('jadwal.index') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>