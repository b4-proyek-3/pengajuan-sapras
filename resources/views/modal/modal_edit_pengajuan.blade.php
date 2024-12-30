<div id="editPengajuanModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center overflow-y-auto">
  <div class="relative w-full h-auto max-h-screen p-4 rounded-lg z-100">
    <div class="fixed inset-0 bg-gray-800 opacity-50"></div>
    <!-- Modal Content -->
    <div class="relative p-2 w-full max-w-lg mx-auto z-100">
      <div class="relative bg-white text-gray-900 rounded-lg">
        <!-- Header Modal -->
        <div class="flex items-center justify-between p-3 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900">Edit Pengajuan</h3>
        </div>
        <!-- Modal body -->
        <div class="p-3 -mt-2">
          <form class="space-y-2" action="{{ route('pengajuan.update', $pengajuans->id_pengajuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
              <label for="nama-pengaju" class="block text-sm font-medium text-gray-900">Nama Pengaju</label>
              <input id="nama-pengaju" value="{{ $pengajuans->pengaju->user->name }}" 
                class="form-control"
                readonly />
            </div>
            <div class="flex flex-col">
              <label for="ormawa" class="block text-sm font-medium text-gray-900">Ormawa</label>
              <input id="ormawa" value="{{ $pengajuans->pengaju->ormawa->nama_ormawa }}" 
                class="form-control"
                readonly />
            </div>
            <div class="flex flex-col">
                <label for="nama-kegiatan" class="block text-sm font-medium text-gray-900">Nama Kegiatan</label>
                <input type="text" id="nama-kegiatan" name="nama_kegiatan" value="{{ $pengajuans->nama_kegiatan }}" 
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Tanggal Kegiatan</label>
                <input type="date" id="tanggal-kegiatan" name ="tanggal_pinjam" value="{{ $pengajuans->tanggal_pinjam }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Tanggal Berakhir</label>
                <input type="date" id="tanggal-akhir" name ="tanggal_akhir" value="{{ $pengajuans->tanggal_akhir }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="tanggal-kegiatan" class="block text-sm font-medium text-gray-900">Waktu Kegiatan</label>
                <input type="time" id="waktu-kegiatan" name ="waktu_pengajuan" value="{{ $pengajuans->waktu_pinjam }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <!-- Label hanya muncul sekali -->
                <label for="tempat-kegiatan" class="block text-sm font-medium text-gray-900">Tempat Kegiatan</label>
            </div>
            <div id="form-container">
                <!-- Form input yang sudah ada dari database -->
                @foreach ($pengajuans->ruangan as $ruangan)
                    <div class="flex flex-col mb-2">
                        <select name="ruangan[]" class="form-control">
                            <option value="">Pilih Tempat</option>
                            @foreach ($tempatList as $tempat)
                                <option value="{{ $tempat->id_ruangan }}"
                                    {{ $tempat->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                    {{ $tempat->nama_ruangan }}, {{ $tempat->gedung->nama_gedung }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="button-group flex space-x-2">
                <!-- Button untuk tambah form -->
                <button type="button" class="inline-flex items-center justify-center mb-2 px-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 btn-add"
                style="background-color: #22C55E !important;">
                    Tambah Tempat
                </button>

                <!-- Button untuk hapus form (akan muncul hanya jika ada lebih dari satu form input) -->
                <button type="button" class="inline-flex items-center justify-center mb-2 px-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-remove"
                style="background-color: #EF4444 !important;">
                    Hapus
                </button>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-tl from-blue-600 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none">
                    update
                </button>
                <button type="button" class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none ml-2" onclick="closePengajuanModal()">
                    batal
                </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formContainer = document.getElementById("form-container");
        const addButton = document.querySelector(".btn-add");
        const removeButton = document.querySelector(".btn-remove");

        // Fungsi untuk menambah form baru
        addButton.addEventListener("click", function() {
            // Clone form input pertama (form yang sudah ada)
            const firstForm = formContainer.querySelector('.flex.flex-col'); 
            const newForm = firstForm.cloneNode(true); 
            
            // Mengatur ulang value select pada form baru
            const selectElement = newForm.querySelector('select');
            selectElement.value = ''; // Mengosongkan pilihan
            
            // Menambahkan pilihan default "Pilih Tempat"
            const defaultOption = newForm.querySelector('option');
            defaultOption.selected = true;

            // Menambahkan form baru ke dalam container
            formContainer.appendChild(newForm);

            // Menampilkan tombol "Hapus" jika ada lebih dari satu form
            updateRemoveButtonVisibility();
        });

        // Fungsi untuk menampilkan atau menyembunyikan tombol "Hapus"
        function updateRemoveButtonVisibility() {
            const formInputs = formContainer.querySelectorAll('.flex.flex-col');
            if (formInputs.length > 1) {
                removeButton.style.display = "inline-flex"; // Menampilkan tombol Hapus
            } else {
                removeButton.style.display = "none"; // Menyembunyikan tombol Hapus jika hanya ada satu form
            }
        }

        // Tombol "Hapus" untuk menghapus form yang terakhir ditambahkan
        removeButton.addEventListener("click", function() {
            const lastForm = formContainer.querySelector('.flex.flex-col:last-child');
            if (lastForm) {
                lastForm.remove(); // Menghapus form yang terakhir ditambahkan
            }
            updateRemoveButtonVisibility(); // Update visibilitas tombol "Hapus"
        });

        updateRemoveButtonVisibility();
    });

    function openPengajuanModal() {
        document.getElementById('editPengajuanModal').classList.remove('hidden');
    }

    function closePengajuanModal() {
        document.getElementById('editPengajuanModal').classList.add('hidden');
    }
</script>