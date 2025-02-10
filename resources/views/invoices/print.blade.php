<!-- resources/views/invoices/print.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->serial }}</title>
    <style>
        /* Basic styles for printing */
        body {
            font-family: 'Amiri', DejaVu Sans, sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 14px;
            margin: 20px;
        }
        h1, p {
            margin: 0 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Hide any buttons or non-printable elements */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        // Automatically trigger print when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <h1>فاتورة رقم: {{ $invoice->serial }}</h1>
    <p><strong>اسم العميل:</strong> {{ $invoice->patient->name }}</p>
    <p><strong>التاريخ:</strong> {{ $invoice->date }}</p>
    <p>
        <strong>السعر الإجمالي:</strong>
        {{ number_format($invoice->items->sum(function($item) { 
            return $item->price * $item->quantity; 
        }), 2) }}
    </p>
    <p><strong>إجمالي السعر المدعوم:</strong> {{ number_format($invoice->total_support, 2) }}</p>
    <p><strong>إجمالي الدعم:</strong> 
        {{ number_format($invoice->items->sum(function($item) {
            return $item->price * $item->quantity;
        }) - $invoice->total_support, 2) }}
    </p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>الدواء</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>السعر المدعوم</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->medication ? $item->medication->name : 'الدواء محذوف' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->supported_price, 2) }}</td>
                    <td>{{ number_format($item->supported_price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Optionally, add a "Return" link if desired -->
    <div class="no-print" style="margin-top: 20px;">
        <a href="{{ route('invoices.index') }}">عودة إلى الفواتير</a>
    </div>
</body>
</html>
