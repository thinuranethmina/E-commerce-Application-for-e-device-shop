@extends('frontend.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <section class="home-hero-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="swiper mySwiper pb-2 pb-lg-3">
                        <div class="swiper-wrapper">
                            @foreach ($banners->where('type', 'hero') as $banner)
                                <div class="swiper-slide">
                                    <img src="{{ asset($banner->image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="button-next d-none">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                    stroke="none">
                                    <path
                                        d="M1340 5111 c-118 -36 -200 -156 -187 -272 3 -27 14 -66 23 -86 11
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -25 377 -398 1093 -1116 l1076 -1077 -1076 -1078 c-716 -717 -1082 -1090
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -1093 -1115 -61 -135 4 -296 140 -347 66 -24 114 -25 180 -4 45 15 146 113
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    1242 1208 1095 1093 1194 1195 1212 1244 11 29 20 70 20 92 0 22 -9 63 -20 92
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -18 49 -117 151 -1212 1244 -1096 1095 -1197 1193 -1242 1208 -52 17 -114 20
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -156 7z" />
                                </g>
                            </svg>
                        </div>
                        <div class="button-prev d-none">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                    stroke="none">
                                    <path
                                        d="M3772 5110 c-52 -17 -114 -20 -156 -7 -45 -15 -146 -113 -1242 -1208
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -1095 -1093 -1194 -1195 -1212 -1244 -11 -29 -20 -70 -20 -92 0 -22 9 -63 20
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -92 18 -49 117 -151 1212 -1244 1096 -1095 1197 -1193 1242 -1208 66 -21 114
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -20 180 4 136 51 201 212 140 347 -11 25 -377 398 -1093 1115 l-1076 1078
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    1076 1077 c716 718 1082 1091 1093 1116 61 135 -4 296 -140 347 -39 14 -93 13
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    -150 -5z" />
                                </g>
                            </svg>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="top-brands-section">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title text-center">Top Brands Search</h3>
                </div>
                <div class="col-12 brand-container">

                    @foreach ($brands as $brand)
                        <a href="{{ route('shop.index') }}?brand[]={{ $brand->id }}" class="card">
                            <img src="{{ $brand->icon }}" alt="">
                        </a>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <section class="featured-products-section">
        <div class="container-xxl">
            <div class="row">
                <div
                    class="col-12 col-lg-3 d-flex flex-lg-column justify-content-start offer-container offers-section mb-4 mb-lg-0">

                    @foreach ($banners->where('type', 'home_sidebar') as $banner)
                        @include('frontend.components.offer-card')
                    @endforeach

                </div>
                <div class="col-12 col-lg-9">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-auto text-center text-lg-start">
                            <h3 class="section-title">New Arrived <br class="d-md-none"> Get to Order Now</h3>
                        </div>
                        <div class="col d-none d-lg-block px-3">
                            <hr class="divider">
                        </div>
                        <div class="col-12 col-lg-auto text-center text-lg-end mt-3 mt-lg-0">
                            <a href="{{ route('shop.index') }}" class="view-all">View All ></a>
                        </div>
                        <div class="col-12 mt-4 product-container">
                            @foreach ($products->where('is_featured', 1)->take(8) as $product)
                                @include('frontend.components.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($seasonal_banner->status == 'Active')
        <section class="sales-poster-section">
            <div class="container-xxl">
                <div class="row mx-auto poster-card">
                    <div class="col col-lg-6 px-0">
                        <h3 class="section-title">{{ $seasonal_banner->label1 }}</h3>
                        <p class="sale-percentage">{{ $seasonal_banner->label2 }}</p>
                        <p class="sale-title">{{ $seasonal_banner->label3 }}</p>
                        <a href="{{ $seasonal_banner->url }}" type="button" class="btn primary-btn">
                            <div>
                                <svg id="shopping-cart" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 22 22">
                                    <g id="shopping-cart-2" data-name="shopping-cart">
                                        <path id="Path_43" data-name="Path 43"
                                            d="M20.82,3.737a2.744,2.744,0,0,0-2.111-.987H3.888L3.85,2.428A2.75,2.75,0,0,0,1.12,0h-.2a.917.917,0,0,0,0,1.833h.2a.917.917,0,0,1,.91.809L3.292,13.368a4.583,4.583,0,0,0,4.552,4.049h9.573a.917.917,0,0,0,0-1.833H7.844A2.75,2.75,0,0,1,5.259,13.75H16.186A4.583,4.583,0,0,0,20.7,9.979l.72-3.991a2.745,2.745,0,0,0-.6-2.251Zm-1.2,1.926L18.9,9.654a2.75,2.75,0,0,1-2.711,2.262H4.967L4.1,4.583h14.6a.917.917,0,0,1,.907,1.08Z"
                                            fill="#fff" />
                                        <circle id="Ellipse_2" data-name="Ellipse 2" cx="1.833" cy="1.833" r="1.833"
                                            transform="translate(4.583 18.333)" fill="#fff" />
                                        <circle id="Ellipse_3" data-name="Ellipse 3" cx="1.833" cy="1.833" r="1.833"
                                            transform="translate(13.75 18.333)" fill="#fff" />
                                    </g>
                                    <g id="Frame_Icon" data-name="Frame Icon">
                                        <rect id="Rectangle_1" data-name="Rectangle 1" width="22" height="22"
                                            rx="10" fill="none" />
                                    </g>
                                </svg>
                            </div>
                            <span>Buy Now</span>
                        </a>
                    </div>
                    <div class="col col-lg-6 px-0 position-relative d-flex justify-content-center align-items-center">
                        <div class="image-wrapper">
                            <img src="{{ $seasonal_banner->image }}" alt="{{ $seasonal_banner->label1 }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="best-products-section">
        <div class="container-xxl">
            <div class="row mx-auto align-items-center">
                <div class="col-12 col-lg-auto text-center text-lg-start">
                    <h3 class="section-title">Best Products</h3>
                </div>
                <div class="col d-none d-lg-block px-3">
                    <hr class="divider">
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-end mt-2 mt-lg-0">
                    <a href="{{ route('shop.index') }}" class="view-all">View All ></a>
                </div>
                <div class="col-12 mt-4 product-container p-0">
                    @foreach ($products->take(15) as $product)
                        @include('frontend.components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="review-section" id="testimonials">
        <div class="container-fluid px-md-0">
            <div class="row mx-auto">
                <div class="col-12">
                    <h2 class="section-title">Our Clients Says</h2>
                </div>
                <div class="col-12 mt-4 p-0 mt-4 mt-lg-5">
                    <div class="owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="review-card">
                                <div class="profile-image-wrapper">
                                    <img class="profile-image" src="{{ asset($testimonial->image) }}" alt="Bandara">
                                </div>
                                <h3 class="profile-name">{{ $testimonial->name }}</h3>
                                <p class="city">{{ $testimonial->location }}</p>
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="{{ $i <= $testimonial->rating ? 'star-fill' : 'star-outline' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m12 2l2.939 5.955l6.572.955l-4.756 4.635l1.123 6.545L12 17l-5.878 3.09l1.123-6.545L2.489 8.91l6.572-.955z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endfor
                                </div>
                                <p class="note">{{ $testimonial->comment }}</p>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.features-section')
@endsection

@section('scripts')
    <script>
        "use strict";
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            loop: true,
            effect: "fade",
            navigation: {
                nextEl: ".button-next",
                prevEl: ".button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    </script>
@endsection
