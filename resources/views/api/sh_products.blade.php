@extends('layouts.app')

@section('javascript')
    <script>
        function product(id){
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
        function showAimsProducts(id) {
            var input = $('#hidden');
            input.val(id);
            let columns = ['styleColorID', 'style', 'color','description'];
            let columnDefs = [
                {
                    render: (data, type, row) => {
                        return `<button class=\'btn btn-outline-light\' onclick="match(${row.id})">Match</button>`;
                    },

                    targets: 4
                },

            ];

            dataTables('#modal_products', "{{ route('fetch_ship_hero_product_modal') }}", columns, columnDefs);
            $.fn.dataTable.ext.errMode = 'none';
        }

        function match(id) {
            var id1 = $('#hidden').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                type: 'POST',
                url: '/match_products',
                dataType: 'json',
                data : {id:id,id1:id1},
                success: function(result3) {
                    if(result3){
                        location.reload();
                    }
                    else
                    {
                        alert("error");
                    }
                }
            });
        }

        window.onload = function() {
            // +++++ Agents Table +++++ //
            let columns = ['GQL_id', 'name', 'sku', 'status'];
            let columnDefs = [
                {
                    render: (data, type, row) => {
                        if(row.status == '1')
                            return '<span class="badge badge-success">Matched</span>'

                        return '<span class="badge badge-danger">Not Matched</span>';
                    },

                    targets: 3
                },
                {
                    render: (data, type, row) => {
                        return `<button class="btn" data-toggle="modal" data-target="#editProduct" onclick="product(${row.id})" style="background-color: transparent;">
                                <i class="fas fa-pen" style="color:#671313;"></i></button>
                                <button class="btn"  onclick="deleteproduct(${row.id})">
                                <i class="fas fa-trash-alt"></i></button>`
                    },

                    targets: 4
                },
                {
                    render: (data, type, row) => {
                        if(row.status == '0')
                        {
                            return `gicts(${row.id})" data-toggle="modal" data-target="#matchProducts">Match</button>`;
                        }
                        else
                        {
                            return null;
                        }
                    },
                    targets: 5

                },
            ];

            var table = dataTables('#shiphero_products', "{{ route('sh_loaddata') }}", columns, columnDefs);
            $.fn.dataTable.ext.errMode = 'none';
        };

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
               <h1 class="text-center my-5" style="font-family: 'Nunito', sans-serif;">SHIPHERO PRODUCTS</h1>
                <a href="/api/GraphQl"><button class="btn" style="color:white;background-color: grey;">Sync Products</button></a>
                    <div class="row justify-content-center my-4">
                        <div class="col">
                            <table class='table border table-hover text-center my-1' id="shiphero_products" style="border-color: black;">
                                <thead>
                                <tr class="bg-dark text-white">
                                    <td><strong>GraphQlProduct-id</strong></td>
                                    <td><strong>Name</strong></td>
                                    <td><strong>Sku</strong></td>
                                    <td><strong>Status</strong></td>
                                    <td><strong>Action</strong></td>
                                    <td><strong>Matching</strong></td>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
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

    <!-- The Product Match Modal -->
    <div class="modal bd-example-modal-lg" id="matchProducts" style="padding: 50px;">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Match Aims360 Products</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="body">
                    <table class='table border table-dark' id="modal_products">
                        <thead>
                        <tr class='bg-dark text-white col-lg-12'>
                            <td><strong>StyleColorID</strong></td>
                            <td><strong>Style</strong></td>
                            <td><strong>Color</strong></td>
                            <td><strong>Description</strong></td>
                            <td><strong>Action</strong></td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <input type="hidden" id="hidden">

            </div>
        </div>
    </div>
@endsection
