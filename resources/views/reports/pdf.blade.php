<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Numerology Compatibility Report - {{ $report->person1_full_name }} &amp; {{ $report->person2_full_name }}</title>
    <style>
        @page {
            margin: 12px;
            size: A4 portrait;
        }

        @font-face {
            font-family: 'Nirmala UI';
            src: url('{{ str_replace('\\', '/', public_path('fonts/Nirmala.ttf')) }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Nirmala UI';
            src: url('{{ str_replace('\\', '/', public_path('fonts/NirmalaB.ttf')) }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: 'Nirmala UI', 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 4px;
            color: #2d3748;
            background-color: #ffffff;
            font-size: 11px;
            line-height: 1.35;
        }

        /* Auspicious ornamental frame */
        .outer-border {
            border: 2px double #b8860b;
            padding: 4px;
            border-radius: 8px;
            background-color: #fffdfa;
        }
        .inner-border {
            border: 1px solid #d4af37;
            padding: 14px 18px;
            border-radius: 6px;
            background: #ffffff;
            position: relative;
        }

        .header-title {
            text-align: center;
            margin-bottom: 10px;
        }
        .brand-name {
            font-size: 20px;
            font-weight: bold;
            color: #4a154b;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 13px;
            color: #6b21a8;
            font-weight: 600;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #d4af37, transparent);
            margin: 8px auto;
            width: 70%;
        }

        /* Profiles side by side */
        .profiles-table {
            width: 100%;
            margin: 8px 0 10px;
            border-collapse: collapse;
        }
        .profile-col {
            width: 44%;
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            background-color: #faf5ff;
            border-radius: 8px;
            border: 1px solid #e9d5ff;
        }
        .heart-col {
            width: 12%;
            text-align: center;
            vertical-align: middle;
            font-size: 22px;
            color: #e11d48;
        }
        .profile-name {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            margin: 3px 0 1px;
        }
        .profile-dob {
            font-size: 11px;
            color: #64748b;
        }
        .avatar-badge {
            display: inline-block;
            width: 32px;
            height: 32px;
            line-height: 32px;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 2px;
        }
        .avatar-blue {
            background-color: #2563eb;
        }
        .avatar-pink {
            background-color: #db2777;
        }

        /* Numbers Table */
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #4a154b;
            text-align: center;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .numbers-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .numbers-table th {
            background-color: #f3e8ff;
            color: #581c87;
            padding: 6px 8px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #e9d5ff;
        }
        .numbers-table td {
            padding: 5px 8px;
            font-size: 11px;
            text-align: center;
            border: 1px solid #f1f5f9;
        }
        .numbers-table tr:nth-child(even) {
            background-color: #fafaf9;
        }
        .numbers-table td.cat-name {
            text-align: left;
            font-weight: 600;
            color: #334155;
            padding-left: 14px;
        }
        .badge-number {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            background-color: #f1f5f9;
            color: #1e293b;
            border-radius: 50%;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #cbd5e1;
        }

        /* Compatibility Score */
        .score-container {
            text-align: center;
            margin: 8px 0 10px;
            padding: 8px;
            background-color: #fef2f2;
            border: 1px solid #fecdd3;
            border-radius: 8px;
        }
        .score-label {
            font-size: 11px;
            font-weight: 600;
            color: #9f1239;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .score-value {
            font-size: 26px;
            font-weight: 900;
            color: #059669;
            line-height: 1;
            margin: 2px 0;
        }

        /* Result Reading */
        .result-box {
            background-color: #f8fafc;
            border-left: 3px solid #6b21a8;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .result-box h4 {
            margin: 0 0 4px;
            font-size: 11px;
            color: #4a154b;
            text-transform: uppercase;
        }
        .result-box p {
            margin: 0;
            color: #475569;
            font-size: 10.5px;
            line-height: 1.4;
        }
        .tamil-summary {
            margin-top: 6px !important;
            padding-top: 6px;
            border-top: 1px dashed #e2e8f0;
            color: #64748b;
            font-size: 10px;
            line-height: 1.4;
        }

        /* Footer */
        .report-footer {
            margin-top: 8px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 6px;
        }
    </style>
</head>
<body>
    <div class="outer-border">
        <div class="inner-border">
            
            <div class="header-title">
                <div class="brand-name">{{ __('messages.app_name') }}</div>
                <div class="brand-subtitle">Numerology Compatibility Report</div>
                <div style="font-size: 11px; color: #854d0e;">Report ID: #ENK-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }} &bull; Date: {{ $report->created_at->format('d-m-Y') }}</div>
            </div>

            <!-- Profiles Comparison -->
            <table class="profiles-table">
                <tr>
                    <td class="profile-col">
                        <div class="avatar-badge avatar-blue">&#128100;</div>
                        <div class="profile-name">{{ $report->person1_full_name }}</div>
                        <div class="profile-dob">{{ $report->p1_dob->format('d-m-Y') }}</div>
                    </td>
                    <td class="heart-col">
                        &hearts;
                    </td>
                    <td class="profile-col">
                        <div class="avatar-badge avatar-pink">&#128100;</div>
                        <div class="profile-name">{{ $report->person2_full_name }}</div>
                        <div class="profile-dob">{{ $report->p2_dob->format('d-m-Y') }}</div>
                    </td>
                </tr>
            </table>

            <!-- Comparison Table -->
            <div class="section-heading">Numerology Numbers</div>
            <table class="numbers-table">
                <thead>
                    <tr>
                        <th style="width: 44%; text-align: left; padding-left: 18px;">Category</th>
                        <th style="width: 28%;">{{ $report->p1_first_name }}</th>
                        <th style="width: 28%;">{{ $report->p2_first_name }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="cat-name">Life Path Number</td>
                        <td><span class="badge-number">{{ $report->p1_life_path }}</span></td>
                        <td><span class="badge-number">{{ $report->p2_life_path }}</span></td>
                    </tr>
                    <tr>
                        <td class="cat-name">Destiny Number</td>
                        <td><span class="badge-number">{{ $report->p1_destiny }}</span></td>
                        <td><span class="badge-number">{{ $report->p2_destiny }}</span></td>
                    </tr>
                    <tr>
                        <td class="cat-name">Soul Number</td>
                        <td><span class="badge-number">{{ $report->p1_soul }}</span></td>
                        <td><span class="badge-number">{{ $report->p2_soul }}</span></td>
                    </tr>
                    <tr>
                        <td class="cat-name">Personality Number</td>
                        <td><span class="badge-number">{{ $report->p1_personality }}</span></td>
                        <td><span class="badge-number">{{ $report->p2_personality }}</span></td>
                    </tr>
                </tbody>
            </table>

            <!-- Compatibility Score -->
            <div class="score-container">
                <div class="score-label">Compatibility Score</div>
                <div class="score-value">{{ $report->compatibility_score }}%</div>
            </div>

            <!-- Result Reading -->
            <div class="result-box">
                <h4>Result Analysis</h4>
                <p>{{ $report->summary_en }}</p>
                @if(!empty($report->summary_ta))
                    <p class="tamil-summary">{{ $report->summary_ta }}</p>
                @endif
            </div>

            <!-- Footer -->
            <div class="report-footer">
                Official Compatibility Certificate &bull; Generated by ENNKANITHAM Portal (ennkanitham.com) &bull; Verified by Astrology &amp; Numerology Panel
            </div>

        </div>
    </div>
</body>
</html>
