<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Numerology Compatibility Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 24px;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 4px solid #6b21a8;
        }
        .header {
            margin-bottom: 24px;
        }
        .header h2 {
            color: #4a154b;
            margin: 0 0 8px;
            font-size: 22px;
        }
        .content {
            font-size: 15px;
            line-height: 1.6;
            color: #4b5563;
        }
        .report-summary-box {
            background-color: #faf5ff;
            border: 1px solid #e9d5ff;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
        }
        .score-pill {
            display: inline-block;
            background: #10b981;
            color: #ffffff;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
        }
        .footer {
            margin-top: 32px;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>{{ __('messages.app_name') }}</h2>
            <p style="color: #6b7280; margin: 0;">{{ __('messages.app_tagline') }}</p>
        </div>

        <div class="content">
            <p>Dear {{ $report->user->first_name ?? $report->user->name }},</p>
            
            <p>Your numerology compatibility report comparing <strong>{{ $report->person1_full_name }}</strong> and <strong>{{ $report->person2_full_name }}</strong> has been approved and attached to this email as a PDF.</p>

            <div class="report-summary-box">
                <div style="margin-bottom: 8px;">
                    <strong>Compatibility Score:</strong> 
                    <span class="score-pill">{{ $report->compatibility_score }}%</span>
                </div>
                <div style="font-size: 14px; color: #4b5563;">
                    <em>"{{ app()->getLocale() === 'ta' ? $report->summary_ta : $report->summary_en }}"</em>
                </div>
            </div>

            <p>Please find your complete report attached as <strong>compatibility_report.pdf</strong>. It can be viewed easily on any mobile device, tablet, or desktop computer.</p>

            <p>Thank you for using {{ __('messages.app_name') }}.</p>
            
            <p style="margin-top: 24px;">
                Regards,<br>
                <strong>Ennkanitham Team</strong>
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ __('messages.app_name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
