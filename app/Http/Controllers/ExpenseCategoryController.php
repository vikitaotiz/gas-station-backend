<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Http\Resources\Expenses\ExpenseCategoryResource;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = ExpenseCategory::latest()->get();

        return ExpenseCategoryResource::collection($payments);
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
            'title' => 'required'
        ]);

        $payment = ExpenseCategory::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new ExpenseCategoryResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $ExpenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = ExpenseCategory::find($id);

        $this->validate($request, [
            'title' => 'required'
        ]);

        $payment->update([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new ExpenseCategoryResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $ExpenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = ExpenseCategory::find($id);

        $payment->delete();

        return response()->json(['message' => 'ExpenseCategory deleted successfully!']);
    }
}
