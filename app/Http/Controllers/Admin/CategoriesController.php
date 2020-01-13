<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    public function index(){
        $categories=Category::all();
        return view('admin.categories.index', ['categories'=>$categories]);
    }
    public function create(){
        return view('admin.categories.create');
    }
    public function store(Request $request){
        // $category=new Category;
        // $category->title=$request->title;
        // $category->save();
        $this->validate($request, [
            'title'=>'required'
            ]);
        Category::create($request->all());
        return redirect()->action('Admin\CategoriesController@index');
    }
    public function edit($id)
    {
       $category= Category::find($id);
       return view('admin.categories.edit', ['category'=>$category]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'required'
            ]);
        // $category=Category::find($id)->first();
        // $category->title=$request->title;
        // $category->save();
        $category=Category::find($id);
        $category->update($request->all());
        // $category->save();
        return redirect()->route('categories.index');
    }
    public function destroy($id)
    {
        Category::find($id)->delete();
        return Redirect::back()->with('message','Operation Successful !');
    }
    
}
