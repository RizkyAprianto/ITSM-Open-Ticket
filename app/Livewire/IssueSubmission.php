<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class IssueSubmission extends Component
{
    public $user_type = 'student'; // student, lecturer, staff
    public $id_number = ''; // Placeholder for NIM or NIP
    public $name = '';
    public $phone = '';
    public $category_id = '';
    public $description = '';

    // Honeypot: field jebakan untuk bot, harus selalu kosong
    public string $honeypot = '';

    public $isSubmitted = false;
    public $ticketId = '';

    protected function rules()
    {
        return [
            'user_type' => 'required|in:student,lecturer,staff',
            'id_number' => 'required|string|max:30',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10|max:1000',
        ];
    }

    protected $messages = [
        'nim.required' => 'NIM wajib diisi.',
        'name.required' => 'Nama wajib diisi.',
        'phone.required' => 'Nomor HP wajib diisi.',
        'category_id.required' => 'Silakan pilih kategori kendala.',
        'description.required' => 'Deskripsi kendala wajib diisi minimal 10 karakter.',
        'description.min' => 'Deskripsi terlalu singkat, mohon jelaskan lebih detail.',
    ];

    public function formatPhoneNumber($number)
    {
        // Remove non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Convert to 62...
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        
        return $number;
    }

    public function submit()
    {
        // =============================================
        // LAYER 1: Honeypot Check (Anti-Bot)
        // Jika field honeypot terisi, bot terdeteksi.
        // Tampilkan fake success agar bot tidak tahu.
        // =============================================
        if (!empty($this->honeypot)) {
            $this->isSubmitted = true; // fake success, tiket tidak disimpan
            return;
        }

        // =============================================
        // Validasi Form Biasa
        // =============================================
        $this->validate();

        // =============================================
        // LAYER 2: NIM Cooldown via Cache (10 menit)
        // Tidak memerlukan validasi SIAKAD.
        // NIM hanya digunakan sebagai key cache.
        // =============================================
        $nimCacheKey = 'nim-cooldown:' . $this->id_number;
        if (Cache::has($nimCacheKey)) {
            $this->addError('id_number', 'Kamu baru saja mengirim laporan. Silakan tunggu beberapa menit sebelum mengirim laporan baru.');
            return;
        }

        // =============================================
        // LAYER 3: Duplicate Check per NIM + Kategori
        // Cegah tiket ganda yang masih aktif.
        // =============================================
        $hasDuplicate = Ticket::where('guest_nim', $this->id_number)
            ->where('category_id', $this->category_id)
            ->whereIn('status', ['open', 'in_progress'])
            ->exists();

        if ($hasDuplicate) {
            $this->addError('description', 'Kamu sudah memiliki laporan aktif untuk kategori ini. Tunggu hingga tiket sebelumnya diselesaikan.');
            return;
        }

        // =============================================
        // Buat Tiket (semua layer lolos)
        // =============================================
        $formattedPhone = $this->formatPhoneNumber($this->phone);
        
        $typePrefix = [
            'student' => 'MHS',
            'lecturer' => 'DSN',
            'staff' => 'STF'
        ][$this->user_type];

        $ticket = Ticket::create([
            'guest_nim' => $this->id_number, // Tetap simpan di guest_nim/id_number
            'guest_name' => $this->name,
            'guest_phone' => $formattedPhone,
            'category_id' => $this->category_id,
            'title' => '[' . $typePrefix . '] Laporan Kendala - ' . $this->id_number,
            'description' => $this->description,
            'status' => 'open',
            'priority' => 'medium',
        ]);

        // Aktifkan cooldown 10 menit untuk NIM ini setelah berhasil submit
        Cache::put($nimCacheKey, true, now()->addMinutes(10));

        $this->ticketId = (string) $ticket->uuid;
        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('livewire.issue-submission', [
            'categories' => Category::all(),
        ]);
    }
}
