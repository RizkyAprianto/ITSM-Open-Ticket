<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan IT Service Center</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0 0 5px 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            color: #64748b;
            font-size: 12px;
        }
        
        .section-title {
            background-color: #f1f5f9;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            border-left: 4px solid #2563eb;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        /* Metrics Box */
        .metrics-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .metric-box {
            width: 32%;
            display: inline-block;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
            padding: 15px 0;
            box-sizing: border-box;
        }
        .metric-title {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .metric-value {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
        }

        /* Status & Categories */
        .row {
            width: 100%;
        }
        .col-half {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .list-item {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .list-item:last-child {
            border-bottom: none;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #334155;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }
        
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-open { background-color: #ffe4e6; color: #be123c; }
        .badge-progress { background-color: #fef3c7; color: #b45309; }
        .badge-resolved { background-color: #d1fae5; color: #047857; }
        .badge-closed { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>

    <!-- HALAMAN 1: SUMMARY STATISTIK -->
    <div class="header">
        <h1>Campus IT Service Center</h1>
        <p>
            Laporan Periode: {{ $month > 0 ? date('F', mktime(0, 0, 0, $month, 10)) : 'Semua Bulan' }} 
            {{ $year > 0 ? $year : 'Semua Tahun' }}
        </p>
        <p>Dicetak pada: {{ $datePrinted }}</p>
    </div>

    <div class="section-title">Ringkasan Utama</div>
    <div class="metrics-container">
        <div class="metric-box">
            <div class="metric-title">Total Tiket</div>
            <div class="metric-value">{{ $totalTickets }}</div>
        </div>
        <div class="metric-box" style="border-left-color: #10b981; border-left-width: 3px;">
            <div class="metric-title">Resolved (Selesai)</div>
            <div class="metric-value">{{ $statusCounts['resolved'] ?? 0 }}</div>
        </div>
        <div class="metric-box" style="border-left-color: #f43f5e; border-left-width: 3px;">
            <div class="metric-title">Open / In Progress</div>
            <div class="metric-value">{{ ($statusCounts['open'] ?? 0) + ($statusCounts['in_progress'] ?? 0) }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-half">
            <div class="section-title">Distribusi Status</div>
            @php
                $statuses = [
                    'open' => ['label' => 'Open', 'color' => '#f43f5e'],
                    'in_progress' => ['label' => 'In Progress', 'color' => '#f59e0b'],
                    'resolved' => ['label' => 'Resolved', 'color' => '#10b981'],
                    'closed' => ['label' => 'Closed', 'color' => '#94a3b8']
                ];
            @endphp
            @foreach($statuses as $key => $status)
                @php 
                    $count = $statusCounts[$key] ?? 0;
                    $percent = $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0;
                @endphp
                <div class="list-item">
                    <span style="color: {{ $status['color'] }}; font-size: 16px;">●</span> 
                    <span style="display:inline-block; width: 80px;">{{ $status['label'] }}</span> 
                    <strong>{{ $count }}</strong> <span style="color:#64748b; font-size:10px;">({{ $percent }}%)</span>
                </div>
            @endforeach
        </div>
        
        <div class="col-half" style="margin-left: 2%;">
            <div class="section-title">Top Kategori Masalah</div>
            @forelse($categories as $index => $category)
                <div class="list-item">
                    <span style="display:inline-block; width: 15px; color:#64748b;">{{ $index + 1 }}.</span>
                    <span style="display:inline-block; width: 130px;">{{ $category->name }}</span>
                    <strong>{{ $category->tickets_count }}</strong> <span style="color:#64748b; font-size:10px;">tiket</span>
                </div>
            @empty
                <div class="list-item" style="color: #94a3b8; font-style: italic;">Belum ada data kategori</div>
            @endforelse
        </div>
    </div>

    <div class="footer">
        Laporan ini dihasilkan secara otomatis oleh sistem ITSM Campus IT Service Center.
    </div>

    <!-- HALAMAN 2: DETAIL TIKET -->
    <div class="page-break"></div>

    <div class="header" style="margin-bottom: 10px; border-bottom: none;">
        <h2 style="margin:0; font-size: 16px; color: #1e3a8a;">DETAIL AKTIVITAS TIKET</h2>
        <p>Periode: {{ $month > 0 ? date('F', mktime(0, 0, 0, $month, 10)) : 'Semua Bulan' }} {{ $year > 0 ? $year : 'Semua Tahun' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">ID Tiket</th>
                <th width="15%">Nama Pelapor</th>
                <th width="15%">Kategori</th>
                <th width="25%">Subjek / Masalah</th>
                <th width="10%">Status</th>
                <th width="11%">Tgl Masuk</th>
                <th width="11%">Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $index => $ticket)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace;">{{ substr($ticket->uuid, 0, 8) }}</td>
                    <td>
                        {{ $ticket->guest_name }}<br>
                        <span style="font-size:8px; color:#64748b;">{{ $ticket->guest_nim }}</span>
                    </td>
                    <td>{{ $ticket->category ? $ticket->category->name : '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($ticket->title, 40) }}</td>
                    <td style="text-align: center;">
                        @php
                            $badgeClass = '';
                            if ($ticket->status == 'open') $badgeClass = 'badge-open';
                            elseif ($ticket->status == 'in_progress') $badgeClass = 'badge-progress';
                            elseif ($ticket->status == 'resolved') $badgeClass = 'badge-resolved';
                            else $badgeClass = 'badge-closed';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($ticket->status == 'in_progress' ? 'Progress' : $ticket->status) }}</span>
                    </td>
                    <td>{{ $ticket->created_at->format('d/m/y H:i') }}</td>
                    <td>{{ $ticket->solved_at ? $ticket->solved_at->format('d/m/y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #94a3b8;">
                        Tidak ada tiket pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px; font-size: 10px; color: #64748b; text-align: right;">
        Total: {{ count($tickets) }} tiket pada halaman ini.
    </div>

</body>
</html>
