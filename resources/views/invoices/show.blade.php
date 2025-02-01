@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل الفاتورة</h1>
    <div class="mb-3">
        <strong>اسم العميل:</strong> {{ $bill->customer_name }}
    </div>
    <div class="mb-3">
        <strong>هاتف العميل:</strong> {{ $bill->customer_phone }}
    </div>
    <div class="mb-3">
        <strong>السعر الإجمالي:</strong> ${{ $bill->total_price }}
    </div>
    <h3>المنتجات</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ $product->price * $product->pivot->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
