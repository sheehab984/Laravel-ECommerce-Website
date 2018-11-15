@extends('store.storeLayout') 
@section('content')
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>

                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">


                        @foreach($products as $product)
                        <!-- product -->
                        <div class="col-md-3">
                            <div class="product">
                                <div class="product-img">
                                    <img src="/uploads/products/{{$product->id}}/{{$product->image_name}}" alt="">
                                    <div class="product-label">
                                        <span class="sale">Offer!!</span>
                                    </div>
                                </div>
                                <div class="product-body">
                                    <p class="product-category">{{$product->category->name}}</p>
                                    <h3 class="product-name"><a href="#">{{$product->name}}</a></h3>
                                    <h4 class="product-price">{{$product->discount}} <del class="product-old-price">{{$product->price}}</del></h4>
                                    <div class="product-rating">
                                    </div>
                                    <div class="product-btns">
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add
                                                to wishlist</span></button>
                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add
                                                to compare</span></button>
                                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                                view</span></button>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <a class="add-to-cart-btn" href="{{route('user.view',['id'=>$product->id])}}"><i class="fa fa-shopping-cart"></i>Purchase</a>
                                </div>
                            </div>
                        </div>
                        <!-- /product -->
                        @endforeach
                    </div>
                    <div style="height:200px"></div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
    </div>
@endsection