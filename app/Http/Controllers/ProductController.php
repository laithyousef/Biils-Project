<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $products = new Product;
        $request->validate([
            'product_name' => "required|max:50|min:1",
            'section_id' => 'required|integer',
            'description' => 'required',
        ]);

        $products->product_name = $request->product_name;
        $products->description = $request->description;
        $products->section_id = $request->section_id;
        $products->save();

        session()->flash('add');
        return redirect('products');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'Product_name' => "required|max:50|min:1",
            'pro_id' => 'required|integer',
            'description' => 'required',
        ]);
        $products = Product::findOrFail($request->pro_id);
        $id = Section::where('section_name' , '=' , $request->section_name)->first()->id;

        $products->update([
            'product_name' => $request->Product_name,
            'section_id' => $id,
            'description' => $request->description
        ]);

            session()->flash('update');
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->pro_id;
        $products = Product::findOrFail($id)->delete();

        session()->flash('delete');
        return back();

    }
}
