<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        if (!$cartId = Session::get('cart_id')) {
            return redirect()->route('home');
        }

        $cart = Cart::find($cartId);

        $cart_items = CartItem::where('cart_id', $cart->id)
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
            ->join('products as p', 'cart_items.product_id', '=', 'p.id')
            ->get(['carts.*', 'p.id as p_id', 'p.*', 'cart_items.*', 'cart_items.id as ci_id']);

        if ($cart_items->isEmpty()) {

            return redirect()->route('home');
        }

        $total = $cart_items->sum('price'); // Calculate total price

        $productsInTheCart = [
            'cart_items' => $cart_items,
            'cart_total' => $cart_items[0]->total,
            'cart_id'    => $cart->id,
        ];

        if (empty($productsInTheCart)) {
            return redirect(route('home'));
        }

        return view('pages.cart', $productsInTheCart);
    }

    public function addToCart(Request $request)
{
    Cart::find(Session::get('cart_id'));

    if (!$request->product_id) {
        return redirect(route('home'));
    }

    try {
        $product = Product::findOrFail($request->product_id);
    } catch (ModelNotFoundException $e) {
        Log::info('Product not found');
        abort(404);
    }

    // Check if there's an existing cart
    $cartId = Session::get('cart_id');
    if (!$cartId) {
        $cart = Cart::create([
            'created_at' => Carbon::now()->toIso8601String(),
        ]);
        $cartId = $cart->id;
        Session::put('cart_id', $cartId);
    } else {
        $cart = Cart::findOrFail($cartId);
    }

    // Check if the cart already has items with a different breed
    $existingBreed = $cart->cartItems()->whereHas('product', function ($query) use ($product) {
        $query->where('breed_id', '!=', $product->breed_id);
    })->exists();

    if ($existingBreed) {
        return back()->with('error', 'You cannot add products with different breeds to the same cart.');
    }

    // Add the product to the cart
    $cartItem = CartItem::create([
        'cart_id'    => $cartId,
        'product_id' => $product->id,
        'price'      => $product->price,
    ]);

    // Update cart total
    $cart->update(['total' => $cart->cartItems->sum('price')]);

    return redirect(route('cart.get'));
}


    public function removeFromCart(Request $request)
    {
        $cartItem = CartItem::with('cart')->where('id', $request->item)->first();
        $cartItem->delete();

        return redirect(route('cart.get'));
    }

}
