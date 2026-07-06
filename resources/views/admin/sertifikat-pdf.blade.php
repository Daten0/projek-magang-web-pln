<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .page {
            width: 100%;
            height: 100vh;
            page-break-after: always;
            position: relative;
        }
        .page:last-child {
            page-break-after: avoid;
        }
        .template-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        /* Page 1 Styles */
        .page1 .top-text {
            position: absolute;
            top: 18%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .page1 .top-text .label {
            font-size: 12px;
            font-weight: bold;
            color: #475569;
            letter-spacing: 0.35em;
            text-transform: uppercase;
        }
        .page1 .top-text .name {
            margin-top: 16px;
            font-size: 32px;
            font-weight: 900;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .page1 .top-text .desc {
            margin-top: 16px;
            font-size: 14px;
            color: #334155;
            max-width: 500px;
            line-height: 1.6;
        }
        .page1 .bottom-left {
            position: absolute;
            left: 5%;
            bottom: 12%;
            font-size: 14px;
            color: #334155;
        }
        .page1 .bottom-left .item {
            margin-bottom: 8px;
        }
        .page1 .bottom-left .label {
            font-weight: bold;
        }
        .page1 .bottom-right {
            position: absolute;
            right: 5%;
            bottom: 12%;
            font-size: 14px;
            color: #334155;
            text-align: right;
        }
        .page1 .bottom-right .item {
            margin-bottom: 8px;
        }
        .page1 .bottom-right .label {
            font-weight: bold;
        }
        /* Page 2 Styles */
        .page2 .top-text {
            position: absolute;
            top: 14%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .page2 .top-text .label {
            font-size: 12px;
            font-weight: bold;
            color: #475569;
            letter-spacing: 0.35em;
            text-transform: uppercase;
        }
        .page2 .top-text .title {
            margin-top: 12px;
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: -0.02em;
        }
        .page2 .middle-table {
            position: absolute;
            top: 28%;
            left: 8%;
            right: 8%;
        }
        .page2 table {
            width: 100%;
            border-collapse: collapse;
        }
        .page2 th, .page2 td {
            border: 1px solid #94a3b8;
            padding: 8px 12px;
            font-size: 14px;
        }
        .page2 th {
            background: rgba(255,255,255,0.95);
            font-weight: bold;
            color: #334155;
        }
        .page2 td {
            background: rgba(255,255,255,0.85);
            color: #334155;
        }
        .page2 .bottom-left {
            position: absolute;
            left: 8%;
            bottom: 12%;
            width: 44%;
            background: rgba(255,255,255,0.9);
            border: 1px solid #94a3b8;
            border-radius: 12px;
            padding: 12px;
            font-size: 14px;
            color: #334155;
        }
        .page2 .bottom-left .label {
            font-weight: bold;
        }
        .page2 .bottom-left .note {
            margin-top: 8px;
            line-height: 1.5;
            color: #475569;
        }
        .page2 .bottom-right {
            position: absolute;
            right: 8%;
            bottom: 10%;
            width: 40%;
            background: rgba(255,255,255,0.9);
            border: 1px solid #94a3b8;
            border-radius: 12px;
            padding: 12px;
            text-align: right;
            font-size: 14px;
            color: #334155;
        }
        .page2 .bottom-right .label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.18em;
            color: #64748b;
        }
        .page2 .bottom-right .value {
            margin-top: 12px;
            font-size: 36px;
            font-weight: 900;
            color: #1e293b;
        }
        .page2 .bottom-right .status {
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-weight: bold;
        }
        .page2 .bottom-right .status.lulus {
            color: #16a34a;
        }
        .page2 .bottom-right .status.tidak-lulus {
            color: #d97706;
        }
    </style>
</head>
<body>

    <!-- Page 1 -->
    <div class="page page1">
        <img src="{{ $template1Path }}" alt="Template 53" class="template-img">
        <div class="overlay">
            <div class="top-text">
                <div class="label">Sertifikat Magang</div>
                <div class="name">{{ strtoupper($peserta['nama']) }}</div>
                <div class="desc">
                    Telah menyelesaikan program magang di PT PLN (Persero) pada Divisi {{ $peserta['divisi'] }} periode {{ $peserta['periode'] }}.
                </div>
            </div>
            <div class="bottom-left">
                <div class="item">
                    <span class="label">Universitas</span>: {{ $peserta['universitas'] }}
                </div>
                <div class="item">
                    <span class="label">Mentor</span>: {{ $peserta['mentor'] }}
                </div>
                <div class="item">
                    <span class="label">Tanggal Terbit</span>: {{ $peserta['tanggal_terbit'] }}
                </div>
            </div>
            <div class="bottom-right">
                <div class="item">
                    <span class="label">Nomor</span>: {{ $nomorSertifikat }}
                </div>
                <div class="item">
                    <span class="label">Status</span>: {{ $penilaianakhir['status_kelulusan'] ?? 'Belum Dinilai' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page page2">
        <img src="{{ $template2Path }}" alt="Template 54" class="template-img">
        <div class="overlay">
            <div class="top-text">
                <div class="label">Ringkasan Penilaian Akhir</div>
                <div class="title">Hasil Kriteria Penilaian</div>
            </div>
            <div class="middle-table">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left;">Komponen Penilaian</th>
                            <th style="text-align: center;">Nilai (Angka)</th>
                            <th style="text-align: center;">Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            function getPredikat($nilai) {
                                if ($nilai >= 85) return 'A';
                                elseif ($nilai >= 70) return 'B';
                                elseif ($nilai >= 60) return 'C';
                                else return 'D';
                            }
                        @endphp
                        <tr>
                            <td>Keterampilan Teknis</td>
                            <td style="text-align: center;">{{ $penilaianakhir['keterampilan_teknis'] ?? '—' }}</td>
                            <td style="text-align: center;">{{ getPredikat($penilaianakhir['keterampilan_teknis'] ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Pemecahan Masalah</td>
                            <td style="text-align: center;">{{ $penilaianakhir['pemecahan_masalah'] ?? '—' }}</td>
                            <td style="text-align: center;">{{ getPredikat($penilaianakhir['pemecahan_masalah'] ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Kedisiplinan</td>
                            <td style="text-align: center;">{{ $penilaianakhir['kedisiplinan'] ?? '—' }}</td>
                            <td style="text-align: center;">{{ getPredikat($penilaianakhir['kedisiplinan'] ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Kerjasama</td>
                            <td style="text-align: center;">{{ $penilaianakhir['kerjasama'] ?? '—' }}</td>
                            <td style="text-align: center;">{{ getPredikat($penilaianakhir['kerjasama'] ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Kehadiran</td>
                            <td style="text-align: center;">{{ $penilaianakhir['kehadiran'] ?? '—' }}</td>
                            <td style="text-align: center;">{{ getPredikat($penilaianakhir['kehadiran'] ?? 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bottom-left">
                <div class="label">Catatan Mentor</div>
                <div class="note">{{ $penilaianakhir['catatan'] ?? 'Belum ada catatan.' }}</div>
            </div>
            <div class="bottom-right">
                <div class="label">Nilai Akhir</div>
                <div class="value">{{ $penilaianakhir['nilai_akhir'] ?? '0' }}</div>
                <div class="status {{ ($penilaianakhir['status_kelulusan'] ?? '') === 'Lulus' ? 'lulus' : 'tidak-lulus' }}">
                    {{ $penilaianakhir['status_kelulusan'] ?? 'Belum Dinilai' }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
