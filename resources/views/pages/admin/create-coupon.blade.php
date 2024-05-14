@extends('layouts.admin-master')
@section("content")
    <div class="container mt-5">
        <h1>Add Coupon</h1>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Code</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="absolute">Absolute</option>
                    <option value="percent">Percent</option>
                    <option value="magical">Magical</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="discount_amount" class="form-label">Discount Amount</label>
                <input type="number" step="0.01" class="form-control" id="discount_amount" name="discount_amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Coupon</button>
        </form>
    </div>
@endsection