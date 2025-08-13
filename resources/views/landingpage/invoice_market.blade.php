<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoiceNo }}</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 11px !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .no-border td {
            border: none !important;
            padding: 2px 0;
        }

        .header-table td {
            border: none;
        }

        .header-table pre {
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        tfoot td {
            border: none !important;
            padding: 5px 0 !important;
        }

        .meta-table td {
            vertical-align: top;
        }

        .meta-table .label {
            white-space: nowrap;
            padding-right: 5px;
            width: 100px;
        }

        .meta-table .colon {
            text-align: center;
            width: 10px;
        }

        .meta-table .value {
            text-align: left;
        }

        .section-divider {
            border-bottom: 1px solid #000;
            margin-top: 0px;
            margin-bottom: 10px;
        }

        .gray {
            background-color: lightgray;
        }

        tfoot tr td {
            font-size: x-small;
        }

        .no-bold {
            font-weight: normal !important;
        }
    </style>
</head>

<body>
    <table class="no-border">
        <tr>
            <td align="left">
                <table class="no-border">
                    <tr>
                        <td>
                            <h1>INVOICE</h1>
                            <h2>SINAU PRINT</h2>
                            <p>
                                Jl. Jatibarang Timur 16 No. 184, Kel. Kedungpane,
                                <br>
                                Kec. Mijen, Kota Semarang, Jawa Tengah 50211
                                <br> <br>
                                sinauprint@gmail.com
                                <br>
                                0819 5276 4747
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="section-divider"></div>
            </td>
        </tr>
    </table>

    <table class="meta-table no-border">
        <tr>
            <td width="70%">
                <table class="no-border">
                    <tr>
                        <td>
                            <strong>Bill to</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $order->nama_pelanggan ?? $order->user->name ?? 'Customer' }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="no-border">
                    <tr>
                        <td class="label">Invoice No</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $invoiceNo }}</td>
                    </tr>
                    <tr>
                        <td class="label">Date</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $date }}</td>
                    </tr>
                    <tr>
                        <td class="label">Due date</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $dueDate }}</td>
                    </tr>
                    <tr>
                        <td class="label">Payment Status</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $paymentStatus }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>

    <!-- ITEM LIST -->
    <table class="meta-table">
        <thead class="gray">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lines as $idx => $line)
                <tr>
                    <td width="40%">{{ $line['name'] }}</td>
                    <td align="center">{{ number_format($line['qty'], 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($line['unit_price'], 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($line['line_total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Express Fee --}}
            @if($expressFee > 0)
                <tr>
                    <td>Kebutuhan Express</td>
                    <td align="center">50%</td>
                    <td align="right">{{ number_format($expressFee, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($expressFee, 2, ',', '.') }}</td>
                </tr>
            @endif
            
            @if($promoDiscount > 0)
                <tr>
                    <td>Kode Promo</td>
                    <td align="center">1</td>
                    <td align="right">{{ number_format($promoDiscount, 2, ',', '.') }}</td>
                    <td align="right">- {{ number_format($promoDiscount, 2, ',', '.') }}</td>
                </tr>
            @endif

            @if($ongkir > 0)
                <tr>
                    <td>Pengiriman {{ $order->kurir ?? 'Kurir' }}</td>
                    <td align="center">1</td>
                    <td align="right">{{ number_format($ongkir, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($ongkir, 2, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td align="right" class="gray">Total</td>
                <td align="right" class="gray">{{ number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>

            {{-- Payment Method Info --}}
            @if ($metodeTransaksi == $metodeTransaksiPaid)
                <tr>
                    <td colspan="2"></td>
                    <td align="right" class="no-bold">Payment Method: </td>
                    <td align="right" class="no-bold">
                        @switch($metodeTransaksi)
                            @case(0) Cash @break
                            @case(1) Transfer @break
                            @case(2) QRIS @break
                            @case(3) Online Payment @break
                            @default Tidak Diketahui @break
                        @endswitch
                    </td>
                </tr>
            @else
                @if($order->dp > 0)
                    <tr>
                        <td colspan="2"></td>
                        <td align="right" class="no-bold">DP Method: </td>
                        <td align="right" class="no-bold">
                            @switch($metodeTransaksi)
                                @case(0) Cash @break
                                @case(1) Transfer @break
                                @case(2) QRIS @break
                                @case(3) Online Payment @break
                                @default Tidak Diketahui @break
                            @endswitch
                            ({{ number_format($order->dp, 2, ',', '.') }})
                        </td>
                    </tr>
                @endif
                
                @if($order->full_payment > 0)
                    <tr>
                        <td colspan="2"></td>
                        <td align="right" class="no-bold">Final Payment: </td>
                        <td align="right" class="no-bold">
                            @switch($metodeTransaksiPaid)
                                @case(0) Cash @break
                                @case(1) Transfer @break
                                @case(2) QRIS @break
                                @case(3) Online Payment @break
                                @default Tidak Diketahui @break
                            @endswitch
                            ({{ number_format($order->full_payment, 2, ',', '.') }})
                        </td>
                    </tr>
                @endif
            @endif

            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold">Paid Amount:</td>
                <td align="right" class="no-bold">{{ number_format($paidAmount, 2, ',', '.') }}</td>
            </tr>
            
            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold">Amount Due:</td>
                <td align="right" class="no-bold">{{ number_format($amountDue, 2, ',', '.') }}</td>
            </tr>
            
            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold"></td>
                <td align="right" class="no-bold"></td>
            </tr>
            
            @if ($metodeTransaksi == 1)
                <tr>
                    <td colspan="2" align="left" class="no-bold">
                        TRANSFER No. rek : BCA 2521644747 a.n. IBNU HAMZAH
                    </td>
                </tr>
            @endif
        </tfoot>
    </table>

</body>
</html>