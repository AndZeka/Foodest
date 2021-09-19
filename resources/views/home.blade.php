@extends('layouts.app')

@section('content')
    <section class="backgraound">
      <form action="{{ route('search.restaurants') }}" method="post">
        @csrf
        <div class="container" >
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="back">
                <div class="line1 os-animation" data-os-animation="rotateInDownLeft" data-os-animation-delay="1s"> </div>
                <div class="line2 os-animation" data-os-animation="rotateInDownLeft" data-os-animation-delay="1s"> </div>
                <h2 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.50s">Network of over 5000 Restaurants</h2>
                <h3 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="1s">To Order Online</h3>
                <div class="line3 os-animation" data-os-animation="rotateInDownRight" data-os-animation-delay="1s"> </div>
                <div class="line4 os-animation" data-os-animation="rotateInDownRight" data-os-animation-delay="1s"> </div>
              </div>
            </div>
          </div>
          <div class="row mt-5 d-flex justify-content-center align-items-center">
            {{-- <div class="col-sm-4">
              <search-text-field/>
            </div>
            <div class="col-sm-4">
              <div class="textbox1 os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.5s">
                <h3>Distance</h3>
                <select name="distance" id="distance" class="form-control">
                    <option value="1">1 Km</option>
                    <option value="2">2 Km</option>
                    <option value="3">3 Km</option>
                    <option value="4">4 Km</option>
                    <option value="5">5 Km</option>
                </select>
              </div>
            </div> --}} 
            <div class="col-sm-4">
              <input class="form-control me-2" type="search" name="search" placeholder="Search Restaurant" aria-label="Search">
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-end">
              <button class="search m-0 mb-1 btn btn-outline-none text-white pl-4 pr-4 p-1" type="submit">
                  <i class="fa fa-search"></i>
              </button>
          </div>
          </div>
        </div>
      </form>
    </section>
    <section class="saction3">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="ordaring">
              <h2 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.50s">Ordering food was never so easy</h2>
              <div class="dotted os-animation" data-os-animation="bounceInLeft" data-os-animation-delay="1s"></div>
              <p class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.50s">Just 4 stap follow</p>
              <div class="dotted1 os-animation" data-os-animation="bounceInRight" data-os-animation-delay="1s"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6">
            <figure class="step os-animation" data-os-animation="fadeInLeft" data-os-animation-delay="0.50s"> <img src="imgs/one.png" alt="" /> </figure>
            <div class="arrow" > <img src="imgs/arrow.png" alt="" /> </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <figure class="step os-animation" data-os-animation="fadeInLeft" data-os-animation-delay="1.5s"> <img src="imgs/two.png" alt="" /> </figure>
            <div class="arrow1 "> <img src="imgs/arrow.png" alt="" /> </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <figure class="step os-animation" data-os-animation="fadeInLeft" data-os-animation-delay="2.5s"> <img src="imgs/thrww.png" alt="" /> </figure>
            <div class="arrow"> <img src="imgs/arrow.png" alt="" /> </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <figure class="step1 os-animation" data-os-animation="fadeInLeft" data-os-animation-delay="3.5s"> <img src="imgs/four.png" alt="" /> </figure>
          </div>
        </div>
      </div>
    </section>
    <section class="saction4">
      <div class="container" id="offer">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="dotted3 os-animation" data-os-animation="bounceInLeft" data-os-animation-delay="1s"></div>
            <div class="special">
              <h2 class="os-animation" data-os-animation="bounceInDown" data-os-animation-delay="0.50s">Special Offer</h2>
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
                  @auth
                    <add-to-cart-button :product="{{ $product }}" />
                  @endauth
                  @guest
                    <a href="{{ url('login') }}">Add to cart &#10152;</a>
                  @endguest
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
    <section class="saction5">
      <div class="container" id="resturant">
          <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="restaurants">
                      <h3 class="os-animation" data-os-animation="rollIn" data-os-animation-delay="1s">Top Restaurants </h3>
                  </div>
                  <div class="dotted6 os-animation" data-os-animation="bounceInRight" data-os-animation-delay="0.50s"></div>
                  <div class="d-flex flex-wrap justify-content-between align-content-between">
                    @foreach ($restaurants as $restaurant)
                      <div class="col-lg-6 col-md-8 col-sm-8 col-xs-6">
                          <figure class="rest os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1s"> <a href="{{ route('restaurant.products', ['slug' => $restaurant->slug]) }}"><img src="{{ $restaurant->photo }}" alt="{{ $restaurant->name }}" style="width: 165px; height: 110px"/> </a> </figure>
                      </div>  
                    @endforeach                  
                  </div>
              </div>            
              <div class="col-lg-8 col-md-8 col-sm-8 pl-5">
                  <div class="food">
                      <h3 class="os-animation" data-os-animation="rollIn" data-os-animation-delay="2.5s">Top Cuisines</h3>
                  </div>
                  <div class="dotted7 os-animation" data-os-animation="bounceInRight" data-os-animation-delay="2.8s"></div>
                  <div class="food1">
                      <div class="row">
                        @foreach ($products8 as $product)
                          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pb-5">
                              <figure class="food os-animation" data-os-animation="fadeInDown
                              " data-os-animation-delay="3.8s"> <img src="{{ $product->photo }}" alt="{{ $product->name }}" style="width:157px ;height: 130px"/>
                                  <div class="order"> 
                                    <p>{{ $product->name }}</p>
                                    @auth
                                      <add-to-cart-button :product="{{ $product }}" style="color: #E24425 !important;" />
                                    @endauth
                                    @guest
                                      <a href="{{ url('login') }}" style="color: #E24425 !important;">Add to cart &#10152;</a>
                                    @endguest
                                  </div>
                              </figure>
                          </div>
                        @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
    <section class="saction6">
      <div class="container">
        <div class="row bg os-animation" data-os-animation="flash" data-os-animation-delay="1s">
          <div class="col-lg-3 col-md-3 col-sm-3 pt-5 pl-5">
            <div class="imgs">
              <h3 class="os-animation text-white">Enjoy Exclusive Food <br />
                Order any of these</h3>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 pt-3">
            <div class="point">
              <p><span>&#10152;</span><a href="#"> Party Order</a></p>
              <p><span>&#10152;</span><a href="#">Home Made Food</a></p>
              <p><span>&#10152;</span><a href="#">Diet Food</a></p>
            </div>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 pt-3">
            <figure class="imgs"> <img src="imgs/abc.png" alt="" /> </figure>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2">
            <div class="button text-center"> <a href="#">Order Now</a> </div>
          </div>
        </div>
      </div>
    </section>
    <section class="saction7">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12">
            <figure class="service os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1s"> <img src="imgs/plan.png" alt=""/> </figure>
            <div class="det os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1.3s">
              <h3>100% Service Guarantee </h3>
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12">
            <figure class="service os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1.5s"> <img src="imgs/mak.png" alt="" /> </figure>
            <div class="det os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1.8s">
              <h3>100% Service Guarantee </h3>
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <figure class="service os-animation" data-os-animation="fadeInDown" data-os-animation-delay="2s"> <img src="imgs/kljj.png" alt=""/> </figure>
            <div class="det os-animation" data-os-animation="fadeInDown" data-os-animation-delay="2.3s">
              <h3>100% Service Guarantee </h3>
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection