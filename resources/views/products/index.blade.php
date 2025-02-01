@extends('layout')
@section('main')

<div class="container text-end">
    <h2 style="color: black">جميع المنتجات</h2>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- Add Product Button -->
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-rounded btn-fw" style="margin: 10px">
        إضافة منتج جديد
    </a>

    <!-- Search Form -->
    <form action="{{ route('admin.products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">بحث</button>
        </div>
    </form>

    <!-- Products Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-rounded btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-rounded btn-sm" style="display:inline-block;">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->id }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center"  style="color: black">لا توجد منتجات متاحة.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
        <!-- Pagination Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <!-- Previous Page Button -->
            @if($products->onFirstPage())
            <span class="btn btn-secondary btn-rounded disabled">السابق</span>
            @else
            <a href="{{ $products->previousPageUrl() }}" class="btn btn-primary btn-rounded">السابق</a>
            @endif

            <!-- Next Page Button -->
            @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="btn btn-primary btn-rounded">التالي</a>
            @else
            <span class="btn btn-secondary btn-rounded disabled">التالي</span>
            @endif
        </div>
</div>

@endsection