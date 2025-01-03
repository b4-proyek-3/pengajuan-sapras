@extends('layout.main')

@section('content')
<!-- Container Dashboard -->
<div class="w-auto px-6 py-6 mx-auto">

    <!-- Main Content -->
    <main class="dashboard-main p-6">
        <h1 class="dashboard-page-title text-2xl font-bold mb-6">Pengajuan Sarana dan Prasarana</h1>
        
        <!-- Search Form -->
        <div class="dashboard-search-form bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex space-x-4">
                <div class="flex-1 relative">
                    <i class="fas fa-map-marker-alt absolute left-3 top-2.5 text-gray-400"></i>
                    <input type="text" placeholder="Gedung H" 
                           class="dashboard-location-input w-full pl-10 pr-4 py-2 border rounded-lg">
                </div>
                <div class="flex-1 relative">
                    <i class="fas fa-calendar absolute left-3 top-2.5 text-gray-400"></i>
                    <input type="text" placeholder="29 Dec 2024 - 30 Dec 2024" 
                           class="dashboard-date-input w-full pl-10 pr-4 py-2 border rounded-lg">
                </div>
                <button class="dashboard-search-button px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cari
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="dashboard-results bg-white rounded-lg shadow p-6">
            <div class="dashboard-results-header flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold">Gedung H: 2 ruangan ditemukan (Dummy Data)</h2>
                <select class="dashboard-sort border rounded-lg px-4 py-2">
                    <option>Sort by: A-Z</option>
                </select>
            </div>

            <!-- Room Cards -->
            <div class="dashboard-room-list space-y-4">
                @php
                // Dummy data for rooms
                $rooms = [
                    ['id' => 'H101', 'nama_tempat' => 'Ruangan 101', 'status' => 'Tidak tersedia'],
                    ['id' => 'H102', 'nama_tempat' => 'Ruangan 102', 'status' => 'Tersedia']
                ];
                @endphp

                @foreach ($rooms as $room)
                    <div class='dashboard-room-card flex border rounded-lg p-4'>
                        <div class='dashboard-room-image w-48 h-48 bg-gray-200 rounded-lg'></div>
                        <div class='dashboard-room-content ml-6 flex-1'>
                            <h3 class='text-lg font-semibold text-blue-600'>{{ $room['nama_tempat'] }}</h3>
                            <p class='text-blue-600 mb-2'>Gedung H</p>
                            <p class='text-gray-600 mb-4'>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Phasellus in tristique dui. Etiam nisl felis, bibendum id facilisis vel, 
                                hendrerit malesuada libero.
                            </p>
                            <div class='dashboard-room-footer flex justify-between items-center'>
                                <span class='text-lg font-semibold'>{{ $room['status'] }}</span>
                                <button class='dashboard-details-button px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700'>
                                    Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>

@endsection 
