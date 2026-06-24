<div>
    @if($isOpen)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <!-- Modal Panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100">
                
                <!-- Header -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Lacak Status Laporan
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 focus:outline-none bg-slate-100 hover:bg-slate-200 p-1.5 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                    
                    @if(!$selectedTicket)
                        <!-- State 1: Search Form -->
                        <div class="mb-8">
                            <label for="searchNim" class="block text-sm font-semibold text-slate-700 mb-2">Masukkan NIM / NIP Anda</label>
                            <div class="flex space-x-3">
                                <input wire:model="searchNim" wire:keydown.enter="search" type="text" id="searchNim" class="flex-1 bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-400 shadow-sm" placeholder="Ketik NIM Anda lalu Enter..." />
                                <button wire:click="search" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors flex items-center">
                                    <span wire:loading.remove wire:target="search">Cari</span>
                                    <span wire:loading wire:target="search">...</span>
                                </button>
                            </div>
                            @if($searchError)
                                <p class="mt-2 text-sm text-rose-500 font-medium">{{ $searchError }}</p>
                            @endif
                        </div>

                        <!-- State 2: Ticket List -->
                        @if(count($tickets) > 0)
                            <div class="space-y-3">
                                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Riwayat Laporan Anda</h4>
                                @foreach($tickets as $ticket)
                                    <div wire:click="selectTicket({{ $ticket->id }})" class="group flex items-center justify-between p-4 bg-white border border-slate-200 hover:border-blue-400 rounded-xl cursor-pointer shadow-sm hover:shadow-md transition-all">
                                        <div class="flex-1 min-w-0 pr-4">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="text-xs font-mono font-bold text-slate-500">{{ substr($ticket->uuid, 0, 8) }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold
                                                    {{ $ticket->status === 'open' ? 'bg-rose-100 text-rose-700' : '' }}
                                                    {{ $ticket->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                                    {{ $ticket->status === 'resolved' || $ticket->status === 'closed' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                                    {{ strtoupper(str_replace('_', ' ', $ticket->status)) }}
                                                </span>
                                            </div>
                                            <p class="text-sm font-bold text-slate-800 truncate group-hover:text-blue-600 transition-colors">{{ $ticket->title }}</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $ticket->created_at->format('d M Y - H:i') }}</p>
                                        </div>
                                        <div class="flex-shrink-0 text-slate-400 group-hover:text-blue-500">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    @else
                        <!-- State 3: Ticket Timeline Detail -->
                        <div>
                            <button wire:click="backToList" class="mb-4 text-sm font-semibold text-slate-500 hover:text-blue-600 flex items-center transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                Kembali ke Daftar
                            </button>

                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 mb-6">
                                <h4 class="text-lg font-bold text-slate-800 mb-1">{{ $selectedTicket->title }}</h4>
                                <p class="text-sm text-slate-600 font-medium mb-3">ID: <span class="font-mono text-slate-800">{{ substr($selectedTicket->uuid, 0, 8) }}</span> | Kategori: {{ optional($selectedTicket->category)->name ?? '-' }}</p>
                                <div class="bg-white p-3 rounded-lg border border-slate-200 text-sm text-slate-700 italic">
                                    "{{ $selectedTicket->description }}"
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="relative pl-4 sm:pl-6">
                                <!-- Line -->
                                <div class="absolute left-[1.35rem] sm:left-[1.85rem] top-2 bottom-2 w-0.5 bg-slate-200"></div>

                                <!-- Node 1: Created -->
                                <div class="relative flex items-start mb-8">
                                    <div class="absolute left-[-1rem] sm:left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-blue-500 ring-4 ring-white"></div>
                                    <div class="ml-4">
                                        <h5 class="text-sm font-bold text-slate-800">Laporan Diterima</h5>
                                        <p class="text-xs text-slate-500 mb-1">{{ $selectedTicket->created_at->format('d M Y - H:i') }}</p>
                                        <p class="text-sm text-slate-600">Laporan Anda telah masuk ke dalam antrean sistem kami.</p>
                                    </div>
                                </div>

                                <!-- Node 2: In Progress -->
                                @if($selectedTicket->status !== 'open')
                                <div class="relative flex items-start mb-8">
                                    <div class="absolute left-[-1rem] sm:left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-amber-500 ring-4 ring-white"></div>
                                    <div class="ml-4">
                                        <h5 class="text-sm font-bold text-slate-800">Sedang Diproses (In Progress)</h5>
                                        <p class="text-xs text-slate-500 mb-1">Status diperbarui</p>
                                        <p class="text-sm text-slate-600">Tim IT sedang memeriksa dan menangani kendala Anda.</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Node 3: Resolved/Closed -->
                                @if(in_array($selectedTicket->status, ['resolved', 'closed']))
                                <div class="relative flex items-start">
                                    <div class="absolute left-[-1rem] sm:left-[-1.5rem] mt-1.5 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></div>
                                    <div class="ml-4 w-full">
                                        <h5 class="text-sm font-bold text-slate-800">Penyelesaian (Resolved)</h5>
                                        <p class="text-xs text-slate-500 mb-2">{{ $selectedTicket->solved_at ? \Carbon\Carbon::parse($selectedTicket->solved_at)->format('d M Y - H:i') : $selectedTicket->updated_at->format('d M Y - H:i') }}</p>
                                        
                                        @if($selectedTicket->resolution_note)
                                        <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-3 text-sm text-emerald-800 mb-3">
                                            <span class="font-bold block mb-1">Catatan Tim IT:</span>
                                            {{ $selectedTicket->resolution_note }}
                                        </div>
                                        @else
                                        <p class="text-sm text-slate-600 mb-3">Laporan telah ditandai selesai oleh Tim IT.</p>
                                        @endif

                                        @if($selectedTicket->resolution_evidence)
                                        <div>
                                            <span class="text-xs font-bold text-slate-500 block mb-2 uppercase tracking-wider">Eviden/Bukti Penyelesaian:</span>
                                            <img src="{{ Storage::url($selectedTicket->resolution_evidence) }}" alt="Eviden" class="w-full max-w-sm rounded-lg border border-slate-200 shadow-sm">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    @endif

                </div>
                
                @if(!$selectedTicket)
                <!-- Footer for State 1 & 2 -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">Hubungi petugas kampus jika laporan Anda tidak diproses lebih dari 2x24 jam.</p>
                </div>
                @endif
                
            </div>
        </div>
    </div>
    @endif
</div>
