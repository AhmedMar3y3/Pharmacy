@extends('layout')

@section('main')
<div class="container">
    <h1>الإعدادات</h1>
    
    <form method="GET" action="{{ route('profile.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="query" class="form-control" placeholder="ابحث بالاسم أو البريد الإلكتروني" value="{{ request('query') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </div>
    </form>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm show-btn" 
                            data-bs-toggle="modal" data-bs-target="#showModal"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}">
                            <i class="bi bi-eye"></i> عرض
                        </button>
                        
                        <button type="button" class="btn btn-warning btn-sm edit-btn" 
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}">
                            <i class="fas fa-edit"></i> تعديل
                        </button>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">لم يتم العثور على مستخدم.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Show Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel">عرض المستخدم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>الاسم:</strong> <span id="show_name"></span></p>
                <p><strong>البريد الإلكتروني:</strong> <span id="show_email"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل المستخدم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
        

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                
                    <button type="button" class="btn btn-secondary" id="togglePasswordSettings">إعدادات الباسورد</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <div id="passwordSettings" style="display: none;">
                        <div class="mb-3">
                    <div class="mb-3">
    <label for="edit_password" class="form-label">كلمة المرور الحالية</label>
    <input type="password" class="form-control" id="edit_password" name="password">
</div>
<div class="mb-3">
    <label for="new_password" class="form-label">كلمة المرور الجديدة (اختياري)</label>
    <input type="password" class="form-control" id="new_password" name="new_password">
</div>
<div class="mb-3">
    <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
</div>
<button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>


            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إعداد الحدث لعرض التفاصيل في Modal
        const showModal = document.getElementById('showModal');
        showModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // الزر الذي فتح الـ modal
            const name = button.getAttribute('data-name');
            const email = button.getAttribute('data-email');
            
            // تحديث المحتوى داخل الـ modal
            const showName = showModal.querySelector('#show_name');
            const showEmail = showModal.querySelector('#show_email');
            
            showName.textContent = name;
            showEmail.textContent = email;
        });

        
    
        // إعداد الحدث لتعديل بيانات المستخدم في Edit Modal
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // الزر الذي فتح الـ modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const email = button.getAttribute('data-email');
            
            // تحديث الحقول في نموذج التعديل
            const editName = editModal.querySelector('#edit_name');
            const editEmail = editModal.querySelector('#edit_email');
            
            editName.value = name;
            editEmail.value = email;
            
            // تحديث URL الخاص بـ form
            const editForm = document.getElementById('editForm');
            editForm.action = `/profile/${id}`;
        });
    
        // إظهار / إخفاء إعدادات كلمة المرور
        document.getElementById('togglePasswordSettings').addEventListener('click', function() {
            const passwordSettings = document.getElementById('passwordSettings');
            passwordSettings.style.display = passwordSettings.style.display === 'none' ? 'block' : 'none';
        });
    });
    </script>
@endsection
