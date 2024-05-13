@props(['price' => '','href'=>'#'])

<form action="{{route('cart.add')}}" method="post">
    @method('put')
    @csrf
    <input name="product_id" id="productid" value="{{$href}}" type="hidden">
    <button class="d-flex align-items-center w-auto tbl-btn info-btn text"
            data-event-cat="Add to cart"
            data-event-act="{{request()->path()}}"
            data-event-lab="{{$href}}"
            data-event-store="true">Add to cart</button>
</form>
