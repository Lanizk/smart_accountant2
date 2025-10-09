@extends('layouts.app')
@section('main')

<div class="main-wrapper">
    {{-- Page Header --}}
    <div class="page_title">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">{{ isset($expense) ? 'Edit Expense' : 'Add Expense' }}</h4>
                <p class="text-muted mb-0 mt-1">{{ isset($expense) ? 'Update expense information' : 'Record a new expense transaction' }}</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary px-4 py-2">
                    <i class="fa fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px;">
            <div class="d-flex align-items-start">
                <i class="fa fa-exclamation-circle me-3 mt-1" style="font-size: 20px;"></i>
                <div class="flex-grow-1">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="row">
        <div class="col-12">
            <div class="white_shd full margin_bottom_30" style="border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #f0f0f0;">
                <div class="full graph_head" style="background: linear-gradient(135deg, {{ isset($expense) ? '#36a9e2 0%, #1e88c7' : '#ff4748 0%, #e63946' }} 100%); padding: 25px 30px; border-radius: 12px 12px 0 0;">
                    <div class="heading1 margin_0">
                        <h2 style="font-size: 20px; color: #fff; font-weight: 600; margin: 0; display: flex; align-items: center;">
                            <i class="fa fa-{{ isset($expense) ? 'edit' : 'shopping-cart' }} me-3" style="font-size: 24px;"></i>
                            Expense Details
                        </h2>
                        <p class="mb-0 mt-2" style="color: rgba(255,255,255,0.9); font-size: 14px;">Fill in the details below to {{ isset($expense) ? 'update' : 'record' }} the expense</p>
                    </div>
                </div>

                <div class="full inner_elements" style="padding: 35px 30px;">
                    <form action="{{ isset($expense) ? route('expenses.update', $expense->id) : route('expenses.store') }}" method="POST">
                        @csrf
                        @if(isset($expense))
                            @method('PUT')
                        @endif

                        {{-- Expense Information Section --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-4" style="color: #2c3e50; font-weight: 600; font-size: 16px; display: flex; align-items: center; padding-bottom: 12px; border-bottom: 2px solid #e8eaed;">
                                <i class="fa fa-info-circle me-2" style="color: #ff4748;"></i>
                                Expense Information
                            </h5>

                            <div class="row">
                                {{-- Category --}}
                                <div class="col-md-6 mb-4">
                                    <label for="expense_category_id" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-tag me-2 text-danger"></i>Category <span class="text-danger">*</span>
                                    </label>
                                    <select name="expense_category_id" 
                                            id="expense_category_id" 
                                            class="form-select @error('expense_category_id') is-invalid @enderror" 
                                            style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                            required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ (isset($expense) && $expense->expense_category_id == $cat->id) || old('expense_category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('expense_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Amount --}}
                                <div class="col-md-6 mb-4">
                                    <label for="amount" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-coins me-2 text-danger"></i>Amount (KSh) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group" style="border-radius: 8px;">
                                        <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-money-bill-wave text-danger"></i>
                                        </span>
                                        <input type="number" 
                                               id="amount" 
                                               name="amount" 
                                               class="form-control @error('amount') is-invalid @enderror" 
                                               value="{{ $expense->amount ?? old('amount') }}" 
                                               step="0.01"
                                               min="0"
                                               placeholder="Enter amount"
                                               style="border-radius: 0 8px 8px 0; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                               required>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-md-12 mb-4">
                                    <label for="description" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-file-alt me-2 text-primary"></i>Description
                                    </label>
                                    <textarea id="description" 
                                              name="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="3"
                                              placeholder="Enter expense description"
                                              style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;">{{ $expense->description ?? old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Payment Details Section --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-4" style="color: #2c3e50; font-weight: 600; font-size: 16px; display: flex; align-items: center; padding-bottom: 12px; border-bottom: 2px solid #e8eaed;">
                                <i class="fa fa-credit-card me-2" style="color: #ff4748;"></i>
                                Payment Details
                            </h5>

                            <div class="row">
                                {{-- Payment Method --}}
                                <div class="col-md-6 mb-4">
                                    <label for="payment_method" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-wallet me-2 text-info"></i>Payment Method <span class="text-danger">*</span>
                                    </label>
                                    <select name="payment_method" 
                                            id="payment_method" 
                                            class="form-select @error('payment_method') is-invalid @enderror" 
                                            style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                            required>
                                        <option value="">-- Select Method --</option>
                                        <option value="cash" {{ (isset($expense) && $expense->payment_method=='cash') || old('payment_method')=='cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="mpesa" {{ (isset($expense) && $expense->payment_method=='mpesa') || old('payment_method')=='mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                        <option value="bank" {{ (isset($expense) && $expense->payment_method=='bank') || old('payment_method')=='bank' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cheque" {{ (isset($expense) && $expense->payment_method=='cheque') || old('payment_method')=='cheque' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Expense Date --}}
                                <div class="col-md-6 mb-4">
                                    <label for="expense_date" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-calendar me-2 text-warning"></i>Expense Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           id="expense_date" 
                                           name="expense_date" 
                                           class="form-control @error('expense_date') is-invalid @enderror" 
                                           value="{{ optional($expense)->expense_date?->format('Y-m-d') ?? old('expense_date', date('Y-m-d')) }}"
                                           style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                           required>
                                    @error('expense_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Term Information Section --}}
                        <div class="form-section mb-4">
                            <h5 class="section-title mb-4" style="color: #2c3e50; font-weight: 600; font-size: 16px; display: flex; align-items: center; padding-bottom: 12px; border-bottom: 2px solid #e8eaed;">
                                <i class="fa fa-calendar-alt me-2" style="color: #ff4748;"></i>
                                Academic Period
                            </h5>

                            <div class="row">
                                {{-- Term --}}
                                <div class="col-md-12 mb-4">
                                    <label for="term_id" class="form-label fw-semibold" style="font-size: 14px; color: #495057; margin-bottom: 10px;">
                                        <i class="fa fa-bookmark me-2 text-primary"></i>Term <span class="text-danger">*</span>
                                    </label>
                                    <select name="term_id" 
                                            id="term_id" 
                                            class="form-select @error('term_id') is-invalid @enderror" 
                                            style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 12px 16px; font-size: 14px;"
                                            required>
                                        <option value="">-- Select Term --</option>
                                        @foreach($terms as $term)
                                            <option value="{{ $term->id }}"
                                                {{ (isset($expense) && $expense->term_id == $term->id) || old('term_id') == $term->id ? 'selected' : '' }}>
                                                {{ $term->name }} ({{ $term->year }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('term_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="form-actions mt-5 pt-4" style="border-top: 1px solid #e8eaed;">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-{{ isset($expense) ? 'primary' : 'danger' }} px-5 py-3 me-3" style="border-radius: 8px; font-weight: 600; font-size: 15px; min-width: 180px;">
                                        <i class="fa fa-{{ isset($expense) ? 'check-circle' : 'save' }} me-2"></i>{{ isset($expense) ? 'Update Expense' : 'Save Expense' }}
                                    </button>
                                    <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary px-5 py-3" style="border-radius: 8px; font-weight: 600; font-size: 15px; min-width: 180px;">
                                        <i class="fa fa-times-circle me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Control Focus Effects */
.form-control:focus,
.form-select:focus {
    border-color: #ff4748;
    box-shadow: 0 0 0 0.2rem rgba(255, 71, 72, 0.15);
}

/* Invalid Feedback Styling */
.invalid-feedback {
    font-size: 13px;
    margin-top: 6px;
}

.is-invalid {
    border-color: #dc3545 !important;
}

/* Input Group Styling */
.input-group-text {
    background: #f8f9fa;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}

.input-group:focus-within .input-group-text {
    border-color: #ff4748;
}

.input-group:focus-within .form-control {
    border-color: #ff4748;
}

/* Button Styles */
.btn-primary {
    background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(54, 169, 226, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #ff4748 0%, #e63946 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 71, 72, 0.3);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #6c757d;
    border: none;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

/* Form Section Styling */
.form-section {
    background: #fafbfc;
    padding: 25px;
    border-radius: 10px;
    border: 1px solid #f0f0f0;
}

/* Placeholder Styling */
.form-control::placeholder,
.form-select::placeholder {
    color: #b0b8c3;
    font-size: 14px;
}

/* Alert Styling */
.alert {
    border-radius: 8px;
}

.alert ul {
    margin-bottom: 0;
}

.alert li {
    margin-bottom: 4px;
}

.alert li:last-child {
    margin-bottom: 0;
}

/* Textarea Styling */
textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

/* Date Input Styling */
input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .full.inner_elements {
        padding: 25px 20px !important;
    }

    .form-section {
        padding: 20px 15px;
    }

    .btn-primary,
    .btn-danger,
    .btn-outline-secondary {
        min-width: 140px !important;
        padding: 12px 20px !important;
        font-size: 14px !important;
    }

    .section-title {
        font-size: 15px !important;
    }

    .full.graph_head {
        padding: 20px 20px !important;
    }

    .full.graph_head h2 {
        font-size: 18px !important;
    }

    .full.graph_head p {
        font-size: 13px !important;
    }
}

@media (max-width: 576px) {
    .btn-primary,
    .btn-danger,
    .btn-outline-secondary {
        width: 100%;
        margin-bottom: 10px;
    }

    .btn-primary,
    .btn-danger {
        margin-right: 0 !important;
    }
}
</style>

@endsection