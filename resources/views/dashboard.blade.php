@extends('layout.main')
@section('content')

<div class="dashboard-container min-h-screen bg-gray-50">
    <main class="dashboard-main bg-gray-50">        <!-- Title Section -->
        <div class="pt-24 text-center">
            <h1 class="dashboard-page-title text-4xl font-bold mb-4 text-gray-600">
                Pengajuan Sarana dan Prasarana
            </h1>
            <p class="dashboard-subtitle text-lg text-gray-600">
                Mau cari ruangan apa? Temukan tempat yang sesuai untuk kegiatan Anda.
            </p>
        </div>

        <!-- Search Form with White Background -->
        <div class="bg-white rounded-b-lg shadow w-full max-w-5xl mx-auto py-6 px-6 mb-8">
            <form action="{{ route('dashboard.index') }}" method="GET" class="grid grid-cols-12 gap-4">
                <!-- Building Selection -->
                <div class="col-span-4">
                    <div class="relative">
                        <select name="gedung" id="gedung" class="w-full h-11 pl-4 pr-1 bg-white rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 appearance-none">
                            <option value="">Pilih Lokasi</option>
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
                <input type="hidden" value="true">
            </form>
        </div>

        <!-- Scroll button -->
        <div class="text-center my-8">
            <button id="scrollToCalendarBtn" class="px-6 py-3 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition-all">
                Lihat Kalender
            </button>
        </div>

        <!-- Calendar section (tambah id untuk scroll) -->
        <div id="calendarSection" class="w-full overflow-auto mt-80">
            <div class="container mx-auto">
                <div id="ruanganCard" class="bg-white shadow-md rounded-lg p-6">
                    <div class="mt-6" id="calendar"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.getElementById('scrollToCalendarBtn').addEventListener('click', function () {
        const calendarSection = document.getElementById('calendarSection');
        
        // Menggunakan scrollIntoView untuk scroll ke bagian calendarSection
        calendarSection.scrollIntoView({ behavior: 'smooth' });
        
        // Setelah itu scroll lebih jauh menggunakan scrollBy
        window.scrollBy(0, -500); 
    });

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id', // Bahasa Indonesia
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            businessHours: [ // Jam kerja weekday & weekend
                {
                    daysOfWeek: [1, 2, 3, 4, 5], // Senin - Jumat
                    startTime: '07:30',
                    endTime: '20:00'
                },
                {
                    daysOfWeek: [0, 6], // Sabtu - Minggu
                    startTime: '07:30',
                    endTime: '17:00'
                }
            ],
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                list: 'Agenda'
            },
            events: '{{ route('dashboard.calendar.data') }}', // API dari Laravel
            eventDidMount: function (info) {
                let status = info.event.extendedProps.status; // Ambil status dari API

                // Tentukan warna berdasarkan status
                let warna;
                switch (status.toLowerCase()) {
                    case 'selesai':
                        warna = '#28a745'; // Hijau
                        break;
                    case 'ditolak':
                        warna = '#dc3545'; // Merah
                        break;
                    default:
                        warna = '#007bff'; // Biru (default)
                        break;
                }

                // Ubah warna dot (titik bulat)
                let dot = info.el.querySelector('.fc-daygrid-event-dot');
                if (dot) {
                    dot.style.backgroundColor = warna;
                }

                // Ubah warna teks event
                info.el.style.color = warna;
                info.el.style.fontWeight = 'bold'; // Supaya lebih jelas

            },
            eventClick: function (info) {
                Swal.fire({
                    title: info.event.title,
                    html: `
                        <p><strong>Status:</strong> <span style="color:${info.el.style.color}; font-weight: bold;">${info.event.extendedProps.status}</span></p>
                        <p><strong>Ormawa:</strong> ${info.event.extendedProps.ormawa}</p>
                        <p><strong>Waktu Mulai:</strong> ${info.event.start.toLocaleString('id-ID')}</p>
                        <p><strong>Waktu Akhir:</strong> ${info.event.end ? info.event.end.toLocaleString('id-ID') : 'Tidak ditentukan'}</p>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: "#3085d6",
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