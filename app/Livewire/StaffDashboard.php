<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class StaffDashboard extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';

    // Modal Properties
    public $showModal = false;
    public $selectedTicketId = null;
    public $newStatus = '';
    public $resolutionNote = '';
    public $resolutionEvidence = null;

    // Notification Properties
    public $lastCheckedTicketId = 0;

    protected $rules = [
        'newStatus' => 'required|in:open,in_progress,resolved,closed',
    ];

    public function mount()
    {
        // Initialize last checked with the highest ID currently in DB
        $latestTicket = Ticket::latest('id')->first();
        if ($latestTicket) {
            $this->lastCheckedTicketId = $latestTicket->id;
        }
    }

    public function checkNewTickets()
    {
        $newTickets = Ticket::where('id', '>', $this->lastCheckedTicketId)
            ->where('status', 'open')
            ->get();

        if ($newTickets->count() > 0) {
            // Get the highest ID from the new tickets
            $this->lastCheckedTicketId = $newTickets->max('id');
            
            // Dispatch event for the browser to catch
            $latest = $newTickets->first(); // grab one for the toast text
            $this->dispatch('new-ticket-alert', title: $latest->title);
            
            // The table will auto-refresh on the next render
        }
    }

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

    public function openStatusModal($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if ($ticket) {
            $this->selectedTicketId = $ticket->id;
            $this->newStatus = $ticket->status;
            $this->resolutionNote = $ticket->resolution_note;
            $this->resolutionEvidence = null; // reset file input
            $this->showModal = true;
        }
    }

    public function closeStatusModal()
    {
        $this->showModal = false;
        $this->reset(['selectedTicketId', 'newStatus', 'resolutionNote', 'resolutionEvidence']);
    }

    public function updateStatus()
    {
        $this->validate();

        if ($this->newStatus === 'resolved') {
            $this->validate([
                'resolutionNote' => 'required|string|min:5',
                'resolutionEvidence' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
            ], [
                'resolutionNote.required' => 'Catatan penyelesaian wajib diisi.',
                'resolutionEvidence.required' => 'Bukti/Eviden wajib diunggah.',
                'resolutionEvidence.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            ]);
        }

        $ticket = Ticket::find($this->selectedTicketId);
        if ($ticket) {
            $updateData = ['status' => $this->newStatus];

            if ($this->newStatus === 'resolved') {
                $path = $this->resolutionEvidence->store('evidences', 'public');
                $updateData['resolution_note'] = $this->resolutionNote;
                $updateData['resolution_evidence'] = $path;
                $updateData['solved_at'] = now();
            }

            $ticket->update($updateData);
            session()->flash('success', 'Status tiket berhasil diperbarui!');
            $this->closeStatusModal();
        }
    }

    public function render()
    {
        $query = Ticket::query()->with('category')->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('guest_name', 'like', '%' . $this->search . '%')
                  ->orWhere('guest_nim', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
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

        $tickets = $query->paginate(10);

        return view('livewire.staff-dashboard', [
            'tickets' => $tickets
        ])->layout('components.layouts.staff');
    }
}
