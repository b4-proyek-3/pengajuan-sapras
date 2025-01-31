<div class="modal fade overflow-y-auto" id="ormawaEditModal" tabindex="-1" aria-labelledby="ormawaEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrmawaModalLabel">Form Edit Ormawa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ormawa.update', $r->id_ormawa ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_ormawa" class="form-label">Nama Ormawa</label>
                        <input type="text" name="nama_ormawa" id="nama_ormawa"
                            value="{{ isset($r) ? $r->nama_ormawa : old('nama_ormawa') }}"
                            class="form-control" required>
                    </div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            onclick="window.location.href='{{ route('ormawa.index') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>