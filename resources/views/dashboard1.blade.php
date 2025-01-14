@extends('layout.main')
@section('content')

<div class="dashboard-container min-h-screen bg-gray-50">
    <main class="dashboard-main bg-gray-50">        <!-- Title Section -->
        <div class="pt-24 text-center">
            <h1 class="dashboard-page-title text-4xl font-bold mb-4 text-gray-600">
                Pengajuan Sarana dan Prasarana
            </h1>
            <p class="dashboard-subtitle text-lg text-gray-600">
                Mau cari ruangan apa? Temukan ruangan yang sesuai untuk kegiatan Anda.
            </p>
        </div>

        <!-- Search Form with White Background -->
        <div class="bg-white rounded-b-lg shadow w-full max-w-5xl mx-auto py-6 px-6 mb-8">
            <form action="{{ route('dashboard.index') }}" method="GET" class="grid grid-cols-12 gap-4">
                <!-- Building Selection -->
                <div class="col-span-4">
                    <div class="relative">
                        <select name="gedung" id="gedung" class="w-full h-11 pl-4 pr-1 bg-white rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 appearance-none">
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

                <input type="hidden" name="from_dashboard1" value="true">
            </form>
        </div>

        <!-- Scroll button -->
        <div class="text-center my-8">
            <button id="scrollToCalendarBtn" class="px-6 py-3 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition-all">
                Lihat Kalender
            </button>
        </div>

        <!-- Calendar section -->
        <div id="calendarSection" class="w-full mb-20">
            <div class="container mx-auto">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    $(document).ready(function() {
        // Scroll button functionality
        const scrollButton = document.getElementById('scrollToCalendarBtn');
        const calendarSection = document.getElementById('calendarSection');

        scrollButton.addEventListener('click', function(e) {
            e.preventDefault();
            const yOffset = -50;
            const y = calendarSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
            
            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/get-calendar-data',
            eventClick: function (info) {
            Swal.fire({
                title: info.event.title, 
                html: `
                    <p><strong>Waktu Mulai:</strong> ${info.event.start.toLocaleString()}</p>
                    <p><strong>Waktu Selesai:</strong> ${info.event.end ? info.event.end.toLocaleString() : 'Tidak ditentukan'}</p>
                `,
                icon: 'info',
                confirmButtonText: 'Tutup'
            });
        }
        });
        calendar.render();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const tanggal = document.getElementById('tanggal');

        flatpickr(tanggal, {
            dateFormat: "d M Y",
            minDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                tanggalAkhir._flatpickr.set('minDate', dateStr);
            }
        });
    });

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

@endsection