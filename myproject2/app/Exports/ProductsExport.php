<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $products = Product::all();

        // Add "No" column
        $products = $products->map(function ($product, $index) {
            return [
                'No' => $index + 1,
                'ID' => $product->id,
                'Product Name' => $product->product_name,
                'Unit' => $product->unit,
                'Type' => $product->type,
                'Information' => $product->information,
                'Qty' => $product->qty,
                'Producer' => $product->producer,
                'Updated At' => $product->updated_at,
                'Created At' => $product->created_at,
            ];
        });

        return collect($products); // ← return the mapped collection
    }


    public function headings(): array
    {
        return [
            'No',
            'ID',
            'Prodcut Name',
            'Unit',
            'Type',
            'Information',
            'Qty',
            'Producer',
            'Updated At',
            'Created At',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 2);

                $sheet->setCellValue('A1', 'PT PT');
                $sheet->setCellValue('A2', 'Rekap Stock Produk');
                $sheet->setCellValue('A3', '');

                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

                // --- Timestamp at the bottom-left ---
                $timestampRow = $sheet->getHighestRow() + 2; // leave one empty row
                $timestamp = now()->format('d-m-Y H:i:s');
                $sheet->setCellValue('A' . $timestampRow, 'Generated at: ' . $timestamp);
                $sheet->getStyle('A' . $timestampRow)->getFont()->setItalic(true);
            },
        ];
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
