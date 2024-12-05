<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('buyer')) {
            $product_transactions = $user->productTransactions()->orderBy('id', 'desc')->get();
        } else {
            $product_transactions = ProductTransaction::orderBy('id', 'desc')->get();
        }
        return view('admin.product_transactions.index', compact('product_transactions'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:20',
            'proof' => 'required|image|mimes:png,jpg,jpeg',
            'notes' => 'nullable|string',
            'post_code' => 'required|string|max:10',
            'phone_number' => 'required|string|max:15',
        ]);
        DB::beginTransaction();
        try {
            $subTotalCents = 0;
            $deliveryFeeCents = 1000 * 100;

            $cartItems = $user->carts();
            foreach ($cartItems as $cartItem) {
                $subTotalCents += $cartItem->product->price * 100;
            }
            $taxCount = (int) round(11 * $subTotalCents / 100);
            $insuranceCount = (int) round(23 * $subTotalCents / 100);
            $grandTotalCents = $subTotalCents + $deliveryFeeCents + $taxCount + $insuranceCount;

            $grandTotal = $grandTotalCents / 100;

            $validated['user_id'] = $user->id;
            $validated['total_amount'] = $grandTotal;
            $validated['is_paid'] = false;

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('payment_proofs', 'public');
                $validated['proof'] = $proofPath;
            }
            $newTransaction = ProductTransaction::create($validated);
            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'product_transaction_id' => $newTransaction->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                ]);
                $item->delete();
            }
            DB::commit();
            return redirect()->route('product_transactions.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ['System Error', $e->getMessage()],
            ]);
        }
    }

    public function show(ProductTransaction $productTransaction)
    {
        $productTransaction = ProductTransaction::with('transactionDetails.product')->find($productTransaction->id);
        return view('admin.product_transactions.details', compact('productTransaction'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, ProductTransaction $productTransaction)
    {
        $productTransaction->update([
            'is_paid' => !$productTransaction->is_paid,
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
    }
}
