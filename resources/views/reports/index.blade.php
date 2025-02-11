@extends('layout')

@section('main')
<div class="container">
    <h1>تقارير العقود</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الجهة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contracts as $contract)
                <tr>
                    <td>{{ $contract->id }}</td>
                    <td>{{ $contract->name }}</td>
                    <td>
                        <a href="{{ route('reports.show', $contract->id) }}" class="btn btn-primary">عرض التقارير</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
