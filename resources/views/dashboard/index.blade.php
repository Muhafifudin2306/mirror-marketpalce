@extends('layouts.app')
@section('content')
    @can('view-dashboard')
        <style>
            .card-hover {
                transition: all 0.3s ease;
                transform: translateY(0);
            }

            .card-hover:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
                transform: translateY(-5px);
            }
        </style>
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card border-top border-primary card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            {{--  <div class="col-3 text-center">
                            <i class="bi bi-clipboard-data-fill text-primary" style="font-size:2rem"></i>
                        </div>  --}}
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pendapatan</h5>
                                    <h3 class="card-text">Rp{{ number_format($sumSubTotalOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$sumSubTotalOrderToday" :yesterdayValue="$sumSubTotalOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-top border-primary card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title">Total Transaksi</h5>
                                    <h3 class="card-text mb-0">{{ number_format($countOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$countOrderToday" :yesterdayValue="$countOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                            {{--  <div class="col-3 text-center">
                            <i class="bi bi-bar-chart-fill text-primary" style="font-size:2rem"></i>
                        </div>  --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-top border-secondary card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-3 text-center">
                                <i class="bi bi-cash text-primary" style="font-size:2rem"></i>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title">Total <span class="fw-bold">Cash</span></h5>
                                    <h3 class="card-text">Rp{{ number_format($sumCashOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$sumCashOrderToday" :yesterdayValue="$sumCashOrderYesterday" />
                                    <p class="card-text text-muted fst-italic">
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-top border-secondary card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-3 text-center">
                                <i class="bi bi-bank text-primary" style="font-size:2rem"></i>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title">Total <span class="fw-bold">Transfer</span></h5>
                                    <h3 class="card-text">Rp{{ number_format($sumTFOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$sumTFOrderToday" :yesterdayValue="$sumTFOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-top border-secondary card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-3 text-center">
                                <i class="bi bi-upc-scan text-primary" style="font-size:2rem"></i>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title">Total <span class="fw-bold">QRIS</span></h5>
                                    <h3 class="card-text">Rp{{ number_format($sumQRISOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$sumQRISOrderToday" :yesterdayValue="$sumQRISOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-top border-success card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title"> Transaksi <span class="fw-bold">Cash</span></h5>
                                    <h3 class="card-text">{{ number_format($countCashOrderToday, 0, ',', '.') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$countCashOrderToday" :yesterdayValue="$countCashOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                <i class="bi bi-coin text-primary" style="font-size:2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-top border-success card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title"> Transaksi <span class="fw-bold">Transfer</span></h5>
                                    <h3 class="card-text">{{ number_format($countTFOrderToday, 0, ',', ',') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$countTFOrderToday" :yesterdayValue="$countTFOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                <i class="bi bi-arrow-left-right text-primary" style="font-size:2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-top border-success card-hover" style="border-top-width:10px">
                        <div class="row g-0 align-items-center">
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title"> Transaksi <span class="fw-bold">QRIS</span></h5>
                                    <h3 class="card-text">{{ number_format($countQRISOrderToday, 0, ',', ',') }}</h3>
                                    <x-check-comparation-per-day :todayValue="$countQRISOrderToday" :yesterdayValue="$countQRISOrderYesterday" />
                                    <p class="card-text tex-muted fst-italic">
                                        <small class="text-muted">Pada Tanggal
                                            {{ Carbon\Carbon::now()->format('d-m-Y') }}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                <i class="bi bi-qr-code-scan text-primary" style="font-size:2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Pendapatan</h5>
                            <form class="row g-2 align-items-end mb-3  justify-content-end" id="filterForm">
                                <div class="col-md-3">
                                    <label for="bulanTahun" class="form-label mb-0">Bulan & Tahun</label>
                                    <input type="month" class="form-control" id="bulanTahun" name="bulanTahun" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                                </div>
                            </form>
                            <canvas id="barChart" height="100"></canvas>
                            <div class="mb-3 text-center">
                                <h6>Total Pendapatan: <span id="totalPerMonth">Rp0</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card" style="overflow-x: auto;">
                        <h5 class="card-header">Data Pesanan Terbaru</h5>
                        <hr />
                        <div class="table-responsive">
                            <table id="datatables" class="table table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal <br>Order</th>
                                        <th>Pelanggan</th>
                                        <th>Invoice</th>
                                        <th>Proofing</th>
                                        <th>Deadline</th>
                                        <th>Express</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $i => $order)
                                        @php
                                            $status = $order->status_pengerjaan;
                                            $badges = [
                                                'pending' => 'bg-label-info',
                                                'verif_pembayaran' => 'bg-label-dark',
                                                'verif_pesanan' => 'bg-label-info',
                                                'produksi' => 'bg-label-primary',
                                                'pengambilan' => 'bg-label-dark',
                                                'selesai' => 'bg-label-success',
                                            ];
                                            $label = [
                                                'pending' => 'Pending',
                                                'verif_pembayaran' => 'Verifikasi Pembayaran',
                                                'verif_pesanan' => 'Verifikasi Pesanan',
                                                'produksi' => 'Produksi',
                                                'pengambilan' => 'Pengambilan',
                                                'selesai' => 'Selesai',
                                            ];
                                        @endphp
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d/m/Y') }}
                                                <br>{{ $order->waktu }}
                                            </td>
                                            <td>{{ $order->nama_pelanggan }} -<br>{{ $order->kontak_pelanggan }}</td>
                                            @php
                                                $no_spk = $order->spk ?? '';
                                                $invoice_number =
                                                    'INV' . explode('-', str_replace('SPK', '', $no_spk))[0];
                                            @endphp
                                            <td>{{ $invoice_number ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->kebutuhan_proofing ? 'bg-label-success' : 'bg-label-primary' }}">
                                                    {{ $order->kebutuhan_proofing ? 'Proofing' : 'Cetak Jadi' }}
                                                </span>
                                            </td>
                                            <td>{!! \Carbon\Carbon::parse($order->deadline)->format('d/m/y') .
                                                '<br>' .
                                                \Carbon\Carbon::parse($order->deadline)->format('H:i:s') !!}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->express ? 'bg-label-success' : 'bg-label-primary' }}">
                                                    {{ $order->express ? 'Express' : 'Tidak' }}
                                                </span>
                                            </td>
                                            <td> <span class="badge {{ $badges[$status] ?? 'secondary' }}">
                                                    {{ $label[$status] ?? ucfirst($status) }}
                                                </span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Belum ada data order</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Jenis Cetakan per Bulan</h5>
                    <hr />
                    <form class="row g-2 align-items-end mb-3 justify-content-end" id="filterCategoryForm">
                        <div class="col-md-3">
                            <label for="bulanTahunKategori" class="form-label mb-0">Bulan & Tahun</label>
                            <input type="month" class="form-control" id="bulanTahunKategori" name="bulanTahunKategori"
                                required>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableKategori">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Cetakan</th>
                                    <th>Total Pendapatan</th>
                                    <th>Total Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi via jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            <script>
                $(function() {
                    var now = new Date();
                    var year = now.getFullYear();
                    var month = (now.getMonth() + 1).toString().padStart(2, '0');
                    var bulanIni = year + '-' + month;
                    $('#bulanTahun').val(bulanIni);

                    var ctx = document.getElementById('barChart').getContext('2d');
                    var barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [],
                            datasets: [{
                                label: 'Pendapatan',
                                data: [],
                                backgroundColor: [
                                    'rgba(0, 123, 255, 0.9)',
                                    'rgba(0, 105, 217, 0.8)',
                                    'rgba(0, 91, 196, 0.7)',
                                    'rgba(0, 77, 175, 0.7)',
                                    'rgba(0, 60, 153, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(0, 123, 255, 1)',
                                    'rgba(0, 105, 217, 1)',
                                    'rgba(0, 91, 196, 1)',
                                    'rgba(0, 77, 175, 1)',
                                    'rgba(0, 60, 153, 1)'
                                ],

                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    function loadChart(period) {
                        $.getJSON('/dashboard/index-json', {
                            period: period
                        }, function(data) {
                            var labels = data.weekly.map(item =>
                                item.minggu + ' (' +
                                item.start.substr(8, 2) + '-' + item.start.substr(5, 2) +
                                ' s/d ' +
                                item.end.substr(8, 2) + '-' + item.end.substr(5, 2) +
                                ')'
                            );
                            var totals = data.weekly.map(item => item.total);

                            barChart.data.labels = labels;
                            barChart.data.datasets[0].data = totals;
                            barChart.update();

                            $('#totalPerMonth').text('Rp' + Number(data.total_per_month).toLocaleString('id-ID'));
                        });
                    }

                    loadChart(bulanIni);

                    $('#filterForm').on('submit', function(e) {
                        e.preventDefault();
                        var bulanTahun = $('#bulanTahun').val();
                        loadChart(bulanTahun);
                    });
                });

                var now = new Date();
                var year = now.getFullYear();
                var month = (now.getMonth() + 1).toString().padStart(2, '0');
                var bulanIni = year + '-' + month;
                $('#bulanTahunKategori').val(bulanIni);

                function loadKategori(period) {
                    $.getJSON('/dashboard/index-category-json', {
                        period_in_category: period
                    }, function(data) {
                        var html = '';
                        if (data.length === 0) {
                            html = '<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>';
                        } else {
                            let no = 0;
                            data.forEach(function(item) {
                                no++
                                html += '<tr>' +
                                    '<td>' + no + '</td>' +
                                    '<td>' + item.name + '</td>' +
                                    '<td>Rp' + Number(item.op_sub_total).toLocaleString('id-ID') + '</td>' +
                                    '<td>' + Number(item.total_order).toLocaleString('id-ID') + '</td>' +
                                    '</tr>';
                            });
                        }
                        $('#tableKategori tbody').html(html);
                    });
                }

                loadKategori(bulanIni);

                $('#filterCategoryForm').on('submit', function(e) {
                    e.preventDefault();
                    var period = $('#bulanTahunKategori').val();
                    loadKategori(period);
                });
            </script>
        @endsection
    @else
        <div class="container-fluid flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Selamat Datang di POS</h5>
                                    <p class="mb-4">
                                        POS Sinau dirancang untuk mendukung proses penjualan dan transaksi Sinau. Kelola
                                        pembayaran, data peserta, dan aktivitas lainnya dengan lebih
                                        terstruktur dan informatif.
                                    </p>

                                    <a href="{{ url('orders') }}" class="btn btn-sm btn-outline-primary">Mulai Sekarang</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan


@endsection
