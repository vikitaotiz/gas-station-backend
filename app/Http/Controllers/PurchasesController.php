<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategory;
use App\Http\Resources\Expenses\PurchaseResource;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function expensesToday()
    {
        return Expense::whereDate('created_at', Carbon::today())->sum('buying_price');
    }

    public function purchasesToday()
    {
        return Expense::whereDate('created_at', Carbon::today())
            ->where('expense_category_id', 1)
            ->sum('buying_price');
    }

    public function purchases()
    {

        $expenses = Expense::where('expense_category_id', 1)
            ->whereDate('created_at', Carbon::today()->toDateString())
            ->get();

        return PurchaseResource::collection($expenses);
    }

    public function savePurchase(Request $request)
    {
        $expense_category = ExpenseCategory::where('title', 'PURCHASES')->first();
        $product = Product::find($request->product_id);
        $newQty = $product->quantity + $request->quantity;
        $product->update([
            'quantity' => $newQty
        ]);

        $newTotalAmount = $product->buying_price * $request->quantity;

        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required',
            'mode' => 'required',
        ]);

        Expense::create([
            'title' => $product->title,
            'lender' => $request->lender,
            'description' => $product->title,
            'quantity' => $request->quantity,
            'buying_price' => $newTotalAmount,
            'mode' => $request->mode,
            'expense_category_id' => $expense_category->id,
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['message' => 'Purchase made successfully!']);
    }
}
