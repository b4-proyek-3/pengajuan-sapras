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
                            <label for="nama_ketuplak" class="form-label">Nama Ketuplak</label>
                            <input type="text" name="nama_ketuplak" id="nama_ketuplak" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="notelp" class="form-label">Nomor Telepon</label>
                            <input type="text" name="notelp" id="notelp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control" required>
                        </div>

                        <div id="form-container">
                            <label for="ruangan" class="form-label">Tempat</label>
                            <div class="mb-3">
                                <select name="ruangan[]" id="ruangan" class="form-control tempat-dropdown" required>
                                    <option value="">Pilih Tempat</option>
                                    @foreach($tempatList as $tempat)
                                        <option value="{{ $tempat->id_ruangan }}">
                                            {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Elemen untuk Tanggal dan Waktu -->
                        <div id="time-date-container" class="hidden">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_mulai[]" id="tanggal_mulai" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Berakhir</label>
                                <input type="date" name="tanggal_akhir[]" id="tanggal_akhir" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai Kegiatan</label>
                                <select name="waktu_mulai[]" id="waktu_mulai" class="form-control" required></select>
                            </div>

                            <div class="mb-3">
                                <label for="waktu_akhir" class="form-label">Waktu Selesai Kegiatan</label>
                                <select name="waktu_akhir[]" id="waktu_akhir" class="form-control" required></select>
                            </div>
                        </div>

                        <!-- Tombol Tambah Tempat -->
                        <div class="button-group">
                            <button type="button"
                                class="inline-flex items-center justify-center mb-2 px-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 btn-add"
                                id="add-place-btn"
                                style="background-color: #22C55E !important;">
                                Tambah Tempat
                            </button>
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

                        <div id="program_kerja_files" style="display: none;">
                            <div class="mb-3">
                                <label for="dokumen1" class="form-label">Proposal</label>
                                <input type="file" name="dokumen1" id="dokumen1" class="form-control"
                                    accept=".pdf">
                            </div>
                        </div>

                        <div id="pergerakan_files" style="display: none;">
                            <div class="mb-3">
                                <label for="dokumen2" class="form-label">Term of Reference</label>
                                <input type="file" name="dokumen2" id="dokumen2" class="form-control"
                                    accept=".pdf">
                            </div>
                        </div>

                        <div id="common_files" style="display: none;">
                            <div class="mb-3">
                                <label for="dokumen3" class="form-label">Surat Peminjaman Sarana
                                    Prasarana</label>
                                <input type="file" name="dokumen3" id="dokumen3" class="form-control"
                                    accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen4" class="form-label">Lembar Pengesahan Kegiatan</label>
                                <input type="file" name="dokumen4" id="dokumen4" class="form-control"
                                    accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen5" class="form-label">Lampiran Daftar Peserta</label>
                                <input type="file" name="dokumen5" id="dokumen5" class="form-control"
                                    accept=".pdf">
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
    document.addEventListener("DOMContentLoaded", () => {
        const formContainer = document.getElementById("form-container");
        const buttonGroup = document.querySelector(".button-group");
        const timeDateContainer = document.getElementById("time-date-container");
        const addPlaceButton = document.getElementById("add-place-btn");

        // Menyimpan ruangan yang sudah dipilih
        let selectedRooms = [];

        // Fungsi untuk memperbarui tombol (tambah/hapus)
        function updateButtons() {
            const formInputs = formContainer.querySelectorAll(".form-row");
            const addButton = buttonGroup.querySelector(".btn-add");
            let removeButton = buttonGroup.querySelector(".btn-remove");

            if (formInputs.length > 1) {
                if (!removeButton) {
                    removeButton = document.createElement("button");
                    removeButton.type = "button";
                    removeButton.textContent = "Hapus";
                    removeButton.className =
                        "inline-flex items-center justify-center ml-1 px-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-remove";
                    removeButton.addEventListener("click", () => {
                        const lastForm = formContainer.lastElementChild;
                        const select = lastForm.querySelector("select");
                        const value = select.value;

                        if (value) {
                            const idx = selectedRooms.indexOf(value);
                            if (idx > -1) {
                                selectedRooms.splice(idx, 1);
                            }
                        }

                        lastForm.remove();
                        updateButtons();
                        updateRoomOptions();
                    });
                    buttonGroup.appendChild(removeButton);
                }
            } else if (removeButton) {
                removeButton.remove();
            }
        }

        function updateRoomOptions() {
            const selects = formContainer.querySelectorAll("select");
            selects.forEach((select) => {
                const options = select.querySelectorAll("option");
                options.forEach((option) => {
                    const roomId = option.value;
                    if (selectedRooms.includes(roomId) && select.value !== roomId) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        function createFormRow() {
            const formRow = document.createElement("div");
            formRow.className = "mb-3";

            const template = `
                <select name="ruangan[]" class="form-control tempat-dropdown" required>
                    <option value="">Pilih Tempat</option>
                    @foreach($tempatList as $tempat)
                        <option value="{{ $tempat->id_ruangan }}">
                            {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                        </option>
                    @endforeach
                </select>
            `;
            formRow.innerHTML = template;

            // Tambahkan form baru setelah "timeDateContainer"
            timeDateContainer.insertAdjacentElement("afterend", formRow);

            const tempatDropdown = formRow.querySelector(".tempat-dropdown");
                tempatDropdown.addEventListener("change", (event) => {
                    const selectedValue = event.target.value;
                    if (selectedValue) {
                        createTimeDateForm(formRow);
                    } else {
                        // Hapus form Tanggal dan Waktu jika pilihan kosong
                        const existingTimeDateForm = formRow.querySelector(".time-date-container");
                        if (existingTimeDateForm) {
                            existingTimeDateForm.remove();
                        }
                    }
            });
        }

        function createTimeDateForm(parentRow) {
            // Periksa apakah form Tanggal dan Waktu sudah ada
            const existingTimeDateForm = parentRow.querySelector(".time-date-container");
            if (existingTimeDateForm) return;

            const timeDateForm = document.createElement("div");
            timeDateForm.className = "mb-3";

            const template = `
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_mulai[]" id="tanggal_mulai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_akhir[]" id="tanggal_akhir" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai Kegiatan</label>
                    <select name="waktu_mulai[]" id="waktu_mulai" class="form-control" required></select>
                </div>

                <div class="mb-3">
                    <label for="waktu_akhir" class="form-label">Waktu Selesai Kegiatan</label>
                    <select name="waktu_akhir[]" id="waktu_akhir" class="form-control" required></select>
                </div>
            `;

            timeDateForm.innerHTML = template;
            parentRow.appendChild(timeDateForm);

            // Inisialisasi dropdown waktu
            const tanggalInput = timeDateForm.querySelector(".tanggal_mulai");
            const waktuMulaiDropdown = timeDateForm.querySelector(".waktu_mulai");
            const waktuAkhirDropdown = timeDateForm.querySelector(".waktu_akhir");

            tanggalInput.addEventListener("change", () => {
                const tanggal = new Date(tanggalInput.value);
                const isWeekend = tanggal.getDay() === 0 || tanggal.getDay() === 6;
                populateTimeDropdown(isWeekend, waktuMulaiDropdown, waktuAkhirDropdown);
            });

            // Isi dropdown waktu dengan default (weekday)
            populateTimeDropdown(false, waktuMulaiDropdown, waktuAkhirDropdown);
        }

        function populateTimeDropdown(isWeekend, waktuMulaiSelect, waktuAkhirSelect) {
            const options = generateTimeOptions(isWeekend);

            waktuMulaiSelect.innerHTML = "";
            waktuAkhirSelect.innerHTML = "";

            options.forEach((time) => {
                const optionStart = document.createElement("option");
                optionStart.value = time;
                optionStart.textContent = time;
                waktuMulaiSelect.appendChild(optionStart);

                const optionEnd = document.createElement("option");
                optionEnd.value = time;
                optionEnd.textContent = time;
                waktuAkhirSelect.appendChild(optionEnd);
            });
        }

        // Inisialisasi waktu dropdown
        const tanggalMulaiInput = document.getElementById("tanggal_mulai");
        const waktuMulaiSelect = document.getElementById("waktu_mulai");
        const waktuAkhirSelect = document.getElementById("waktu_akhir");

        function generateTimeOptions(isWeekend) {
            const startHour = 7;
            const startMinute = 30;
            const endHour = isWeekend ? 17 : 20;
            const options = [];

            for (let hour = startHour; hour <= endHour; hour++) {
                for (let minute of [0, 30]) {
                    if (hour === startHour && minute < startMinute) continue;
                    const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                    options.push(time);
                }
            }

            return options;
        }

        function populateTimeDropdown(isWeekend) {
            const options = generateTimeOptions(isWeekend);
            waktuMulaiSelect.innerHTML = "";
            waktuAkhirSelect.innerHTML = "";
            options.forEach((time) => {
                const optionStart = document.createElement("option");
                optionStart.value = time;
                optionStart.textContent = time;
                waktuMulaiSelect.appendChild(optionStart);

                const optionEnd = document.createElement("option");
                optionEnd.value = time;
                optionEnd.textContent = time;
                waktuAkhirSelect.appendChild(optionEnd);
            });
        }

        tanggalMulaiInput.addEventListener("change", () => {
            const tanggal = new Date(tanggalMulaiInput.value);
            const isWeekend = tanggal.getDay() === 0 || tanggal.getDay() === 6;
            populateTimeDropdown(isWeekend);
        });

        populateTimeDropdown(false);

        addPlaceButton.addEventListener("click", () => {
            createFormRow();
            updateButtons();
            updateRoomOptions();
        });

        formContainer.addEventListener("change", (event) => {
            if (event.target.tagName === "SELECT") {
                const select = event.target;
                const selectedValue = select.value;

                if (selectedValue) {
                    timeDateContainer.classList.remove("hidden");
                } else {
                    timeDateContainer.classList.add("hidden");
                }

                const previousValue = select.getAttribute("data-previous-value");

                if (previousValue) {
                    const idx = selectedRooms.indexOf(previousValue);
                    if (idx > -1) {
                        selectedRooms.splice(idx, 1);
                    }
                }

                if (selectedValue && !selectedRooms.includes(selectedValue)) {
                    selectedRooms.push(selectedValue);
                }

                select.setAttribute("data-previous-value", selectedValue);
                updateRoomOptions();
            }
        });
    });

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