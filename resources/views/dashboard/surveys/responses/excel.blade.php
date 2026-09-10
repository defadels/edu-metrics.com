<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Respons Survei - {{ $survey->title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            color: #333333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #cccccc;
            padding: 8px 12px;
            vertical-align: middle;
        }
        th {
            background-color: #006400;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            color: #006400;
            text-align: center;
            border: none;
        }
        .header-subtitle {
            font-size: 12pt;
            text-align: center;
            color: #555555;
            border: none;
        }
        .meta-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 10px;
        }
        .meta-label {
            background-color: #f4f6f8;
            font-weight: bold;
            width: 180px;
        }
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            background-color: #e8f5e9;
            color: #006400;
            padding: 10px;
            border: 1px solid #c8e6c9;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bg-light {
            background-color: #f9fbfd;
        }
        .badge-likert {
            font-weight: bold;
            color: #1b5e20;
        }
    </style>
</head>
<body>
    <!-- HEADER / METADATA -->
    <table>
        <tr>
            <td colspan="{{ max(8 + $questions->count(), 8) }}" class="header-title">
                LAPORAN HASIL RESPONS SURVEI
            </td>
        </tr>
        <tr>
            <td colspan="{{ max(8 + $questions->count(), 8) }}" class="header-subtitle">
                {{ config('app.name', 'Edu Metrics') }} - STKIP Pasundan
            </td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Judul Survei</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}"><strong>{{ $survey->title }}</strong></td>
        </tr>
        <tr>
            <td class="meta-label">Kategori</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}">{{ $survey->category->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Periode Survei</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}">
                {{ $survey->start_date ? $survey->start_date->format('d M Y') : '-' }} s/d {{ $survey->end_date ? $survey->end_date->format('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="meta-label">Total Responden Selesai</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}"><strong>{{ $totalResponses }} Responden</strong></td>
        </tr>
        @if(isset($avgLikert) && $avgLikert > 0)
        <tr>
            <td class="meta-label">Rata-rata Skor Likert</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}"><strong>{{ $avgLikert }} / 5.00</strong></td>
        </tr>
        @endif
        <tr>
            <td class="meta-label">Waktu Export</td>
            <td colspan="{{ max(6 + $questions->count(), 6) }}">{{ now()->translatedFormat('d F Y, H:i:s') }}</td>
        </tr>
    </table>

    <br>

    <!-- TABEL REKAPITULASI RESPONDEN & JAWABAN -->
    <table>
        <thead>
            <tr>
                <th class="section-title" colspan="{{ 8 + $questions->count() }}" style="text-align: left;">
                    REKAPITULASI JAWABAN TIAP RESPONDEN
                </th>
            </tr>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 200px;">Nama Responden</th>
                <th style="width: 140px;">NIM</th>
                <th style="width: 200px;">Program Studi</th>
                <th style="width: 220px;">Email</th>
                <th style="width: 120px;">Tipe Akun</th>
                <th style="width: 150px;">Waktu Mulai</th>
                <th style="width: 150px;">Waktu Selesai</th>
                @foreach($questions as $index => $q)
                    <th style="width: 250px;">
                        Q{{ $index + 1 }}. {{ $q->question_text }}
                        <br>
                        <small style="font-weight: normal; opacity: 0.9;">
                            ({{ $q->question_type === 'likert' ? 'Skala Likert' : ($q->question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Isian') }})
                        </small>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($responses as $index => $response)
                @php
                    $isAnon = $survey->is_anonymous;
                    $respUser = $response->user;
                    $respName = $isAnon ? 'Anonymous Respondent' : ($respUser->name ?? $response->respondent_name ?? 'Unknown');
                    $respNim = $isAnon ? '-' : ($respUser->nim ?? '-');
                    $respProdi = $isAnon ? '-' : ($respUser->program_study ?? '-');
                    $respEmail = $isAnon ? '-' : ($respUser->email ?? '-');
                    $respType = $response->user_id ? 'Mahasiswa' : 'Guest';
                @endphp
                <tr class="{{ $index % 2 == 1 ? 'bg-light' : '' }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $respName }}</strong></td>
                    <td class="text-center">{{ $respNim }}</td>
                    <td>{{ $respProdi }}</td>
                    <td>{{ $respEmail }}</td>
                    <td class="text-center">{{ $respType }}</td>
                    <td class="text-center">{{ $response->started_at ? $response->started_at->format('d/m/Y H:i') : '-' }}</td>
                    <td class="text-center">{{ $response->completed_at ? $response->completed_at->format('d/m/Y H:i') : '-' }}</td>
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
                        <td>{{ $formattedAns }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 8 + $questions->count() }}" class="text-center" style="padding: 20px; color: #888888;">
                        Belum ada responden yang menyelesaikan survei ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    <!-- RINGKASAN PERSENTASE PER PERTANYAAN -->
    <table>
        <thead>
            <tr>
                <th class="section-title" colspan="4" style="text-align: left;">
                    RINGKASAN STATISTIK & DISTRIBUSI JAWABAN
                </th>
            </tr>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 400px;">Pertanyaan</th>
                <th style="width: 300px;">Pilihan / Opsi / Skala</th>
                <th style="width: 150px;">Jumlah Respon & Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $qIndex = 1; @endphp
            @foreach($questionStats as $qId => $stats)
                @if($stats['question']->question_type === 'likert' || $stats['question']->question_type === 'multiple_choice')
                    @foreach($stats['options'] as $oIndex => $opt)
                        <tr>
                            @if($oIndex === 0)
                                <td class="text-center" rowspan="{{ count($stats['options']) }}" style="vertical-align: top;">
                                    {{ $qIndex }}
                                </td>
                                <td rowspan="{{ count($stats['options']) }}" style="vertical-align: top;">
                                    <strong>{{ $stats['question']->question_text }}</strong>
                                    <br>
                                    <small style="color: #666666;">
                                        Tipe: {{ $stats['question']->question_type === 'likert' ? 'Skala Likert' : 'Pilihan Ganda' }} | Total: {{ $stats['total_answers'] }} tanggapan
                                    </small>
                                </td>
                            @endif
                            <td>{{ $opt['label'] }} {{ isset($opt['value']) ? ' (Skor: ' . $opt['value'] . ')' : '' }}</td>
                            <td class="text-center">
                                <strong>{{ $opt['count'] }}</strong> ({{ $opt['percentage'] }}%)
                            </td>
                        </tr>
                    @endforeach
                    @php $qIndex++; @endphp
                @elseif($stats['question']->question_type === 'text')
                    <tr>
                        <td class="text-center" style="vertical-align: top;">{{ $qIndex }}</td>
                        <td style="vertical-align: top;">
                            <strong>{{ $stats['question']->question_text }}</strong>
                            <br>
                            <small style="color: #666666;">Tipe: Isian Bebas (Text) | Total: {{ $stats['total_answers'] }} tanggapan</small>
                        </td>
                        <td colspan="2">
                            <em>Pertanyaan isian teks terbuka (rincian teks tertera pada tabel rekapitulasi data responden di atas).</em>
                        </td>
                    </tr>
                    @php $qIndex++; @endphp
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
