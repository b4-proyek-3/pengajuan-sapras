<div id="upload-Modal" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="rounded-lg shadow-xl bg-white flex flex-col w-3/4 md:w-1/2 lg:w-1/3 p-6 relative">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-2 mb-4">
            <h2 class="text-xl font-bold">Unggah Dokumen</h2>
            <button class="text-gray-500 text-xl" onclick="closeModal()">&times;</button>
        </div>

        <!-- Content -->
        <form action="{{ route('updatedokumen', $dokumen[0]->id_pengajuan ?? '') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <input type="hidden" id="removedFiles" name="removed_files" value="[]">
            <input type="file" id="fileInput" name="files[]" class="hidden" accept=".pdf" multiple />

            <div class="flex space-x-4">
                <!-- Drag and Drop Area -->
                <div id="dropZone" class="border-2 border-dashed border-orange-400 h-[180px] w-1/2 flex flex-col items-center justify-center bg-gray-50">
                    <p class="text-orange-500 font-semibold">Tarik files ke sini</p>
                    <p class="text-gray-500 my-1">Atau</p>
                    <input type="file" id="fileInput" name="files[]" class="hidden" accept=".pdf" multiple />
                    <button type="button" class="text-orange-600 underline" onclick="document.getElementById('fileInput').click();">Jelajahi</button>
                </div>

                <!-- File List -->
                <div id="fileListContainer" class="w-1/2">
                    <ul id="fileList">
                        @if($dokumen->isEmpty())
                            <p class="text-gray-500">Tidak ada dokumen yang tersedia.</p>
                        @else
                            @foreach($dokumen as $row)
                                <li class="flex justify-between items-center p-2">
                                    <img src="/assets/img/pdf.png" alt="PDF Icon" class="w-6 h-6 mr-2">
                                    <span class="text-xs mr-2 flex-shrink-0">{{ $row->nama_dokumen }}</span>
                                    <button type="button" class="text-red-500" onclick="removeFile(this, '{{ $row->id }}')">&times;</button>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" class="btn-orange" onclick="resetFiles(); closeModal();">Batalkan</button>
                <button type="submit" class="btn-blue">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDokumenModal() {
        document.getElementById('upload-Modal').classList.remove('hidden');
    }

    function closeDokumenModal() {
        document.getElementById('upload-Modal').classList.add('hidden');
    }
</script>