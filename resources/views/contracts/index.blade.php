@extends('layout')

@section('main')
<div class="container">
    <h1>العقود</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Medication Button -->
    <button type="button" class="btn btn-primary mb-3 me-auto d-block" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="fas fa-plus"></i> إضافة عقد جديد
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>النسبة للمحلي</th>
                <th>النسبة للمستورد</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contracts as $contract)
            <tr>
                <td>{{ $contract->id }}</td>
                <td>{{ $contract->name }}</td>
                <td>{{ $contract->local_discount_percentage }}</td>
                <td>{{ $contract->imported_discount_percentage }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit-btn" 
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $contract->id }}"
                            data-name="{{ $contract->name }}"
                            data-local_discount_percentage="{{ $contract->local_discount_percentage }}"
                            data-imported_discount_percentage="{{ $contract->imported_discount_percentage }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا العقد');">
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
                    <td colspan="12" class="text-center">لم يتم العثور على عقود.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Create Medication Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">إضافة عقد جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('contracts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الجهة</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="local_discount_percentage" class="form-label">نسبة خصم المحلي</label>
                            <input type="number" step="0.01" class="form-control" id="local_discount_percentage" name="local_discount_percentage" required>
                        </div>
                        <div class="mb-3">
                            <label for="imported_discount_percentage" class="form-label">نسبة خصم المستورد</label>
                            <input type="number" step="0.01" class="form-control" id="imported_discount_percentage" name="imported_discount_percentage" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Medication Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">تعديل العقد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">اسم الجهة</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_local" class="form-label">نسبة خصم المحلي</label>
                            <input type="number" step="0.01" class="form-control" id="edit_local" name="local_discount_percentage" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_imported" class="form-label">نسبة خصم المستورد</label>
                            <input type="number" step="0.01" class="form-control" id="edit_imported" name="imported_discount_percentage" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal Handler
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const contractId = this.dataset.id;
                document.getElementById('editForm').action = `/update-contract/${contractId}`;
                
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_local').value = this.dataset.local_discount_percentage;
                document.getElementById('edit_imported').value = this.dataset.imported_discount_percentage;
            });
        });
    });
</script>
@endsection
