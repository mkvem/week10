@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="h1">{{ $clothes->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-2">
            <img src="{{ asset('images/dummy-clothes.jpg')}}" class="rounded mb-2" style="height:200px;" />
        </div>
        <div class="col">
            <div>
                <div class="my-1" style="background-color:{{env(strtoupper($clothes->color))}};width:16px;height:16px;float:left;"></div>
                <span class="ml-1 my-auto">{{ $clothes->color }}</span>
            </div>
            <div>Size: {{ $clothes->size }}</div>

            <!-- Add to cart section -->
            <form action="" class="row form-group my-2" method="POST">
                @csrf
                <div class="col-md-2">
                    <input type="number" min="0" class="form-control" />
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <span class="fa fa-cart-shopping"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="h1"><span class="fa fa-comment"></span> Reviews</h1>
        </div>

        @foreach ($clothes->reviews as $review)
        <div class="col-md-12 my-3">
            <h5 class="h5">{{$review->name}}</h5>
            <p>{{$review->review}}</p>
        </div>
        @endforeach
    </div>
@endsection