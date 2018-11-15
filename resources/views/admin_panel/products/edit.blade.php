@extends('admin_panel.adminLayout') @section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('admin.products')}}">
                                < Back to List</a>
                                    <br>
                                    <br>
                                    <h4 class="card-title">Edit product</h4>
                                    <br>
                                    <img id="imageHolder" src="/uploads/products/{{$product->id}}/{{$product->image_name}}" alt="add image" height="300" width="300"
                                    />
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <br><br>
                                        <input type="file" name="myfile" id="myfile" onchange="loadFile(event)">
                                        <br><br>
                                        <div class="form-group">
                                            <label >Product Name</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="Name" value="{{$product->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Product Description</label>
                                            <textarea type="textarea" class="form-control" name="Description">{{$product->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Large select</label>
                                            <select class="form-control form-control-md" id="exampleFormControlSelect1" name="Category">
                                                @php foreach($catlist->all() as $cat) { if($product->category->id==$cat->id) { $select_attribute='selected'; } echo "
                                                <option value=".$cat->id." " .$select_attribute.">".$cat->name." </option>"; $select_attribute=''; } @endphp
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label >Product Price</label>
                                            <input type="text" class="form-control" name="Price" value="{{$product->price}}">
                                        </div>
                                        <div class="form-group">
                                            <label >Product Discounted Price</label>
                                            <input type="text" class="form-control"  name="Discounted_Price" value="{{$product->discount}}">
                                        </div>
                                        <div class="form-group">
                                            <label >Product Sizes</label>
                                            <input type="number" id="sizePicker" class="form-control col-md-2">
                                            <br>
                                            <a onclick="addSize()" class="btn btn-sm btn-primary" >add</a>
                                            <br>
                                            <br>
                                            <div id="sizes" > 
                                            </div>  
                                            <input type="text" class="form-control" id="sizeList" name="Sizes" value="{{$product->sizes}}" hidden>
                                        </div>
                                        <div class="form-group ">
                                            <label >Product Colors</label>
                                            
                                            <input type="color" id="picker" class="form-control col-md-2">
                                            <br>
                                            <a onclick="addColor()" class="btn btn-sm btn-primary" >add</a>
                                            <br>
                                            <br>
                                            <div id="colors" style="border:1px solid #eee"> 
                                            </div>  
                                            <br>            
                                            <input type="text" class="form-control" id="color_list" name="Colors" value="{{$product->colors}}" hidden>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label >Product Tags</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="Tags" value="{{$product->tag}}">
                                        </div>
                                        <input type="submit" name="saveButton" class="btn btn-success mr-2" id="updateButton" value="UPDATE" />
                                    </form>
                                    @if($errors->any())


                                    <ul>
                                        @foreach($errors->all() as $err)
                                        <tr>
                                            <td>
                                                <li>{{$err}}</li>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </ul>
                                    @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageHolder').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $( document ).ready(function() {
        $("#myfile").change(function () {
        readURL(this);
    });

});
$( document ).ready(function() {
    var addedColor = document.querySelector("#color_list").value;
    var arrayOfColor = addedColor.split(',');
    var sizeList = document.querySelector("#sizeList").value;
    var arrayOfSize = sizeList.split(",");
    document.querySelector("#sizes").innerHTML = sizeComponent(arrayOfSize);
    //console.log(addedColor);
    onReadyColorList(arrayOfColor);       
});
function onReadyColorList(arrayOfColor){
    var addedColor = document.querySelector("#color_list").value;
    var arrayOfColor = addedColor.split(',');
    for(var i =0 ; i< arrayOfColor.length; i++){
        newColor = `<div style="height:25px;display:inline-block;margin:5px;width:25px!important;background-color:${arrayOfColor[i]}"></div>`;
        document.querySelector("#colors").innerHTML += newColor;
    }
}
function addColor(){
    var pickedColor = document.querySelector("#picker").value;
    newColor = `<div style="height:25px;display:inline-block;margin:5px;width:25px!important;background-color:${pickedColor}"></div>`;
    var addedColor = document.querySelector("#color_list").value;
    //console.log(addedColor);
    if (addColor != null){  
        var arrayOfColor = addedColor.split(',');
        if(!arrayOfColor.includes(pickedColor)){
            arrayOfColor.push(pickedColor);
            document.querySelector("#color_list").value = arrayOfColor.join(',');
            document.querySelector("#colors").innerHTML += newColor;
        }
        
        console.log(addedColor);
       
        
    } 
}
function sizeComponent(arrayOfSize){
    var s = ``;
    
    for(var i = 0 ; i < arrayOfSize.length; i ++){
        //alert(1);
        var temp = `<span style="border:2px solid #eee;padding:5px 5px;margin:4px">${arrayOfSize[i]}</span>`;
        console.log(temp);
        s += temp;
    }
   // console.log(s);
    return s;
}
function addSize(){
    var size = document.querySelector("#sizePicker").value;
    var sizeList = document.querySelector("#sizeList").value;
    if(size != ""){
        var arrayOfSize = sizeList.split(",");
        console.log(arrayOfSize);
            if(size != ""){
            if(!arrayOfSize.includes(size)){
                arrayOfSize.push(size);
                document.querySelector("#sizeList").value = arrayOfSize.join(",");
                document.querySelector("#sizes").innerHTML = sizeComponent(arrayOfSize);
                console.log(arrayOfSize.join(","));
            }
        }
    }
    //console.log(sizes);
}
</script>
@endsection
