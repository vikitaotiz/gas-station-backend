<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\Sales\SaleResource;
use App\Product;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();

        return SaleResource::collection($sales);
    }

    public function salesToday()
    {
        return Sale::whereDate('created_at', Carbon::today())->sum('amount');
    }

    public function salesTodayData()
    {
        $sales = Sale::whereDate('created_at', Carbon::today())->get();
        return $sales;
    }

    public function salesTodayCash()
    {
        return Sale::whereDate('created_at', Carbon::today())
            ->where('mode', 'Cash')
            ->sum('amount');
    }

    public function salesTodayMpesa()
    {
        return Sale::whereDate('created_at', Carbon::today())
            ->where('mode', 'Mpesa')
            ->sum('amount');
    }

    public function salesTodayCredit()
    {
        return Sale::whereDate('created_at', Carbon::today())
            ->where('mode', 'Credit')
            ->sum('amount');
    }

    public function salesProductCost()
    {
        $arr_sales = Sale::whereDate('created_at', Carbon::today())->get();

        $productsCost = 0;

        foreach ($arr_sales as $sale) {
            foreach ($sale->content as $item) {
                $productsCost += $item['buying_price'] * $item['quantity'];
            }
        }
        return $productsCost;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicateSale = Sale::whereDate('created_at', Carbon::today())
            ->where('receipt_no', $request->receipt_no)
            ->where('bill', $request->bill)
            ->where('mode', $request->mode)
            ->where('amount', $request->amount)
            ->first();

        if ($duplicateSale) {
            return response()->json(['error' => 'Sale record exists!']);
        } else {
            $sale = Sale::create([
                'bill' => $request->bill,
                'mode' => $request->mode,
                'amount' => $request->amount,
                'creditor_name' => $request->creditor_name,
                'receipt_no' => $request->receipt_no,
                'content' => $request->content,
                'user_id' => auth()->user()->id
            ]);

            foreach ($request->content as $product) {
                $prod = Product::where('title', $product['title'])->first();
                $prod->quantity = $prod->quantity - $product['quantity'];
                $prod->save();
            }

            Cart::find($request->cart_id)->delete();
            return new SaleResource($sale);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);

        return $sale;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        $this->validate($request, [
            'name' => 'required'
        ]);

        $sale->update([
            'name' => $request->name
        ]);

        return new SaleResource($sale);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);

        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully!']);
    }
}
