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

        window.onload = function() {
            // +++++ Agents Table +++++ //
            let columns = ['styleColorID', 'style', 'color', 'description'];
            let columnDefs = [
                {
                    render: (data, type, row) => {
                        if(row.status == '1')
                            return '<span class="badge badge-success">Matched</span>'

                        return '<span class="badge badge-danger">Not Matched</span>';
                    },

                    targets: 4
                },
                {
                    render: (data, type, row) => {
                        return `<button class="btn" data-toggle="modal" data-target="#eProduct" onclick="eproduct(${row.id})" style="background-color: transparent;">
                                <i class="fas fa-pen" style="color:#671313;"></i></button>
                                <button class="btn"  onclick="dproduct(${row.id})">
                                <i class="fas fa-trash-alt"></i></button>`
                    },

                    targets: 5
                },
            ];

            dataTables('#aims360_products', "{{ route('aims360_loaddata') }}", columns, columnDefs);

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
                <h1 class="text-center my-5" style="font-family: 'Nunito', sans-serif;">AIMS360 PRODUCTS</h1>
                <a href="/api/Aim360Styles"><button class="btn" style="color:white;background-color: grey;">Sync Products</button></a>
                    <div class="row justify-content-center my-4">
                        <div class="col">
                            <table class='table border table-hover text-center my-1' id="aims360_products" style="border-color: black;">
                                <thead>
                                <tr class="bg-dark text-white">
                                    <td><strong>StyleColorID</strong></td>
                                    <td><strong>Style</strong></td>
                                    <td><strong>Color</strong></td>
                                    <td><strong>Description</strong></td>
                                    <td><strong>Status</strong></td>
                                    <td><strong>Action</strong></td>
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
