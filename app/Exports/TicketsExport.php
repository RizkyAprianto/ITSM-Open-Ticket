<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        $query = Ticket::query()->with('category')->orderBy('created_at', 'asc');
        
        if ($this->month && $this->month > 0) {
            $query->whereMonth('created_at', $this->month);
        }
        if ($this->year && $this->year > 0) {
            $query->whereYear('created_at', $this->year);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Tiket ID',
            'Nama Pelapor',
            'NIM/NIP',
            'Nomor HP',
            'Kategori',
            'Judul/Masalah',
            'Status',
            'Prioritas',
            'Tanggal Dibuat',
            'Tanggal Selesai'
        ];
    }

    public function map($ticket): array
    {
        $statusLabels = [
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ];

        $priorityLabels = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
        ];

        return [
            substr($ticket->uuid, 0, 8),
            $ticket->guest_name,
            $ticket->guest_nim,
            $ticket->guest_phone,
            $ticket->category ? $ticket->category->name : '-',
            $ticket->title,
            $statusLabels[$ticket->status] ?? $ticket->status,
            $priorityLabels[$ticket->priority] ?? $ticket->priority,
            $ticket->created_at->format('d/m/Y H:i'),
            $ticket->solved_at ? $ticket->solved_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
