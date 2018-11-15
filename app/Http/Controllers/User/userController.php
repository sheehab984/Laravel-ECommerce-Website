<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\orderRequest;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\sale;
use App\User;
use App\Address;

class userController extends Controller
{
    public function index()
    {
    	$res = Product::all();
        $cat = Category::all();
    	return view('store.index')
            ->with('products', $res)
            ->with("cat", $cat)
            ->with('index', 1);
    }
    public function view($id)
    {
        $res = Product::find($id);
        $res1 = Product::all();
        $cat=Category::find($res->category_id);
        $colorList = explode(',',$res->colors);
        $sizeList = explode(',',$res->sizes);
    	$cat = Category::all();
        return view('store.product')
            ->with('product', $res)
            ->with('products', $res1)
            ->with('cat', $cat)
            ->with('sizes',$sizeList)
            ->with('colors',$colorList);
            
    }

    public function search(Request $r){
        $category ;
        $name ;
        if($r->query("c")){
            $category = $r->query("c");
        }
        if($r->query("n")){
            $name = $r->query("n");
        }

        $res = Product::all();
        $cat = Category::all();

        if(isset($category) && isset($name)){
            $name = strtolower($name);
            $sRes = DB::select( DB::raw("SELECT * FROM `products` WHERE lower(name) like '%$name%' and category_id = $category" ) );
            //dd("SELECT * FROM `products` WHERE lower(name) like '%$name%' and category_id = $category" );
            //$a = 0;
        }
        else if(isset($name)){
            $name = strtolower($name);
            $sRes = DB::select( DB::raw("SELECT * FROM `products` WHERE lower(name) like '%$name%'" ) );
          //dd("SELECT * FROM `products` WHERE lower(name) like '%$name%'" );
           // $a = 1;
        }

        else if(isset($category)){
            $sRes = DB::table('products')
            ->where("category_id" , $category)
            ->get();
            //$a = 2;
        }
        else{
            $sRes = DB::table('products')
            ->get();
           // $a= 3;
        }

        if(!isset($category)) {
            $category = -1;
        }
        //dd($sRes);
    	return view('store.search')
            ->with('products', $sRes)
            ->with("cat", $cat)
            ->with("a", $category);
    }

    public function post($id,orderRequest $r)
    {
        
        if(!($r->session()->has('cart')))
        {
            $c=$id.":1:".$r->size.":".$r->color;
            $r->session()->put('cart',$c);
        }
        else
        {
            $cd=$id.":1:".$r->size.":".$r->color;
            $total=session('cart').",".$cd;

            $r->session()->put('cart',$total);

        }
        return redirect()->route('user.home');

    }

    
    public function cart(Request $r)
    {
        $res = Product::all();
        $cat = Category::all();
        if(!session()->has('cart'))
        {
            return view('store.cart')->with('all',null)
            ->with('products',[])
            ->with('products', $res)
            ->with("cat", $cat);
        }
        $cart=[];
        $product=[];
        $cost=0;
        $totalCart = explode(',',session('cart'));
         foreach($totalCart as $c)
         {
            $cart[]=explode(':',$c);
            $a=explode(':',$c);
            $res = Product::find($a[0]);
            $product[]=$res;

            $cost+= $res->discount;
            $r->session()->put('price',$cost);

         }

    	return view('store.cart')
            ->with('products', $res)
            ->with("cat", $cat)
            ->with('all',$cart)
            ->with('prod',$product)
            ->with('total',$cost);
            
    }
    public function confirm(Request $r)
    {
        
        if($r->has('order'))
        {
          //  dd(1);
            if($r->session()->has('user'))
            {
                $sales= new sale();
                $sales->user_id=session('user')->id;
                $sales->product_id=session('cart');
                $sales->order_status='Placed';
                $sales->price=session('price');
                $sales->save();
           // dd(1);
            $r->session()->forget('cart');
            $r->session()->forget('price');
            //dd( $r->session());
            return redirect()->route('user.cart');

            }
            else{

                return redirect()->route('user.cart');
            }
            
        }

        if($r->has('signup'))
        {
            
            $validatedData = $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric',
            'tel' => 'required|numeric',
            'pass' => 'required|min:5'
            ]);

            //dd($validatedData);
            $u=new User();
            $add=new Address();
            $add->area=$r->address;
            $add->city=$r->city;
            $add->zip=$r->zip;

            $add->save();
            $add_id=$add->id;

            $u->full_name=$r->name;
            $u->email=$r->email;
            $u->password=$r->pass;
            $u->address_id=$add_id;
            $u->phone=$r->tel;
            
            //dd($u);

            $u->save();

            $user=User::find($u->id);

            $r->session()->put('user',$user);

            return redirect()->route('user.cart');
        }
       
    }
    public function history(Request $r)
    {
        $res1= sale::where('user_id', session('user')->id)->get();
        if(!$res1)
        {
            return view('user.orderHistory')->with('all',[])
         ->with('products',[])
         ->with('sale',[]);
        }
        
        $cart=[];
        $product=[];
        $id=[];
        foreach($res1 as $r )
        {
             $totalCart = explode(',',$r->product_id);
             foreach($totalCart as $c)
             {
                $cart[]=array_prepend(explode(':',$c), $r->id);
                $a=explode(':',$c);
                $res = Product::find($a[0]);
                $product[]=$res;
                

             }
        }
        $res = Product::all();
        $cat = Category::all();
          //dd($cart); 
         return view('store.history')
         ->with('products', $res)
         ->with("cat", $cat)
         ->with('all',$cart)
         ->with('prods',$product)
         ->with('sale',$res1);

        
    }
    
}
