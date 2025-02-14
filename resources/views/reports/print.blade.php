<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <h1 style="text-align: center">صيدليات مكة</h1>
    <p style="text-align: center; display: flex; justify-content: center; gap: 20px;">
        <span>الرقم الضريبي : 253-135-601</span>
        <span>السجل التجاري : 97810</span>
        <span>موبايل : 01009333880</span>
    </p>
    <hr>
    <title>تقرير العقد: {{ $contract->name }} - {{ $monthParam }}</title>
    <style>
        /* General Styles */
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
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Set a custom page size and margins if needed */
        @page {
            size: 4in 9in; /* Adjust these dimensions to your envelope size */
            margin: 5mm;
        }

        /* Print-specific Styles */
        @media print {
            body {
                font-size: 10px;
                margin: 5mm;
            }
            table {
                font-size: 10px;
                margin-top: 10px;
            }
            th, td {
                padding: 2px;
            }
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
                <th>رقم العامل</th>
                <th>العميل</th>
                <th>الإجمالي قبل الخصم</th>
                <th>إجمالي الادوية المحلية</th>
                <th>إجمالي الادوية المستوردة</th>
                <th>الإجمالي بعد الخصم</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patientReports as $report)
                <tr>
                    <td>{{ $report['patient']->worker_num }}</td>
                    <td>{{ $report['patient']->name }}</td>
                    <td>{{ number_format($report['total_invoice_price'], 2) }}</td>
                    <td>{{ number_format($report['total_local_price'], 2) }}</td>
                    <td>{{ number_format($report['total_imported_price'], 2) }}</td>
                    <td>{{ number_format($report['total_supported_price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th style="background: gray"></th>
                <th>المجموع الكلي</th>
                <th>{{ number_format($grandTotalInvoicePrice, 2) }}</th>
                <th>{{ number_format($grandTotalLocalPrice, 2) }}</th>
                <th>{{ number_format($grandTotalImportedPrice, 2) }}</th>
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
