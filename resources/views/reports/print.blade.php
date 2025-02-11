<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <h1>صيدلية دكتور رامي</h1>
    <title>تقرير العقد: {{ $contract->name }} - {{ $monthParam }}</title>
    <style>
        h1 {
            font-size: 24px;
        }
        p strong {
            font-size: 18px;
        }
    </style>
    <style>
        body {
            font-family: 'Amiri', DejaVu Sans, sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 14px;
            margin: 20px;
            line-height: 1.6;
        }
        h1, h2, p {
            margin: 0 0 10px 0;
        }
        hr {
            border: 1px solid #ccc;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <h1>تقرير العقد</h1>
    <p><strong>اسم العقد:</strong> {{ $contract->name }}</p>
    <p><strong>الشهر:</strong> {{ $monthParam }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>العميل</th>
                <th>إجمالي سعر الفواتير<br>(قبل الخصم)</th>
                <th>إجمالي الدعم<br>(بعد الخصم)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patientReports as $report)
                <tr>
                    <td>{{ $report['patient']->name }}</td>
                    <td>{{ number_format($report['total_invoice_price'], 2) }}</td>
                    <td>{{ number_format($report['total_supported_price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>المجموع الكلي</th>
                <th>{{ number_format($grandTotalInvoicePrice, 2) }}</th>
                <th>{{ number_format($grandTotalSupportedPrice, 2) }}</th>
            </tr>
        </tfoot>
    </table>
    <!-- Optionally, add a return link (hidden when printing) -->
    <div class="no-print" style="margin-top: 20px;">
        <a href="{{ route('reports.show', $contract->id) }}?month={{ $monthParam }}">عودة إلى التقرير</a>
    </div>
</body>
</html>
