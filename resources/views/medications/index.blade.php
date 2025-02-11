@extends('layout')

@section('main')
<div class="container">
    <h1>الأدوية</h1>
    <form action="{{ route('medications.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <div class="row  w-100">
                <div class="col-10">  
                              <input type="text" name="search" class="form-control" placeholder="ابحث عن دواء" value="{{ request('search') }}">
                </div>
                <div class="col-2">  
                              <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif 

 <!-- Add Medication Button -->
 <button type="button" class="btn btn-primary mb-3 me-auto d-block" data-bs-toggle="modal" data-bs-target="#createModal">
    <i class="fas fa-plus"></i> إضافة دواء جديد
</button>


    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>السعر المدعوم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medications as $medication)
            <tr>
                <td>{{ $medication->name }}</td>
                <td>{{ $medication->quantity }}</td>
                <td>{{ $medication->price }}</td>
                <td>{{ $medication->supported_price }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit-btn" 
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $medication->id }}"
                            data-name="{{ $medication->name }}"
                            data-quantity="{{ $medication->quantity }}"
                            data-price="{{ $medication->price }}"
                            data-supported-price="{{ $medication->supported_price }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('medications.destroy', $medication->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الدواء؟');">
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
                    <td colspan="12" class="text-center">لم يتم العثور على أدوية.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Create Medication Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">إضافة دواء جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('medications.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الدواء</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">الكمية</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">السعر</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="supported_price" class="form-label">السعر المدعوم</label>
                            <input type="number" step="0.01" class="form-control" id="supported_price" name="supported_price" required>
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
                    <h5 class="modal-title" id="editModalLabel">تعديل الدواء</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">اسم الدواء</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label">الكمية</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">السعر</label>
                            <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_supported_price" class="form-label">السعر المدعوم</label>
                            <input type="number" step="0.01" class="form-control" id="edit_supported_price" name="supported_price" required>
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
                const medicationId = this.dataset.id;
                document.getElementById('editForm').action = `/update-medication/${medicationId}`;
                
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_quantity').value = this.dataset.quantity;
                document.getElementById('edit_price').value = this.dataset.price;
                document.getElementById('edit_supported_price').value = this.dataset.supportedPrice;
            });
        });
    });
</script>
@endsection