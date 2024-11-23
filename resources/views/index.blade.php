@extends('base')

@section('content')
    {{-- Shopping Cart Modal --}}
    <div id="shoppingCartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shopping Cart</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="loadingGif" class="col-md-12 position-relative py-4">
                            <img src="{{asset('images/loading.gif')}}" class="position-absolute top-50 start-50 translate-middle" style="width:48px;" />
                        </div>
                        <div id="listItems" class="col-md-12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('checkout') }}">
                        <button id="checkOutButton" type="button" class="btn btn-primary">Check Out</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Shopping Cart Modal --}}

    {{-- Shopping Cart Button --}}
    <button type="button" class="my-2 btn btn-sm btn-primary position-absolute top-0 end-2" data-bs-toggle="modal"
        data-bs-target="#shoppingCartModal">
        <span class="fa fa-shopping-cart"></span>
    </button>
    {{-- End of Shopping Cart Button --}}

    @foreach ($listClothes as $clothes)
        <a href="{{ route('productpage', ['id' => $clothes->id]) }}" style="text-decoration:none;">
            <div class="row justify-content-center">
                <div class="border-top col-md-4 pt-3 pb-3 clearfix">
                    <h3 class="display-5">{{ $clothes->name }}</h3>
                    <div class="float-start">
                        <div class="my-1"
                            style="background-color:{{ env(strtoupper($clothes->color)) }};width:16px;height:16px;float:left;">
                        </div>
                        <span class="ml-1 my-auto">{{ $clothes->color }};</span>
                        Size: {{ $clothes->size }}
                    </div>
                    <div class="float-end">
                        <span class="fa fa-comment"></span>
                        {{ $clothes->reviews->count() }}
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endsection

@section('library-js')
    <script type="text/javascript">
        // Load Shopping Cart Data, same as in product page
        function loadShoppingCartData() {
            $("#listItems").html("");
            $("#loadingGif").show();
            $.ajax({
                url: "/shoppingcart/{{ session()->getId() }}",
                success: function(result) {
                    var html;
                    if (result.data.length > 0) {
                        html = "<ul class='list-group'>";
                        for (var i = 0; i < result.data.length; i++) {
                            html += "<li class='list-group-item'>";
                            html += "<img src='{{ asset('images/dummy-clothes.jpg') }}'' class='rounded mb-2 mr-3' style='height:100px;float:left;'' />";
                            html += result.data[i].clothes.name + " - ";
                            html += result.data[i].clothes.color + " - ";
                            html += result.data[i].clothes.size;
                            html += "<input type='number' class='jumlah form-control ml-5' value='" + result.data[i].jumlah + "' style='width:60px;display:inline-block;' data-id='" + result.data[i].id + "' />";
                            html += "<button type='button' class='delete btn btn-sm btn-danger' style='float:right;' data-id='" + result.data[i].id + "'>";
                            html += "<i class='fa-solid fa-trash-can'></i>";
                            html += "</button>";
                            html += "</li>";
                        }
                        html += "</ul>";
                        $("#checkOutButton").prop("disabled", false);
                    } else {
                        html = "Shopping cart is empty !";
                        $("#checkOutButton").prop("disabled", true);
                    }

                    $("#listItems").html(html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                },
                complete: function(xhr, status, error) {
                    $("#loadingGif").hide();
                }
            });
        }

        $(document).ready(function() {
            $("#shoppingCartModal").on('show.bs.modal', function(event) {
                loadShoppingCartData();
            });
        });
    </script>
@endsection