<?php

namespace App\Http\Controllers\admin_panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryVerifyRequest;
use App\Http\Requests\CategoryEditVerifyRequest;

use Illuminate\Support\Facades\DB;
use App\Category;


class categoriesController extends Controller
{
    public function index()
    {
        $result = Category::all();

    	return view('admin_panel.categories.index')
    		->with('catlist', $result);
        
    }
    
    public function posted( CategoryVerifyRequest $request)
    {
        $cat = new Category();
        $cat->name = $request->Name;
        $cat->type = $request->Type;
        $cat->save();
        return redirect()->route('admin.categories');
    }
    
    public function edit($id)
    {
        

        $cat = Category::find($id);
        
        return view('admin_panel.categories.edit')
            ->with('category', $cat);
    }

    public function update(CategoryEditVerifyRequest $request, $id)
    {
      
        $catToUpdate = Category::find($request->id);
        $catToUpdate->name = $request->Name;
        $catToUpdate->type = $request->Type;
        $catToUpdate->save();
        
        return redirect()->route('admin.categories');
    }
    
    public function delete($id)
    {
       
        $cat = Category::find($id);

        return view('admin_panel.categories.delete')
            ->with('category', $cat);
    }

    public function destroy(Request $request)
    {
        

        $catToDelete = Category::find($request->id);
        $catToDelete->delete();

        

        return redirect()->route('admin.categories');
    }
}
