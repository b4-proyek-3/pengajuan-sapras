<div id="editPengajuanModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-100 flex justify-center items-center overflow-y-auto">
  <div class="relative w-full h-auto max-h-screen p-4 rounded-lg z-100">
    <div class="fixed inset-0 bg-gray-800 opacity-50 z-100"></div>
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
              <label for="nama_ketuplak" class="block text-sm font-medium text-gray-900">Nama Pengaju</label>
              <input id="nama_ketuplak" value="{{ $pengajuans->nama_ketuplak }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
              <label for="ormawa" class="block text-sm font-medium text-gray-900">Ormawa</label>
              <input id="ormawa" value="{{ $pengajuans->pengaju->ormawa->nama_ormawa }}"
                class="form-control"
                readonly />
            </div>
            <div class="flex flex-col">
                <label for="nomor-telepon" class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
                <input type="text" id="nomor-telepon" name="no_telp" value="{{ $pengajuans->notelp }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="nama-kegiatan" class="block text-sm font-medium text-gray-900">Nama Kegiatan</label>
                <input type="text" id="nama-kegiatan" name="nama_kegiatan" value="{{ $pengajuans->nama_kegiatan }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="jumlah-peserta" class="block text-sm font-medium text-gray-900">Jumlah Peserta</label>
                <input type="text" id="jumlah-peserta" name="jumlah_peserta" value="{{ $pengajuans->jumlah_peserta }}"
                class="form-control"/>
            </div>
            <div class="flex flex-col">
                <label for="link" class="block text-sm font-medium text-gray-900">Surat Izin Orang Tua</label>
                <input type="url" id="link_gdrive" name="link_gdrive" value="{{ $pengajuans->link_drive }}" placeholder="https://drive.google.com/drive/folders/surat_izin_orang_tua"
                class="form-control"/>
            </div>
            <div id="form-container">
                @foreach ($pengajuans->ruangan as $index => $ruangan)
                    <div class="form-item border-b mb-3">
                        <!-- Dropdown untuk memilih ruangan -->
                        <div class="mb-3">
                            <label for="ruangan" class="block text-sm font-medium text-gray-900">Tempat</label>
                            <select name="ruangan[]" class="form-control tempat-dropdown" onchange="onRoomChange(this)">
                                <option value="">Pilih Tempat</option>
                                @foreach ($tempatList as $tempat)
                                    <option value="{{ $tempat->id_ruangan }}"
                                        {{ $tempat->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                        {{ $tempat->nama_ruangan }} - {{ $tempat->gedung->nama_gedung }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input untuk tanggal dan waktu -->
                        <div class="dynamic-fields">
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-900">Tanggal Mulai</label>
                                <input type="text" name="tanggal_mulai[]" value="{{ $ruangan->pivot->tanggal_mulai }}" class="form-control tanggal-input">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-900">Tanggal Berakhir</label>
                                <input type="text" name="tanggal_akhir[]" value="{{ $ruangan->pivot->tanggal_akhir }}" class="form-control tanggal-input">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-900">Waktu Mulai Kegiatan</label>
                                <select name="waktu_mulai[]" class="form-control waktu-mulai" id="waktu_mulai_{{ $index }}" required>
                                    <option value="{{ $ruangan->pivot->waktu_mulai }}" selected>{{ $ruangan->pivot->waktu_mulai }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-900">Waktu Selesai Kegiatan</label>
                                <select name="waktu_akhir[]" class="form-control waktu-selesai" id="waktu_akhir_{{ $index }}" required>
                                    <option value="{{ $ruangan->pivot->waktu_akhir }}" selected>{{ $ruangan->pivot->waktu_akhir }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <div class="remove-btn-container mb-3">
                            <button type="button" class="inline-flex items-center justify-center mb-2 px-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-remove"
                            style="background-color: #EF4444 !important;" onclick="removeRoom(this)">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="button-group flex space-x-2">
                <!-- Button untuk tambah form -->
                <button type="button" class="inline-flex items-center justify-center mb-2 px-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 btn-add"
                style="background-color: #22C55E !important;" onclick="addRoom()">
                    Tambah Tempat
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
    const weekdayTimes = generateTimeOptions("07:30", "20:00", 30);
    const weekendTimes = generateTimeOptions("07:30", "17:00", 30);

    // Fungsi untuk menghasilkan waktu dalam interval tertentu
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

    function isWeekend() {
        const today = new Date();
        const day = today.getDay(); // 0 = Sunday, 6 = Saturday
        return day === 0 || day === 6;
    }

    function loadTimeOptions(index, selectedStart, selectedEnd) {
        const times = isWeekend() ? weekendTimes : weekdayTimes;

        const waktuMulaiSelect = document.getElementById(`waktu_mulai_${index}`);
        const waktuAkhirSelect = document.getElementById(`waktu_akhir_${index}`);

        waktuMulaiSelect.innerHTML = '';
        waktuAkhirSelect.innerHTML = '';

        times.forEach(time => {
            const optionMulai = document.createElement('option');
            optionMulai.value = time;
            optionMulai.textContent = time;
            if (time === selectedStart) optionMulai.selected = true;
            waktuMulaiSelect.appendChild(optionMulai);

            const optionAkhir = document.createElement('option');
            optionAkhir.value = time;
            optionAkhir.textContent = time;
            if (time === selectedEnd) optionAkhir.selected = true;
            waktuAkhirSelect.appendChild(optionAkhir);
        });
    }

    window.onload = function () {
        @foreach ($pengajuans->ruangan as $index => $ruangan)
            loadTimeOptions(
                {{ $index }},
                "{{ $ruangan->pivot->waktu_mulai }}",
                "{{ $ruangan->pivot->waktu_akhir }}"
            );
        @endforeach
    };

    function addRoom() {
        const container = document.getElementById("form-container");
        const newForm = document.createElement("div");

        newForm.classList.add("form-item", "border-b", "mb-3");
        newForm.innerHTML = `
        <label for="ruangan" class="block text-sm font-medium text-gray-900">Tempat</label>
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

        // Tambahkan form-item baru sebelum tombol "Tambah Tempat"
        container.appendChild(newForm);

        // Pindahkan tombol "Tambah Tempat" ke bawah form-item terakhir
        const addPlaceBtnContainer = document.getElementById("add-place-btn-container");
        container.appendChild(addPlaceBtnContainer);
        moveRemoveButtonToLast(newForm);
    }

    function removeRoom(button) {
        const formItem = button.closest(".form-item");
        formItem.remove();

        // Pastikan tombol "Tambah Tempat" tetap di bawah form terakhir
        const container = document.getElementById("form-container");
        const addPlaceBtnContainer = document.getElementById("add-place-btn-container");
        container.appendChild(addPlaceBtnContainer);
    }

    function moveRemoveButtonToLast(formItem) {
        // Pastikan tombol hapus berada di bawah semua input dalam form item
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
                    <label class="block text-sm font-medium text-gray-900">Tanggal Peminjaman</label>
                    <input type="text" name="tanggal_mulai[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Tanggal Berakhir</label>
                    <input type="text" name="tanggal_akhir[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Waktu Mulai Kegiatan</label>
                    <select name="waktu_mulai[]" class="form-control waktu-mulai" required>
                        <option value="">Pilih Waktu</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Waktu Selesai Kegiatan</label>
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
        // Ambil disabled dates pertama kali
        fetchDisabledDates(function(disabledDates) {
            // Terapkan flatpickr pada input yang ada
            applyFlatpickr(disabledDates);
        });
    });

    function openPengajuanModal() {
        document.getElementById('editPengajuanModal').classList.remove('hidden');
    }

    function closePengajuanModal() {
        document.getElementById('editPengajuanModal').classList.add('hidden');
    }
</script>