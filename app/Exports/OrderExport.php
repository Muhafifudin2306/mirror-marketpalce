<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class OrderExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'NO',
            'SPK',
            'TGL',
            'WAKTU ORDER',
            'CUST',
            'NO TLP',
            'EMAIL',
            'NAMA FILE',
            'BAHAN',
            'P',
            'L',
            'QTY',
            'TOTAL METER',
            'HARGA',
            'TOTAL HARGA',
            'METODE PEMBAYARAN',
            'TOTAL BAYAR',
            'TANGGAL BAYAR',
            'TOTAL PIUTANG',
            'KET PAY',
            'KET JADI',
            'TIME PICKUP'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $data = $this->data;
                $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V']; // Kolom Invoice (A=No, B=Invoice, dst)
                $startRow = 2;

                $prevInvoice = null;
                $mergeStart = $startRow;

                foreach ($data as $index => $row) {
                    $currentRow = $startRow + $index;
                    if ($prevInvoice === null) {
                        $prevInvoice = $row['invoice'];
                        $mergeStart = $currentRow;
                    } elseif ($row['invoice'] !== $prevInvoice) {
                        if ($mergeStart < $currentRow - 1) {
                            foreach ($cols as $col) {
                                $sheet->mergeCells("{$col}{$mergeStart}:{$col}" . ($currentRow - 1));
                            }
                        }
                        $prevInvoice = $row['invoice'];
                        $mergeStart = $currentRow;
                    }
                }
                if (isset($currentRow) && $mergeStart < $currentRow) {
                    foreach ($cols as $col) {
                        $sheet->mergeCells("{$col}{$mergeStart}:{$col}{$currentRow}");
                    }
                }
                foreach (range('A', 'V') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                $headingRange = 'A1:AA1'; // Sesuaikan dengan jumlah kolom headings
                $sheet->getStyle($headingRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '0070C0' 
                        ]
                    ],
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF'],
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}
