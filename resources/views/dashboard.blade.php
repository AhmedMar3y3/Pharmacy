@extends('layout')
@section('main')
<div class="container mt-5">
    <div class="row">
        <!-- بطاقة عدد العملاء -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">عدد العملاء</h5>
                    <p class="card-text">{{ $patientCount }}</p>
                </div>
                <i class="fas fa-users fa-3x"></i>
                </div>
            </div>
            </div>
        </div>


        <!-- بطاقة عدد الفواتير -->
        <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card info-card customers-card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">عدد الفواتير</h5>
                            <p class="card-text">{{ $invoice }}</p>
                        </div>
                        <i class="fas fa-file-invoice-dollar fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقة عدد العقود -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card info-card customers-card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">عدد العقود</h5>
                            <p class="card-text">{{ $contract }}</p>
                        </div>
                        <i class="fas fa-file-contract fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية -->
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">عدد العملاء</h5>
                    <canvas id="patientsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">عدد الفواتير والعملاء</h5>
                    <canvas id="invoicesContractsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تضمين Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const patientsData = {
        labels: ['عدد العملاء'],
        datasets: [{
            label: 'عدد العملاء',
            data: [{{ $patientCount }}],
            backgroundColor: 'rgba(104, 159, 56, 0.2)',
            borderColor: 'rgba(104, 159, 56, 1)',
            borderWidth: 1
        }]
    };

    const invoicesContractsData = {
        labels: ['الفواتير', 'العملاء'],
        datasets: [{
            label: 'العدد',
            data: [{{ $invoice }}, {{ $patientCount }}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    };

    const patientsCtx = document.getElementById('patientsChart').getContext('2d');
    new Chart(patientsCtx, {
        type: 'bar',
        data: patientsData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // رسم مخطط عدد الفواتير والعقود
    const invoicesContractsCtx = document.getElementById('invoicesContractsChart').getContext('2d');
    new Chart(invoicesContractsCtx, {
        type: 'pie', // نوع الرسم البياني (دائري)
        data: invoicesContractsData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

<style>
    /* لون أزرق فاتح جدًا */
    .bg-soft-blue {
        background-color: #a8d8f0; /* لون أزرق فاتح وهادئ */
    }

    /* لون أخضر فاتح جدًا */
    .bg-soft-green {
        background-color: #b8e6b8; /* لون أخضر فاتح وهادئ */
    }

    /* لون برتقالي فاتح */
    .bg-soft-orange {
        background-color: #ffcc99; /* لون برتقالي فاتح وهادئ */
    }
</style>
@endsection