<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Survei - {{ $survey->title }}</title>
    <style>
        @page {
            margin: 12mm 15mm;
            size: A4 landscape;
        }
        body {
            font-family: 'Helvetica', 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #222222;
            line-height: 1.3;
        }
        .header-kop {
            text-align: center;
            border-bottom: 2px solid #006400;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .inst-title {
            font-size: 13pt;
            font-weight: bold;
            color: #006400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title {
            font-size: 11pt;
            font-weight: bold;
            color: #333333;
            margin-top: 3px;
        }
        .doc-subtitle {
            font-size: 8pt;
            color: #666666;
        }
        
        .meta-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .meta-box td {
            padding: 5px 8px;
            font-size: 8.5pt;
            border-bottom: 1px solid #edf2f7;
        }
        .meta-label {
            font-weight: bold;
            color: #4a5568;
            width: 18%;
        }
        .meta-value {
            color: #1a202c;
            font-weight: 600;
        }
        
        .section-header {
            font-size: 10pt;
            font-weight: bold;
            color: #006400;
            border-bottom: 1.5px solid #006400;
            padding-bottom: 4px;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            font-size: 8pt;
        }
        table.data-table th {
            background-color: #006400;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .progress-bar-bg {
            background-color: #e2e8f0;
            height: 8px;
            border-radius: 4px;
            width: 100%;
            overflow: hidden;
            display: inline-block;
        }
        .progress-bar-fill {
            background-color: #006400;
            height: 100%;
        }

        .signature-section {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .sig-box {
            float: right;
            width: 250px;
            text-align: center;
            font-size: 8.5pt;
        }
        .sig-space {
            height: 50px;
        }

        .page-number:after {
            content: counter(page);
        }
        .footer {
            position: fixed;
            bottom: -5mm;
            left: 0;
            right: 0;
            font-size: 7.5pt;
            color: #718096;
            text-align: right;
            border-top: 1px solid #e2e8f0;
            padding-top: 3px;
        }
    </style>
</head>
<body>
    <!-- FOOTER PAGE NUMBERING -->
    <div class="footer">
        Dicetak otomatis oleh Sistem Edu Metrics STKIP Pasundan | Halaman <span class="page-number"></span>
    </div>

    <!-- HEADER KOP -->
    <div class="header-kop">
        <div class="inst-title">Lembaga Penjaminan Mutu (LPM) - STKIP Pasundan</div>
        <div class="doc-title">LAPORAN REKAPITULASI HASIL RESPONS SURVEI</div>
        <div class="doc-subtitle">Edu Metrics Quality Assurance Information System</div>
    </div>

    <!-- METADATA SURVEI -->
    <table class="meta-box">
        <tr>
            <td class="meta-label">Judul Survei</td>
            <td class="meta-value">{{ $survey->title }}</td>
            <td class="meta-label">Total Responden</td>
            <td class="meta-value">{{ $totalResponses }} Responden Selesai</td>
        </tr>
        <tr>
            <td class="meta-label">Kategori</td>
            <td class="meta-value">{{ $survey->category->name ?? '-' }}</td>
            <td class="meta-label">Skor Rata-rata Likert</td>
            <td class="meta-value">{{ isset($avgLikert) && $avgLikert > 0 ? $avgLikert . ' / 5.00' : '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Periode Survei</td>
            <td class="meta-value">
                {{ $survey->start_date ? $survey->start_date->format('d/m/Y') : '-' }} s/d {{ $survey->end_date ? $survey->end_date->format('d/m/Y') : '-' }}
            </td>
            <td class="meta-label">Tanggal Cetak</td>
            <td class="meta-value">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

    <!-- BAGIAN 1: STATISTIK PER PERTANYAAN -->
    <div class="section-header">1. Ringkasan Distribusi Jawaban per Pertanyaan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Pertanyaan & Tipe</th>
                <th style="width: 35%;">Pilihan / Skala</th>
                <th style="width: 20%;">Jumlah & Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $qNum = 1; @endphp
            @forelse($questionStats as $qId => $stats)
                @if($stats['question']->question_type === 'likert' || $stats['question']->question_type === 'multiple_choice')
                    @foreach($stats['options'] as $oIdx => $opt)
                        <tr>
                            @if($oIdx === 0)
                                <td class="text-center" rowspan="{{ count($stats['options']) }}" style="vertical-align: top;">
                                    {{ $qNum }}
                                </td>
                                <td rowspan="{{ count($stats['options']) }}" style="vertical-align: top;">
                                    <strong>{{ $stats['question']->question_text }}</strong>
                                    <br>
                                    <span style="color: #64748b; font-size: 7.5pt;">
                                        Tipe: {{ $stats['question']->question_type === 'likert' ? 'Skala Likert' : 'Pilihan Ganda' }} | Respon: {{ $stats['total_answers'] }}
                                    </span>
                                </td>
                            @endif
                            <td>{{ $opt['label'] }} {{ isset($opt['value']) ? ' (Skor: ' . $opt['value'] . ')' : '' }}</td>
                            <td class="text-center font-bold">
                                {{ $opt['count'] }} ({{ $opt['percentage'] }}%)
                            </td>
                        </tr>
                    @endforeach
                    @php $qNum++; @endphp
                @elseif($stats['question']->question_type === 'text')
                    <tr>
                        <td class="text-center" style="vertical-align: top;">{{ $qNum }}</td>
                        <td style="vertical-align: top;">
                            <strong>{{ $stats['question']->question_text }}</strong>
                            <br>
                            <span style="color: #64748b; font-size: 7.5pt;">Tipe: Isian Bebas (Text) | Respon: {{ $stats['total_answers'] }}</span>
                        </td>
                        <td colspan="2" style="font-style: italic; color: #475569;">
                            Pertanyaan isian teks terbuka (rincian jawaban tertera pada tabel rekapitulasi data responden di bawah).
                        </td>
                    </tr>
                    @php $qNum++; @endphp
                @endif
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data statistik pertanyaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- BAGIAN 2: REKAPITULASI JAWABAN TIAP RESPONDEN -->
    <div style="page-break-before: always;"></div>
    
    <div class="section-header">2. Rekapitulasi Data Responden & Jawaban Lengkap</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 120px;">Responden</th>
                <th style="width: 70px;">NIM</th>
                <th style="width: 100px;">Prodi</th>
                <th style="width: 75px;">Selesai</th>
                @foreach($questions as $idx => $q)
                    <th>
                        Q{{ $idx + 1 }}
                        <br>
                        <span style="font-size: 6.5pt; font-weight: normal; opacity: 0.9;">
                            {{ Str::limit($q->question_text, 25) }}
                        </span>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($responses as $index => $response)
                @php
                    $isAnon = $survey->is_anonymous;
                    $respUser = $response->user;
                    $respName = $isAnon ? 'Anonymous' : ($respUser->name ?? $response->respondent_name ?? 'Unknown');
                    $respNim = $isAnon ? '-' : ($respUser->nim ?? '-');
                    $respProdi = $isAnon ? '-' : ($respUser->program_study ?? '-');
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $respName }}</strong></td>
                    <td class="text-center">{{ $respNim }}</td>
                    <td>{{ $respProdi }}</td>
                    <td class="text-center" style="font-size: 7pt;">
                        {{ $response->completed_at ? $response->completed_at->format('d/m/y H:i') : '-' }}
                    </td>
                    @foreach($questions as $q)
                        @php
                            $ans = $response->answers->firstWhere('question_id', $q->id);
                            $formattedAns = '-';
                            if ($ans) {
                                if ($q->question_type === 'likert') {
                                    $scaleOpt = $q->likertScale ? $q->likertScale->options->firstWhere('value', $ans->likert_value) : null;
                                    $formattedAns = $ans->likert_value . ($scaleOpt ? ' (' . $scaleOpt->label . ')' : '');
                                } elseif ($q->question_type === 'multiple_choice') {
                                    $formattedAns = $ans->selectedOption->option_text ?? '-';
                                } elseif ($q->question_type === 'text') {
                                    $formattedAns = $ans->text_value ?? '-';
                                }
                            }
                        @endphp
                        <td style="font-size: 7.5pt;">{{ $formattedAns }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 5 + $questions->count() }}" class="text-center" style="padding: 15px;">
                        Belum ada responden yang menyelesaikan survei ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SIGNATURE BLOCK -->
    <div class="signature-section">
        <div class="sig-box">
            <div>Bandung, {{ now()->translatedFormat('d F Y') }}</div>
            <div style="font-weight: bold; margin-top: 3px;">Lembaga Penjaminan Mutu (LPM)</div>
            <div class="sig-space"></div>
            <div style="font-weight: bold; text-decoration: underline;">Administrator Sistem</div>
            <div style="font-size: 7.5pt; color: #666666;">Edu Metrics STKIP Pasundan</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
