@extends('layout.main')
@section('content')
    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
            <!-- Pengajuan Card -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Pengajuan</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalPengajuan }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tempat Card -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Tempat</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalTempat }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Users</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalUsers }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-single-02 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ormawa Card -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Ormawa</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalOrmawa }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-vector text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- cards row 2 -->
        <!-- Pengajuan Overview -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mt-0 lg:w-7/12 lg:flex-none">
                <div
                    class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                    <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                        <h6>Pengajuan Overview</h6>
                        <p class="text-sm leading-normal">
                            <i class="fa fa-arrow-up text-lime-500"></i>
                            <span class="font-semibold">Pengajuan per bulan</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div>
                            <canvas id="chart-line" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data diambil dari server-side dan diteruskan ke view sebagai array JavaScript
                var data = @json($monthlyStatus);

                var ctx = document.getElementById("chart-line").getContext("2d");

                var gradientStroke1 = ctx.createLinearGradient(0, 230, 0, 50);
                gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
                gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
                gradientStroke1.addColorStop(0, "rgba(203,12,159,0)");

                var gradientStroke2 = ctx.createLinearGradient(0, 230, 0, 50);
                gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
                gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
                gradientStroke2.addColorStop(0, "rgba(20,23,39,0)");

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: data.map(item => item.month),
                        datasets: [{
                                label: "Selesai",
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 0,
                                borderColor: "#cb0c9f",
                                borderWidth: 3,
                                backgroundColor: gradientStroke1,
                                fill: true,
                                data: data.map(item => item.selesai_count),
                                maxBarThickness: 6,
                            },
                            {
                                label: "Ditolak",
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 0,
                                borderColor: "#3A416F",
                                borderWidth: 3,
                                backgroundColor: gradientStroke2,
                                fill: true,
                                data: data.map(item => item.ditolak_count),
                                maxBarThickness: 6,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                        },
                        interaction: {
                            intersect: false,
                            mode: "index",
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: "#b2b9bf",
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: "normal",
                                        lineHeight: 2,
                                    },
                                },
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                },
                                ticks: {
                                    display: true,
                                    color: "#b2b9bf",
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: "normal",
                                        lineHeight: 2,
                                    },
                                },
                            },
                        },
                    },
                });
            });
        </script>
    </div>
@endsection
