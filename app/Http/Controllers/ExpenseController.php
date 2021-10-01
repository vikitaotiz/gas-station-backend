<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Resources\Expenses\ExpenseResource;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return ExpenseResource::collection($expenses);
    }

    public function expenses_today_data()
    {
        $expenses = Expense::whereDate('created_at', Carbon::today())->get();
        return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'quantity' => 'required',
            'buying_price' => 'required',
            'mode' => 'required',
            'expense_category_id' => 'required'
        ]);

        $expense = Expense::create([
            'title' => $request->title,
            'lender' => $request->lender,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'buying_price' => $request->buying_price,
            'mode' => $request->mode,
            'expense_category_id' => $request->expense_category_id,
            'user_id' => auth()->user()->id
        ]);

        return new ExpenseResource($expense);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $Expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);

        return $expense;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $Expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id);

        $this->validate($request, [
            'title' => 'required',
            'quantity' => 'required',
            'buying_price' => 'required',
            'mode' => 'required',
            'expense_category_id' => 'required'
        ]);

        $expense->update([
            'title' => $request->title,
            'lender' => $request->lender,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'buying_price' => $request->buying_price,
            'mode' => $request->mode,
            'expense_category_id' => $request->expense_category_id,
            'user_id' => auth()->user()->id
        ]);

        return new ExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $Expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);

        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully!']);
    }

    public function reportsData(Request $request)
    {
        if ($request->secondDate) {
            $expenses = Expense::whereBetween('created_at', [$request->firstDate, $request->secondDate])
                ->get();
            $sales = Sale::whereBetween('created_at', [$request->firstDate, $request->secondDate])
                ->get();
            $arr_sales = Sale::whereBetween('created_at', [$request->firstDate, $request->secondDate])
                ->get();
        } else {
            $expenses = Expense::whereDate('created_at', $request->firstDate)->get();
            $sales = Sale::whereDate('created_at', $request->firstDate)->get();
            $arr_sales = Sale::whereDate('created_at', $request->firstDate)->get();
        }

        $productsCost = 0;
        foreach ($arr_sales as $sale) {
            foreach ($sale->content as $item) {
                $productsCost += $item['buying_price'] * $item['quantity'];
            }
        }

        return array(
            'sales' => $sales,
            'expenses' => $expenses,
            'products_cost' => $productsCost
        );
    }
}
