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
            $product = Product::where('id', $request->product_id)->first();
        } catch (ModelNotFoundException $e) {
            Log::info('error 1');
            abort(404);
        }

        if ($cartId = Session::get('cart_id')) {
            $cartExists = Cart::where('id', $cartId)->exists();
            if (!$cartExists) {
                Session::forget('cart_id');

                if (!($cartId = Session::get('cart_id'))) {

                    $cart = Cart::create([
                        'created_at' => Carbon::now()->toIso8601String(),
                    ], ['id']);
                    $cartId = $cart->id;

                    Session::put('cart_id', $cartId);
                }
            }
        } else {
            $cart = Cart::create([
                'created_at' => Carbon::now()->toIso8601String(),
            ], ['id']);
            $cartId = $cart->id;

            Session::put('cart_id', $cartId);
        }


        $cart = Cart::where('id', $cartId)->get()->first();

        if (CartItem::where('cart_id', $cartId)->where('product_id', $product->id)->exists()) {
            Log::info('product is already in cart');

            return redirect(route('cart.get'));
        }

        try {
            $cartUpdated = CartItem::insert([
                'cart_id'    => $cartId,
                'product_id' => $product->id,
                'price'      => $product->price,
            ]);

            if ($cartUpdated) {
                if ($cart instanceof Cart) {

                    $items = $cart->cartItems->map(fn(CartItem $cartItem) => [
                        'id'    => $cartItem->product->id,
                        'name'  => $cartItem->product->name,
                        'price' => $cartItem->product->price,
                    ]);

                    $total = null;
                    foreach ($items as $item) {
                        $total += $item['price'];
                    }
                    $cart->update(['total' => $total]);
                }
            }

        } catch (\Throwable $e) {
            Log::info('error ----2');
        }


        return redirect(route('cart.get'));
    }

    public function removeFromCart(Request $request)
    {
        $cartItem = CartItem::with('cart')->where('id', $request->item)->first();
        $cartItem->delete();

        return redirect(route('cart.get'));
    }

}
