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
                <div class="col-span-3">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-800 focus:ring-2 focus:ring-indigo-400">
                        Cari
                    </button>
                    <input type="hidden" name="sort" value="{{ request('sort', 'asc') }}">
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
                    <select name="sort" class="h-10 pl-4 pr-8 border border-gray-300 rounded-md bg-white focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Sort by: A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Sort by: Z-A</option>
                    </select>
                </div>

                <!-- Room List -->
                <div class="space-y-4">
                    @forelse($ruangans as $ruangan)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 bg-gray-200 rounded-lg"></div>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">Ruangan {{ $ruangan->nama_ruangan }}</a>
                                </h3>
                                <p class="text-blue-600 text-sm">{{ $ruangan->gedung->nama_gedung }}</p>
                                <p class="mt-2 text-gray-600">{{ $ruangan->deskripsi }}</p>
                            </div>
                            <div class="ml-6 flex flex-col items-end justify-between">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ !$ruangan->isBooked ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ !$ruangan->isBooked ? 'Tersedia' : 'Tidak tersedia' }}
                                </span>
                                <button class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
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
$(document).ready(function() {
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

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
    });
});
</script>
@endpush
@endsection