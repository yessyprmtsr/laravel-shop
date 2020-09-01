<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Modist - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/customer/assets/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/animate.css')}}">

    <link rel="stylesheet" href="{{ asset('/customer/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{ asset('/customer/assets/css/aos.css')}}">

    <link rel="stylesheet" href="{{ asset('/customer/assets/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{ asset('/customer/assets/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/jquery.timepicker.css')}}">


    <link rel="stylesheet" href="{{ asset('/customer/assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{ asset('/customer/assets/css/style.css')}}">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Modist</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
	          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="product-single.html">Woman Jacket</a>
                <a class="dropdown-item" href="cart.html">Man Jacket</a>
                <a class="dropdown-item" href="checkout.html">Blazzer</a>
                <a class="dropdown-item" href="checkout.html">Cardigan</a>
              </div>
            </li>
            <li class="nav-item"><a href="{{ route('login')}}" class="nav-link">Login</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">User</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="cart.html">Cart</a>
                  <a class="dropdown-item" href="checkout.html">Check Out</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </a>
                </div>
              </li>
	        <li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>

      @yield('content')
    <footer class="ftco-footer bg-light ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Modist</h2>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{ asset('customer/assets/js/jquery.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/popper.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery.easing.1.3.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery.stellar.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/aos.js')}}"></script>
  <script src="{{ asset('customer/assets/js/jquery.animateNumber.min.js')}}"></script>
  <script src="{{ asset('customer/assets/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{ asset('customer/assets/js/scrollax.min.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{ asset('customer/assets/js/google-map.js')}}"></script>
  <script src="{{ asset('customer/assets/js/main.js')}}"></script>

  </body>
</html>
