@extends('layout')

@section('main')
<div class="container">
    <h1>إنشاء فاتورة</h1>
    <form action="{{ route('bills.store') }}" method="POST">
        
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
        @csrf
        <!-- Customer Name -->
        <div class="mb-3">
            <label for="customer_name" class="form-label">اسم العميل</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
        </div>

        <!-- Customer Phone -->
        <div class="mb-3">
            <label for="customer_phone" class="form-label">هاتف العميل</label>
            <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
        </div>

        <!-- Products Section -->
        <div id="products-container">
            <div class="product-row mb-3">
                <label for="product_0" class="form-label">المنتج</label>
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <select name="products[0][id]" id="product_0" class="form-select" required>
                            <option value="" selected disabled>اختر منتج</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ${{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="products[0][quantity]" class="form-control" placeholder="الكمية" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger remove-product">إزالة</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 justify-content-between">
            <div class="col-auto">
                <!-- Add Product Button -->
                <button type="button" id="add-product" class="btn btn-primary">+</button>
            </div>
            <div class="col-auto">
                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">إنشاء</button>
            </div>
        </div>
    </form>
</div>

<script>
    const productsData = @json($products);
    let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', function () {
        const productsContainer = document.getElementById('products-container');
        const newProductRow = document.createElement('div');
        newProductRow.classList.add('product-row', 'mb-3');

        let optionsHtml = '<option value="" selected disabled>اختر منتج</option>';
        productsData.forEach(product => {
            if (product.quantity > 0) {
                optionsHtml += `<option value="${product.id}" data-price="${product.price}">${product.name} - $${product.price}</option>`;
            }
        });

        newProductRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <select name="products[${productIndex}][id]" class="form-select" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control" placeholder="الكمية" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-product">إزالة</button>
                </div>
            </div>
        `;

        productsContainer.appendChild(newProductRow);
        productIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
        }
    });
</script>
@endsection
