@extends('layouts.app')

@section('javascript')
	<script>
		function validate(file) {
    		var ext = file.split(".");
    		ext = ext[ext.length-1].toLowerCase();
    		var arrayExtensions = ["xlsx"];

    		if (arrayExtensions.lastIndexOf(ext) == -1) {
        	alert("File extension is not xlsx");
        	$("#file").val("");
            }
        }

	// function ajaxRequest(url, type, data) {
	// 	return $.ajax({
	// 		url: url,
	// 		type: type,
	// 		headers: {
	// 			'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
	// 		},
	// 		data: data,
	// 		success: (res) => {
	// 			return res;
	// 		},
	// 		error: (err) => {
	// 			//
	// 		}
	// 	});
	// }

	async function getproduct(id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
            	type: 'POST',
           		url: '/getproduct',
            	dataType: 'json',
            	data : {id:id},
            	success: function(result) {
            	if(result){
 					console.log(result);
             		var body =  $('#body');
             		body.empty();
             		body.append(result);
            	}
            	else
            	{
                	alert("error");
            	}
            	}
        		});
            }
    function delproduct(id) {
    	        var flag  = confirm("Are You Sure");
                if(flag==true)
                {
	                $.ajax({
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
	                    },
	            	type: 'get',
	            	url: '/delproduct',
	            	dataType: 'json',
	            	data : {id:id},
	            	success: function(result1) {
	            	if(result1){
	 					console.log(result1);
	 					location.reload();
	            	}
	            	else
	            	{
	                alert("error");
	            	}
	            	}
	        		});
                }
            }

    </script>
@endsection

@section('content')

<div class="container">

	@if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
    	<div class="col col-md-4 offset-1">
    		<button class="btn" style="background-color:grey;color:white;" data-toggle="modal" data-target="#addModal">+</button>
    		<a href="{{ route('Export') }}"><button class="btn" style="background-color:grey;color:white;">Export Excel</button></a>
    	</div>
        <div class="col col-md-6">
			<form action="{{ route('Import_Data') }}"  method="post" enctype="multipart/form-data" style="padding-left: 5vw;">
                @csrf

                <div class="form-group">
                    <input type="file" name="file" id="file" style="background-color: grey; border-radius: 5px;" onChange="validate(this.value)" required>
                    <button type="submit" class="btn btn-primary my-1 col-md-3 mx-1">Import Excel</button>

                </div>
            </form>
        </div>
    </div>
    @if(!count($products) == 0)
    <div class="row justify-content-center">
    	<div class="col-md-10 offset-1">
    		<table class='table border table-hover text-center my-1' style="border-color: black;font-family: 'Nunito', sans-serif;">
    			<tr class="bg-dark text-white">
    		    	<td><strong>Id</strong></td>
    				<td><strong>Style</strong></td>
    				<td><strong>Color</strong></td>
    				<td><strong>SizeNum</strong></td>
    				<td><strong>SizeDesc</strong></td>
    				<td><strong>ShipHero SKU</strong></td>
    				<td><strong>Action</strong></td>
    			</tr>
    		 	@foreach($products as $key=>$product)
    				<tr>
    					<td>{{ $key+1 }}</td>
    					<td>{{ $product->style }}</td>
    					<td>{{ $product->color }}</td>
    					<td>{{ $product->sizenum }}</td>
    					<td>{{ $product->sizedesc }}</td>
    					<td>{{ $product->SKU }}</td>
    					<td><button class="btn" data-toggle="modal" data-target="#editModal" onclick="getproduct({{$product->id}})" style="background-color: transparent;"><i class="fas fa-pen" style="color:black;"></i></button>
    					<button class="btn"  onclick="delproduct({{$product->id}})"><i class="fas fa-trash-alt"></i></button></td>
    		    	</tr>
    			@endforeach
    		</table>
    	</div>
    </div>
    @endif
</div>
<!-- The Product Add Modal -->
<div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <div class="modal-body">
		    <form action="{{ route('Product') }}" method="post">
		    @csrf
		  		<div class="form-group">
		    		<label for="style">Style:</label>
		    		<input type="text" class="form-control" id="style" name="style" required="">
		  		</div>
		  		<div class="form-group">
		    		<label for="color">Color:</label>
		    		<input type="text" class="form-control" id="color" name="color" required>
		  		</div>
		  		<div class="form-group">
		    		<label for="sizenum">SizeNum:</label>
		    		<input type="text" class="form-control" id="sizenum" name="sizenum" required>
		  		</div>
		  		<div class="form-group">
		    		<label for="sizedesc">SizeDesc:</label>
		    		<input type="text" class="form-control" id="sizedesc" name="sizedesc" required>
		  		</div>
		  		<div class="form-group">
		    		<label for="sku">ShipHero_SKU:</label>
		    		<input type="text" class="form-control" id="sku" name="sku" required>
		  		</div>
		  		<button type="submit" class="btn btn-primary">Submit</button>
			</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- The Product Edit Modal -->
<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
	  <div class="modal-body" id="body">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endsection

