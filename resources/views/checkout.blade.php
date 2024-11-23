@extends('base')

@section('content')
    <div class="row justify-content-center py-2 mb-3">
        <div class="col-md-6">
            <h1 class="display-5">Check Out Summary</h1>
        </div>
    </div>
    @foreach ($listCartItems as $items)      
    <div class="row justify-content-center">
        <div class="col-md-6">
            <img src='{{ asset('images/dummy-clothes.jpg') }}' class='rounded mb-2 mr-3' style='height:100px;float:left;' />
            {{ $items->clothes->name }} - {{ $items->clothes->size }} 
            <span class="fw-bold">( {{ $items->jumlah }} )</span>
            <div>
                <div class="my-1"
                    style="background-color:{{ env(strtoupper($items->clothes->color)) }};width:16px;height:16px;float:left;">
                </div>
                <span class="ml-1 my-auto">{{ $items->clothes->color }}</span>
            </div>
        </div>
    </div>
    @endforeach
@endsection