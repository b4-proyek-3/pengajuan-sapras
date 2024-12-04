<div id="editDokumenModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center overflow-y-auto">
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
            
            <div class="mb-3" id="program_kerja_files" style="display: none;">
                <label for="dokumen1" class="form-label">Proposal</label>
                <input type="file" name="dokumen1" id="dokumen1" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="pergerakan_files" style="display: none;">
                <label for="dokumen2" class="form-label">Term of Reference</label>
                <input type="file" name="dokumen2" id="dokumen2" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3">
                <label for="dokumen3" class="form-label">Surat Peminjaman Sarana Prasarana</label>
                <input type="file" name="dokumen3" id="dokumen3" class="form-control" accept=".pdf">
            </div>
            <div class="mb-3">
                <label for="dokumen4" class="form-label">Surat Izin Berkegiatan</label>
                <input type="file" name="dokumen4" id="dokumen4" class="form-control" accept=".pdf">
            </div>
            <div class="mb-3">
                <label for="dokumen5" class="form-label">Surat Pernyataan Ketua Ormawa</label>
                <input type="file" name="dokumen5" id="dokumen5" class="form-control" accept=".pdf">
            </div>
            <div class="mb-3">
                <label for="dokumen6" class="form-label">Surat Pendampingan Pembina</label>
                <input type="file" name="dokumen6" id="dokumen6" class="form-control" accept=".pdf">
            </div>
            <div class="mb-3">
                <label for="dokumen7" class="form-label">Lampiran Daftar Peserta</label>
                <input type="file" name="dokumen7" id="dokumen7" class="form-control" accept=".pdf">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-tl from-blue-600 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none">
                    update
                </button>
                <button type="button" class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none ml-2" onclick="closeDokumenModal()">
                    batal
                </button>
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>

<script>
    function showFilesForJenisKegiatan(jenisKegiatan) {
        document.getElementById('program_kerja_files').style.display = 'none';
        document.getElementById('pergerakan_files').style.display = 'none';
        
        if (jenisKegiatan === 'proker') {
            document.getElementById('program_kerja_files').style.display = 'block';
        } else if (jenisKegiatan === 'pergerakan') {
            document.getElementById('pergerakan_files').style.display = 'block';
        } else {
            document.getElementById('program_kerja_files').style.display = 'none';
            document.getElementById('pergerakan_files').style.display = 'none';
        }
    }

    function openDokumenModal() {
        document.getElementById('editDokumenModal').classList.remove('hidden');
        const jenisKegiatan = "{{ $pengajuans->jenis_kegiatan }}";  // Pastikan ini terisi dengan benar
        showFilesForJenisKegiatan(jenisKegiatan);
    }

    function closeDokumenModal() {
        document.getElementById('editDokumenModal').classList.add('hidden');
    }
</script>
