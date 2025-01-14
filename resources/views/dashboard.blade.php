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
            <div class="bg-white rounded-lg shadow">
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
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ !$ruangan->isBooked ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ !$ruangan->isBooked ? 'Tersedia' : 'Tidak tersedia' }}
                                    </span>
                                    <button 
                                        class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                                        onclick="showAvailableTimes(
                                            {{ $ruangan->id_ruangan }}, 
                                            '{{ request('daterange') }}', 
                                            '{{ json_encode($ruangan->menggunakanRuangan->map(function($item) {
                                                return [
                                                    'date' => \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y'),
                                                    'start' => $item->waktu_mulai,
                                                    'end' => $item->waktu_akhir,
                                                ];
                                            })) }}'
                                        )">
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
    let bookedTimes = [];

    document.addEventListener('DOMContentLoaded', function() {
        initializeDateRangePicker();
        initializeDetailButtons();
        initializeNavigationButtons();
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

    function initializeDetailButtons() {
        document.querySelectorAll('[onclick^="showAvailableTimes"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                try {
                    const args = this.getAttribute('onclick').match(/\((.*?)\)/)[1].split(',').map(arg => 
                        arg.trim().replace(/^['"]|['"]$/g, '')
                    );
                    showAvailableTimes(...args);
                } catch (error) {
                    console.error('Error parsing detail button arguments:', error);
                }
            });
        });
    }

    function initializeNavigationButtons() {
        document.getElementById('prevDay')?.addEventListener('click', () => changeDay(-1));
        document.getElementById('nextDay')?.addEventListener('click', () => changeDay(1));
    }

    function initializeSortHandler() {
        document.getElementById('sort')?.addEventListener('change', function() {
            document.getElementById('sortForm').submit();
        });
    }

    function showAvailableTimes(ruanganId, dateRange, times) {
        try {
            const dates = dateRange ? dateRange.split(' - ') : [];
            startDate = dates[0] ? new Date(dates[0]) : null;
            endDate = dates[1] ? new Date(dates[1]) : null;
            currentDate = startDate ? new Date(startDate) : null;
            bookedTimes = typeof times === 'string' ? JSON.parse(times) : times;

            if (!startDate || !endDate) {
                throw new Error('Invalid date range');
            }

            displaySlots(currentDate, bookedTimes);
            openModal();
        } catch (error) {
            console.error('Error showing available times:', error);
            alert('Terjadi kesalahan saat memuat jadwal. Silakan coba lagi.');
        }
    }

    function changeDay(offset) {
        if (!currentDate || !startDate || !endDate) return;

        const newDate = new Date(currentDate);
        newDate.setDate(newDate.getDate() + offset);

        if (newDate >= startDate && newDate <= endDate) {
            currentDate = newDate;
            displaySlots(currentDate, bookedTimes);
        }
    }

    function displaySlots(date, bookedTimes) {
        if (!date) return;

        const modalContent = document.getElementById('scheduleBody');
        if (!modalContent) return;

        modalContent.innerHTML = '';

        const dateString = date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        const todayBookings = bookedTimes.filter(time => time.date === dateString);
        const slots = calculateAvailableSlots([{ start: '07:30', end: '17:00' }], todayBookings);

        slots.forEach(slot => {
            const row = createTimeSlotRow(slot);
            modalContent.appendChild(row);
        });
    }

    function createTimeSlotRow(slot) {
        const row = document.createElement('tr');
        const timeCell = document.createElement('td');
        const statusCell = document.createElement('td');

        timeCell.className = 'border-b py-2 px-4';
        statusCell.className = `border-b py-2 px-4 ${slot.booked ? 'text-red-500' : 'text-green-500'}`;

        timeCell.textContent = `${slot.start} - ${slot.end}`;
        statusCell.textContent = slot.booked ? 'Tidak Tersedia' : 'Tersedia';

        row.appendChild(timeCell);
        row.appendChild(statusCell);
        return row;
    }

    function calculateAvailableSlots(operatingHours, bookings) {
        const slots = [];
        const interval = 30;

        operatingHours.forEach(hour => {
            let current = convertTimeToMinutes(hour.start);
            const end = convertTimeToMinutes(hour.end);

            while (current < end) {
                const slotStart = formatMinutesToTime(current);
                const slotEnd = formatMinutesToTime(current + interval);

                slots.push({
                    start: slotStart,
                    end: slotEnd,
                    booked: isTimeSlotBooked(slotStart, slotEnd, bookings)
                });

                current += interval;
            }
        });

        return slots;
    }

    function isTimeSlotBooked(start, end, bookings) {
        return bookings.some(booking => {
            const bookingStart = convertTimeToMinutes(booking.start);
            const bookingEnd = convertTimeToMinutes(booking.end);
            const slotStart = convertTimeToMinutes(start);
            const slotEnd = convertTimeToMinutes(end);

            return (slotStart < bookingEnd && slotEnd > bookingStart);
        });
    }

    function convertTimeToMinutes(time) {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function formatMinutesToTime(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
    }

    function openModal() {
        const modal = document.getElementById('timeModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('timeModal');
        if (modal) modal.classList.add('hidden');
    }

    $(document).ready(function() {
        // Daterange picker initialization
        $('#daterange').daterangepicker({
            opens: 'left',
            autoApply: true,
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
        });

        // Update the input field value on date range selection
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
        });

        document.getElementById('sort').addEventListener('change', function() {
            document.getElementById('sortForm').submit();
        });
    });
</script>
@endpush

@endsection