@extends('layouts.app')

@section('javascript')
    <script>
        function Unmatch(id,shipHeroId,aims360Id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                },
                type: 'POST',
                url: '/unmatch_products',
                dataType: 'json',
                data: {id: id, shipHeroId: shipHeroId, aims360Id: aims360Id},
                success: function (result3) {
                    if (result3) {
                        location.reload();
                    } else {
                        alert("error");
                    }
                }
            });
        }
        window.onload = function() {
            let columns = [ 'QraphQlProducts_id','GQL_id','name','sku','Aims360Products_id','styleColorID','style','color'];
            let columnDefs = [
                {
                    render: (data, type, row) => {
                       return `<button class="btn" onclick="Unmatch(${row.id},${row.QraphQlProducts_id},${row.Aims360Products_id})"><i class="fas fa-not-equal"></i></button>`;
                    },

                    targets: 8
                },
            ];

            dataTables('#match_products', "{{ route('MP_loaddata') }}", columns, columnDefs);
            $.fn.dataTable.ext.errMode = 'throw';
          };
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card col-12" style="border: none;border-radius:20px;margin-top: 5vh;">
            <div class="card-header bg-white" style="border: none;">
                <h1 class="text-center my-5" style="font-family: 'Nunito', sans-serif;">MATCHED PRODUCTS</h1>
            </div>
            <div class="card-body">
                <div class="row justify-content-center my-4">
                    <div class="col">
                        <table class='table table-hover text-center pr-5' id="match_products" style="border-color: black;width:100% !important;">
                            <thead>
                            <tr class="text-black">
                                <td><strong>SHeroProductID</strong></td>
                                <td><strong>GQL_ID</strong></td>
                                <td><strong>Name</strong></td>
                                <td><strong>Sku</strong></td>
                                <td><strong>A360ProductID</strong></td>
                                <td><strong>StyleColorID</strong></td>
                                <td><strong>Style</strong></td>
                                <td><strong>Color</strong></td>
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
    </div>





@endsection