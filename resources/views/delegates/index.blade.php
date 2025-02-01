@extends('layout')
@section('main')
<div class="container text-end">
    <h2>جميع مندوبي التوصيل </h2>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- delegates Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>الهاتف</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($delegates as $delegate)
            <tr>
                <td>
                    <!-- Delete Button -->
                    <form action="{{ route('admin.delegates.destroy', $delegate->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-trash"></i></button>
                    </form>

                    <!-- Show Button -->
                    <button class="btn btn-info btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#showDelegateModal{{ $delegate->id }}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
                <td>{{ $delegate->phone }}</td>
                <td>{{ $delegate->first_name }}</td>
                <td>{{ $delegate->id }}</td>
            </tr>

            <!-- Show delegate Modal -->
            <div class="modal fade text-end" id="showDelegateModal{{ $delegate->id }}" tabindex="-1" aria-labelledby="showDelegateModalLabel{{ $delegate->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showDelegateModalLabel{{ $delegate->id }}">عرض السؤال</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p style="color: black"><strong>الاسم الاول:</strong> {{ $delegate->first_name }}</p>
                            <p style="color: black"><strong>الاسم الاخير:</strong> {{ $delegate->last_name }}</p>
                            <p style="color: black"><strong>الهاتف:</strong> {{ $delegate->phone }}</p>
                            <p style="color: black"><strong>الإيميل:</strong> {{ $delegate->email }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
>
            @empty
            <tr>
                <td colspan="12" class="text-center">لا يوجد مندوبين متاحين.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection