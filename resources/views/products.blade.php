@extends('layouts.app')

@section('content')
    <section class="saction4">
      <div class="container" id="offer">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="dotted3 os-animation" data-os-animation="bounceInLeft" data-os-animation-delay="1s"></div>
            <div class="special">
              <h2 class="os-animation" data-os-animation="bounceInDown" data-os-animation-delay="0.50s">Products</h2>
              <div class="dotted4 os-animation" data-os-animation="bounceInRight" data-os-animation-delay="1s"></div>
            </div>
          </div>
          @foreach ($products as $product)
            <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="slider clearfix os-animation" data-os-animation="fadeInDown
                            " data-os-animation-delay="0.20s">
                <div class="img clearfix"> <img src="{{ $product->photo }}" alt="" style="max-height:130px; min-height:130px"/> </div>
                <div class="title clearfix">
                  <h3>{{ $product->name }}<br /></h3>
                  <p>{{ $product->description }}</p>
                  <add-to-cart-button :product="{{ $product }}" />
                </div>
              </div>
            </div>
          @endforeach
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="dotted3 os-animation" data-os-animation="bounceInLeft" data-os-animation-delay="1s"></div>
            <div class="special">
              <h2 class="os-animation" data-os-animation="bounceInDown" data-os-animation-delay="0.50s">Comments</h2>
              <div class="dotted4 os-animation" data-os-animation="bounceInRight" data-os-animation-delay="1s"></div>
            </div>
          </div>
          <form action="{{ route('comment.store',['slug' => $restaurant->slug]) }}" method="POST">
            @csrf
            <input type="text" hidden value="{{ $id }}" name="restaurant_id">
            <input type="text" hidden value="{{ $restaurant->slug }}" name="slug" required>
            <div class="row">
              <div class="col-md-8 col-lg-8 my-auto">
                <input type="text" name="message" placeholder="Add your comment..." class="form-control">
              </div>
              <div class="col-md-4 col-lg-4">
                <button type="submit" class="btn btn-success form-control" style="margin-right: 0 !important; margin-left: 0 !important">Send</button>
              </div>
            </div>
          </form>
          @foreach ($comments as $comment)
          <div class="container mt-1">
            <div class="row d-flex ">
                <div class="col-md-8">
                    <div class="card p-3 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="user d-flex flex-row align-items-center"> <img src="../imgs/profile/{{ $comment->user['photo'] }}" width="30" class="user-img rounded-circle mr-2"><span><small class="font-weight-bold text-primary">{{ $comment->user['name'] }}</small> <small class="font-weight-bold ml-3">{{ $comment->message }}</small></span> </div> <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection