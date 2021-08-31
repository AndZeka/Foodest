@extends('layouts.app')

@section('content')
@if (count($baskets)>0)
<section class="saction4">
    <div class="container bg-white">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $subtotal = 0;
                        $shipping = 0;
                        @endphp
                        @foreach($baskets as $basket)
                        <tr>
                            <td class="col-sm-8 col-md-6">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#"> <img class="media-object"
                                            src="/imgs/{{ $basket->product->photo }}"
                                            style="width: 72px; height: 72px;"> </a>
                                    <div class="media-body ml-1">
                                        <h4 class="media-heading"><a href="#">{{ $basket->product->name }}</a></h4>
                                        <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                        <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>{{ $basket->qty }}</strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>${{ $basket->price }}</strong></td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <strong>${{ number_format($basket->price * $basket->qty, 2) }}</strong>
                            </td>
                            @php
                            $subtotal = $subtotal+($basket->price * $basket->qty);
                            @endphp
                            <td class="col-sm-1 col-md-1">
                                <form action="{{ route('basket.destroy', [$basket->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"> Remove</span>
                                    </button>
                            </td>
                            </form>
                        </tr>
                        @endforeach

                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td class="text-right">
                                <h5><strong>${{ $subtotal }}</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td>
                                <h5>Estimated shipping</h5>
                            </td>
                            <td class="text-right">
                                <h5><strong>${{ $shipping }}</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td>
                                <h3>Total</h3>
                            </td>
                            <td class="text-right">
                                <h3><strong>${{ $subtotal + $shipping }}</strong></h3>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td>
                                <a class="btn btn-info" href="{{ url('/') }}">Continue Shopping</a>
                            </td>
                            <td>
                                <a href="{{ route('checkout.index') }}" class="btn btn-success">
                                    Checkout <span class="glyphicon glyphicon-play"></span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@else
<section class="saction4">
    <div class="container bg-white">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-md-offset-1 d-flex align-items-center justify-content-center" style="height:200px">
                <h1 class="text-danger text-center font-weight-bold"> Cart is empty! </h1>
            </div>
        </div>
    </div>
</section>
@endif

@endsection