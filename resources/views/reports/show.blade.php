@extends('layout')

@section('main')
<div class="container">
    <h1>تقرير العقد: {{ $contract->name }}</h1>
    
    <!-- Form to filter the report by month -->
    <form method="GET" action="{{ route('reports.show', $contract->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="month">اختر الشهر</label>
                <input type="month" name="month" id="month" class="form-control" value="{{ $monthParam }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">عرض التقرير</button>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('reports.print', $contract->id) }}?month={{ $monthParam }}" target="_blank" class="btn btn-secondary mt-4">طباعة التقرير</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم العامل</th>
                <th>العميل</th>
                <th>الإجمالي قبل الخصم</th>
                <th>إجمالي الادوية المحلية</th>
                <th>إجمالي الادوية المستوردة</th>
                <th>الإجمالي بعد الخصم</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patientReports as $report)
                <tr>
                    <td>{{ $report['patient']->worker_num }}</td>
                    <td>{{ $report['patient']->name }}</td>
                    <td>{{ number_format($report['total_invoice_price'], 2) }}</td>
                    <td>{{ number_format($report['total_local_price'], 2) }}</td>
                    <td>{{ number_format($report['total_imported_price'], 2) }}</td>
                    <td>{{ number_format($report['total_supported_price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th style="background: gray"></th>
                <th>المجموع الكلي</th>
                <th>{{ number_format($grandTotalInvoicePrice, 2) }}</th>
                <th>{{ number_format($grandTotalLocalPrice, 2) }}</th>
                <th>{{ number_format($grandTotalImportedPrice, 2) }}</th>
                <th>{{ number_format($grandTotalSupportedPrice, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
