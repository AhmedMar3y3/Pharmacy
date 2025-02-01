@extends('layout')

@section('main')
<div class="container">
    <h1>الفواتير</h1>
    <form method="GET" action="{{ route('bills.index') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="البحث عن طريق اسم العميل" value="{{ request('search') }}">
    </form>
    <a href="{{ route('bills.create') }}" class="btn btn-primary mb-3" style="background-color: #0e123e; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='white'; this.style.color='#0e123e';" onmouseout="this.style.backgroundColor='#0e123e'; this.style.color='white';">إنشاء فاتورة</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم العميل</th>
                <th>هاتف العميل</th>
                <th>السعر الإجمالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $bill)
                <tr>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ $bill->customer_phone }}</td>
                    <td>${{ $bill->total_price }}</td>
                    <td>
                        <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> <!-- أيقونة العرض -->
                        </a>
                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="fas fa-trash-alt"></i>                           
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                        <td colspan="5" class="text-center">لم يتم العثور على فواتير.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $bills->links() }}
</div>
@endsection
