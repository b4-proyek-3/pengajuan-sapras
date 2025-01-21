@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
<div class="bg-gray-50 min-h-screen">

    <!-- Main Content -->
    <div class="px-6 py-4">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Pengajuan Sarana dan Prasarana</h1>

        <!-- Orange Banner Section -->
        <div class="bg-orange-400 h-10 rounded-t-lg"></div>

        <!-- Search Form with White Background -->
        <div class="bg-white rounded-b-lg shadow p-6">
                <form action="{{ route('dashboard.index') }}" method="GET" class="grid grid-cols-12 gap-4">
                    <!-- Building Selection -->
                    <div class="col-span-4">
                        <div class="relative">
                            <select name="gedung" id="gedung" class="w-full h-11 pl-4 pr-8 bg-white rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 appearance-none">
                                <option value="">Pilih Gedung</option>
                                @foreach($gedungs as $gedung)
                                    <option value="{{ $gedung->id_gedung }}" {{ request('gedung') == $gedung->id_gedung ? 'selected' : '' }}>
                                        {{ $gedung->nama_gedung }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="col-span-5">
                        <div class="relative">
                            <input type="text"
                                id="daterange"
                                name="daterange"
                                class="w-full h-11 pl-4 pr-4 bg-white rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500"
                                placeholder="13 Jan 2025 - 16 Jan 2025"
                                value="{{ request('daterange') }}"
                                readonly>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="col-span-3 flex justify-end">
                        <button class="w-full md:w-auto bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-800 focus:ring-2 focus:ring-indigo-400">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="bg-white rounded-lg shadow mt-4">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ $selectedGedung ? $selectedGedung->nama_gedung : 'Semua Gedung' }}: {{ $ruangans->count() }} ruangan ditemukan
                        </h2>

                        <!-- Sort Dropdown -->
                        <form id="sortForm" action="{{ route('dashboard.index') }}" method="GET">
                            <!-- Hidden Inputs untuk Mempertahankan Nilai Filter -->
                            <input type="hidden" name="gedung" value="{{ request('gedung') }}">
                            <input type="hidden" name="daterange" value="{{ request('daterange') }}">

                            <select id="sort" name="sort" class="h-10 pl-4 pr-8 border border-gray-300 rounded-md bg-white focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Sort by: A-Z</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Sort by: Z-A</option>
                            </select>
                        </form>
                    </div>

                    <!-- Room List -->
                    <div class="space-y-4">
                    @forelse($ruangans as $ruangan)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex">
                                <!-- Foto Ruangan -->
                                <div class="flex-shrink-0">
                                    @if($ruangan->foto)
                                        <img src="{{ asset('storage/' . $ruangan->foto) }}" alt="Foto Ruangan"
                                            class="w-32 h-32 object-cover rounded-lg">
                                    @else
                                        <div class="w-32 h-32 bg-gray-200 flex items-center justify-center rounded-lg">
                                            <span class="text-gray-500 text-sm">Tidak Ada Foto</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Deskripsi Ruangan -->
                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-800">{{ $ruangan->nama_ruangan }}</a>
                                    </h3>
                                    <p class="text-blue-600 text-sm">{{ $ruangan->gedung->nama_gedung }}</p>
                                    <p class="mt-2 text-gray-600 text-sm">
                                        <strong>Kapasitas:</strong> {{ $ruangan->kapasitas ?? 'N/A' }} orang
                                    </p>
                                    <!-- Menampilkan Data dari Menggunakan Ruangan -->
                                    @if($ruangan->menggunakanRuangan->count())
                                        @foreach($ruangan->menggunakanRuangan as $menggunakan)
                                            <p class="mt-2 text-gray-600 text-sm">
                                                <strong>Tanggal:</strong>
                                                @php
                                                    $tanggalMulai = \Carbon\Carbon::parse($menggunakan->tanggal_mulai);
                                                    $tanggalAkhir = \Carbon\Carbon::parse($menggunakan->tanggal_akhir);

                                                    // Logika Format Tanggal
                                                    if ($tanggalMulai->format('F Y') === $tanggalAkhir->format('F Y')) {
                                                        // Bulan dan tahun sama
                                                        echo $tanggalMulai->format('d') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    } elseif ($tanggalMulai->year === $tanggalAkhir->year) {
                                                        // Tahun sama, tapi bulan berbeda
                                                        echo $tanggalMulai->format('d F') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    } else {
                                                        // Tahun berbeda
                                                        echo $tanggalMulai->format('d F Y') . ' - ' . $tanggalAkhir->format('d F Y');
                                                    }
                                                @endphp
                                            </p>
                                            <p class="text-gray-600 text-sm">
                                                <strong>Waktu:</strong> {{ $menggunakan->waktu_mulai ?? 'N/A' }} - {{ $menggunakan->waktu_akhir ?? 'N/A' }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="mt-2 text-gray-500 text-sm">Belum ada penggunaan</p>
                                    @endif
                                </div>

                                <!-- Status dan Tombol -->
                                <div class="ml-6 flex flex-col items-end justify-between">
                                <div id="roomStatusLabel" style="font-weight: bold; margin-top: 10px;"></div>
                                <button
                                        class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 btn btn-primary detail-button"
                                        data-id-ruangan="{{ $ruangan->id_ruangan }}"
                                        data-dates="{{ json_encode($bookedTimes->where('id_ruangan', $ruangan->id_ruangan)) }}">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada ruangan yang ditemukan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('modal.modal_details_dashboard')
@push('styles')
<style>
    .daterangepicker {
        @apply bg-white rounded-lg shadow-lg border border-gray-200;
    }
    .daterangepicker .calendar-table {
        @apply border-none;
    }
    .daterangepicker td.active {
        @apply bg-blue-600;
    }
    .daterangepicker td.in-range {
        @apply bg-blue-100;
    }
</style>
@endpush

@push('scripts')
<script>
    let startDate, endDate, currentDate;

    document.addEventListener('DOMContentLoaded', function() {
        initializeDateRangePicker();
        initializeSortHandler();
    });

    function initializeDateRangePicker() {
        $('#daterange').daterangepicker({
            opens: 'left',
            autoApply: true,
            minDate: moment(),
            locale: {
                format: 'DD MMM YYYY',
                applyLabel: "Pilih",
                cancelLabel: "Batal",
                daysOfWeek: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                monthNames: [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ],
            },
            showDropdowns: true,
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
        });
    }

    function initializeSortHandler() {
        document.getElementById('sort')?.addEventListener('change', function() {
            document.getElementById('sortForm').submit();
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        const detailButtons = document.querySelectorAll(".detail-button");

        detailButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const idRuangan = button.getAttribute("data-id-ruangan");
                let dates = button.getAttribute("data-dates");

                console.log("Original dates string:", dates);

                try {
                    dates = JSON.parse(dates);
                } catch (error) {
                    console.error("JSON parsing error:", error);
                }

                console.log("Parsed dates:", dates);

                // Pastikan dates adalah array
                if (!Array.isArray(dates)) {
                    // Jika dates adalah objek, konversi ke array
                    if (typeof dates === 'object') {
                        dates = Object.values(dates);
                    }
                }

                console.log("Dates as array:", dates);

                // Jika dates masih bukan array, keluarkan error
                if (!Array.isArray(dates)) {
                    console.error("dates masih bukan array setelah konversi:", dates);
                    return; // Berhenti jika dates bukan array
                }

                // Filter dates sesuai idRuangan yang dipilih
                dates = dates.filter((item) => item.id_ruangan === parseInt(idRuangan));
                dates2 = dates;

                console.log("Filtered dates:", dates);

                // Hilangkan tanggal duplikat
                dates = dates
                    .map((item) => item.date)
                    .filter((value, index, self) => self.indexOf(value) === index) // Hilangkan duplikasi
                    .sort();

                console.log("Sorted dates:", dates);

                // State untuk melacak tanggal yang dipilih
                let selectedIndex = 0;

                // Fungsi untuk memperbarui tabel berdasarkan tanggal yang dipilih
                function updateTable(selectedDate) {
                    // Tentukan apakah tanggal adalah weekday atau weekend
                    const isWeekend = checkIfWeekend(selectedDate);

                    // Rentang waktu berdasarkan weekday/weekend
                    const startTime = "07:30";
                    const endTime = isWeekend ? "17:00" : "20:00";
                    const timeSlots = generateTimeSlots(startTime, endTime);

                    // Cek apakah ada booking untuk tanggal tertentu
                    const bookingsForDate = dates2.filter(
                        (booking) => booking.date === selectedDate
                    );

                    console.log("Bookings for date:", bookingsForDate);

                    let timeSlotsWithStatus = [];

                    // Jika ada booking, tentukan status slot waktu
                    if (bookingsForDate.length > 0) {
                        timeSlotsWithStatus = timeSlots.map((slot) => {
                            const isBooked = bookingsForDate.some((booking) => {
                                return slot.start >= booking.start && slot.end <= booking.end;
                            });

                            return {
                                ...slot,
                                status: isBooked ? "Tidak Tersedia" : "Tersedia",
                            };
                        });
                    } else {
                        // Jika tidak ada booking, semua slot waktu Tersedia
                        timeSlotsWithStatus = timeSlots.map((slot) => ({
                            ...slot,
                            status: "Tersedia",
                        }));
                    }

                    // Tentukan status ruangan berdasarkan slot waktu
                    const isRoomAvailable = timeSlotsWithStatus.some((slot) => slot.status === "Tersedia");

                    // Tampilkan data di tabel modal
                    const tableBody = document.getElementById("timeSlotsTable");
                    tableBody.innerHTML = "";
                    timeSlotsWithStatus.forEach((slot) => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${slot.start} - ${slot.end}</td>
                            <td style="color: ${slot.status === "Tersedia" ? "green" : "red"};">
                                ${slot.status}
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    // Perbarui label tanggal di modal
                    const dateLabel = document.getElementById("selectedDateLabel");
                    dateLabel.textContent = `${selectedDate}`;

                    updateButtonsVisibility();
                }

                function updateButtonsVisibility() {
                    const prevButton = document.getElementById("prevDateButton");
                    const nextButton = document.getElementById("nextDateButton");

                    if (dates.length <= 1) {
                        prevButton.style.display = "none";
                        nextButton.style.display = "none";
                    } else {
                        prevButton.style.display = selectedIndex > 0 ? "block" : "none";
                        nextButton.style.display = selectedIndex < dates.length - 1 ? "block" : "none";
                    }
                }

                // Event listener untuk tombol Prev
                const prevButton = document.getElementById("prevDateButton");
                prevButton.addEventListener("click", () => {
                    if (selectedIndex > 0) {
                        selectedIndex--;
                        const selectedDate = dates[selectedIndex];
                        updateTable(selectedDate);
                    }
                });

                // Event listener untuk tombol Next
                const nextButton = document.getElementById("nextDateButton");
                nextButton.addEventListener("click", () => {
                    if (selectedIndex < dates.length - 1) {
                        selectedIndex++;
                        const selectedDate = dates[selectedIndex];
                        updateTable(selectedDate);
                    }
                });

                // Tampilkan modal pertama kali dengan tanggal pertama
                const initialDate = dates.length > 0 ? dates[selectedIndex] : "Tanggal Tersedia";
                updateTable(initialDate);

                const modal = new bootstrap.Modal(document.getElementById("timeSlotsModal"));
                modal.show();
            });
        });

        // Fungsi untuk membuat rentang waktu
        function generateTimeSlots(startTime, endTime) {
            const slots = [];
            let currentTime = startTime;

            while (currentTime < endTime) {
                const nextTime = addMinutes(currentTime, 30);
                slots.push({ start: currentTime, end: nextTime });
                currentTime = nextTime;
            }

            return slots;
        }

        // Fungsi untuk menambah menit
        function addMinutes(time, minsToAdd) {
            const [hours, minutes] = time.split(":").map(Number);
            const date = new Date();
            date.setHours(hours, minutes + minsToAdd);
            const newHours = date.getHours().toString().padStart(2, "0");
            const newMinutes = date.getMinutes().toString().padStart(2, "0");
            return `${newHours}:${newMinutes}`;
        }

        // Fungsi untuk mengecek apakah tanggal adalah weekend
        function checkIfWeekend(dateString) {
            // Format tanggal "DD MMMM YYYY"
            const [day, month, year] = dateString.split(" ");
            const monthIndex = getMonthIndex(month);
            const date = new Date(year, monthIndex, day);
            const dayOfWeek = date.getDay();
            return dayOfWeek === 0 || dayOfWeek === 6; // 0 = Minggu, 6 = Sabtu
        }

        // Fungsi untuk mendapatkan indeks bulan
        function getMonthIndex(monthName) {
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return months.indexOf(monthName);
        }
    });
</script>
@endpush

@endsection