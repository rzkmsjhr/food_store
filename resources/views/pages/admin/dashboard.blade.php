@extends('layouts.admin-master')

@section("content")
<div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">Add Coupon</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline; float:right;">
        @csrf
        <button type="submit" class="btn btn-secondary mb-3">Logout</button>
    </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Discount Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->type }}</td>
                        <td>{{ $coupon->discount_amount }}</td>
                        <td>{{ $coupon->status }}</td>
                        <td>
                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection