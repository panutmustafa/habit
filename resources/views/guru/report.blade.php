<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kebiasaan Siswa - {{ $myClass->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        h1, h2, h3, h4 {
            color: #222;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        h3 {
            font-size: 16px;
            margin-top: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .student-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .habit-stats p {
            margin: 2px 0;
        }
        .reflection-content {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 3px solid #007bff;
            margin-top: 5px;
            font-style: italic;
        }
        .feedback-content {
            background-color: #e2f0d9; /* Light green */
            padding: 10px;
            border-left: 3px solid #28a745; /* Green */
            margin-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Kebiasaan Siswa</h1>
        <h2>Kelas: {{ $myClass->name }}</h2>
        <p>Guru: {{ $teacher->name }}</p>
        <p>Tanggal Laporan: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>

        @foreach ($reportData as $studentData)
            <div class="student-section">
                <h3>Siswa: {{ $studentData['student']->name }} ({{ $studentData['student']->email }})</h3>

                <h4>Statistik Kebiasaan Harian (7 Hari Terakhir)</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Kebiasaan</th>
                            <th>Selesai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentData['daily_habit_stats'] as $stats)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stats['date'])->format('d M Y') }}</td>
                                <td>{{ $stats['total_habits'] }}</td>
                                <td>{{ $stats['completed_habits'] }}</td>
                                <td>{{ $stats['percentage'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Refleksi Mingguan</h4>
                @if ($studentData['reflections']->isNotEmpty())
                    @foreach ($studentData['reflections'] as $reflection)
                        <div style="margin-bottom: 10px;">
                            <strong>Minggu ke: {{ \Carbon\Carbon::parse($reflection->week_start_date)->format('d F Y') }}</strong>
                            <p><strong>Refleksi Siswa:</strong></p>
                            <div class="reflection-content">
                                {{ $reflection->content }}
                            </div>
                            @if ($reflection->is_reviewed && $reflection->feedback)
                                <p><strong>Feedback Guru ({{ $reflection->reviewedBy->name ?? 'N/A' }}):</strong></p>
                                <div class="feedback-content">
                                    {{ $reflection->feedback }}
                                </div>
                            @elseif ($reflection->is_reviewed)
                                <p><em>(Refleksi telah ditinjau tanpa feedback spesifik)</em></p>
                            @else
                                <p><em>(Menunggu ditinjau)</em></p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p>Tidak ada refleksi yang diserahkan.</p>
                @endif
            </div>
            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach

        <div style="margin-top: 50px; text-align: right;">
            <p>Hormat kami,</p>
            <p style="margin-top: 60px;">({{ $teacher->name }})</p>
            <p>Guru Kelas {{ $myClass->name }}</p>
        </div>
    </div>
</body>
</html>
