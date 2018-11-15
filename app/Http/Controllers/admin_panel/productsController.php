<?php

namespace App\Http\Controllers\admin_panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVerifyRequest;
use App\Http\Requests\ProductEditVerifyRequest;

use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;


class productsController extends Controller
{
   public function index()
    {
        $result = Product::all();

    	return view('admin_panel.products.index')
    		->with('prdlist', $result);
        
    }
    
     public function create()
    {
        $result = Category::all();
        return view('admin_panel.products.create')
            ->with('catlist', $result);
        
    }
    
    
    
    public function store(ProductVerifyRequest $request)
    { 
        $file = $request->file('myfile');

        $temp_string='/uploads/products/'.(string)(DB::table('products')->max('id')+1);
        if (!file_exists(public_path().$temp_string)) {
            mkdir( public_path().$temp_string, 0777, true);
        }
		$file->move(public_path().$temp_string."/","1.".$file->getClientOriginalExtension());
        $prd = new Product();
        $prd->image_name = "1.".$file->getClientOriginalExtension();
        $prd->name = $request->Name;
        $prd->description = $request->Description;
        $prd->category_id = $request->Category;
        $prd->price = $request->Price;
        $prd->discount = $request->Discounted_Price;
        $prd->sizes = $request->Sizes;
        $prd->colors = $request->Colors;
        $prd->tag = $request->Tags;


        $prd->save();
        
       return redirect()->route('admin.products');
    }
    
    
    public function edit($id)
    {
        $cat = Category::all();
        
          

        $prd = Product::find($id);
        
        
        
        return view('admin_panel.products.edit')
            ->with('product', $prd)
            ->with('catlist', $cat)
            ->with('select_attribute', '');

            
    }

    public function update(ProductEditVerifyRequest $request, $id)
    {
      
        $prdToUpdate = Product::find($request->id);
        $prdToUpdate->name = $request->Name;
        $prdToUpdate->description = $request->Description;
        $prdToUpdate->price = $request->Price;
        $prdToUpdate->discount= $request->Discounted_Price;
        $prdToUpdate->category_id = $request->Category;
        $prdToUpdate->sizes = $request->Sizes;
        $prdToUpdate->colors = $request->Colors;
        $prdToUpdate->tag= $request->Tags;
        
        //NEW FILE UPLOADED
        if($request->myfile!=null)
        {            
            $file = $request->file('myfile');

            //$temp_for_same_file_name = Product::where('image_name',$file->getClientOriginalName())->first();

            //$file_pointer = "uploads/products/".$product_image_ToUpdate->id."/".  $product_image_ToUpdate->image_name;
            //unlink($file_pointer);
            $temp_string='/uploads/products/'.$prdToUpdate->id;
            $prdToUpdate->image_name = "1.".$file->getClientOriginalExtension();
            $file->move(public_path().$temp_string."/","1.".$file->getClientOriginalExtension());
            $prdToUpdate->save();
        
            return redirect()->route('admin.products');
            }
        else{
            
            $prdToUpdate->save();
            return redirect()->route('admin.products');
        }
        
        
        
        
        
    }
    
    public function delete($id)
    {
       
        $prd = Product::find($id);

        return view('admin_panel.products.delete')
            ->with('product', $prd);
    }

    public function destroy(Request $request)
    {
        
       
        $prdToDelete = Product::find($request->id);
        //deleting image folder
        try{
            $src='uploads/products/'.$prdToDelete->id.'/';
            $dir = opendir($src);
            while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $src . '/' . $file;
                if ( is_dir($full) ) {
                    rrmdir($full);
                }
                else {
                    unlink($full);
                }
                }
            }
            closedir($dir);
            rmdir($src);
        }
        catch(\Exception $e){

        }
        //deleting image folder done
        
       
        
        $prdToDelete->delete();
        
        return redirect()->route('admin.products');

        
       
        
    }
    
   
    
    
}
