<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create products
        $this->product = Product::factory()->create();

        // Create a cart and add items to it
        $this->cart = Cart::factory()->create();
        $this->cartItem = CartItem::factory()->create([
            'cart_id' => $this->cart->id,
            'product_id' => $this->product->id,
            'price' => $this->product->price,
        ]);

        // Create an active coupon
        $this->coupon = Coupon::factory()->create([
            'code' => 'DISCOUNT10',
            'type' => 'percent',
            'discount_amount' => 10,
            'status' => 'active',
        ]);

        // Set the cart ID in the session
        Session::put('cart_id', $this->cart->id);
    }

    public function test_cart_view_with_empty_cart()
    {
        Session::put('cart_id', 1);

        $response = $this->get(route('cart.get'));

        $response->assertRedirect(route('home'));
    }

    public function test_add_to_cart()
    {
        $product = Product::factory()->create();
        $this->post(route('cart.add'), ['product_id' => $product->id]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'price'      => $product->price,
        ]);

        $response = $this->post(route('cart.add'), ['product_id' => $product->id]);
        $response->assertRedirect(route('cart.get'));
    }

    public function test_remove_from_cart()
    {
        $cart = Cart::factory()->create();
        $cartItem = CartItem::factory()->create(['cart_id' => $cart->id]);

        $response = $this->post(route('cart.remove'), ['item' => $cartItem->id]);

        $response->assertRedirect(route('cart.get'));
        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    public function test_apply_coupon()
    {
        $cart = Cart::factory()->create();
        $coupon = Coupon::factory()->create(['status' => 'active']);

        Session::put('cart_id', $cart->id);

        $response = $this->post(route('cart.applyCoupon'), ['coupon_code' => $coupon->code]);

        $response->assertRedirect()->with('success', 'Coupon applied successfully.');
        $this->assertTrue(Session::has('coupon_id'));
    }

    public function test_apply_invalid_coupon()
    {
        $cart = Cart::factory()->create();

        Session::put('cart_id', $cart->id);

        $response = $this->post(route('cart.applyCoupon'), ['coupon_code' => 'INVALID']);

        $response->assertRedirect()->with('error', 'Invalid coupon code or the coupon is not active.');
    }

    public function test_save_cart()
    {
        $cart = Cart::factory()->create();
        $coupon = Coupon::factory()->create();
        Session::put('cart_id', $cart->id);
        Session::put('coupon_id', $coupon->id);
        Session::put('discounted_total', 100);

        $response = $this->post(route('cart.save'), [
            'cart_id'         => $cart->id,
            'coupon_id'       => $coupon->id,
            'discounted_total' => 100,
        ]);

        $response->assertRedirect(route('cart.get'))->with('success', 'Cart saved successfully.');

        $this->assertDatabaseHas('carts', [
            'id'        => $cart->id,
            'coupon_id' => $coupon->id,
            'total'     => 100,
        ]);

        $this->assertFalse(Session::has('cart_id'));
        $this->assertFalse(Session::has('coupon_id'));
        $this->assertFalse(Session::has('discounted_total'));
    }
}
