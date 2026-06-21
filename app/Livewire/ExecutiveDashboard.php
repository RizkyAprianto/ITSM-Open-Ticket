<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Category;

class ExecutiveDashboard extends Component
{
    public int $filterMonth = 0; // 0 = Semua bulan
    public int $filterYear = 0;  // 0 = Semua tahun

    public function mount()
    {
        $this->filterYear = now()->year;
    }

    public function getPdfUrlProperty(): string
    {
        return route('executive.report.pdf', [
            'month' => $this->filterMonth,
            'year' => $this->filterYear
        ]);
    }

    public function getExcelUrlProperty(): string
    {
        return route('executive.report.excel', [
            'month' => $this->filterMonth,
            'year' => $this->filterYear
        ]);
    }

    public function render()
    {
        // Metric 1: Total Overall
        $totalTickets = Ticket::count();

        // Metric 2: Tickets by Status (Pie Chart)
        $statusCounts = Ticket::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $chartStatusData = [
            $statusCounts['open'] ?? 0,
            $statusCounts['in_progress'] ?? 0,
            $statusCounts['resolved'] ?? 0,
            $statusCounts['closed'] ?? 0,
        ];

        // Metric 3: Tickets by Category (Bar Chart)
        $categories = Category::withCount('tickets')->get();
        $chartCategoryNames = $categories->pluck('name')->toArray();
        $chartCategoryCounts = $categories->pluck('tickets_count')->toArray();

        // Years for dropdown
        $oldestTicket = Ticket::orderBy('created_at', 'asc')->first();
        $startYear = $oldestTicket ? $oldestTicket->created_at->year : now()->year;
        $years = range($startYear, now()->year);

        return view('livewire.executive-dashboard', [
            'totalTickets' => $totalTickets,
            'chartStatusData' => json_encode($chartStatusData),
            'chartCategoryNames' => json_encode($chartCategoryNames),
            'chartCategoryCounts' => json_encode($chartCategoryCounts),
            'recentTickets' => Ticket::latest()->take(5)->get(),
            'years' => $years,
        ])->layout('components.layouts.executive');
    }
}
