@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل الفاتورة</h1>

    <div class="mb-4">
        <p><strong>اسم المريض:</strong> {{ $invoice->patient->name }}</p>
        <p><strong>التاريخ:</strong> {{ $invoice->date }}</p>
        <p>
            <strong>إجمالي السعر:</strong>
            {{ number_format($invoice->items->sum(function($item) {
                return $item->price * $item->quantity;
            }), 2) }}
        </p>
        <p><strong>إجمالي الدعم:</strong> {{ number_format($invoice->total_support, 2) }}</p>
    </div>

    <table class="table table-bordered">
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
            @forelse ($invoice->items as $item)
                <tr>
                    <td>{{ $item->medication->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->supported_price, 2) }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">لا توجد أدوية مسجلة</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mt-3">رجوع</a>
</div>
@endsection
