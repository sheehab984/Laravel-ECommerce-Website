@extends('store.storeLayout')
@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        @if(!session('user'))
        <div class="row">
        <form method="post">
            {{csrf_field()}}
            <div class="col-md-7">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">Billing address</h3>
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input class="input" type="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="city" placeholder="City">
                    </div>
                    <div class="form-group">
                        <input class="input" type="text" name="zip" placeholder="ZIP Code">
                    </div>
                    <div class="form-group">
                        <input class="input" type="tel" name="tel" placeholder="Telephone">
                    </div>
                    <div class="form-group">
                        <input class="input" type="password" name="pass" placeholder="Enter Your Password">
                    </div>

                    
                        
                        <input type="submit"  name="signup" class="primary-btn order-submit" value="Sign Up">
                </form>
                    
                </div>
                <!-- /Billing Details -->
            </div>
            @endif

            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Your Order</h3>
                </div>
                <div class="order-summary">
                    <div class="order-col">
						<div><strong>PRODUCT</strong></div>
						<div><strong>COLOR & DIMENTION </strong></div>
                        <div><strong>TOTAL</strong></div>
                    </div>
                    <div class="order-products">
                    @if($all != null)
					@foreach($all as $c)
					@foreach($prod as $p)
					@if($c[0]==$p->id)
                        <div class="order-col">
							<div><img src="/uploads/products/{{$p->id}}/{{$p->image_name}}" height="50px" width="50px">--{{$p->name}}</div>
							<div style="height:25px;width:25px;display:inline-block;background-color: {{$c[3]}}"></div>
							<div>{{$c[2]}}</div>
							<div>{{$p->discount}}</div>
						</div>
						@break
					@endif
					@endforeach 
					@endforeach 
                    
                    </div>
                    <div class="order-col">
                        <div>Shiping</div>
                        <div><strong>FREE</strong></div>
                    </div>
                    <div class="order-col">
                        <div><strong>TOTAL</strong></div>
                        <div><strong class="order-total">{{$total}}</strong></div>
                    </div>
                    @else
                    <div class="order-col">
                        <h1>Your Cart is Empty</h1>
                    </div>
                    @endif
                </div>
                <div class="payment-method">
                    <div class="input-radio">
                        <input type="radio" name="payment" id="payment-2" checked>
                        <label for="payment-2">
                            <span></span>
                            Cash On Delivery
                        </label>
                        <div class="caption">
                            <p>The product Will be delivered within 24 hour of confirmation. We accept only Cash on delivery at this moment.</p>
                        </div>
                    </div>
                </div>
                @if(session('user'))
                    @if($all != null)
                    <form method="post" name="cart">
                        {{csrf_field()}}
                        <input type="submit"  name="order" class="primary-btn order-submit" value="Confirm order">
                    </form>

                    @else
                        <a href="{{route('user.home')}}"><input type="button"  class="primary-btn order-submit" value="Order Now"></a>
                    @endif
                
                @else
                    <a href="#"><input type="button"  class="primary-btn order-submit" value="Sign Up"></a>   
                    <a href="{{route('user.login')}}"><input type="button"  class="primary-btn order-submit" value="Login"></a>   
                    
                @endif
                

                
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
@endsection
