<div wire:poll.10s="checkNewTickets">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto">
            <input type="text" wire:model.live="search" placeholder="Cari Nama, NIM, atau Judul..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-64">
            
            <select wire:model.live="statusFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Semua Status</option>
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
            </select>

            <div class="flex items-center space-x-2">
                <input type="date" wire:model.live="startDate" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <span class="text-gray-500">s/d</span>
                <input type="date" wire:model.live="endDate" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiket ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Identitas (NIM/NIP)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengirim</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori & Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ substr($ticket->uuid, 0, 8) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">
                            {{ $ticket->guest_nim ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $ticket->guest_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-bold">{{ $ticket->title }}</div>
                            <div class="text-xs text-blue-600 font-medium mb-1">{{ optional($ticket->category)->name ?? 'Uncategorized' }}</div>
                            <div class="text-sm text-gray-500 line-clamp-2 italic">"{{ $ticket->description }}"</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                wire:click="openStatusModal({{ $ticket->id }})"
                                class="text-xs font-semibold rounded-full px-3 py-1.5 border hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2
                                {{ $ticket->status === 'open' ? 'bg-red-100 text-red-800 border-red-200 focus:ring-red-500' : '' }}
                                {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800 border-yellow-200 focus:ring-yellow-500' : '' }}
                                {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-800 border-green-200 focus:ring-green-500' : '' }}
                                {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-800 border-gray-200 focus:ring-gray-500' : '' }}
                                ">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                <svg class="inline-block w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ticket->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <!-- WhatsApp Action -->
                            @if($ticket->guest_phone)
                                <a href="https://wa.me/{{ $ticket->guest_phone }}?text=Halo%20{{ urlencode($ticket->guest_name) }},%20kami%20dari%20Tim%20IT%20Kampus%20terkait%20laporan%20kendala%20Anda..." target="_blank" class="text-green-600 hover:text-green-900 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M11.996 0A12 12 0 0 0 0 12c0 2.115.553 4.103 1.531 5.823L.125 23.875l6.216-1.391A11.961 11.961 0 0 0 11.996 24C18.625 24 24 18.625 24 12S18.625 0 11.996 0zm0 22.008c-1.802 0-3.513-.464-5.06-1.341l-.36-.213-3.766.845.859-3.666-.233-.37c-.966-1.536-1.479-3.32-1.479-5.185 0-5.525 4.492-10.012 10.038-10.012 5.545 0 10.036 4.487 10.036 10.012S17.541 22.008 11.996 22.008zm5.508-7.519c-.302-.152-1.789-.884-2.066-.985-.278-.102-.48-.152-.682.152-.202.304-.783.985-.96 1.187-.177.202-.355.228-.657.076-1.637-.828-2.673-1.602-3.714-3.415-.205-.357.202-.338.794-1.528.076-.153.038-.28-.019-.381-.057-.102-.682-1.644-.935-2.253-.245-.591-.497-.512-.682-.52-.177-.008-.38-.01-.582-.01-.202 0-.53.076-.808.381s-1.06 1.04-1.06 2.537c0 1.497 1.085 2.943 1.237 3.146.152.204 2.146 3.277 5.197 4.593 2.068.892 2.766.974 3.754.821.844-.132 2.686-1.096 3.064-2.155.378-1.059.378-1.966.265-2.155-.113-.189-.417-.303-.719-.455z"/></svg>
                                    Hubungi
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Belum ada tiket yang ditemukan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $tickets->links() }}
        </div>
    </div>

    <!-- Status Update Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeStatusModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="updateStatus">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Ubah Status Tiket
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="newStatus" class="block text-sm font-medium text-gray-700">Status Baru</label>
                                <select id="newStatus" wire:model.live="newStatus" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="closed">Closed</option>
                                </select>
                                @error('newStatus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            @if($newStatus === 'resolved')
                                <div>
                                    <label for="resolutionNote" class="block text-sm font-medium text-gray-700">Catatan Penyelesaian</label>
                                    <textarea id="resolutionNote" wire:model="resolutionNote" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    @error('resolutionNote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="resolutionEvidence" class="block text-sm font-medium text-gray-700">Bukti/Eviden (Wajib)</label>
                                    <input type="file" id="resolutionEvidence" wire:model="resolutionEvidence" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @error('resolutionEvidence') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" wire:click="closeStatusModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Real-time Notification Toast & Audio -->
    <audio id="notification-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
    
    <div 
        x-data="{ show: false, message: '' }"
        x-on:new-ticket-alert.window="
            message = $event.detail.title;
            show = true;
            document.getElementById('notification-sound').play().catch(e => console.log('Audio play error:', e));
            setTimeout(() => { show = false }, 5000);
        "
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-4 right-4 sm:top-6 sm:right-6 z-[100] max-w-sm w-full bg-white shadow-2xl rounded-xl pointer-events-auto border border-blue-100 overflow-hidden"
        style="display: none;"
    >
        <div class="p-4 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-50 opacity-50"></div>
            <div class="relative flex items-start">
                <div class="flex-shrink-0 pt-0.5">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-bold text-slate-900">
                        Laporan Baru Masuk!
                    </p>
                    <p class="mt-1 text-sm font-medium text-slate-600" x-text="message"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="show = false" class="bg-transparent rounded-md inline-flex text-slate-400 hover:text-slate-600 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
