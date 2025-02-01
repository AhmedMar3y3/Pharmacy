@extends('layout')
@section('styles')
<style>
    .image-upload-square {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        width: 250px; 
        height: 250px;
        border-radius: 15px;
        margin: 0 auto; /* Center the container */
    }

    .image-upload-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
@endsection

@section('main')

<div class="container text-end">
    <h2>تفاصيل المنتج</h2>

    <!-- Image Container -->
    <div class="text-center mb-3">
        @if($product->image)
            <div class="image-upload-square border">
                <img src="{{ asset('/images/product/' . basename($product->image)) }}" alt="Image">
            </div>
        @else
            <p>لا توجد صورة متاحة.</p>
        @endif
    </div>

    <!-- Product Details -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text"><strong>الوصف:</strong> {{ $product->description }}</p>
            <p class="card-text"><strong>الوصفة:</strong> {{ $product->recipe }}</p>
            <p class="card-text"><strong>الكمية:</strong> {{ $product->quantity }}</p>
            <p class="card-text"><strong>السعر:</strong> {{ $product->price }}</p>
            @if($product->discount_price)
            <p class="card-text"><strong>سعر الخصم:</strong> {{ $product->discount_price }}</p>
            @endif
            @if($product->points)
                <p class="card-text"><strong>النقاط:</strong> {{ $product->points }}</p>
            @endif
            <p class="card-text"><strong>الفئة :</strong> {{ $product->category->name }}</p>
        </div>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">العودة إلى القائمة</a>
</div>

@endsection