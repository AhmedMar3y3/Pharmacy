@extends('layout')

@section('main')
<div class="container">
    <h1>الفواتير</h1>


    <!-- Create Invoice Button -->
    <button type="button" class="btn btn-primary mb-3 me-auto d-block" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
        إنشاء فاتورة
    </button>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Invoices Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم العميل</th>
                <th>التاريخ</th>
                <th>السعر الإجمالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->patient->name }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>
                        ${{ number_format($invoice->items->sum(function($item) { 
                            return $item->price * $item->quantity; 
                        }), 2) }}
                    </td>
                    <td>
                        <!-- Instead of an AJAX call, each invoice has its own modal -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewInvoiceModal-{{ $invoice->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">لم يتم العثور على فواتير.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

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
                        <label for="patient_id" class="form-label">اسم المريض</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="">اختر المريض</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">التاريخ</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="serial" class="form-label">رقم السيريال</label>
                        <input type="text" name="serial" id="serial" class="form-control" required>
                    </div>
                    <div id="items-container">
                        <div class="item-row mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>الدواء</label>
                                    <select name="items[0][medication_id]" class="form-select medication-select" required>
                                        <option value="">اختر الدواء</option>
                                        @foreach ($medications as $medication)
                                            <option value="{{ $medication->id }}" 
                                                data-price="{{ $medication->price }}"
                                                data-supported-price="{{ $medication->supported_price }}"
                                                data-stock="{{ $medication->quantity }}">
                                                {{ $medication->name }} (المخزون: {{ $medication->quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>الكمية</label>
                                    <input type="number" name="items[0][quantity]" class="form-control" placeholder="الكمية" min="1" required>
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

<!-- View Invoice Modals for Each Invoice -->
@foreach ($invoices as $invoice)
    <div class="modal fade" id="viewInvoiceModal-{{ $invoice->id }}" tabindex="-1" aria-labelledby="viewInvoiceModalLabel-{{ $invoice->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInvoiceModalLabel-{{ $invoice->id }}">تفاصيل الفاتورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Invoice Details (server-side rendered) -->
                    <div class="mb-4">
                        <p><strong>رقم السيريال:</strong> {{ $invoice->serial }}</p>
                        <p><strong>اسم المريض:</strong> {{ $invoice->patient->name }}</p>
                        <p><strong>التاريخ:</strong> {{ $invoice->date }}</p>
                        <p>
                            <strong>إجمالي السعر:</strong>
                            {{ number_format($invoice->items->sum(function($item) {
                                return $item->price * $item->quantity;
                            }), 2) }}
                        </p>
                        <p><strong>إجمالي السعر المدعوم:</strong> {{ number_format($invoice->total_support, 2) }}</p>
                        <p><strong>إجمالي الدعم: </strong> 
                            {{ number_format($invoice->items->sum(function($item) {
                                return $item->price * $item->quantity;
                            }) - $invoice->total_support, 2) }}
                        </p>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الدواء</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>السعر المدعوم</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->medication ? $item->medication->name : 'الدواء محذوف' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) }}</td>
                                    <td>{{ number_format($item->supported_price, 2) }}</td>
                                    <td>{{ number_format($item->supported_price * $item->quantity, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد أدوية مسجلة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary" onclick="printInvoice({{ $invoice->id }})">طباعة</button>
                    <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-info">تحميل PDF</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function printInvoice(invoiceId) {
        var printUrl = "{{ url('invoices') }}/" + invoiceId + "/print";
        var printWindow = window.open(printUrl, '_blank');
        printWindow.focus();

    }
</script>

<!-- Optional: JavaScript for adding/removing medication items in the Create Invoice Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Medication Item
        let itemIndex = 1;
        document.getElementById('add-item').addEventListener('click', function() {
            const newRow = document.querySelector('.item-row').cloneNode(true);
            const newIndex = itemIndex++;
    
            // Update names and clear values
            newRow.querySelectorAll('select, input').forEach(element => {
                element.name = element.name.replace('[0]', `[${newIndex}]`);
                element.value = '';
            });
    
            document.getElementById('items-container').appendChild(newRow);
        });
    
        // Remove Medication Item
        document.getElementById('items-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('.item-row').length > 1) {
                    e.target.closest('.item-row').remove();
                }
            }
        });
    });
</script>
@endsection
