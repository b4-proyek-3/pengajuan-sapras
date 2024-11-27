<div id="upload-Modal" class="hidden fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-3xl w-full">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">Upload Files</h3>
            <button onclick="closeDokumenModal()" class="text-gray-500 hover:text-black">
                &times;
            </button>
        </div>
        <hr class="my-4">
        <div class="grid sm:grid-cols-2 gap-12">
            <!-- File Upload Input -->
            <div for="uploadFile1" class="bg-gray-50 text-center px-4 rounded w-full h-80 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 border-dashed font-[sans-serif]">
                <div class="py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-2 fill-gray-600 inline-block" viewBox="0 0 32 32">
                        <path d="..." />
                        <path d="..." />
                    </svg>
                    <h4 class="text-base font-semibold text-gray-600">Drag and drop files here</h4>
                </div>
                <hr class="w-full border-gray-400 my-2" />
                <div class="py-6">
                    <input type="file" id="uploadFile1" class="hidden" onchange="tambahDokumen(this)" />
                    <label for="uploadFile1" class="block px-6 py-2.5 rounded text-gray-600 text-sm tracking-wider cursor-pointer font-semibold border-none outline-none bg-gray-200 hover:bg-gray-100">Browse Files</label>
                    <p class="text-xs text-gray-400 mt-4">PNG, JPG, SVG, WEBP, and GIF are allowed.</p>
                </div>
            </div>

            <!-- Dokumen List -->
            <div id="dokumen-list" class="space-y-8 mt-4">
                <div class="flex flex-col space-y-4">
                    @foreach($pengajuans->dokumen as $dokumen)
                        <div class="flex flex-col border border-gray-300 rounded-md p-2">
                            <div class="flex">
                                <p class="mt-2 text-sm text-gray-500 font-semibold flex-1">
                                    {{ $dokumen->nama_dokumen }} 
                                </p>
                                <!-- Tombol X untuk Menghapus Dokumen -->
                                <svg onclick="hapusDokumen('{{ $pengajuans->id_pengajuan }}', '{{ $dokumen->no_dokumen }}')" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    class="w-2 mr-2 cursor-pointer shrink-0 fill-black hover:fill-red-500"
                                    viewBox="0 0 320.591 320.591">
                                    <path d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"></path>
                                    <path d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"></path>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="simpanPerubahan()" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Simpan</button>
            <button onclick="closeDokumenModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
        </div>
    </div>
</div>

<script>
    let dokumenDihapus = []; // Untuk menyimpan dokumen yang dihapus sementara
    let dokumenDiupdate = []; // Untuk menyimpan dokumen yang ditambahkan atau diubah

    // Fungsi menambah atau memperbarui dokumen baru
    function tambahDokumen(input) {
        const file = input.files[0];
        const namaDokumen = 'dokumen' + (dokumenDiupdate.length + 1); // Berikan penamaan sesuai aturan
        dokumenDiupdate.push({ nama: namaDokumen, file });
        input.value = ''; // Reset input file setelah memilih dokumen
        updateDokumenList();
    }

    // Tandai dokumen untuk dihapus
    function tandaiDokumenDihapus(idDokumen, namaDokumen) {
        dokumenDihapus.push({ id: idDokumen, nama: namaDokumen });
        updateDokumenList();
    }

    // Fungsi untuk memperbarui tampilan daftar dokumen
    function updateDokumenList() {
        const listContainer = document.getElementById('dokumen-list');
        listContainer.innerHTML = '';

        dokumenDiupdate.forEach(doc => {
            listContainer.innerHTML += `
                <div class="flex flex-col border border-gray-300 rounded-md p-2">
                    <p class="mt-2 text-sm text-gray-500 font-semibold flex-1">
                        ${doc.nama}
                    </p>
                </div>`;
        });

        dokumenDihapus.forEach(doc => {
            listContainer.innerHTML += `
                <div class="flex flex-col border border-red-500 rounded-md p-2">
                    <p class="mt-2 text-sm text-red-500 font-semibold flex-1">
                        ${doc.nama} (Dihapus)
                    </p>
                </div>`;
        });
    }

    // Fungsi menyimpan perubahan dokumen
    function simpanPerubahan() {
        const formData = new FormData();
        formData.append('dokumenDihapus', JSON.stringify(dokumenDihapus));

        dokumenDiupdate.forEach((doc, index) => {
            formData.append(`dokumenBaru[${index}]`, doc.file);
            formData.append(`dokumenNama[${index}]`, doc.nama);
        });

        fetch('/pengajuan/simpan-dokumen', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert("Gagal menyimpan perubahan dokumen.");
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function openDokumenModal() {
        document.getElementById('upload-Modal').classList.remove('hidden');
    }

    function closeDokumenModal() {
        dokumenDihapus = [];
        dokumenDiupdate = [];
        updateDokumenList(); // Bersihkan tampilan list dokumen
        document.getElementById('upload-Modal').classList.add('hidden');
    }
</script>
