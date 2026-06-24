<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\Attributes\On;

class PublicTicketTracking extends Component
{
    public $isOpen = false;
    public $searchNim = '';
    public $tickets = [];
    public $selectedTicket = null;
    public $searchError = '';

    #[On('openTrackingModal')]
    public function openModal($nim = null)
    {
        $this->resetTracking();
        $this->isOpen = true;
        
        if ($nim) {
            $this->searchNim = $nim;
            $this->search();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetTracking();
    }

    public function resetTracking()
    {
        $this->searchNim = '';
        $this->tickets = [];
        $this->selectedTicket = null;
        $this->searchError = '';
    }

    public function search()
    {
        $this->searchError = '';
        $this->tickets = [];
        $this->selectedTicket = null;

        if (empty(trim($this->searchNim))) {
            $this->searchError = 'NIM/NIP tidak boleh kosong.';
            return;
        }

        $tickets = Ticket::where('guest_nim', $this->searchNim)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($tickets->isEmpty()) {
            $this->searchError = 'Tidak ditemukan riwayat tiket untuk NIM/NIP tersebut.';
        } else {
            $this->tickets = $tickets;
        }
    }

    public function selectTicket($id)
    {
        $this->selectedTicket = Ticket::where('id', $id)
            ->where('guest_nim', $this->searchNim) // Security check
            ->with('category')
            ->first();
    }

    public function backToList()
    {
        $this->selectedTicket = null;
    }

    public function render()
    {
        return view('livewire.public-ticket-tracking');
    }
}
