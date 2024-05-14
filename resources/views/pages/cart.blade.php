@extends('layouts.master')

@section("content")
    <div class="cart-content">
        <div class="row d-none d-md-block mt-md-4">
            <div class="col-12 ">
                <h1>Your cart</h1>
            </div>
        </div>

        <div class="cart-table">
            <div class="row cart-table-heading d-none d-md-flex">
                <div class="col-8 pe-0 ps-0">
                    Product Name
                </div>
                <div class="col-2">
                    Price
                </div>
            </div>
            @foreach($cart_items as $item)
                <div class="row cart-table-body">
                    <div class="col-8 pe-0 ps-0 cart-item-name">
                       {{$item->name}}
                    </div>
                    <div class="col-4">
                        <div class="text-start d-md-inline-block">
                            ${{$item->price}}
                        </div>
                        <div class="text-start float-md-end">
                            <form method="post" action="{{route('cart.delete')}}">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{$item->ci_id}}" name="item">
                                <input class="remove-item" type="submit" value="Remove" title="Remove item from the cart"/>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row m-0 justify-content-end">
                <div class="cart-table-total">
                    <div class="total">
                        <span>Price:</span> <span class="price-wrapper">${{$cart_total}}</span><br>
                        <span>Discounted Price:</span> <span class="discounted-price-wrapper">${{ session('discounted_total', $cart_total) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-10 col-9">
                <form method="post" action="{{route('cart.applyCoupon')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter coupon code" name="coupon_code">
                        <button class="btn btn-primary" type="submit">Apply Coupon</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2 col-3">
                <form method="post" action="{{route('cart.save')}}">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ Session::get('cart_id') }}">
                <input type="hidden" name="coupon_id" value="{{ session('coupon_id') }}">
                <input type="hidden" name="discounted_total" value="{{ session('discounted_total', $cart_total) }}">
                    <button class="btn btn-primary" type="submit">Save Cart</button>
                </form>
            </div>
        </div>
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
