@extends('layouts.admin-master')

@section("content")
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">Add Coupon</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Discount Amount</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->id }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->type }}</td>
                        <td>{{ $coupon->discount_amount }}</td>
                        <td>{{ $coupon->created_at }}</td>
                        <td>{{ $coupon->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection