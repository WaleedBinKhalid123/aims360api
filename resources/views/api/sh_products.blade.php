@extends('layouts.app')

@section('javascript')

    <script type="text/javascript">
        async function product(id){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                type: 'POST',
                url: '/ship_hero_product_get',
                dataType: 'json',
                data: {id: id},
                success: function (result) {
                    if (result) {
                        console.log(result);
                        var body = $('#product');
                        body.empty();
                        body.append(result);
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function deleteproduct(id) {
            var flag  = confirm("Are You Sure");
            if(flag==true)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    type: 'get',
                    url: '/ship_hero_product_delete',
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
            <div class="col-md-10 offset-1 px-5">
               <h1 class="text-center my-2" style="font-family: 'Nunito', sans-serif;">SHIPHERO PRODUCTS</h1>
                <a href="/api/GraphQl"><button class="btn" style="color:white;background-color: grey;">Sync</button></a>
                @if(!count($products) == 0)
                    <div class="row justify-content-center my-4">
                        <div class="col">
                            <table class='table border table-hover text-center my-1' style="border-color: black;">
                                <tr class="bg-dark text-white">
                                    <td><strong>Check</strong></td>
                                    <td><strong>GraphQlProduct-id</strong></td>
                                    <td><strong>Name</strong></td>
                                    <td><strong>Sku</strong></td>
                                    <td>Action</td>
                                </tr>
                                @foreach($products as $key=>$product)
                                    <tr>
                                        <td><input type="checkbox" id="{{$key}}"></td>
                                        <td>{{ $product->GQL_id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td><button class="btn" data-toggle="modal" data-target="#editProduct" onclick="product({{$product->id}})" style="background-color: transparent;"><i class="fas fa-pen" style="color:#671313;"></i></button>
                                            <button class="btn"  onclick="deleteproduct({{$product->id}})"><i class="fas fa-trash-alt"></i></button></td>
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
    <div class="modal" id="editProduct">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="product">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection
