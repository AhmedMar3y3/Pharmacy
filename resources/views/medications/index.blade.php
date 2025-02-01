@extends('layout')

@section('main')
<div class="container">
    <h1>الأدوية</h1>
    
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3" style="background-color: #0e123e; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='white'; this.style.color='#0e123e';" onmouseout="this.style.backgroundColor='#0e123e'; this.style.color='white';">إضافة منتج</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> <!-- أيقونة العرض -->
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> <!-- أيقونة التعديل -->
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                    
                </tr>
                @empty
                <tr>
                        <td colspan="4" class="text-center">لم يتم العثور على منتجات.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection