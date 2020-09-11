<div class="shop-sidebar mr-50">
    <form method="GET" action="{{ url('products')}}">
		<div class="sidebar-widget mb-40">
			<h3 class="sidebar-title">Filter by Price</h3>
			<div class="price_filter">
				<div id="slider-range"></div>
				<div class="price_slider_amount">
					<div class="label-input">
						<label>price : </label>
						<input type="text" id="amount" name="price"  placeholder="Add Your Price" style="width:170px" />
						<input type="hidden" id="productMinPrice" value="{{ $minPrice }}"/>
                        <input type="hidden" id="productMaxPrice" value="{{ $maxPrice }}"/>

					</div>
                    <button type="submit">Filter</button>
				</div>
			</div>
		</div>
    </form>

    {{-- tampil kategori --}}
    @if ($categories)
		<div class="sidebar-widget mb-45">
			<h3 class="sidebar-title">Categories</h3>
			<div class="sidebar-categories">
				<ul>
					@foreach ($categories as $category)
							<li><a href="{{ url('products?category='. $category->slug) }}">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

    {{-- tampil color --}}

    @if ($colors)
		<div class="sidebar-widget sidebar-overflow mb-45">
			<h3 class="sidebar-title">color</h3>
			<div class="sidebar-categories">
				<ul>
					@foreach ($colors as $color)
						<li><a href="{{ url('products?option='. $color->id) }}">{{ $color->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
    @endif


    <div class="sidebar-widget mb-40">
        <h3 class="sidebar-title">size</h3>
        <div class="product-size">
            <ul>
                <li><a href="#">xl</a></li>
                <li><a href="#">m</a></li>
                <li><a href="#">l</a></li>
                <li><a href="#">ml</a></li>
                <li><a href="#">lm</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-widget mb-50">
        <h3 class="sidebar-title">Top rated products</h3>
        <div class="sidebar-top-rated-all">
            <div class="sidebar-top-rated mb-30">
                <div class="single-top-rated">
                    <div class="top-rated-img">
                        <a href="#"><img src="assets/img/product/sidebar-product/1.jpg" alt=""></a>
                    </div>
                    <div class="top-rated-text">
                        <h4><a href="#">Flying Drone</a></h4>
                        <div class="top-rated-rating">
                            <ul>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                            </ul>
                        </div>
                        <span>$140.00</span>
                    </div>
                </div>
            </div>
            <div class="sidebar-top-rated mb-30">
                <div class="single-top-rated">
                    <div class="top-rated-img">
                        <a href="#"><img src="assets/img/product/sidebar-product/2.jpg" alt=""></a>
                    </div>
                    <div class="top-rated-text">
                        <h4><a href="#">Flying Drone</a></h4>
                        <div class="top-rated-rating">
                            <ul>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                            </ul>
                        </div>
                        <span>$140.00</span>
                    </div>
                </div>
            </div>
            <div class="sidebar-top-rated mb-30">
                <div class="single-top-rated">
                    <div class="top-rated-img">
                        <a href="#"><img src="assets/img/product/sidebar-product/3.jpg" alt=""></a>
                    </div>
                    <div class="top-rated-text">
                        <h4><a href="#">Flying Drone</a></h4>
                        <div class="top-rated-rating">
                            <ul>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                            </ul>
                        </div>
                        <span>$140.00</span>
                    </div>
                </div>
            </div>
            <div class="sidebar-top-rated mb-30">
                <div class="single-top-rated">
                    <div class="top-rated-img">
                        <a href="#"><img src="assets/img/product/sidebar-product/4.jpg" alt=""></a>
                    </div>
                    <div class="top-rated-text">
                        <h4><a href="#">Flying Drone</a></h4>
                        <div class="top-rated-rating">
                            <ul>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                                <li><i class="pe-7s-star"></i></li>
                            </ul>
                        </div>
                        <span>$140.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
