@extends('layouts.app')

@section('main')
<div class="row column_title">
    <div class="col-md-12">
         <div class="page_title">
        
</div>
</div>
</div>

<div class="row w-100">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Assign Extra Fees to Students</h2>
                </div>
            </div>

            <div class="full px-4 py-4">
                <form method="GET" action="{{ route('assignextrafeeform') }}">
                    <div class="row mb-4">
                        <!-- Extra Fee -->
                        <div class="col-md-4">
                            <label for="extra_fee_id" class="form-label">Extra Fee Type</label>
                            <select name="extra_fee_id" id="extra_fee_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Select Extra Fee --</option>
                                @foreach($extraFees as $fee)
                                    <option value="{{ $fee->id }}"
                                        data-amount="{{ $fee->amount }}"
                                        data-quantity-based="{{ $fee->is_quantity_based ? '1':'0'}}"
                                        {{ $selectedExtraFee == $fee->id ? 'selected' : '' }}>
                                        {{ $fee->name }} (KES {{ $fee->amount }}) {{ $fee->term->name }}-{{ $fee->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Class Filter -->
                        <div class="col-md-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control" {{ !$selectedExtraFee ? 'disabled' : '' }} onchange="this.form.submit()">
                                <option value="">-- All Classes --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Filter -->
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search Student</label>
                            <input type="text" name="search" id="search" value="{{ $searchQuery }}" 
                                   class="form-control" placeholder="Name or Admission No."
                                   {{ !$selectedExtraFee ? 'disabled' : '' }}>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" {{ !$selectedExtraFee ? 'disabled' : '' }}>Filter</button>
                        </div>
                    </div>
                </form>

                @if($students->isNotEmpty())
                    <form action="{{ route('assignextrafee') }}" method="POST">
                        @csrf
                        <input type="hidden" name="extra_fee_id" value="{{ $selectedExtraFee }}">

                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all"></th>
                                        <th>Student Name</th>
                                        <th>Admission No.</th>
                                        <th>Class</th>
                                        <th class="quantity-col">Quantity</th>
                                        <th class="total-col">Total (KES)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($students as $student)
    @php
        $assigned = $assignedExtraFees->get($student->id); // null if not assigned
    @endphp
    <tr class="student-row">
        <td>
            <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
            <input type="checkbox" 
                   class="student-checkbox" 
                   name="students[{{ $student->id }}][selected]" 
                   value="1"
                   {{ $assigned ? 'checked' : '' }}>
        </td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->admission }}</td>
        <td>{{ $student->class->name }}</td>
        <td class="quantity-col">
            <input type="number" 
                   class="form-control quantity-input" 
                   name="students[{{ $student->id }}][quantity]" 
                   min="1" 
                   value="{{ $assigned ? $assigned->quantity : '' }}"
                   {{ $assigned ? '' : 'disabled' }}>
        </td>
        <td class="total-col">
            <span class="student-total">
                KES {{ $assigned ? number_format($assigned->amount, 2) : '0.00' }}
            </span>
        </td>
    </tr>
@endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Assign Fees</button>
                        </div>
                    </form>
                @elseif($selectedExtraFee)
                    <p class="text-muted">No students found for the selected criteria.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
    const extraFeeSelect = document.getElementById('extra_fee_id');
    const studentRows = document.querySelectorAll('.student-row');

    function calculateTotal(row, amount, quantityBased) {
        const quantityInput = row.querySelector('.quantity-input');
        const totalField = row.querySelector('.student-total');
        let quantity = quantityBased ? parseFloat(quantityInput.value) || 0 : 1;
        totalField.textContent = `KES ${(quantity * amount).toFixed(2)}`;
    }

    function updateUIBasedOnFee() {
        const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];
        const amount = parseFloat(selectedOption.dataset.amount);
        const quantityBased = selectedOption.dataset.quantityBased === '1';

        // Show or hide quantity column
        document.querySelectorAll('.quantity-col').forEach(cell => {
            cell.style.display = quantityBased ? 'table-cell' : 'none';
        });

        studentRows.forEach(row => {
            const checkbox = row.querySelector('.student-checkbox');
            const quantityInput = row.querySelector('.quantity-input');

            if (!checkbox.checked && !quantityInput.value) {
                quantityInput.disabled = true;
            }

            if (!quantityBased) {
                quantityInput.disabled = true;
                quantityInput.value = 1;
            }

            calculateTotal(row, amount, quantityBased);
        });
    }

    // Enable/disable quantity when checkbox changes
    studentRows.forEach(row => {
        const checkbox = row.querySelector('.student-checkbox');
        const quantityInput = row.querySelector('.quantity-input');
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                quantityInput.disabled = false;
                if (!quantityInput.value) quantityInput.value = 1; // default
            } else {
                quantityInput.disabled = true;
                quantityInput.value = '';
            }
            const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];
            const amount = parseFloat(selectedOption.dataset.amount);
            const quantityBased = selectedOption.dataset.quantityBased === '1';
            calculateTotal(row, amount, quantityBased);
        });

        // Recalculate total on quantity change
        quantityInput.addEventListener('input', () => {
            const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];
            const amount = parseFloat(selectedOption.dataset.amount);
            const quantityBased = selectedOption.dataset.quantityBased === '1';
            calculateTotal(row, amount, quantityBased);
        });
    });

    updateUIBasedOnFee();
});
</script>
