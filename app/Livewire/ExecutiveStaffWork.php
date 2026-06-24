<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket;

class ExecutiveStaffWork extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $search = '';
    public $startDate = '';
    public $endDate = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Ticket::with('category')->orderBy('updated_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('guest_name', 'like', '%' . $this->search . '%')
                  ->orWhere('guest_nim', 'like', '%' . $this->search . '%')
                  ->orWhere('uuid', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00', 
                $this->endDate . ' 23:59:59'
            ]);
        } elseif ($this->startDate) {
            $query->where('created_at', '>=', $this->startDate . ' 00:00:00');
        } elseif ($this->endDate) {
            $query->where('created_at', '<=', $this->endDate . ' 23:59:59');
        }

        // Hide resolved tickets that are not from today
        $query->where(function($q) {
            $q->where('status', '!=', 'resolved')
              ->orWhere(function($subQ) {
                  $subQ->where('status', 'resolved')
                       ->whereDate('updated_at', today());
              });
        });

        $tickets = $query->paginate(15);

        return view('livewire.executive-staff-work', [
            'tickets' => $tickets
        ])->layout('components.layouts.executive');
    }
}
