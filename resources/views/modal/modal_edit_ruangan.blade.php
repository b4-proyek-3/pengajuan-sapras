<!-- Modal Edit Ruangan -->
<div class="modal fade overflow-y-auto" id="ruanganEditModal" tabindex="-1" aria-labelledby="ruanganEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ruanganEditModalLabel">Edit Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Ruangan -->
                <form action="{{ route('ruangan.update', $r->id_ruangan) }}" method="POST" enctype="multipart/form-data" id="editRuanganForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" id="nama_ruangan"
                            value="{{ isset($r) ? $r->nama_ruangan : old('nama_ruangan') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="id_gedung">Gedung</label>
                        <select name="id_gedung" id="id_gedung" class="form-control" required>
                            @foreach($gedung as $g)
                                <option value="{{ $g->id_gedung }}"
                                    {{ isset($r) && $r->id_gedung == $g->id_gedung ? 'selected' : '' }}>
                                    {{ $g->nama_gedung }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" id="kapasitas"
                            value="{{ isset($r) ? $r->kapasitas : old('kapasitas') }}"
                            class="form-control" required min="1">
                    </div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            onclick="window.location.href='{{ route('ruangan.index') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
