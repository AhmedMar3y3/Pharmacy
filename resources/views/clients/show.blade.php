@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل العميل</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">الاسم: {{ $client->name }}</h5>
            <p class="card-text">العنوان: {{ $client->address }}</p>
            <p class="card-text">رقم الهاتف: {{ $client->phone }}</p>
            <p class="card-text">رقم الهوية: {{ $client->ID_number }}</p>
        </div>
    </div>

    <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-3">العودة إلى القائمة</a>
</div>
@endsection