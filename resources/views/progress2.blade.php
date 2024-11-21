@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <h5 class="pt-2 mb-1 font-bold">Status Pengajuan #{{ $pengajuan->id_pengajuan }}</h5>
    <p class="pt-2 mb-1 font-semibold">
        <i class="fas fa-calendar-alt"></i> Dibuat pada {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->addHours(7)->format('d-m-Y H:i') }}
    </p>

    <!-- Progress Bar -->
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <ul id="progressbar" class="text-center">
                @foreach($progressStatus as $step => $isActive)
                    <li class="{{ $isActive ? 'active' : '' }} {{ $stepStatus[$step]['isRevisi'] ? 'revisi' : '' }} {{ $stepStatus[$step]['isDitolak'] ? 'ditolak' : '' }} step0">
                        <div class="circle">
                            <i class="fa fa-{{ $stepIcons[$step] ?? 'circle' }}"></i>
                        </div>
                        <p>{{ $step }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Form Pengajuan -->
    <div class="form-pengajuan">
        <div class="form-row">
            <div class="form-group">
                <label for="nama-kegiatan">Nama Kegiatan</label>
                <input type="text" id="nama-kegiatan" class="form-control" value="{{ $pengajuan->nama_kegiatan }}" readonly>
            </div>
            <div class="form-group">
                <label for="tanggal-kegiatan">Tanggal Kegiatan</label>
                <input type="date" id="tanggal-kegiatan" class="form-control" value="{{ $pengajuan->tanggal_pinjam }}" readonly>
            </div>
            <div class="form-group">
                <label for="ormawa">Ormawa</label>
                <input type="text" id="ormawa" class="form-control" value="{{ $ormawa->nama_ormawa }}" readonly>
            </div>
        </div>
    </div>

    <!-- Status Tracker -->
    <div class="tracking_status_container">
        <div class="tracking_status_wrapper">
            <div class="tracking_status_header">STATUS</div>
            <ul class="tracking_status_list">
                @foreach ($stepIcons as $step => $icon)
                    @php
                        $roleMap = [
                            'Review Sekretaris BEM' => 'sekum-bem',
                            'Review KLI' => 'kli',
                            'Review Wadir 3' => 'wd-3'
                        ];
                        $review = $reviews->firstWhere('reviewer.role', $roleMap[$step] ?? '');
                        
                        $statusClass = '';
                        if ($stepStatus[$step]['status']) {
                            if ($stepStatus[$step]['isDitolak']) {
                                $statusClass = 'ditolak';
                            } elseif ($stepStatus[$step]['isRevisi']) {
                                $statusClass = 'revisi';
                            } else {
                                $statusClass = 'active';
                            }
                        }
                    @endphp
                    <li class="tracking_status_item {{ $statusClass }}">
                        <div class="tracking_status_date">
                            @if($step === 'Pengajuan dibuat')
                                {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->addHours(7)->format('d-m-Y H:i:s') }}
                            @elseif(isset($reviewDates[$step]))
                                {{ \Carbon\Carbon::parse($reviewDates[$step])->addHours(7)->format('d-m-Y H:i:s') }}
                            @else
                                Menunggu review
                            @endif
                        </div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                                <i class="fa-solid fa-{{ $icon }}"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">{{ $step }}</div>
                                <div class="tracking_status_desc">
                                    @if($step === 'Pengajuan dibuat')
                                        Pengajuan telah dibuat dengan ID {{ $pengajuan->id_pengajuan }}
                                    @elseif($step === 'Diterima' && isset($reviewDates['Review Wadir 3']))
                                        Pengajuan diterima pada tanggal {{ \Carbon\Carbon::parse($reviewDates['Review Wadir 3'])->format('d-m-Y H:i:s') }}
                                    @elseif($stepStatus[$step]['status'])
                                        @if($stepStatus[$step]['isRevisi'])
                                            Pengajuan perlu direvisi dengan catatan: {{ $review->catatan ?? 'Tidak ada catatan' }}
                                        @elseif($stepStatus[$step]['isDitolak'])
                                            Ditolak oleh {{ $roleMap[$step] ?? 'Reviewer' }} dengan catatan: {{ $review->catatan ?? 'Tidak ada catatan' }}
                                        @else
                                            Sudah direview oleh {{ $roleMap[$step] ?? 'Reviewer' }} dengan catatan: {{ $review->catatan ?? 'Tidak ada catatan' }}
                                        @endif
                                    @else
                                        Menunggu review dari {{ $roleMap[$step] ?? 'Reviewer' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
