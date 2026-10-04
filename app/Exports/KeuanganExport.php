<?php

namespace App\Exports;

use App\Models\Keuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeuanganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $kategori;
    protected $tipe;

    public function __construct($startDate = null, $endDate = null, $kategori = null, $tipe = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->kategori = $kategori;
        $this->tipe = $tipe;
    }

    public function collection()
    {
        $query = Keuangan::with('user')->orderBy('tanggal', 'asc')->orderBy('id', 'asc');

        if ($this->startDate) {
            $query->where('tanggal', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('tanggal', '<=', $this->endDate);
        }
        if ($this->kategori && $this->kategori !== 'all') {
            $query->where('kategori', $this->kategori);
        }
        if ($this->tipe && $this->tipe !== 'all') {
            $query->where('tipe', $this->tipe);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Tipe',
            'Kategori',
            'Keterangan',
            'Pemasukan (Rp)',
            'Pengeluaran (Rp)',
            'Saldo Berjalan (Rp)',
            'Dicatat Oleh',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->tanggal->format('d/m/Y'),
            strtoupper($row->tipe),
            $row->kategori,
            $row->keterangan,
            $row->tipe === 'pemasukan' ? (float)$row->jumlah : 0,
            $row->tipe === 'pengeluaran' ? (float)$row->jumlah : 0,
            (float)($row->saldo_setelahnya ?? 0),
            $row->user ? $row->user->name : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '059669'], // Emerald color
                ],
            ],
        ];
    }
}
