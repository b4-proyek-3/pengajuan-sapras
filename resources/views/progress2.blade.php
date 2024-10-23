@extends('layout.main')
@section('content')
<!-- cards -->
<div class="w-full px-6 py-6 mx-auto">
        <h5 class="pt-2 mb-1 font-bold">Status Pengajuan #No Pengajuan</h5>
        <p class="pt-2 mb-1 font-semibold">
            <i class="fas fa-calendar-alt"></i> Dibuat pada DD-MM-YYYY HH:MM:SS
        </p>


        <!-- Add class 'active' to progress -->
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li class="active step0">
                        <div class="circle">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div>Pengajuan dibuat</div>
                    </li>
                    <li class="active step0">
                        <div class="circle">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <div>Review Sekretaris BEM</div>
                    </li>
                    <li class="active step0">
                        <div class="circle">
                            <i class="fa fa-pencil-square-o"></i>
                        </div>
                        <div>Review KLI</div>
                    </li>
                    <li class="active step0">
                        <div class="circle">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div>Review ULT</div>
                    </li>
                    <li class="step0">
                        <div class="circle">
                            <i class="fa fa-user"></i>
                        </div>
                        <div>Review Wadir 3</div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="form-pengajuan">
            <div class="form-row">
                <div class="form-group">
                    <label for="nama-kegiatan">Nama Kegiatan</label>
                    <input type="text" id="nama-kegiatan" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tanggal-kegiatan">Tanggal Kegiatan</label>
                    <input type="date" id="tanggal-kegiatan" class="form-control">
                </div>
                <div class="form-group">
                    <label for="ormawa">Ormawa</label>
                    <input type="text" id="ormawa" class="form-control">
                </div>
            </div>
        </div>

        <!-- Status Tracker -->
        <div class="tracking_status_container">
            <div class="tracking_status_wrapper">
                <div class="tracking_status_header">STATUS</div>
                <ul class="tracking_status_list">
                    <li class="tracking_status_item">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                              <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Selesai</div>
                                <div class="tracking_status_desc">Pengajuan selesai diajukan</div>
                            </div>
                        </div>
                    </li>

                    <li class="tracking_status_item">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                              <i class="fa-solid fa-user-magnifying-glass"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Dalam Review WD 3</div>
                                <div class="tracking_status_desc">Pengajuan sedang direview oleh WD 3</div>
                            </div>
                        </div>
                    </li>

                    <li class="tracking_status_item">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                              <i class="fa-solid fa-user-magnifying-glass"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Dalam review ULT</div>
                                <div class="tracking_status_desc">Pengajuan sedang dalam review ULT</div>
                            </div>
                        </div>
                    </li>

                    <li class="tracking_status_item active">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                              <i class="fa-solid fa-file-check"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Review KLI</div>
                                <div class="tracking_status_desc">Pengajuan telah disetujui oleh KLI [A02]</div>
                            </div>
                        </div>
                    </li>

                    <li class="tracking_status_item active">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                            <i class="fa-solid fa-file-check"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Review Sekretaris BEM</div>
                                <div class="tracking_status_desc">Pengajuan telah disetujui Sekretaris  [A01]</div>
                            </div>
                        </div>
                    </li>

                    <li class="tracking_status_item active">
                        <div class="tracking_status_date">dd-mm-yyyy hh:mm:dd</div>
                        <div class="tracking_status_content">
                            <div class="tracking_status_dot"></div>
                            <div class="tracking_status_icon">
                                <i class="fa-duotone fa-solid fa-file-export"></i>
                            </div>
                            <div class="tracking_status_text">
                                <div class="tracking_status_title">Pengajuan Dibuat</div>
                                <div class="tracking_status_desc">Pengajuan telah diajukan dan akan diriview Sekretaris BEM</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

@endsection