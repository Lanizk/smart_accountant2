@extends('layouts.app')
@section('main')
<form action="{{ route('extrafeeinsert') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Fee Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="term">Term:</label>
        <select id="term" name="term" class="form-control">
            <option value="Term 1">Term 1</option>
            <option value="Term 2">Term 2</option>
            <option value="Term 3">Term 3</option>
        </select>
    </div>

    <div class="form-group">
        <label for="fee_type">Fee Type:</label>
        <select id="fee_type" name="fee_type" class="form-control">
            <option value="fixed">Fixed</option>
            <option value="quantity_based">Quantity-Based</option>
        </select>
    </div>

    <!-- Unit Price Field (for quantity-based fees) -->
    <div class="form-group" id="unitPriceContainer" style="display: none;">
        <label for="unit_price">Rate per Unit (e.g., per km):</label>
        <input type="number" id="unit_price" name="unit_price" class="form-control" step="0.01">
    </div>

    <div class="form-group">
        <label for="studentSearch">Search Students:</label>
        <input type="text" id="studentSearch" class="form-control" placeholder="Search by name...">
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Student Name</th>
                <th>Quantity (if applicable e.g. Distance in KM)</th>
                <th>Total Fee</th>
            </tr>
        </thead>
        
    </table>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-success">Add Fee</button>
    </div>
</form>

<script>
    document.getElementById('fee_type').addEventListener('change', function() {
        let unitPriceContainer = document.getElementById('unitPriceContainer');
        let unitPriceInput = document.getElementById('unit_price');
        let isQuantityBased = this.value === 'quantity_based';

        unitPriceContainer.style.display = isQuantityBased ? 'block' : 'none';
        unitPriceInput.value = isQuantityBased ? unitPriceInput.value : ''; 
    });

    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let row = this.closest('tr');
            let quantityInput = row.querySelector('.quantity-input');
            let totalFeeInput = row.querySelector('.total-fee');

            if (this.checked) {
                quantityInput.removeAttribute('disabled');
            } else {
                quantityInput.setAttribute('disabled', 'true');
                quantityInput.value = '';
                totalFeeInput.value = '';
            }
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function() {
            let row = this.closest('tr');
            let totalFeeInput = row.querySelector('.total-fee');
            let unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
            let quantity = parseFloat(this.value) || 0;

            totalFeeInput.value = (quantity * unitPrice).toFixed(2);
        });
    });

    document.getElementById('studentSearch').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        document.querySelectorAll('#studentTable tr').forEach(row => {
            let studentName = row.children[1].textContent.toLowerCase();
            row.style.display = studentName.includes(searchValue) ? '' : 'none';
        });
    });
</script>
@endsection