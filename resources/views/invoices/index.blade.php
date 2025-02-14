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
                       {{ number_format($invoice->items->sum(function($item) { 
                            return $item->price * $item->quantity; 
                        }), 2) }} ج.م 
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
    <!-- Pagination Links -->
  <!-- Pagination Buttons -->
  <div class="d-flex justify-content-between mt-4">
    <!-- Previous Page Button -->
    @if($invoices->onFirstPage())
    <span class="btn btn-secondary btn-rounded disabled">السابق</span>
    @else
    <a href="{{ $invoices->previousPageUrl() }}" class="btn btn-primary btn-rounded">السابق</a>
    @endif

    <!-- Next Page Button -->
    @if($invoices->hasMorePages())
    <a href="{{ $invoices->nextPageUrl() }}" class="btn btn-primary btn-rounded">التالي</a>
    @else
    <span class="btn btn-secondary btn-rounded disabled">التالي</span>
    @endif
</div>
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
                    <!-- Patient, Date, Serial fields here -->
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">اسم العميل</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="">اختر العميل</option>
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

                    <!-- Items Container -->
                    <div id="items-container">
                        <div class="item-row mb-3">
                            <div class="row">
                                <!-- Medication Selection -->
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
                                <!-- Price Input -->
                                <div class="col-md-3">
                                    <label>السعر</label>
                                    <input type="number" step="0.01" name="items[0][price]" class="form-control price-input" placeholder="السعر" required>
                                </div>
                                <!-- Quantity Input -->
                                <div class="col-md-2">
                                    <label>الكمية</label>
                                    <input type="number" name="items[0][quantity]" class="form-control" placeholder="الكمية" min="1" required>
                                </div>
                                <!-- Type Selection -->
                                <div class="col-md-2">
                                    <label>النوع</label>
                                    <select name="items[0][type]" class="form-select" required>
                                        <option value="">اختر النوع</option>
                                        <option value="local">محلي</option>
                                        <option value="imported">مستورد</option>
                                    </select>
                                </div>
                                <!-- Remove Button -->
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-item mt-4">حذف</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- Add More Items Button -->
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
                        <p><strong>اسم العميل:</strong> {{ $invoice->patient->name }}</p>
                        <p><strong>التاريخ:</strong> {{ $invoice->date }}</p>
                        <p>
                            <strong>إجمالي السعر:</strong>
                            {{ number_format($invoice->items->sum(function($item) {
                                return $item->price * $item->quantity;
                            }), 2) }}
                        </p>
                        <p><strong>الإجمالي بعد الخصم:</strong> {{ number_format($invoice->total_support, 2) }}</p>
                        <p><strong>حاصل الخصم : </strong> 
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
                                <th>السعر بعد الخصم</th>
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
    // Function to update the price input based on selected medication
    function updatePrice(selectElement) {
        // Get the selected option's data-price attribute
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        // Find the corresponding price input in the same row
        var row = selectElement.closest('.row');
        var priceInput = row.querySelector('.price-input');
        if (price && priceInput) {
            priceInput.value = price;
        } else if (priceInput) {
            priceInput.value = '';
        }
    }

    // Attach change event to existing medication selects
    document.querySelectorAll('select[name^="items"][name$="[medication_id]"]').forEach(function(select) {
        select.addEventListener('change', function() {
            updatePrice(this);
        });
    });

    // Add Medication Item (Clone Row)
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const newRow = document.querySelector('.item-row').cloneNode(true);
        const newIndex = itemIndex++;

        // Update names and clear values for all inputs/selects in the new row
        newRow.querySelectorAll('select, input').forEach(function(element) {
            // Replace the index inside square brackets
            element.name = element.name.replace(/\[\d+\]/, `[${newIndex}]`);
            element.value = '';
        });

        document.getElementById('items-container').appendChild(newRow);

        // Attach change event for the new row's medication select
        var newMedSelect = newRow.querySelector('select[name^="items"][name$="[medication_id]"]');
        if (newMedSelect) {
            newMedSelect.addEventListener('change', function() {
                updatePrice(this);
            });
        }
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
