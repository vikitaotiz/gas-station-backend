<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Cart;
use App\Http\Resources\Bills\BillResource;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill_ids = Cart::where('hold', 1)->pluck('bill_id');

        $bills = Bill::whereNotIn('id', $bill_ids)->get();

        return BillResource::collection($bills);
    }

    public function carts()
    {
        $carts = Cart::latest()->where('hold', 0)->with('user')->get();
        return $carts;
    }

    public function cartsOnhold()
    {
        $carts = Cart::latest()->where('hold', 1)->get();
        return $carts;
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
            'name' => 'required'
        ]);

        $bill = Bill::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return new BillResource($bill);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $Bill
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::find($id);

        return $bill;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $Bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = Bill::find($id);

        $this->validate($request, [
            'name' => 'required'
        ]);

        $bill->update([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return new BillResource($bill);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $Bill
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = Bill::find($id);

        $bill->delete();

        return response()->json(['message' => 'Bill deleted successfully!']);
    }

    public function billCart(Request $request)
    {
        $cart = Cart::where('bill', $request->bill)
            ->where('bill_id', $request->bill_id)
            ->first();

        if ($cart) {
            $arr = $cart->content;
            array_push($arr, $request->content[0]);
            $cart->update([
                'content' => $arr
            ]);
        } else {
            $randNum = 'LBR#' . strval(rand(1000, 100000));
            Cart::create([
                'bill' => $request->bill,
                'receipt_no' => $randNum,
                'bill_id' => $request->bill_id,
                'hold' => $request->hold,
                'amount' => $request->amount,
                'content' => $request->content,
                'user_id' => auth()->user()->id
            ]);
        }

        return response()->json(['message' => 'Product added successfully!']);
    }

    public function changeProductQty(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->update([
            'content' => $request->newArray
        ]);

        return $cart;
    }

    public function deleteSingleProduct(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->update([
            'content' => $request->newArray
        ]);

        return $cart;
    }

    public function deleteSingleBill(Request $request)
    {
        $cart = Cart::find($request->id)->delete();
        return response()->json(['message' => 'Bill deleted successfully!']);
    }

    public function clearAllBills()
    {
        $bill_ids = Cart::where('hold', 0)->get();

        foreach ($bill_ids as $bill) {
            Cart::find($bill->id)->delete();
        }
    }

    public function putBillOnhold(Request $request)
    {
        $cart = Cart::find($request->id)->update(['hold' => 1]);
        return $cart;
    }

    public function removeBillOnhold(Request $request)
    {
        $cart = Cart::find($request->id)->update(['hold' => 0]);
        return $cart;
    }
}
