@extends('admin_panel.adminLayout') @section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products Table <a class="btn btn-lg btn-success" style="float:right;margin-right:50px;color:white" href="{{route('admin.products.create')}}">+ Add Product</a></h4>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Images
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Category
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Update
                                    </th>
                                    <th>
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($prdlist as $prd)
                                <tr>
                                    <td>
                                        <img src="/uploads/products/{{$prd->id}}/{{$prd->image_name}}" style="width:100px;height:100px;border-radius:10%;" alt="">
                                    </td>
                                    <td>
                                        {{$prd->name}}
                                    </td>
                                    <td>
                                        {{$prd->description}}
                                    </td>
                                    <td>
                                        {{$prd->category->name}}
                                    </td>
                                    <td>
                                        {{$prd->price}}
                                    </td>
                                    <td><a href="{{route('admin.products.edit', ['id' => $prd->id])}}" class="btn btn-warning">Edit</a> </td>
                                    <td><a href="{{route('admin.products.delete', ['id' => $prd->id])}}"class="btn btn-danger">Delete</a></td> 
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

