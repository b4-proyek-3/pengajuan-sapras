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
                            <div id="notelp-error" class="text-danger mt-1" style="display: none;">Nomor telepon harus berupa angka dan minimal 10 digit!</div>
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
                <select name="ruangan[]" class="form-control tempat-dropdown" required onchange="onRoomChange(this)">
                    <option value="">Pilih Tempat</option>
                    @foreach($tempatList as $tempat)
                        <option value="{{ $tempat->id_ruangan }}">
                            {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="remove-btn-container mb-3">
                <button type="button" class="inline-flex items-center justify-center ml-1 px-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-remove" 
                onclick="removeRoom(this)"
                style="background-color: #EF4444 !important;">
                    Hapus
                </button>
            </div>
        `;

        container.appendChild(newForm);

        const addPlaceBtnContainer = document.getElementById("add-place-btn-container");
        container.appendChild(addPlaceBtnContainer);
        moveRemoveButtonToLast(newForm);

        // Otomatis inisialisasi Flatpickr saat form baru ditambahkan
        const selectElement = newForm.querySelector("select");
        onRoomChange(selectElement);
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

    function applyFlatpickr(formItem, data) {
        const disabledDates = data.disabledDates || [];
        const disabledTimes = data.disabledTimes || {};

        const tanggalInputs = formItem.querySelectorAll(".tanggal-input");
        const waktuMulaiSelects = formItem.querySelectorAll(".waktu-mulai");
        const waktuSelesaiSelects = formItem.querySelectorAll(".waktu-selesai");

        console.log("🚫 Tanggal yang dinonaktifkan:", disabledDates);

        // Inisialisasi Flatpickr untuk tanggal
        tanggalInputs.forEach(input => {
            if (input._flatpickr) {
                input._flatpickr.destroy();
            }
            flatpickr(input, {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: disabledDates, // Nonaktifkan tanggal penuh
                onChange: function (selectedDates, dateStr) {
                    console.log("📅 Tanggal dipilih:", dateStr);
                    applyTimeDropdown(waktuMulaiSelects, waktuSelesaiSelects, dateStr, disabledTimes);
                }
            });
        });

        // Jika ada tanggal pertama, isi dropdown waktu
        const firstDate = tanggalInputs[0]?.value;
        if (firstDate) {
            applyTimeDropdown(waktuMulaiSelects, waktuSelesaiSelects, firstDate, disabledTimes);
        }
    }

    // Fungsi untuk mengisi dropdown waktu berdasarkan tanggal yang dipilih
    function applyTimeDropdown(waktuMulaiSelects, waktuSelesaiSelects, selectedDate, disabledTimes) {
        if (!selectedDate) return;

        const blockedTimes = disabledTimes[selectedDate] || [];
        const dateObj = new Date(selectedDate);
        const isWeekend = dateObj.getDay() === 0 || dateObj.getDay() === 6;

        const fullSlot = isWeekend
            ? { from: "07:30", to: "17:00" } // Weekend
            : { from: "07:30", to: "20:00" }; // Weekday

        console.log(`📅 ${selectedDate} adalah ${isWeekend ? "WEEKEND" : "WEEKDAY"}`);
        console.log(`⏳ Waktu yang diblokir untuk ${selectedDate}:`, blockedTimes);

        // Generate slot waktu berdasarkan blokir
        let availableSlots = [{ ...fullSlot }];
        blockedTimes.forEach(({ mulai, akhir }) => {
            const start = mulai.slice(0, 5);
            const end = akhir.slice(0, 5);

            availableSlots = availableSlots.flatMap(slot => {
                if (end <= slot.from || start >= slot.to) return [slot];
                else if (start > slot.from && end < slot.to) return [{ from: slot.from, to: start }, { from: end, to: slot.to }];
                else if (start <= slot.from && end < slot.to) return [{ from: end, to: slot.to }];
                else if (start > slot.from && end >= slot.to) return [{ from: slot.from, to: start }];
                return [];
            });
        });

        console.log(`✅ Waktu yang bisa dipilih untuk ${selectedDate}:`, availableSlots);

        // Buat daftar waktu dalam interval 30 menit
        function generateTimeOptions(from, to) {
            let times = [];
            let currentTime = from;
            while (currentTime <= to) {
                times.push(currentTime);
                let [hours, minutes] = currentTime.split(":").map(Number);
                minutes += 30;
                if (minutes >= 60) {
                    minutes = 0;
                    hours += 1;
                }
                currentTime = `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
            }
            return times;
        }

        let availableTimes = [];
        availableSlots.forEach(slot => {
            availableTimes.push(...generateTimeOptions(slot.from, slot.to));
        });

        console.log("⏰ Pilihan waktu:", availableTimes);

        // Isi dropdown waktu mulai dan selesai
        function fillDropdown(selectElement, times) {
            selectElement.innerHTML = `<option value="">Pilih Waktu</option>`;
            times.forEach(time => {
                selectElement.innerHTML += `<option value="${time}">${time}</option>`;
            });
        }

        waktuMulaiSelects.forEach(select => fillDropdown(select, availableTimes));
        waktuSelesaiSelects.forEach(select => fillDropdown(select, availableTimes));
    }

    // Fungsi untuk menangani perubahan pada dropdown ruangan
    function onRoomChange(select) {
        const formItem = select.closest(".form-item");

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
                    <select name="waktu_mulai[]" class="form-control waktu-mulai" required>
                        <option value="">Pilih Waktu</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 mb-2">Waktu Selesai Kegiatan</label>
                    <select name="waktu_akhir[]" class="form-control waktu-selesai" required>
                        <option value="">Pilih Waktu</option>
                    </select>
                </div>
            `;

            formItem.appendChild(dynamicFields);
        }

    const roomId = select.value;
    if (!roomId) return;

    console.log(`Mengambil data disabled dates untuk ruangan ID: ${roomId}`);

    Promise.all([
        fetch(`/disabled-dates?id_ruangan=${roomId}`).then(res => res.json()),
        fetch(`/get-disabled-dates`).then(res => res.json())
    ])
    .then(([data1, data2]) => {
        console.log("Response dari /disabled-dates:", data1);
        console.log("Response dari /get-disabled-dates:", data2);

        // Gabungkan disabledDates dari kedua sumber
        const allDisabledDates = [
            ...new Set([...(data1.disabledDates || []), ...(data2 || [])])
            ];

            // Gunakan disabledTimes hanya dari /disabled-dates
            const allDisabledTimes = { ...data1.disabledTimes };

            applyFlatpickr(formItem, { disabledDates: allDisabledDates, disabledTimes: allDisabledTimes });
        })
        .catch(error => console.error("Error fetching disabled dates:", error));
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
            commonFiles.style.display = "block";
            dokumen2.setAttribute("required", "true");
            dokumen4.setAttribute("required", "true");
            dokumen3.style.display = "none";
            dokumen5.style.display = "none";
            document.getElementById("dokumen3").parentElement.style.display = "none";
            document.getElementById("dokumen5").parentElement.style.display = "none";
        }
    }

    // Call on page load to handle any default state
    document.addEventListener("DOMContentLoaded", function () {
        showFileInputs();
    });

    const notelpInput = document.getElementById('notelp');
    const errorDiv = document.getElementById('notelp-error');

    notelpInput.addEventListener('input', function () {
        const pattern = /^[0-9]{10,}$/; // Hanya angka, minimal 10 digit
        if (!pattern.test(notelpInput.value)) {
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });
    
</script>