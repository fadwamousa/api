<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Category;
class CategoryController extends ApiController
{

    public function index()
    {
        //

        $categories = Category::all();
        return $this->showAll($categories);
    }


    public function store(Request $request)
    {
        //
        $rules = [
          'name'  => 'required',
          'description'  => 'required'
        ];

        $this->validate($request,$rules);

        $category = Category::create($request->all());

        return $this->showOne($category);



    }


    public function show(Category $category)
    {
        //

        //$category= Category::findOrFail($id);
        return $this->showOne($category);
    }


    public function update(Request $request, Category $category)
    {

      $category->fill($request->only(['name','description']));

      if(!$category->isDirty()){
        return $this->errorResponse('you need to add some change in your data',422);
      }

      $category->save();
      return $this->showOne($category);



    }


    public function destroy(Category $category)
    {
        //

        //$category= Category::findOrFail($id);
        $category->delete();
        return $this->showOne($category);
    }
}
