@extends('layout.main')
@section('content')

<!-- Cards -->
<div class="w-auto px-6 py-6 mx-auto">
    <div class="container mx-auto mt-6">
        <div id="ruanganCard" class="bg-white shadow-md rounded-lg p-6 -mt-1 relative ? {{ ($activeTab ?? '') === 'ruangan' }}">
            <div class="bg-orange-500 p-4 border-b border-orange-500 mt-4"></div>
                <div class="bg-gray-100 p-4 border-b border-gray-300">
                    <div class="filter-form">
                        <form method="GET" action="{{ route('calendar') }}">
                            <label for="ruangan">Pilih Ruangan:</label>
                            <select name="ruangan_id" id="ruangan">
                                <option value="">Semua Ruangan</option>
                                @foreach (\App\Models\Ruangan::all() as $ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}"
                                        {{ request('ruangan_id') == $ruangan->id_ruangan ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="mt-2" id="calendar"></div>
            </div>
        </div>

        <footer class="pt-4 w-full bg-transparent">
            <div class="container mx-auto px-6">
                <div class="flex flex-wrap items-center justify-center">
                    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-1/2 text-center">
                        <p class="text-center text-sm font-normal text-slate-500">
                            Pengajuan Sarana dan Prasarana<br>
                            Politeknik Negeri Bandung
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
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
</script>

@endsection