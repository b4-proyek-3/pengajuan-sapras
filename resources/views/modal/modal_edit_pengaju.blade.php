<div class="modal fade overflow-y-auto" id="editPengajuModal" tabindex="-1" aria-labelledby="editPengajuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPengajuModalLabel">Form Edit Pengaju</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', '__ID__') }}" method="POST" enctype="multipart/form-data" class="form-class" id="formEditPengaju">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="id_ormawa">Ormawa</label>
                        <select name="id_ormawa" id="id_ormawa" class="form-control">
                            <option value=""> Pilih Ormawa </option>
                            @foreach($ormawa as $o)
                                <option value="{{ $o->id_ormawa }}"
                                    {{ isset($p) && $p->id_ormawa == $o->id_ormawa ? 'selected' : '' }}>
                                    {{ $o->nama_ormawa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div id="passwordError" class="password-error" style="display: none;">Password harus terdiri dari minimal 8 karakter.</div>
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

