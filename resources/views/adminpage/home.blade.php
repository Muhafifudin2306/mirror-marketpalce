@extends('adminpage.index')
@section('content')
@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-body text-bg-light text-left">
                    <div class="row">
                        <div class="col-md-1 d-flex justify-content-end align-items-center">
                            <i class='fa fa-credit-card'></i>
                        </div>      
                        <div class="col-md-3">
                            <p class="card-title">Total Income</p>
                            <h4 class="card-text">Rp. 
                                @if ($totalIncome > 10000000 && $totalIncome < 1000000000)
                                    {{ number_format($totalIncome / 1000000, 1) }} jt
                                @elseif ($totalIncome > 1000000000)
                                    {{ number_format($totalIncome / 1000000000, 1) }} M
                                @else
                                    {{ number_format($totalIncome, 0, ',', '.') }}
                                @endif
                            </h4>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-center">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="col-md-3">
                            <p class="card-title">Produk Terjual</p>
                            <h4 class="card-text">{{ $totalProdukTerjual }}</h4>
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-center">
                            <i class='fa fa-user'></i>
                        </div>
                        <div class="col-md-3">
                            <p class="card-title">Total Pelanggan</p>
                            <h4 class="card-text">{{ $totalPelanggan }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Income Bulanan --}}
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Income Bulanan
                    </div>
                    <div class="card-body"><canvas id="barChartIncome" width="100%" height="40"></canvas></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const bulanLabels = @json($bulanIncome->pluck('month')->map(function($m) {
                                return \Carbon\Carbon::parse($m)->translatedFormat('F Y');
                            }));
                            const incomeData = @json($bulanIncome->pluck('income'));

                            new Chart(document.querySelector('#barChartIncome'), {
                                type: 'bar',
                                data: {
                                    labels: bulanLabels,
                                    datasets: [{
                                        label: 'Grafik Income Bulanan',
                                        data: incomeData,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: { beginAtZero: true }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            {{-- Grafik Produk Terjual --}}
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Produk Terjual / Bulan
                    </div>
                    <div class="card-body"><canvas id="barChartTerjual" width="100%" height="40"></canvas></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const bulanLabels = @json($bulanTerjual->pluck('month')->map(function($m) {
                                return \Carbon\Carbon::parse($m)->translatedFormat('F Y');
                            }));
                            const terjualData = @json($bulanTerjual->pluck('terjual'));

                            new Chart(document.querySelector('#barChartTerjual'), {
                                type: 'bar',
                                data: {
                                    labels: bulanLabels,
                                    datasets: [{
                                        label: 'Produk Terjual',
                                        data: terjualData,
                                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                        borderColor: 'rgba(255, 159, 64, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1,
                                                precision: 0
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</main>
@else
    @include('adminpage.access_denied') 
@endif
@endsection
