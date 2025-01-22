<div class="modal fade overflow-y-auto" id="editReviewerModal" tabindex="-1" aria-labelledby="editReviewerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewerModalLabel">Form Edit Reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', $r->user->id_user) }}" method="POST" enctype="multipart/form-data" id="formId2">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" value="{{ isset($r) ? $r->user->name : old('name') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <option value="sekum-bem" {{ $r->role == 'sekum-bem' ? 'selected' : '' }}>BEM</option>
                            <option value="kli" {{ $r->role == 'kli' ? 'selected' : '' }}>KLI</option>
                            <option value="wd-3" {{ $r->role == 'wd-3' ? 'selected' : '' }}>WD3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ isset($r) ? $r->user->email : old('email') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div id="passwordError3" class="text-danger" style="display: none;">Password harus terdiri dari minimal 8 karakter.</div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="background-color: #2563eb !important;">Simpan</button>
                        <button type="button"
                            class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                            onclick="window.location.href='{{ url('/users?active_tab=reviewer') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('formId2').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var passwordError = document.getElementById('passwordError3');

        // Cek apakah password panjangnya kurang dari 8 karakter
        if (password.length < 8) {
            event.preventDefault(); // Mencegah form dari pengiriman
            passwordError.style.display = 'block'; // Menampilkan pesan error
        } else {
            passwordError.style.display = 'none'; // Menyembunyikan pesan error jika valid
        }
    });
</script>
