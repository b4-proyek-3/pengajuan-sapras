<!-- Modal Edit gedung -->
@if(isset($g))
<div class="modal fade overflow-y-auto" id="gedungEditModal" tabindex="-1" aria-labelledby="gedungEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gedungEditModalLabel">Edit Gedung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit gedung -->
                <form action="{{ route('gedung.update', $g->id_gedung) }}" method="POST" enctype="multipart/form-data" id="editgedungForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_gedung" class="form-label">Nama Gedung</label>
                        <input type="text" name="nama_gedung" id="nama_gedung"
                            value="{{ $g->nama_gedung }}"
                            class="form-control">
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
@endif
