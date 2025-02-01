@extends('Admin.layout')

@section('main')
<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container dashboard">
    <div class="row">
        <!-- New Users Today Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">New Users <span>| Today</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div class="ps-3">
                            {{-- <h6>{{ $newUsersToday }}</h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Doctors Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Doctors <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="ps-3">
                            {{-- <h6>{{ $totalDoctors }}</h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pharmacies Card -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Pharmacies <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-prescription"></i>
                        </div>
                        <div class="ps-3">
                            {{-- <h6>{{ $totalPharmacies }}</h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Total Medications Card -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Medications <span>| Total</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-capsule"></i>
                            </div>
                            <div class="ps-3">
                                {{-- <h6>{{ $totalMedications }}</h6> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Total Representatives Commercial -->
        
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Representatives <span>| Commerce</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="ps-3">
                            {{-- <h6>{{ $totalCommercial }}</h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Representatives Scientific -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Representatives <span>| Scientific</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-eyedropper"></i>
                        </div>
                        <div class="ps-3">
                            {{-- <h6>{{ $totalScientific }}</h6> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users <span>| Last week</span></h5>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

{{-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        const last7Days = @json(array_keys($last7Days));
        const newUserCounts = @json(array_values($last7Days));
        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'New Users',
                data: newUserCounts,
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'datetime',
                categories: last7Days,
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return Math.round(val); // Ensures whole numbers on y-axis
                    }
                },
                min: 0, // Optional: ensures the y-axis starts from 0
                forceNiceScale: true // Optional: ensures nice scaling of y-axis
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            }
        }).render();
    });
</script>  --}}


                    <!-- End Line Chart -->

                </div>

            </div>
        </div><!-- End Reports -->
        
    </div>
</div>

<style>
    .dashboard .row {
        justify-content: center;
    }

    .dashboard .info-card {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
        min-height: 120px; 

    }

    .dashboard .card-icon {
        color: #4154f1 !important;
        background: #fefefe !important;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 45px;
    }

    .dashboard h5.card-title {
        font-size: 1.5rem;
    }

    .dashboard h6 {
        font-size: 2rem;
    }

    .dashboard .container {
        max-width: 1000px;
    }
</style>

{{-- @endsection --}}
