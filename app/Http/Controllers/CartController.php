<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store($productId)
    {
        $user = Auth::user();
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();
        if ($existingCartItem) {
            return redirect()->route('carts.index');
        }
        DB::beginTransaction();
        try {
            $cart = Cart::updateOrCreate([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $cart->save();
            DB::commit();
            return redirect()->route('carts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ['System Error', $e->getMessage()],
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
