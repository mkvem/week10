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
                        <div id="listItems" class="col-md-12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Check Out</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Shopping Cart Modal --}}

    {{-- Notification Toast --}}
    {{-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div> --}}
    <div id="resultToast" class="toast-container position-absolute top-0 end-0 p-3">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong id="notificationTitle" class="me-auto"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="notificationMessage" class="toast-body">
            </div>
        </div>
    </div>
    {{-- End of Notification Toast --}}

    <div class="row">
        <div class="col-md-11">
            <h1 class="h1">{{ $clothes->name }}</h1>
        </div>
        <div class="col-md-1">
            <button type="button" class="my-2 btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#shoppingCartModal">
                Show Cart
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-2">
            <img src="{{ asset('images/dummy-clothes.jpg') }}" class="rounded mb-2" style="height:200px;" />
        </div>
        <div class="col">
            <div>
                <div class="my-1"
                    style="background-color:{{ env(strtoupper($clothes->color)) }};width:16px;height:16px;float:left;">
                </div>
                <span class="ml-1 my-auto">{{ $clothes->color }}</span>
            </div>
            <div>Size: {{ $clothes->size }} {{ session()->getId() }}</div>

            <!-- Add to cart section -->
            <div class="row form-group my-2">
                <div class="col-md-2">
                    <input id="jumlah" type="number" name="jumlah" min="0" value="0"
                        class="form-control" />
                </div>
                <div class="col">
                    <button id="addToCart" class="btn btn-primary" type="button">
                        <span class="fa fa-cart-shopping"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="h1"><span class="fa fa-comment"></span> Reviews</h1>
        </div>

        @foreach ($clothes->reviews as $review)
            <div class="col-md-12 my-3">
                <h5 class="h5">{{ $review->name }}</h5>
                <p>{{ $review->review }}</p>
            </div>
        @endforeach
    </div>
@endsection

@section('library-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#resultToast").show();
            $("#shoppingCartModal").on('show.bs.modal', function(event) {
                console.log("Modal is opened !");
                $.ajax({
                    url: "/shoppingcart/{{ session()->getId() }}",
                    success: function(result) {
                        console.log(result);
                        var html = "<ul class='list-group'>";
                        for (var i = 0; i < result.data.length; i++) {
                            html += "<li class='list-group-item'>";
                            html += result.data[i].clothes.name + " - ";
                            html += result.data[i].clothes.color + " - ";
                            html += result.data[i].clothes.size + " - ";
                            html += result.data[i].jumlah;
                            html += "<form action='/deletefromshoppingcart' method='POST'>";
                            html += "<input type='hidden' name='_token' value='{{ csrf_token() }}' />";
                            html += "<input type='hidden' name='id' value='" + result.data[i].id + "' />";
                            html += "<button type='submit' class='btn btn-sm btn-danger' style='float:right;'>";
                            html += "<i class='fa-solid fa-trash-can'></i>";
                            html += "</button>";
                            html += "</form>";
                            html += "</li>";
                        }
                        html += "</ul>";
                        $("#listItems").html(html);
                    }
                });
            });

            //Add to cart function
            $("#addToCart").on('click', function() {
                console.log("Add to cart");
                var jumlah = $("#jumlah").val();
                $.ajax({
                    url: "/addtocart",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "session_id": "{{ session()->getId() }}",
                        "clothes_id": {{ $clothes->id }},
                        "jumlah": jumlah
                    },
                    success: function(result) {
                        console.log(result);
                        $("#notificationTitle").html(result.result);
                        $("#notificationMessage").html(result.message);
                        $("#resultToast").show();
                        $("#jumlah").val(0);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
