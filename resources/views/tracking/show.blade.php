<!-- resources/views/tracking/show.blade.php -->
@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <h5 class="pt-2 mb-1 font-bold">Status Pengajuan #{{ $pengajuan->id_pengajuan }}</h5>
    <p class="pt-2 mb-1 font-semibold">
        <i class="fas fa-calendar-alt"></i> Dibuat pada {{ $pengajuan->created_at->format('d-m-Y H:i:s') }}
    </p>

    <!-- Progress Bar -->
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <ul id="progressbar" class="text-center">
                @foreach($progressStatus as $step => $isComplete)
                    <li class="{{ $isComplete ? 'active' : '' }} step0">
                        <!-- ... progress bar HTML ... -->
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Form dan Status Tracker -->
    <div class="dashboard-container">
        <div class="dashboard-row">
            <!-- Form Pengajuan Card -->
            <div class="dashboard-col">
                <div class="form-pengajuan card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nama-kegiatan">Nama Kegiatan</label>
                            <input type="text" value="{{ $pengajuan->nama_kegiatan }}" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal-kegiatan">Tanggal Kegiatan</label>
                            <input type="date" value="{{ $pengajuan->tanggal_kegiatan }}" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ormawa">Ormawa</label>
                            <input type="text" value="{{ $pengajuan->ormawa }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Tracker Card -->
            <div class="dashboard-col">
                <div class="tracking_status_container card">
                    <div class="tracking_status_wrapper">
                        <div class="tracking_status_header">STATUS</div>
                        <ul class="tracking_status_list">
                            @foreach($pengajuan->reviews as $review)
                            <li class="tracking_status_item {{ $loop->first ? 'active' : '' }}">
                                <div class="tracking_status_date">
                                    {{ $review->tanggal_review->format('d-m-Y H:i:s') }}
                                </div>
                                <div class="tracking_status_content">
                                    <div class="tracking_status_dot"></div>
                                    <div class="tracking_status_icon">
                                        <i class="fa-solid {{ $this->getStatusIcon($review->status) }}"></i>
                                    </div>
                                    <div class="tracking_status_text">
                                        <div class="tracking_status_title">
                                            {{ $this->getStatusTitle($review->nip) }}
                                        </div>
                                        <div class="tracking_status_desc">
                                            {{ $review->review }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection