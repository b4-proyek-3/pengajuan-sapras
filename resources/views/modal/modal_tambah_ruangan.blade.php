<div class="modal fade overflow-y-auto" id="ruanganModal" tabindex="-1" aria-labelledby="ruanganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ruanganModalLabel">Form Tambah Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ruangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_gedung">Gedung</label>
                        <select name="id_gedung" id="id_gedung" class="form-control" required>
                            <option value=""> Pilih Gedung </option>
                            @foreach($gedung as $g)
                                <option value="{{ $g->id_gedung }}">{{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control" min="1" required>
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