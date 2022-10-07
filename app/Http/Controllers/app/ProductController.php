<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = Product::latest()->with('images')->get();
    return view("content.products.index", compact(['products']));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $category = Category::latest()->get();
    return view("content.products.create", compact(['category']));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = \Validator::make($request->all(), [ // <---
      'name' => 'required',
      'desc' => 'required',
      "price" => "required|numeric",
      "category_id" => "required|exists:categories,id",
    ]);
    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }
    $product = Product::create(['name' => $request->get('name'), "desc" => $request->get('desc'), "category_id" => $request->get('category_id'), "price" => $request->get('price')]);
    if ($request->hasFile("image")) {
      $imageName =    time() . '.' . $request->image->extension();
      $request->image->move(public_path('images'), $imageName);
      $product->images()->create(['url' => $imageName]);
    }
    return redirect(route('product-index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $product = Product::find($id)->first();

    $category = Category::latest()->get();
    return view("content.products.edit", compact(['product', 'category']));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    $validator = \Validator::make($request->all(), [ // <---
      'name' => 'required',
      'desc' => 'required',
      "price" => "required|numeric",
      "category_id" => "required|exists:categories,id",
    ]);

    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }
    $product = Product::find($id);
    if ($request->hasFile('image')) {
      $image = $product->images()->first();
      if ($image) {
        File::delete(public_path('images/') . $image->url);
        $product->images()->delete();
        $imageName =    time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $product->images()->create(['url' => $imageName]);
      }
    }
    $product->update([
      "name" => $request->get('name'),
      "desc" => $request->get('desc'),
    ]);
    return redirect(route('product-index', $product->id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product =  Product::find($id);
    $image = $product->images()->first();
    if ($image) {
      File::delete(public_path('images/') . $image->url);
    }
    $product->images()->delete();
    $product->delete();
    return redirect(route('product-index'));
  }
}
