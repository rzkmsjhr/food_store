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
                            <input class="remove-item" type="submit" value="Remove" title="Remove test from the cart"/>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row m-0 justify-content-end">
                <div class="cart-table-total">
                    <div class="total">
                        <span>Total:</span> <span class="price-wrapper">${{$item->total}}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
