<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Products\ProductsResource;
use App\Http\Resources\Products\StockResource;
use App\Stock;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Product::latest()->get();
        return ProductsResource::collection($categories);
    }

    public function getStocks()
    {
        $stocks = Stock::whereDate('created_at', Carbon::today())->get();
        return StockResource::collection($stocks);
    }

    public function createStocks(Request $request)
    {
        $stock = Stock::whereDate('created_at', Carbon::today())
            ->where('product_id', $request->product_id)
            ->first();

        if ($stock) {
            return response()->json(['error' => 'Product stock already created!']);
        } else {
            $system_stock = Product::find($request->product_id)->quantity;
            $stock = Stock::create([
                'quantity' => $request->quantity,
                'system_stock' => $system_stock,
                'product_id' => $request->product_id,
                'user_id' => auth()->user()->id,
            ]);
            return $stock;
        }
    }

    public function removeStock($id)
    {
        $stock = Stock::find($id);
        $stock->delete();
        return response()->json(['message' => 'Stock deleted!']);
    }

    public function stocksDate(Request $request)
    {
        if ($request->secondDate) {
            $stocks = Stock::whereBetween('created_at', [$request->firstDate, $request->secondDate])->get();
        } else {
            $stocks = Stock::whereDate('created_at', $request->firstDate)->get();
        }
        return StockResource::collection($stocks);
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
            'min_qty' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'product_category_id' => 'required'
        ]);

        $category = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'min_qty' => $request->min_qty,
            'image_url' => $request->image_url,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'product_category_id' => $request->product_category_id,
            'user_id' => auth()->user()->id
        ]);

        return new ProductsResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Product::find($id);

        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'quantity' => 'required',
            'min_qty' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'product_category_id' => 'required'
        ]);

        $category = Product::find($id);

        $category->update([
            'title' => $request->title,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'min_qty' => $request->min_qty,
            'image_url' => $request->image_url,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'product_category_id' => $request->product_category_id,
            'user_id' => auth()->user()->id
        ]);

        return new ProductsResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Product::find($id);

        $category->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }
}
