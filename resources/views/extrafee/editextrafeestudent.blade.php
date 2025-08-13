@extends('layouts.app')

@section('main')
<div class="row column_title">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="d-flex justify-content-end align-items-center py-3 px-4 white_shd border rounded mb-3 mt-3">
                <a href="#" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a>
            </div>
        </div>
    </div>
</div>

<div class="row w-100">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit Assigned Extra Fees</h2>
                </div>
            </div>

            <div class="full px-4 py-4">
                <form action="{{ route('updateassignedextrafee', $assignedFee->id) }}" method="POST">
                    @csrf
                    

                    <div class="row mb-4">
                        <!-- Fee Selection -->
                        <div class="col-md-4">
                            <label for="extra_fee_id" class="form-label">Extra Fee Type</label>
                            <select name="extra_fee_id" id="extra_fee_id" class="form-control" required>
                                <option value="">-- Select Extra Fee --</option>
                                @foreach($extraFees as $fee)
                                    <option 
                                        value="{{ $fee->id }}"
                                        data-amount="{{ $fee->amount }}"
                                        data-quantity-based="{{ $fee->is_quantity_based ? '1':'0'}}"
                                        data-description="{{ $fee->description }}"
                                        {{ $assignedFee->extra_fee_id == $fee->id ? 'selected' : '' }}>
                                        {{ $fee->name }} (KES {{ $fee->amount }}) {{$fee->term->name}}-{{$fee->year}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fee Description -->
                        <div class="col-md-8">
                            <label class="form-label d-block">Fee Description</label>
                            <p id="fee_description" class="border rounded p-2 text-muted">
                                Select a fee to see details...
                            </p>
                        </div>
                    </div>

                    <!-- Student Table -->
                    <div id="student_table_wrapper" style="display: none;">
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
                                <tbody id="student_table">
                                    @foreach($students as $student)
                                        @php
                                            $existing = $assignedStudents->firstWhere('student_id', $student->id);
                                        @endphp
                                        <tr data-class="{{ $student->class_id }}" class="student-row">
                                            <td>
                                                <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                                <input type="checkbox" 
                                                    class="student-checkbox" 
                                                    name="students[{{ $student->id }}][selected]" 
                                                    value="1"
                                                    {{ $existing ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->admission }}</td>
                                            <td>{{ $student->class->name }}</td>
                                            <td class="quantity-col">
                                                <input type="number" 
                                                    class="form-control quantity-input" 
                                                    name="students[{{ $student->id }}][quantity]" 
                                                    min="1" 
                                                    placeholder="Qty" 
                                                    value="{{ $existing && $existing->quantity ? $existing->quantity : '' }}">
                                            </td>
                                            <td class="total-col">
                                                <span class="student-total">KES 0.00</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Update Fees</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const extraFeeSelect = document.getElementById('extra_fee_id');
    const descriptionElement = document.getElementById('fee_description');
    const studentRows = document.querySelectorAll('.student-row');
    const studentTableWrapper = document.getElementById('student_table_wrapper');

    function updateUIBasedOnFee() {
        const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];

        if (selectedOption.value !== "") {
            studentTableWrapper.style.display = 'block';
        } else {
            studentTableWrapper.style.display = 'none';
            descriptionElement.textContent = "Select a fee to see details...";
            return;
        }

        const amount = parseFloat(selectedOption.dataset.amount);
        const quantityBased = selectedOption.dataset.quantityBased === '1';
        const description = selectedOption.dataset.description;
        descriptionElement.textContent = description || "No description.";

        document.querySelectorAll('.quantity-col').forEach(cell => {
            cell.style.display = quantityBased ? 'table-cell' : 'none';
        });

        studentRows.forEach(row => {
            const quantityInput = row.querySelector('.quantity-input');
            if (quantityBased) {
                quantityInput.disabled = false;
            } else {
                quantityInput.disabled = true;
                quantityInput.value = 1;
            }
            calculateTotal(row, amount, quantityBased);
        });
    }

    function calculateTotal(row, amount, quantityBased) {
        const quantityInput = row.querySelector('.quantity-input');
        const totalField = row.querySelector('.student-total');
        let quantity = quantityBased ? parseFloat(quantityInput.value) || 0 : 1;
        totalField.textContent = `KES ${(quantity * amount).toFixed(2)}`;
    }

    studentRows.forEach(row => {
        const quantityInput = row.querySelector('.quantity-input');
        quantityInput.addEventListener('input', () => {
            const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];
            const amount = parseFloat(selectedOption.dataset.amount);
            const quantityBased = selectedOption.dataset.quantityBased === '1';
            calculateTotal(row, amount, quantityBased);
        });
    });

    extraFeeSelect.addEventListener('change', updateUIBasedOnFee);

    // Run once at load (to prefill edit data)
    updateUIBasedOnFee();
});
</script>
