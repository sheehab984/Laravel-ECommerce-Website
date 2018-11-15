@extends('store.storeLayout')
@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
        <form method="post">
            {{csrf_field()}}
            <div class="col-md-12">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">User Login</h3>
                    </div>
                    <div class="form-group">
                        <input class="input" type="email" name="email" placeholder="Email...">
                    </div>
                    <div class="form-group">
                        <input class="input" type="password" name="pass" placeholder="Enter Your Password">
                    </div>
                        <input type="submit"  name="signup" class="primary-btn order-submit" value="Sign In">
                </form>
                    
                </div>
                <!-- /Billing Details -->
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
@endsection
