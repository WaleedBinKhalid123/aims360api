@extends('layouts.app')

@section('javascript')

    <script type="text/javascript">
        function eproduct(id){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                type: 'POST',
                url: '/aims360_product_get',
                dataType: 'json',
                data: {id: id},
                success: function (result) {
                    if (result) {
                        console.log(result);
                        var body = $('#gproduct');
                        body.empty();
                        body.append(result);
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function dproduct(id) {
            var flag  = confirm("Are You Sure");
            if(flag==true)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    type: 'get',
                    url: '/aims360_product_delete',
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
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center my-5" style="font-family: 'Nunito', sans-serif;">AIMS360 PRODUCTS</h1>
                <a href="/api/Aim360Styles"><button class="btn" style="color:white;background-color: grey;">Sync Products</button></a>
                @if(!count($products) == 0)
                    <div class="row justify-content-center my-4">
                        <div class="col">
                            <table class='table border table-hover text-center my-1' style="border-color: black;">
                                <tr class="bg-dark text-white">
                                    <td><strong>StyleColorID</strong></td>
                                    <td><strong>Style</strong></td>
                                    <td><strong>Color</strong></td>
                                    <td><strong>Description</strong></td>
                                    <td><strong>Status</strong></td>
                                    <td><strong>Action</strong></td>
                                </tr>
                                @foreach($products as $key=>$product)
                                    <tr>
                                        <td>{{ $product->styleColorID }}</td>
                                        <td>{{ $product->style }}</td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->description }}</td>
                                        @if($product->status == '0')
                                            <td><span class="badge badge-danger">UnMatch</span></td>
                                        @endif
                                        @if($product->status == '1')
                                            <td><span class="badge badge-success">Match</span></td>
                                        @endif
                                        <td><button class="btn" data-toggle="modal" data-target="#eProduct" onclick="eproduct({{$product->id}})" style="background-color: transparent;"><i class="fas fa-pen" style="color:#671313;"></i></button>
                                            <button class="btn"  onclick="dproduct({{$product->id}})"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- The Product Edit Modal -->
    <div class="modal" id="eProduct">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="gproduct">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


@endsection
