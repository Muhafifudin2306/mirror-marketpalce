<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoiceNo }}</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
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
                        <td>{{ $order->nama_pelanggan }}</td>
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
                {{-- <th>#</th> --}}
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lines as $idx => $line)
                <tr>
                    {{-- <td>{{ $idx + 1 }}</td> --}}
                    <td width="40%">
                        {{ $line['name'] }}
                        @if (!empty($line['additional_size']))
                            {{ ' ' . $line['additional_size'] }}
                        @endif
                        @if (!empty($line['additional_unit']))
                            {{ ' ' . $line['additional_unit'] }}
                        @endif

                        {{-- Logika untuk long_order dan width_order --}}
                        @if (!empty($line['long_order']) && !empty($line['width_order']))
                            {{ ' ' . $line['long_order'] . ' x ' . $line['width_order'] }}
                        @elseif (!empty($line['long_order']))
                            {{ ' ' . $line['long_order'] }}
                        @elseif (!empty($line['width_order']))
                            {{ ' ' . $line['width_order'] }}
                        @endif
                    </td>
                    <td align="center">{{ number_format($line['qty'], 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($line['unit_price'], 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($line['line_total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @php
                $expressTotal = 0;
                foreach ($lines as $line) {
                    $expressTotal += $line['line_total'];
                }
            @endphp

            @if ($express == 1)
                <tr>
                    <td>Kebutuhan Express</td>
                    <td align="center">50%</td>
                    <td align="right">{{ number_format(0.5 * $expressTotal, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format(0.5 * $expressTotal, 2, ',', '.') }}</td>
                </tr>
            @endif

            @if ($order->potongan_rp)
                <tr>
                    <td>Potongan Harga</td>
                    <td align="center">1</td>
                    <td align="right">{{ number_format($potongan_rp, 2, ',', '.') }}</td>
                    <td align="right">- {{ number_format($potongan_rp, 2, ',', '.') }}</td>
                </tr>
            @elseif ($order->diskon_persen)
                <tr>
                    <td>Diskon Persen</td>
                    <td align="center">{{ $diskon_persen }}%</td>
                    <td align="right">
                        {{ number_format(($order->diskon_persen / 100) * ($subtotal - $order->ongkir ?? 0)) }}
                    </td>
                    <td align="right">-
                        {{ number_format(($order->diskon_persen / 100) * ($subtotal - $order->ongkir ?? 0)) }}
                    </td>
                </tr>
            @endif

            @if ($order->metode_pengiriman)
                <tr>
                    <td>Pengiriman {{ $order->kurir }}</td>
                    <td align="center">1</td>
                    <td align="right">{{ number_format($order->ongkir, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($order->ongkir, 2, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td align="right" class="gray">Total</td>
                @if ($order->potongan_rp)
                    <td align="right" class="gray">
                        {{ number_format($order->subtotal - $order->potongan_rp, 2, ',', '.') }}</td>
                @elseif ($order->diskon_persen)
                    <td align="right" class="gray">
                        {{ number_format($order->subtotal - ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir), 2, ',', '.') }}
                    </td>
                @else
                    <td align="right" class="gray">{{ number_format($order->subtotal, 2, ',', '.') }}
                    </td>
                @endif
            </tr>
            @if ($metodeTransaksi == $metodeTransaksiPaid)
                <tr>
                    <td colspan="2"></td>
                    <td align="right" class="no-bold">Payment Method: </td>
                    <td align="right" class="no-bold">
                        @if ($metodeTransaksi == 0)
                            Cash
                        @elseif ($metodeTransaksi == 1)
                            Transfer
                        @elseif ($metodeTransaksi == 2)
                            QRIS
                        @else
                            Tidak Diketahui
                        @endif
                    </td>
                </tr>
            @elseif ($metodeTransaksi != $metodeTransaksiPaid)
                @if ($order->dp)
                    <tr>
                        <td colspan="2"></td>
                        <td align="right" class="no-bold">DP Method: </td>
                        <td align="right" class="no-bold">
                            @if ($metodeTransaksi == 0)
                                Cash
                            @elseif ($metodeTransaksi == 1)
                                Transfer
                            @elseif ($metodeTransaksi == 2)
                                QRIS
                            @else
                                Tidak Diketahui
                            @endif
                            ({{ number_format($order->dp, 2, ',', '.') }})
                        </td>
                    </tr>
                @endif
                @if ($order->full_payment)
                    <tr>
                        <td colspan="2"></td>
                        <td align="right" class="no-bold">Final Payment: </td>
                        <td align="right" class="no-bold">
                            @if ($metodeTransaksiPaid == 0)
                                Cash
                            @elseif ($metodeTransaksiPaid == 1)
                                Transfer
                            @elseif ($metodeTransaksiPaid == 2)
                                QRIS
                            @else
                                Tidak Diketahui
                            @endif
                            ({{ number_format($order->full_payment, 2, ',', '.') }})
                        </td>
                    </tr>
                @endif
            @endif
            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold">Paid Amount:</td>
                @php
                    $subtotal = $order->subtotal;
                    if ($order->potongan_rp) {
                        $dibayar = $subtotal - $order->potongan_rp - $order->termin;
                    } elseif ($order->diskon_persen) {
                        $dibayar =
                            $subtotal -
                            ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir) -
                            $order->termin;
                    } else {
                        $dibayar = $subtotal - $order->termin;
                    }
                @endphp
                <td align="right" class="no-bold">{{ number_format($dibayar, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold">Amount Due:</td>
                <td align="right" class="no-bold">{{ number_format($termin, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td align="right" class="no-bold"></td>
                <td align="right" class="no-bold"></td>
            </tr>
            @if ($metodeTransaksi == 1)
                <tr>
                    <td colspan="7" align="left" class="no-bold">TRANSFER No. rek : BCA 2521644747 a.n.
                        IBNU HAMZAH
                    </td>
                </tr>
            @endif
        </tfoot>
    </table>


</body>

</html>
