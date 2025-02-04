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
                            <!-- Form-item pertama -->
                            <div class="form-item border-b mb-3">
                                <label for="ruangan" class="form-label">Tempat</label>
                                <div class="mb-3">
                                    <select name="ruangan[]" id="ruangan" class="form-control tempat-dropdown" required onchange="onRoomChange(this)">
                                        <option value="">Pilih Tempat</option>
                                        @foreach($tempatList as $tempat)
                                            <option value="{{ $tempat->id_ruangan }}">
                                                {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Tambah Tempat -->
                        <div id="add-place-btn-container" class="mb-3">
                            <button type="button"
                                class="inline-flex items-center justify-center px-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                id="add-place-btn"
                                style="background-color: #22C55E !important;"
                                onclick="addRoom()">
                                Tambah Tempat
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="activity_type" class="form-label">Jenis Kegiatan</label>
                            <select name="activity_type" id="activity_type" class="form-control" required onchange="showFileInputs()">
                                <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                                <option value="proker">Program Kerja</option>
                                <option value="pergerakan">Pergerakan</option>
                                <option value="latihan_rutin">Latihan Rutin</option>
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
                                data-bs-dismiss="modal">Batal</button>
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
    const weekdayTimes = generateTimeOptions("07:30", "20:00", 30);
    const weekendTimes = generateTimeOptions("07:30", "17:00", 30);

    function generateTimeOptions(start, end, interval) {
      const startTime = parseTime(start);
      const endTime = parseTime(end);
      const times = [];

      for (let time = startTime; time <= endTime; time.setMinutes(time.getMinutes() + interval)) {
        times.push(formatTime(time));
      }

      return times;
    }

    function parseTime(timeStr) {
      const [hours, minutes] = timeStr.split(":").map(Number);
      return new Date(0, 0, 0, hours, minutes);
    }

    function formatTime(date) {
      return `${date.getHours().toString().padStart(2, "0")}:${date.getMinutes().toString().padStart(2, "0")}`;
    }

    function addRoom() {
        const container = document.getElementById("form-container");
        const newForm = document.createElement("div");

        newForm.classList.add("form-item", "border-b", "mb-3");
        newForm.innerHTML = `
        <label for="ruangan" class="form-label">Tempat</label>
            <div class="mb-3">
                <select name="ruangan[]" id="ruangan" class="form-control tempat-dropdown" required onchange="onRoomChange(this)">
                    <option value="">Pilih Tempat</option>
                    @foreach($tempatList as $tempat)
                        <option value="{{ $tempat->id_ruangan }}">
                            {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="remove-btn-container mb-3">
                <button type="button"
                class="inline-flex items-center justify-center ml-1 px-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-remove" 
                onclick="removeRoom(this)"
                style="background-color: #EF4444 !important;">
                    Hapus
                </button>
            </div>
        `;
        container.appendChild(newForm);

        // Pindahkan tombol "Tambah Tempat" ke bawah form-item terakhir
        const addPlaceBtnContainer = document.getElementById("add-place-btn-container");
        container.appendChild(addPlaceBtnContainer);
        moveRemoveButtonToLast(newForm);
    }

    function removeRoom(button) {
        const formItem = button.closest(".form-item");
        formItem.remove();

        const container = document.getElementById("form-container");
        const addPlaceBtnContainer = document.getElementById("add-place-btn-container");
        container.appendChild(addPlaceBtnContainer);
    }

    function moveRemoveButtonToLast(formItem) {
        const removeButtonContainer = formItem.querySelector(".remove-btn-container");
        const lastInput = formItem.querySelector("select, input, textarea");

        // Pindahkan tombol hapus ke bawah elemen input terakhir
        if (lastInput) {
            formItem.appendChild(removeButtonContainer);
        }
    }

    // Fungsi untuk mengambil daftar tanggal yang dinonaktifkan dari server
    async function fetchDisabledDates(callback) {
        try {
            const response = await fetch("/get-disabled-dates");
            const disabledDates = await response.json();
            callback(disabledDates);
        } catch (error) {
            console.error("Error fetching disabled dates:", error);
        }
    }

    function applyFlatpickr(disabledDates) {
        document.querySelectorAll(".tanggal-input").forEach(input => {
            flatpickr(input, {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: disabledDates
            });
        });
    }

    // Fungsi untuk menangani perubahan pada dropdown ruangan
    function onRoomChange(select) {
        const formItem = select.closest(".form-item");

        // Cek apakah input form sudah ada, jika belum, tambahkan
        if (select.value && !formItem.querySelector(".dynamic-fields")) {
            const dynamicFields = document.createElement("div");
            dynamicFields.classList.add("dynamic-fields");

            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label class="block text-gray-700 mb-2">Tanggal Peminjaman</label>
                    <input type="text" name="tanggal_mulai[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 mb-2">Tanggal Berakhir</label>
                    <input type="text" name="tanggal_akhir[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 mb-2">Waktu Mulai Kegiatan</label>
                    <select name="waktu_mulai[]" class="form-control" required>
                        ${weekdayTimes.map(time => `<option value="${time}">${time}</option>`).join("")}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 mb-2">Waktu Selesai Kegiatan</label>
                    <select name="waktu_akhir[]" class="form-control" required>
                        ${weekdayTimes.map(time => `<option value="${time}">${time}</option>`).join("")}
                    </select>
                </div>
            `;

            fetchDisabledDates(applyFlatpickr);
            formItem.appendChild(dynamicFields);
            moveRemoveButtonToLast(formItem);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const namaKegiatanInput = document.getElementById("nama_kegiatan");

        namaKegiatanInput.addEventListener("input", function () {
            const maxLength = 100; 
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
        const dokumen1 = document.getElementById("dokumen1");
        const dokumen2 = document.getElementById("dokumen2");
        const dokumen3 = document.getElementById("dokumen3");
        const dokumen4 = document.getElementById("dokumen4");
        const dokumen5 = document.getElementById("dokumen5");

        // Reset display styles and remove required attribute
        programKerjaFiles.style.display = "none";
        pergerakanFiles.style.display = "none";
        commonFiles.style.display = "none";

        dokumen1.removeAttribute("required");
        dokumen2.removeAttribute("required");
        dokumen3.removeAttribute("required");
        dokumen4.removeAttribute("required");
        dokumen5.removeAttribute("required");

        // Show relevant file inputs and set required attributes
        if (activityType === "proker") {
            programKerjaFiles.style.display = "block";
            commonFiles.style.display = "block";
            dokumen1.setAttribute("required", "true");
            dokumen3.setAttribute("required", "true");
            dokumen4.setAttribute("required", "true");
            dokumen5.setAttribute("required", "true");
        } else if (activityType === "pergerakan") {
            pergerakanFiles.style.display = "block";
            commonFiles.style.display = "block";
            dokumen2.setAttribute("required", "true");
            dokumen3.setAttribute("required", "true");
            dokumen4.setAttribute("required", "true");
            dokumen5.setAttribute("required", "true");
        } else if (activityType === "latihan_rutin") {
            pergerakanFiles.style.display = "block";
            dokumen2.setAttribute("required", "true");
        }
    }

    // Call on page load to handle any default state
    document.addEventListener("DOMContentLoaded", function () {
        showFileInputs();
    });
    
</script>