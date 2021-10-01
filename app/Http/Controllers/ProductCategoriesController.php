<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Resources\Products\ProductCategories;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductCategory::latest()->get();

        return ProductCategories::collection($categories);
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

        $category = ProductCategory::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new ProductCategories($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ProductCategory::find($id);

        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::find($id);

        $this->validate($request, [
            'title' => 'required'
        ]);

        $category->update([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new ProductCategories($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::find($id);

        $category->delete();

        return response()->json(['message' => 'ProductCategory deleted successfully!']);
    }
}
