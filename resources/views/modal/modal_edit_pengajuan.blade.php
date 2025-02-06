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
              <input id="nama-pengaju" value="{{ $pengajuans->nama_ketuplak }}"
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
                                <label class="block text-sm font-medium text-gray-900">Waktu Mulai</label>
                                <select name="waktu_mulai[]" class="form-control waktu_mulai" id="waktu_mulai_{{ $index }}">
                                    <option value="{{ $ruangan->pivot->waktu_mulai }}" selected>{{ $ruangan->pivot->waktu_mulai }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-900">Waktu Selesai</label>
                                <select name="waktu_akhir[]" class="form-control waktu_akhir" id="waktu_akhir_{{ $index }}">
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
        // Terapkan flatpickr pada setiap input dengan kelas .tanggal-input
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
                    <label class="block text-sm font-medium text-gray-900">Tanggal Peminjaman</label>
                    <input type="text" name="tanggal_mulai[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Tanggal Berakhir</label>
                    <input type="text" name="tanggal_akhir[]" class="form-control tanggal-input" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Waktu Mulai Kegiatan</label>
                    <select name="waktu_mulai[]" class="form-control" required>
                        ${weekdayTimes.map(time => `<option value="${time}">${time}</option>`).join("")}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900">Waktu Selesai Kegiatan</label>
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