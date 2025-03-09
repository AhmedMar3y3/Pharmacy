<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInvoiceModalLabel">إنشاء فاتورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">اسم العميل</label>
                        <div class="input-group">
                            <select name="patient_id" id="patient_id" class="form-select" required>
                                <option value="">اختر العميل</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                                إضافة عميل جديد
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">التاريخ</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">رقم السيريال</label>
                        <input type="text" name="serial" id="serial" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
                            إضافة دواء جديد
                        </button>
                    </div>
                    <div id="items-container">
                        <div class="item-row mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>الدواء</label>
                                    <select name="items[0][medication_id]" class="form-select" required>
                                        <option value="">اختر الدواء</option>
                                        @foreach ($medications as $medication)
                                            <option value="{{ $medication->id }}" data-price="{{ $medication->price }}">
                                                {{ $medication->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>السعر</label>
                                    <input type="number" step="0.01" name="items[0][price]" class="form-control price-input" required>
                                </div>
                                <div class="col-md-2">
                                    <label>الكمية</label>
                                    <input type="number" step="0.01" name="items[0][quantity]" class="form-control" min="0.01" required>
                                </div>
                                <div class="col-md-2">
                                    <label>النوع</label>
                                    <select name="items[0][type]" class="form-select" required>
                                        <option value="">اختر النوع</option>
                                        <option value="local">محلي</option>
                                        <option value="imported">مستورد</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-item mt-4">حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="btn btn-secondary mb-3">إضافة دواء</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">إضافة عميل جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPatientForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ID_number" class="form-label">رقم الهوية</label>
                        <input type="text" name="ID_number" id="ID_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="worker_num" class="form-label">رقم العامل</label>
                        <input type="text" name="worker_num" id="worker_num" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contract_id" class="form-label">العقد</label>
                        <select name="contract_id" id="contract_id" class="form-select" required>
                            <option value="">اختر العقد</option>
                            @foreach ($contracts as $contract)
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

<!-- Add Medication Modal -->
<div class="modal fade" id="addMedicationModal" tabindex="-1" aria-labelledby="addMedicationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicationModalLabel">إضافة دواء جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMedicationForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="med_name" class="form-label">اسم الدواء</label>
                        <input type="text" name="name" id="med_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="med_price" class="form-label">السعر</label>
                        <input type="number" step="0.01" name="price" id="med_price" class="form-control" required>
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

<script>
document.getElementById('addPatientForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('{{ route('clients.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('patient_id');
            const option = document.createElement('option');
            option.value = data.patient.id;
            option.text = data.patient.name;
            select.add(option);
            select.value = data.patient.id;
            bootstrap.Modal.getInstance(document.getElementById('addPatientModal')).hide();
        } else {
            alert('حدث خطأ أثناء إضافة العميل');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إضافة العميل');
    });
});

document.getElementById('addMedicationForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('{{ route('medications.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const selects = document.querySelectorAll('select[name$="[medication_id]"]');
            selects.forEach(select => {
                const option = document.createElement('option');
                option.value = data.medication.id;
                option.text = data.medication.name;
                option.setAttribute('data-price', data.medication.price);
                select.add(option);
            });
            bootstrap.Modal.getInstance(document.getElementById('addMedicationModal')).hide();
        } else {
            alert('حدث خطأ أثناء إضافة الدواء');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إضافة الدواء');
    });
});
</script>