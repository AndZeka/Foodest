@extends('layouts.app')

@section('content')
<section class="saction4">
    <div class="container bg-white p-5 card text-center">
        <div class="col-sm-12 col-md-12 col-md-offset-1 text-center">
            <h1 class="text-secondary text-center font-weight-bold">Order Submitted Successfully</h1><br />
            <img class="mx-auto d-block" src="/imgs/mark-icon.png" width="30%" />
        </div>
        <div class="col-sm-12 col-md-12 col-md-offset-1 text-center">
            <br />
            <h4 class="text-secondary" style="font-weight: 500;">Thank you for your order!</h4>
            <h5 class="text-secondary pt-2"  style="font-weight: 500;">Your Order Number is : {{ $order_id }}</h5>
        </div>
    </div>
</section>
@endsection