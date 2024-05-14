@extends('layouts.admin-master')
@section("content")
    <div class="container mt-5">
        <h1>Edit Coupon</h1>
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="code" class="form-label">Code</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required onchange="toggleDiscountAmount()">
                    <option value="absolute" {{ $coupon->type == 'absolute' ? 'selected' : '' }}>Absolute</option>
                    <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percent</option>
                    <option value="magical" {{ $coupon->type == 'magical' ? 'selected' : '' }}>Magical</option>
                </select>
            </div>
            <div class="mb-3" id="discountAmountDiv">
                <label for="discount_amount" class="form-label">Discount Amount</label>
                <input type="number" step="0.01" class="form-control" id="discount_amount" name="discount_amount" value="{{ $coupon->discount_amount }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" {{ $coupon->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $coupon->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Coupon</button>
        </form>
    </div>
@endsection
