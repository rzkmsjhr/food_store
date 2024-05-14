<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\Hash;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function testShowLoginForm()
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.admin.login');
    }

    public function testLoginWithValidCredentials()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/secret/admin/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email' => 'Invalid credentials']);
        $this->assertGuest();
    }

    public function testDashboardView()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.admin.dashboard');
    }

    public function testCreateCouponView()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.coupons.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.admin.create-coupon');
    }

    public function testStoreCoupon()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.coupons.store'), [
            'code' => 'NEWCOUPON',
            'type' => 'percent',
            'discount_amount' => 20,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Coupon added successfully!');
        $this->assertDatabaseHas('coupons', [
            'code' => 'NEWCOUPON',
            'type' => 'percent',
            'discount_amount' => 20,
            'status' => 'active',
        ]);
    }

    public function testEditCouponView()
    {
        $this->actingAs($this->admin);

        $coupon = Coupon::factory()->create();

        $response = $this->get(route('admin.coupons.edit', $coupon->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.admin.edit-coupon');
    }

    public function testUpdateCoupon()
    {
        $this->actingAs($this->admin);

        $coupon = Coupon::factory()->create([
            'code' => 'OLDCOUPON',
        ]);

        $response = $this->put(route('admin.coupons.update', $coupon->id), [
            'code' => 'UPDATEDCOUPON',
            'type' => 'absolute',
            'discount_amount' => 50,
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Coupon updated successfully!');
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'code' => 'UPDATEDCOUPON',
            'type' => 'absolute',
            'discount_amount' => 50,
            'status' => 'inactive',
        ]);
    }

    public function testDestroyCoupon()
    {
        $this->actingAs($this->admin);

        $coupon = Coupon::factory()->create();

        $response = $this->delete(route('admin.coupons.destroy', $coupon->id));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Coupon deleted successfully!');
        $this->assertDatabaseMissing('coupons', [
            'id' => $coupon->id,
        ]);
    }
}
