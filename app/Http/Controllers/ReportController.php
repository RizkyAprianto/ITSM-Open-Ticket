<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadPdf(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $query = Ticket::query();
        if ($month && $month > 0) {
            $query->whereMonth('created_at', $month);
        }
        if ($year && $year > 0) {
            $query->whereYear('created_at', $year);
        }

        // 1. Total
        $totalTickets = $query->count();

        // 2. Status Distribution
        $statusCounts = (clone $query)->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 3. Category Distribution
        $categoriesQuery = Category::withCount(['tickets' => function($q) use ($month, $year) {
            if ($month && $month > 0) $q->whereMonth('created_at', $month);
            if ($year && $year > 0) $q->whereYear('created_at', $year);
        }])->get();

        // 4. Ticket Data for Details Table
        $tickets = (clone $query)->with('category')->orderBy('created_at', 'asc')->get();

        $pdf = Pdf::loadView('reports.ticket-summary-pdf', [
            'month' => $month,
            'year' => $year,
            'totalTickets' => $totalTickets,
            'statusCounts' => $statusCounts,
            'categories' => $categoriesQuery->sortByDesc('tickets_count')->take(5),
            'tickets' => $tickets,
            'datePrinted' => now()->format('d M Y H:i')
        ]);

        $filename = 'Laporan-ITSM-' . ($month > 0 ? str_pad($month, 2, '0', STR_PAD_LEFT) . '-' : '') . ($year > 0 ? $year : 'All') . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadExcel(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        
        $filename = 'Detail-Tiket-ITSM-' . ($month > 0 ? str_pad($month, 2, '0', STR_PAD_LEFT) . '-' : '') . ($year > 0 ? $year : 'All') . '.xlsx';
        
        return Excel::download(new TicketsExport($month, $year), $filename);
    }
}
