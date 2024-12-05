<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
