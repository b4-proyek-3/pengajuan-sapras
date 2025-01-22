<div class="modal fade overflow-y-auto" id="editPengajuModal" tabindex="-1" aria-labelledby="editPengajuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPengajuModalLabel">Form Edit Pengaju</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', $p->user->id_user) }}" method="POST" enctype="multipart/form-data" id="formID">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" value="{{ isset($p) ? $p->user->name : old('name') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ isset($p) ? $p->nim : old('nim') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_ormawa">Ormawa</label>
                        <select name="id_ormawa" id="id_ormawa" class="form-control" required>
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
                        <input type="email" name="email" id="email" value="{{ isset($p) ? $p->user->email : old('email') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div id="passwordError" class="text-danger" style="display: none;">Password harus terdiri dari minimal 8 karakter.</div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            onclick="window.location.href='{{ route('users.index') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

