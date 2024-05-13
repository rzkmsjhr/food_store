@extends('layouts.master')

@section("content")
    <div class="row">
        <table class="mt-5 mb-5 product-table">
            <thead>
            <tr class="table-header">
                <th scope="col" class="product-number">No</th>
                <th scope="col" class="product-name">Product Name</th>
                <th scope="col" class="product-price">Price</th>
                <th scope="col" class="product-breed">Breed</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="product-table-body">
            @foreach($products as $key => $row)
                @if($loop->iteration % 2 == 0)
                    @php $class = 'even'; @endphp
                @else
                    @php $class = 'odd'; @endphp
                @endif

                <tr class="{{$class}}">
                <td>{{ $products->firstItem() + $key }}</td>
                <td><a name="{{$row['id']}}"></a><strong>{{$row['name']}}</strong></td>
                <td>${{$row['price']}}</td>
                <td>{{$row->breeds->name}}</td>
                <td class="add-to-cart-btn">
                    <x-add-to-cart price="{{$row['price']}}" href="{{$row['id']}}"/>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection
