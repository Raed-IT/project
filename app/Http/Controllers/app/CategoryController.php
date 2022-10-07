<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use function PHPSTORM_META\map;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $category = Category::latest()->with('images')->get();
    return view("content.category.index", compact(['category']));
  }
  public function edit($id)
  {
    $category = Category::find($id)->first();

    return view("content.category.edit", compact(['category']));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {

    return view("content.category.create");
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
      'name' => 'required|unique:categories|max:255',
      'desc' => 'required',
    ]);
    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }
    $category = Category::create(['name' => $request->get('name'), "desc" => $request->get('desc')]);
    if ($request->hasFile("image")) {
      $imageName =    time() . '.' . $request->image->extension();
      $request->image->move(public_path('images'), $imageName);
      $category->images()->create(['url' => $imageName]);
    }
    return redirect(route('category-index'));
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
    ]);

    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }
    $category = Category::find($id);
    if ($request->hasFile('image')) {
      $image = $category->images()->first();
      if ($image) {
        File::delete(public_path('images/') . $image->url);
        $category->images()->delete();
        $imageName =    time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $category->images()->create(['url' => $imageName]);
      }
    }
    $category->update([
      "name" => $request->get('name'),
      "desc" => $request->get('desc'),
    ]);
    return redirect(route('category-edit', $category->id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $category =  Category::find($id);
    $image = $category->images()->first();
    if ($image) {
      File::delete(public_path('images/') . $image->url);
    }
    $category->images()->delete();
    $category->delete();
    return redirect(route('category-index'));
  }
}
