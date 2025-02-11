<!-- resources/views/invoices/pdf.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->id }}</title>
    <style>

        @font-face {
            font-family: 'Amiri';
            src: url("{{ storage_path('fonts/Amiri-Regular.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Amiri', DejaVu Sans, sans-serif;
            direction: rtl !important;
            text-align: right;
            font-size: 14px;
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
    </style>
</head>
<body>
    <h1>فاتورة رقم: {{ $invoice->serial }}</h1>
    <p><strong>اسم المريض:</strong> {{ $invoice->patient->name }}</p>
    <p><strong>التاريخ:</strong> {{ $invoice->date }}</p>
    <p>
        <strong>السعر الإجمالي:</strong>
        ${{ number_format($invoice->items->sum(function($item) { 
            return $item->price * $item->quantity; 
        }), 2) }}
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
</body>
</html>
