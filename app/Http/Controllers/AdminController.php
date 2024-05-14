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
    $request->validate([
        'code' => 'required|unique:coupons,code|max:255',
        'type' => 'required|in:absolute,percent,magical',
        'discount_amount' => 'required|numeric',
    ]);

    Coupon::create([
        'code' => $request->input('code'),
        'type' => $request->input('type'),
        'discount_amount' => $request->input('discount_amount'),
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Coupon added successfully!');
}

}
