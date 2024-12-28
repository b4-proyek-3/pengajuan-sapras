<!-- Modal -->
<div class="modal fade overflow-y-auto" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanModalLabel">Form Pengajuan Sarana dan Prasarana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_akhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="waktu" class="form-label">Waktu Kegiatan</label>
                            <input type="time" name="waktu_pinjam" id="waktu_pinjam" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="ruangan" class="form-label">Tempat</label>
                            <select name="ruangan[]" id="ruangan" class="form-control" required>
                                <option value=""> Pilih Tempat </option>
                                @foreach($tempatList as $tempat)
                                    <option value="{{ $tempat->id_ruangan }}">{{ $tempat->nama_ruangan }}, {{ $tempat->gedung->nama_gedung }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="activity_type" class="form-label">Jenis Kegiatan</label>
                            <select name="activity_type" id="activity_type" class="form-control" required onchange="showFileInputs()">
                                <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                                <option value="proker">Program Kerja</option>
                                <option value="pergerakan">Pergerakan</option>
                            </select>
                            <p class="text-gray-500 text-sm mt-1">File maksimal 2 MB</p>
                        </div>

                        <!-- File upload field khusus untuk Program Kerja (Proposal) -->
                        <div id="program_kerja_files" style="display: none;">
                            <div class="mb-3">
                                <label for="dokumen1" class="form-label">Proposal</label>
                                <input type="file" name="dokumen1" id="dokumen1" class="form-control" accept=".pdf">
                            </div>
                        </div>

                        <!-- File upload field khusus untuk Pergerakan (Term of Reference) -->
                        <div id="pergerakan_files" style="display: none;">
                            <div class="mb-3">
                                <label for="dokumen2" class="form-label">Term of Reference</label>
                                <input type="file" name="dokumen2" id="dokumen2" class="form-control" accept=".pdf">
                            </div>
                        </div>

                        <!-- File upload fields yang sama untuk kedua jenis kegiatan -->
                        <div id="common_files" style="display: none;">
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
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link Surat Izin Orang Tua</label>
                            <input type="url" name="link_gdrive" id="link_gdrive" class="form-control" placeholder="https://drive.google.com/drive/folders/surat_izin_orang_tua">
                        </div>

                        <div class="flex justify-center mt-6 space-x-4">
                            <button type="submit"
                                class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                style="background-color: #2563eb !important;">Simpan</button>
                            <button type="button"
                                class="bg-gray-600 text-white py-2 px-6 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                onclick="window.location.href='{{ route('pengajuan.index') }}'">Batal</button>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const namaKegiatanInput = document.getElementById("nama_kegiatan");

        namaKegiatanInput.addEventListener("input", function () {
            const maxLength = 100; // Batas maksimal karakter
            const errorMessage = document.getElementById("error_nama_kegiatan");

            if (namaKegiatanInput.value.length > maxLength) {
                if (!errorMessage) {
                    const errorDiv = document.createElement("div");
                    errorDiv.id = "error_nama_kegiatan";
                    errorDiv.style.color = "red";
                    errorDiv.textContent = "Nama kegiatan tidak boleh lebih dari 100 karakter.";
                    namaKegiatanInput.parentNode.appendChild(errorDiv);
                }
            } else {
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const alertMessage = "{{ session('alert') }}";
        if (alertMessage) {
            alert(alertMessage);
        }
    });

    function checkFileSize(inputId) {
        const input = document.getElementById(inputId);
        input.addEventListener("change", function () {
            const file = input.files[0];
            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert("File yang diunggah tidak boleh lebih dari 2MB!");
                    input.value = "";
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        checkFileSize("dokumen1");
        checkFileSize("dokumen2");
        checkFileSize("dokumen3");
        checkFileSize("dokumen4");
        checkFileSize("dokumen5");
        checkFileSize("dokumen6");
        checkFileSize("dokumen7");
    });

    function showFileInputs() {
        const activityType = document.getElementById("activity_type").value;
        const programKerjaFiles = document.getElementById("program_kerja_files");
        const pergerakanFiles = document.getElementById("pergerakan_files");
        const commonFiles = document.getElementById("common_files");

        // Reset display styles
        programKerjaFiles.style.display = "none";
        pergerakanFiles.style.display = "none";
        commonFiles.style.display = "block";

        if (activityType === "proker") {
            programKerjaFiles.style.display = "block";
        } else if (activityType === "pergerakan") {
            pergerakanFiles.style.display = "block";
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        showFileInputs();
    });
    
</script>