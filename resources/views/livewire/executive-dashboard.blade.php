<div>
    <!-- Metrics Header -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100 border-l-4 border-l-indigo-500">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Laporan</h3>
            <div class="text-4xl font-extrabold text-slate-800">{{ $totalTickets }}</div>
            <p class="text-xs text-indigo-600 mt-2 font-medium">Keseluruhan tiket masuk</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100 border-l-4 border-l-emerald-500">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Penyelesaian (Resolved)</h3>
            <div class="text-4xl font-extrabold text-slate-800">{{ json_decode($chartStatusData)[2] }}</div>
            <p class="text-xs text-emerald-600 mt-2 font-medium">Tiket berhasil ditangani IT</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-100 border-l-4 border-l-rose-500">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Menunggu (Open)</h3>
            <div class="text-4xl font-extrabold text-slate-800">{{ json_decode($chartStatusData)[0] }}</div>
            <p class="text-xs text-rose-600 mt-2 font-medium">Membutuhkan atensi segera</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8" wire:ignore>
        
        <!-- Status Distribution Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Status Distribusi</h3>
            <div id="statusChart" class="flex justify-center"></div>
        </div>

        <!-- Categories Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Top Kategori Masalah</h3>
            <div id="categoryChart"></div>
        </div>

    </div>

    @script
    <script>
        setTimeout(() => {
            // Render Status Chart (Pie)
            var statusOptions = {
                series: {!! $chartStatusData !!},
                labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
                chart: { type: 'donut', height: 350 },
                colors: ['#ef4444', '#f59e0b', '#10b981', '#64748b'],
                plotOptions: {
                    pie: { donut: { size: '65%' } }
                },
                dataLabels: { enabled: true },
                legend: { position: 'bottom' }
            };
            
            var elStatus = document.querySelector("#statusChart");
            if (elStatus) {
                var statusChart = new ApexCharts(elStatus, statusOptions);
                statusChart.render();
            }

            // Render Category Chart (Bar)
            var categoryOptions = {
                series: [{
                    name: 'Jumlah Tiket',
                    data: {!! $chartCategoryCounts !!}
                }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                xaxis: {
                    categories: {!! $chartCategoryNames !!},
                },
                colors: ['#4f46e5'],
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: false, columnWidth: '55%' }
                },
                dataLabels: { enabled: false }
            };
            
            var elCategory = document.querySelector("#categoryChart");
            if (elCategory) {
                var categoryChart = new ApexCharts(elCategory, categoryOptions);
                categoryChart.render();
            }
        }, 100);
    </script>
    @endscript

</div>
