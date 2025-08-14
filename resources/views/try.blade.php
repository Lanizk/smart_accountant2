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
        $assigned = $assignedExtraFees->get($student->id);
        $isSelected = !is_null($assigned);
        $quantity = $isSelected ? $assigned->quantity : 1;
        $total = $isSelected ? $assigned->amount : 0;
    @endphp
    <tr>
        <td>
            <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
            <input type="checkbox" class="student-checkbox"
                   name="students[{{ $student->id }}][selected]"
                   value="1"
                   {{ $isSelected ? 'checked' : '' }}>
        </td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->admission }}</td>
        <td>{{ $student->class->name }}</td>
        <td class="quantity-col">
            <input type="number" class="form-control quantity-input"
                   name="students[{{ $student->id }}][quantity]"
                   min="1"
                   value="{{ $quantity }}"
                   {{ !$isSelected ? 'disabled' : '' }}>
        </td>
        <td class="total-col">
            <span class="student-total">
                KES {{ number_format($total, 2) }}
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































@extends('layouts.app')

@section('main')
<div class="row column_title">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="d-flex justify-content-end align-items-center py-3 px-4 white_shd border rounded mb-3 mt-3">
                <a href="#" class="btn btn-success px-4 py-2 fw-bold">+ Add New</a> {{-- Optional button --}}
            </div>
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
                <form action="{{ route('assignextrafee') }}" method="POST">
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
                                        data-description="{{ $fee->description }}">
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
                                    <tr data-class="{{ $student->class_id }}" class="student-row">
                                          <td>
                                             
                                             <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">

                                                    <input type="checkbox" 
                                                    class="student-checkbox" 
                                                    name="students[{{ $student->id }}][selected]" 
                                                    value="1">
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
                                                   disabled>
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
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Assign Fees</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection




<script>
document.addEventListener('DOMContentLoaded', function () {
    const extraFeeSelect = document.getElementById('extra_fee_id'); // ✅ Correct ID
    const descriptionElement = document.getElementById('fee_description');
    const studentRows = document.querySelectorAll('.student-row'); // ✅ Ensure this class exists
    const studentTableWrapper = document.getElementById('student_table_wrapper'); // ✅ Wrapper for hiding/showing

    function updateUIBasedOnFee() {
        const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];

        // Show table only if a fee is selected
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

        // Show fee description
        descriptionElement.textContent = description || "No description.";

        // Toggle quantity column visibility
        document.querySelectorAll('.quantity-col').forEach(cell => {
            cell.style.display = quantityBased ? 'table-cell' : 'none';
        });

        // Update each row
        studentRows.forEach(row => {
            const checkbox = row.querySelector('.student-checkbox');
            const quantityInput = row.querySelector('.quantity-input');
            const totalField = row.querySelector('.student-total');

            if (quantityBased) {
                quantityInput.disabled = false;
                quantityInput.value = ''; // Let user enter
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

    // Attach quantity listeners
    studentRows.forEach(row => {
        const quantityInput = row.querySelector('.quantity-input');
        quantityInput.addEventListener('input', () => {
            const selectedOption = extraFeeSelect.options[extraFeeSelect.selectedIndex];
            const amount = parseFloat(selectedOption.dataset.amount);
            const quantityBased = selectedOption.dataset.quantityBased === '1';
            calculateTotal(row, amount, quantityBased);
        });
    });

    // Listen for extra fee change
    extraFeeSelect.addEventListener('change', updateUIBasedOnFee);

    // Initial state
    updateUIBasedOnFee();



});
</script>