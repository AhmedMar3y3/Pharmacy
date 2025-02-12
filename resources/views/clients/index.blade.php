@extends('layout')

@section('main')
    <div class="container">
        <h1>العملاء</h1>

        <form method="GET" action="{{ route('clients.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="query" class="form-control" placeholder="ابحث بالاسم أو رقم الهوية"
                        value="{{ request('query') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Client Button -->
        <div class="mb-3 text-start">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> إضافة عميل جديد
            </button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>العقد</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->contract ? $client->contract->name : 'بدون عقد' }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="{{ $client->id }}" data-name="{{ $client->name }}"
                                data-phone="{{ $client->phone }}" data-id_number="{{ $client->ID_number }}"
                                data-worker_num="{{ $client->worker_num }}"
                                data-contract="{{ $client->contract ? $client->contract->id : '' }}"
                                data-contract_name="{{ $client->contract ? $client->contract->name : '' }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا العميل؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            <!-- Show Button -->
                            <button type="button" class="btn btn-success btn-sm show-btn" data-bs-toggle="modal"
                                data-bs-target="#showModal" data-id="{{ $client->id }}" data-name="{{ $client->name }}"
                                data-phone="{{ $client->phone }}" data-id_number="{{ $client->ID_number }}"
                                data-worker_num="{{ $client->worker_num }}"
                                data-contract_name="{{ $client->contract ? $client->contract->name : '' }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لم يتم العثور على عميل.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Show Client Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">تفاصيل العميل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الاسم:</strong> <span id="show_name"></span></p>
                    <p><strong>رقم العميل:</strong> <span id="show_id"></span></p>
                    <p><strong>رقم الهاتف:</strong> <span id="show_phone"></span></p>
                    <p><strong>رقم الهوية:</strong> <span id="show_ID_number"></span></p>
                    <p><strong>رقم العامل:</strong> <span id="show_worker_num"></span></p>
                    <p><strong>اسم العقد:</strong> <span id="show_contract_name"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Client Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">إضافة عميل جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="ID_number" class="form-label">رقم الهوية</label>
                            <input type="text" class="form-control" id="ID_number" name="ID_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="worker_num" class="form-label">رقم العامل</label>
                            <input type="text" class="form-control" id="worker_num" name="worker_num" required>
                        </div>
                        <div class="mb-3">
                            <label for="contract_id" class="form-label">العقد</label>
                            <select class="form-select" name="contract_id" id="contract_id" required>
                                <option value="">اختر العقد</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                @endforeach
                            </select>
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

    <!-- Edit Client Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">تعديل العميل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">اسم العميل</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="edit_ID_number" class="form-label">رقم الهوية</label>
                            <input type="text" class="form-control" id="edit_ID_number" name="ID_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_worker_num" class="form-label">رقم العامل</label>
                            <input type="text" class="form-control" id="edit_worker_num" name="worker_num" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_contract_id" class="form-label">العقد</label>
                            <select class="form-select" name="contract_id" id="edit_contract_id" required>
                                <option value="">اختر العقد</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                @endforeach
                            </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Combined event listeners for edit and show modals
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const clientId = this.dataset.id;
                    // Set the action URL for the edit form
                    document.getElementById('editForm').action = `/update-clients/${clientId}`;
                    document.getElementById('edit_name').value = this.dataset.name;
                    document.getElementById('edit_phone').value = this.dataset.phone;
                    document.getElementById('edit_ID_number').value = this.dataset.id_number;
                    document.getElementById('edit_worker_num').value = this.dataset.worker_num;
                    document.getElementById('edit_contract_id').value = this.dataset.contract;
                });
            });

            document.querySelectorAll('.show-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('show_name').textContent = this.dataset.name;
                    document.getElementById('show_id').textContent = this.dataset.id;
                    document.getElementById('show_phone').textContent = this.dataset.phone;
                    document.getElementById('show_ID_number').textContent = this.dataset.id_number;
                    document.getElementById('show_worker_num').textContent = this.dataset.worker_num;
                    document.getElementById('show_contract_name').textContent = this.dataset.contract_name;
                });
            });
        });
    </script>
@endsection