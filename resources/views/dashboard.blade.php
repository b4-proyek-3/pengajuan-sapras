@extends('layout.main')
@section('content')

<div class="dashboard-container min-h-screen bg-gray-50">
    <main class="dashboard-main p-8 flex flex-col items-center justify-center min-h-screen bg-gray-50">
        <!-- Title Section -->
        <div class="mt-24 text-center">
            <h1 class="dashboard-page-title text-4xl font-bold mb-4 text-gray-600">
                Pengajuan Sarana dan Prasarana
            </h1>
            <p class="dashboard-subtitle text-lg text-gray-600">
                Mau cari ruangan apa? Temukan ruangan yang sesuai untuk kegiatan Anda.
            </p>
        </div>

        <!-- Search Form -->
        <div id="searchCard" class="bg-white shadow-md rounded-lg p-8 w-full max-w-6xl">
            <form method="GET" action="{{ route('dashboard') }}" class="space-y-4">
                <div class="flex space-x-4">

                    <!-- Filter Nama Gedung -->
                    <div class="flex-1 relative">
                        <label for="gedung" class="sr-only">Pilih Gedung:</label>
                        <select name="gedung_id" id="gedung" class="dashboard-room-select w-full min-w-[300px] pl-6 pr-4 py-2 border rounded-lg">
                            <option value="">Cari Gedung</option>
                            @foreach (\App\Models\Gedung::all() as $gedung)
                                <option value="{{ $gedung->id_gedung }}" 
                                    {{ request('gedung_id') == $gedung->id_gedung ? 'selected' : '' }}>
                                    {{ $gedung->nama_gedung }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Nama Ruangan -->
                    <div class="flex-1 relative">
                        <label for="ruangan" class="sr-only">Pilih Ruangan:</label>
                        <select name="ruangan_id" id="ruangan" class="dashboard-room-select w-full min-w-[300px] pl-4 pr-4 py-2 border rounded-lg">
                            <option value="">Cari Ruangan</option>
                            @foreach (\App\Models\Ruangan::all() as $ruangan)
                                <option value="{{ $ruangan->id_ruangan }}" 
                                    {{ request('ruangan_id') == $ruangan->id_ruangan ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                

                    <!-- Filter Tanggal -->
                    <div class="flex space-x-4">
                        <div class="flex-1 relative">
                            <label for="tanggal" class="sr-only">Pilih Tanggal</label>
                            <i class="fas fa-calendar absolute left-3 top-2.5 text-gray-400"></i>
                            <input type="text" name="tanggal" id="tanggal"
                                class="w-full min-w-[300px] pl-10 pr-4 py-2 border rounded-lg" placeholder="Cari Tanggal"
                                value="{{ request('tanggal') }}">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="dashboard-search-button px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Cari
                        </button>
                    </div>
                </div>    
            </form>
        </div>

        <!-- Scroll to Calendar Button -->
        <button onclick="document.getElementById('calendarSection').scrollIntoView({ behavior: 'smooth' })" 
            class="mt-12 px-6 py-3 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600">
            Lihat Kalender
        </button>

        <!-- Calendar Section -->
        <div id="calendarSection" class="w-full mt-40">
            <div class="container mx-auto">
                <div id="ruanganCard" class="bg-white shadow-md rounded-lg p-6">
                    <div class="mt-6" id="calendar"></div>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
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
</script>

@endsection