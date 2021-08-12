<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lobster+Two:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,300,700' rel='stylesheet' type='text/css' />

        @livewireStyles

        <!-- Scripts -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <!--CSS-->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/responsive.css"/>

        <!--JS-->

        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/modernizr.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/waypoints.min.js"></script>

        <script type="application/javascript" src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <header>
                <div class="container">
                  <div class="row clearfix" id="home">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <div class="logo">
                        <h1> <a href="#"><img src="imgs/TMPS000136.png" alt="" /></a> </h1>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <div class="contact">
                        <p>Questions? Call us Toll-free!<span class="number"><a href="#">1800-0000-7777</a></span><span class="time">(11AM to 11PM)</span></p>
                      </div>
                    </div>
                  </div>
                </div>
            </header>
            <section class="saction1">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="menu">
                      <div class="mobile-nav-container"> </div>
                      <div class="mobile-nav-btn"><img class="nav-open" src=					      "https://s3-us-west-2.amazonaws.com/s.cdpn.io/6214/nav-open.png" alt="Nav Button Open" /> <img class="nav-close" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/6214/nav-close.png" alt="Nav Button Close" /> </div>
                      <nav>
                        <ul>
                          <li><a href="#home">Home</a></li>
                          <li><a href="#resturant">Popular Restaurants </a></li>
                          <li><a href="#offer">Order </a></li>
                          <li><a href="#contact">Contact</a></li>
                        </ul>
                      </nav>
                    </div>
                    <div class="login">
                      <ul>
                          @if (Route::has('login'))
                              <div class="sm:block">
                                  @auth
                                      <li><a href="{{ url('/dashboard') }}" class="text-sm underline">DASHBOARD</a></li>
                                  @else
                                      <li><a href="{{ route('login') }}" class="text-sm underline">LOG IN</a></li>
              
                                      @if (Route::has('register'))
                                          <li><a href="{{ route('register') }}" class="ml-4 text-sm underline">REGISTER</a></li>
                                      @endif
                                  @endauth
                              </div>
                          @endif
                        {{-- <li><a href="#">Login</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">Help</a></li> --}}
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            @yield('content')
            <footer class="saction8">
                <div class="container" id="contact">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="site">
                        <h3>Site Link</h3>
                      </div>
                      <div class="sitelink">
                        <ul>
                          <li> <span>&#10152;</span><a href="#">About Us</a></li>
                          <li><span>&#10152;</span><a href="#">Contact Us</a></li>
                          <li><span>&#10152;</span><a href="#">Privacy Policy</a></li>
                          <li><span>&#10152;</span><a href="#">Terms of Use</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="site">
                        <h3>Site Link</h3>
                      </div>
                      <div class="sitelink">
                        <ul>
                          <li> <span>&#10152;</span><a href="#">About Us</a></li>
                          <li><span>&#10152;</span><a href="#">Contact Us</a></li>
                          <li><span>&#10152;</span><a href="#">Privacy Policy</a></li>
                          <li><span>&#10152;</span><a href="#">Terms of Use</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="follow">
                        <h3>Follow Us On...</h3>
                      </div>
                      <div class="social">
                        <ul>
                          <li> <i class="fa fa-facebook-square"></i><a href="#">Facebook</a></li>
                          <li><i class="fa fa-twitter-square"></i><a href="#">Twitter</a></li>
                          <li><i class="fa fa-linkedin-square"></i><a href="#">Linkedin</a></li>
                          <li><i class="fa fa-google-plus-square"></i><a href="#">Google Plus</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="submit">
                        <h3>Subscribe Newsletter</h3>
                        <p>To get latest updates and food deals
                          every week</p>
                      </div>
                      <div class="submitbox">
                        <input type="text" />
                        <div class="sub"> <a href="#">Submit</a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </footer>
            <footer class="saction9">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="email">&copy; All right reserved 2014  /  FoodFinder </div>
                      <p class="freetemplates">Free Template by <a href="http://freetemplates.pro/">FreeTemplates.pro</a></p>
                    </div>
                  </div>
                </div>
            </footer>
        </div>
    </body>
</html>
