<div id="editDokumenModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center overflow-y-auto">
  <div class="relative w-full h-auto max-h-screen p-4 rounded-lg z-100">
    <div class="fixed inset-0 bg-gray-800 opacity-50"></div>
    <!-- Modal Content -->
    <div class="relative p-2 w-full max-w-lg mx-auto z-100">
      <div class="relative bg-white text-gray-900 rounded-lg">
        <!-- Header Modal -->
        <div class="flex items-center justify-between p-3 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900">Edit Dokumen</h3>
        </div>
        <!-- Modal body -->
        <div class="p-3 -mt-2">
          <form class="space-y-2" action="{{ route('dokumen.update', $pengajuans->id_pengajuan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- File upload selection checkboxes -->
            <div class="mb-3">
              <label class="form-label">Pilih Dokumen yang akan diupdate:</label>
              <div style="display:none;" id="dokumen1-ch">
                <input type="checkbox" id="dokumen1-checkbox" name="dokumen1_checkbox" onclick="toggleFileInput('dokumen1')"> Proposal
              </div>
              <div  style="display:none;" id="dokumen2-ch">
                <input type="checkbox" id="dokumen2-checkbox" name="dokumen2_checkbox" onclick="toggleFileInput('dokumen2')"> Term of Reference
              </div>
              <div>
                <input type="checkbox" id="dokumen3-checkbox" name="dokumen3_checkbox" onclick="toggleFileInput('dokumen3')"> Surat Peminjaman Sarana Prasarana
              </div>
              <div>
                <input type="checkbox" id="dokumen4-checkbox" name="dokumen4_checkbox" onclick="toggleFileInput('dokumen4')"> Surat Izin Berkegiatan
              </div>
              <div>
                <input type="checkbox" id="dokumen5-checkbox" name="dokumen5_checkbox" onclick="toggleFileInput('dokumen5')"> Surat Pernyataan Ketua Ormawa
              </div>
              <div>
                <input type="checkbox" id="dokumen6-checkbox" name="dokumen6_checkbox" onclick="toggleFileInput('dokumen6')"> Surat Pendampingan Pembina
              </div>
              <div>
                <input type="checkbox" id="dokumen7-checkbox" name="dokumen7_checkbox" onclick="toggleFileInput('dokumen7')"> Lampiran Daftar Peserta
              </div>
            </div>

            <!-- File input fields -->
            <div class="mb-3" id="dokumen1" style="display:none;">
              <label for="dokumen1" class="form-label">Proposal</label>
              <input type="file" name="dokumen1" id="dokumen1-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen2" style="display:none;">
              <label for="dokumen2" class="form-label">Term of Reference</label>
              <input type="file" name="dokumen2" id="dokumen2-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen3" style="display:none;">
              <label for="dokumen3" class="form-label">Surat Peminjaman Sarana Prasarana</label>
              <input type="file" name="dokumen3" id="dokumen3-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen4" style="display:none;">
              <label for="dokumen4" class="form-label">Surat Izin Berkegiatan</label>
              <input type="file" name="dokumen4" id="dokumen4-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen5" style="display:none;">
              <label for="dokumen5" class="form-label">Surat Pernyataan Ketua Ormawa</label>
              <input type="file" name="dokumen5" id="dokumen5-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen6" style="display:none;">
              <label for="dokumen6" class="form-label">Surat Pendampingan Pembina</label>
              <input type="file" name="dokumen6" id="dokumen6-input" class="form-control" accept=".pdf">
            </div>

            <div class="mb-3" id="dokumen7" style="display:none;">
              <label for="dokumen7" class="form-label">Lampiran Daftar Peserta</label>
              <input type="file" name="dokumen7" id="dokumen7-input" class="form-control" accept=".pdf">
            </div>

            <div class="flex justify-end">
              <button type="submit" class="bg-gradient-to-tl from-blue-600 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none">
                Update
              </button>
              <button type="button" class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none ml-2" onclick="closeDokumenModal()">
                Batal
              </button>
            </div>
          </form>
        </div>  
      </div>
    </div>
  </div>
</div>

<script>
  function toggleFileInput(docId) {
    const checkbox = document.getElementById(docId + '-checkbox');
    const fileInput = document.getElementById(docId);

    if (checkbox.checked) {
      fileInput.style.display = 'block';
    } else {
      fileInput.style.display = 'none';
    }
  }

  function showFilesForJenisKegiatan(jenisKegiatan) {
      const dokumen1Checkbox = document.getElementById('dokumen1-ch');
      const dokumen2Checkbox = document.getElementById('dokumen2-ch');
      const dokumen3Checkbox = document.getElementById('dokumen3-checkbox');
      // Reset semua visibility
      dokumen1Checkbox.style.display = 'none';
      dokumen2Checkbox.style.display = 'none';

      // Atur visibility berdasarkan jenis kegiatan
      if (jenisKegiatan === 'proker') {
          dokumen1Checkbox.style.display = 'block';
      } else if (jenisKegiatan === 'pergerakan') {
          dokumen2Checkbox.style.display = 'block';
      }
  }

  function openDokumenModal() {
    document.getElementById('editDokumenModal').classList.remove('hidden');
    const jenisKegiatan = "{{ $pengajuans->jenis_kegiatan }}"; 
    showFilesForJenisKegiatan(jenisKegiatan);
  }

  function closeDokumenModal() {
    document.getElementById('editDokumenModal').classList.add('hidden');
  }
</script>
