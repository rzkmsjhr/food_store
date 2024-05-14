<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/secret/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        $coupons = Coupon::all();
        return view('pages.admin.dashboard', compact('coupons'));
    }

    public function createCoupon()
    {
        // Handle the creation of a new coupon
        return view('pages.admin.create-coupon');
    }

    public function storeCoupon(Request $request)
{
    $data = $request->validate([
        'code' => 'required|string|max:255|unique:coupons,code',
        'type' => 'required|string',
        'discount_amount' => 'nullable|numeric',
        'status' => 'required|in:active,inactive',
    ]);

    if ($data['type'] === 'magical') {
        $data['discount_amount'] = null;
    }

    Coupon::create($data);

    return redirect()->route('admin.dashboard')->with('success', 'Coupon added successfully!');
}

public function editCoupon($id)
{
    $coupon = Coupon::findOrFail($id);
    return view('pages.admin.edit-coupon', compact('coupon'));
}

    public function updateCoupon(Request $request, $id)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'type' => 'required|string',
            'discount_amount' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        if ($data['type'] === 'magical') {
            $data['discount_amount'] = null;
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Coupon updated successfully.');
    }

public function destroyCoupon($id)
{
    $coupon = Coupon::findOrFail($id);
    $coupon->delete();

    return redirect()->route('admin.dashboard')->with('success', 'Coupon deleted successfully!');
}

public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

}
