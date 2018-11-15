@extends('store.storeLayout')
@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Product main img -->
            <div class="col-md-5 ">
                <div id="product-main-img">
                    <div class="product-preview">
                        <img src="/uploads/products/{{$product->id}}/{{$product->image_name}}" alt="">
                    </div>
                </div>
            </div>
            <!-- /Product main img -->


            <!-- Product details -->
            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name">{{$product->name}}</h2>
                    <div>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="product-price">{{$product->discount}} <del class="product-old-price">{{$product->price}}</del></h3>
                        <span class="product-available">In Stock</span>
                    </div>
                    <p>{{$product->description}}</p>
                    <form method="post">
                    {{csrf_field()}}
                    <div class="product-options">
                        <label>
                            Size
                            <select name="size" class="input-select">
                                @foreach($sizes as $s)
                                <option value="{{$s}}">{{$s}}</option>
                                @endforeach
                            </select>
                        </label>
                        @foreach($colors as $c)
                        <input type="radio" name="color" value="{{$c}}">
                        <div style="height:25px;width:25px;margin:5px;display:inline-block;background-color: {{$c}}"></div>
                        @endforeach
                    </div>

                    <div class="add-to-cart">
                        <button type="submit" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                    </div>
                    </form>
                    <ul class="product-links">
                        <li>Category:</li>
                        <li><a href="{{route('user.search')}}?c={{$product->category->id}}">{{$product->category->name}}</a></li>
                    </ul>
                </div>
            </div>
            <!-- /Product details -->

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<div style="height:200px"></div>
<!-- /SECTION -->
@endsection
