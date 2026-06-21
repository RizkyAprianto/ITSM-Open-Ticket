<div x-data="dashboardData()" class="max-w-7xl mx-auto space-y-8">
    
    <!-- Metrics Header -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Total Laporan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 rounded-l-xl"></div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Laporan</h3>
                    <div class="text-4xl font-extrabold text-slate-800">{{ $totalTickets }}</div>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-indigo-600 mt-4 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Keseluruhan tiket masuk
            </p>
        </div>
        
        <!-- Penyelesaian (Resolved) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500 rounded-l-xl"></div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Penyelesaian (Resolved)</h3>
                    <div class="text-4xl font-extrabold text-slate-800">{{ json_decode($chartStatusData)[2] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-emerald-600 mt-4 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tiket berhasil ditangani IT
            </p>
        </div>

        <!-- Menunggu (Open) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500 rounded-l-xl"></div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Menunggu (Open)</h3>
                    <div class="text-4xl font-extrabold text-slate-800">{{ json_decode($chartStatusData)[0] ?? 0 }}</div>
                </div>
                <div class="p-3 bg-rose-50 rounded-lg text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-rose-600 mt-4 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Membutuhkan atensi segera
            </p>
        </div>
    </div>

    <!-- Export Panel -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Ekspor Laporan</h3>
                <p class="text-xs text-slate-500">Unduh data tiket dalam format PDF atau Excel.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="flex items-center gap-2">
                <select wire:model.live="filterMonth" class="text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-32 py-2">
                    <option value="0">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>

                <select wire:model.live="filterYear" class="text-sm border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-28 py-2">
                    <option value="0">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                <a href="{{ $this->pdfUrl }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-rose-600 border border-transparent rounded-lg shadow-sm hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    PDF
                </a>
                <a href="{{ $this->excelUrl }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" wire:ignore>
        
        <!-- Status Distribution Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-6 pb-3 border-b border-slate-100">Status Distribusi</h3>
            <div x-ref="donutChart" class="flex justify-center min-h-[350px]"></div>
        </div>

        <!-- Categories Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-6 pb-3 border-b border-slate-100">Top Kategori Masalah</h3>
            <div x-ref="barChart" class="min-h-[350px]"></div>
        </div>

    </div>

    @script
    <script>
        Alpine.data('dashboardData', () => ({
            donutChart: null,
            barChart: null,
            
            init() {
                // Ensure robust polling in case CDN loads slowly
                this.pollForApexCharts();
            },
            
            pollForApexCharts() {
                let attempts = 0;
                let interval = setInterval(() => {
                    if (typeof ApexCharts !== 'undefined') {
                        clearInterval(interval);
                        this.renderCharts();
                    }
                    attempts++;
                    if (attempts > 100) clearInterval(interval); // Timeout after 5 seconds
                }, 50);
            },
            
            renderCharts() {
                // 1. Render Status Donut Chart
                let statusOptions = {
                    series: {!! $chartStatusData !!},
                    labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
                    chart: { 
                        type: 'donut', 
                        height: 350,
                        fontFamily: 'inherit'
                    },
                    colors: ['#f43f5e', '#f59e0b', '#10b981', '#94a3b8'], // Rose, Amber, Emerald, Slate
                    plotOptions: {
                        pie: { 
                            donut: { size: '70%' },
                            expandOnClick: false
                        }
                    },
                    dataLabels: { 
                        enabled: false // Sleek minimalist look
                    },
                    stroke: {
                        width: 0 // Removes border around pie slices
                    },
                    legend: { 
                        position: 'bottom',
                        horizontalAlign: 'center',
                        markers: { radius: 12 },
                        itemMargin: { horizontal: 10, vertical: 5 }
                    }
                };
                
                if (this.$refs.donutChart) {
                    this.donutChart = new ApexCharts(this.$refs.donutChart, statusOptions);
                    this.donutChart.render();
                }

                // 2. Render Category Bar Chart
                let categoryOptions = {
                    series: [{
                        name: 'Jumlah Tiket',
                        data: {!! $chartCategoryCounts !!}
                    }],
                    chart: { 
                        type: 'bar', 
                        height: 350, 
                        toolbar: { show: false },
                        fontFamily: 'inherit'
                    },
                    xaxis: {
                        categories: {!! $chartCategoryNames !!},
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: {
                            style: { colors: '#64748b' }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: { colors: '#64748b' },
                            formatter: (value) => Math.round(value)
                        }
                    },
                    colors: ['#4f46e5'], // Solid Indigo
                    plotOptions: {
                        bar: { 
                            borderRadius: 6, // Rounded top corners
                            columnWidth: '45%',
                            dataLabels: { position: 'top' }
                        }
                    },
                    dataLabels: { 
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ['#334155']
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4, // Faint dashed grid lines
                        position: 'back'
                    }
                };
                
                if (this.$refs.barChart) {
                    this.barChart = new ApexCharts(this.$refs.barChart, categoryOptions);
                    this.barChart.render();
                }
            }
        }));
    </script>
    @endscript
</div>
