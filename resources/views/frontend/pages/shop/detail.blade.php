@extends('frontend.app')
@section('content')
    <section class="view-product-section">
        <div class="container">
            <div class="row mx-auto">

                <style>
                    .view-product-section .thumbnail_slider {
                        max-width: 700px;
                        margin: 30px auto;
                    }

                    .view-product-section .splide__slide {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 400px;
                        width: 580px;
                        overflow: hidden;
                        transition: .2s;
                        border-width: 2px !important;
                        margin-bottom: 10px;
                    }

                    .view-product-section .splide--fade>.splide__track>.splide__list>.splide__slide {
                        border-radius: 6px !important;
                    }

                    .view-product-section .splide--nav>.splide__track>.splide__list>.splide__slide.is-active {
                        border: 1px solid var(--border-color) !important;
                        border-radius: 6px !important;
                    }

                    .view-product-section .splide__slide img {
                        width: auto;
                        height: auto;
                        margin: auto;
                        display: block;
                        max-width: 100%;
                        max-height: 100%;
                        border-radius: 6px !important;
                    }

                    .splide__arrow {
                        background-color: rgba(190, 190, 190, 0.1) !important;
                    }
                </style>

                <div class="col-12 col-lg-7">

                    <div class="thumbnail_slider">
                        <div id="primary_slider">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide" onclick="viewImage(this);">
                                        <img src="{{ asset($product->thumbnail) }}">
                                    </li>
                                    @foreach ($product->galleries as $gallery)
                                        <li class="splide__slide" onclick="viewImage(this);">
                                            <img src="{{ asset($gallery->image) }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div id="thumbnail_slider">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide">
                                        <img src="{{ asset($product->thumbnail) }}">
                                    </li>
                                    @foreach ($product->galleries as $gallery)
                                        <li class="splide__slide">
                                            <img src="{{ asset($gallery->image) }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- Thumbnal Slider End-->
                    </div>

                </div>

                <div class="col-12 col-lg-5 mt-5 mt-lg-0">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <span class="stock-availability @if ($product->variations[0]->stock <= 0) red @else green @endif"
                        id="availability">{{ $product->variations[0]->stock <= 0 ? 'Out Of Stock' : 'In Stock' }}</span>
                    <a href="#reviews-section">
                        <div class="d-xl-inline-block mt-3 mt-xl-0 ms-xl-3">
                            @php
                                $averageRating = round($product->reviews->avg('rating'));
                                $maxStars = 5;
                            @endphp

                            <div class="stars">
                                @for ($i = 1; $i <= $maxStars; $i++)
                                    @if ($i <= $averageRating)
                                        <div class="star-fill">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m12 2l2.939 5.955l6.572.955l-4.756 4.635l1.123 6.545L12 17l-5.878 3.09l1.123-6.545L2.489 8.91l6.572-.955z">
                                                </path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="star-outline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m12 2l2.939 5.955l6.572.955l-4.756 4.635l1.123 6.545L12 17l-5.878 3.09l1.123-6.545L2.489 8.91l6.572-.955z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                @endfor
                            </div>

                            <span class="rating">{{ $product->reviewRate() }}</span>
                            <span class="rating-count">({{ $product->reviews->where('status', 'Active')->count() }}
                                Reviews)</span>
                        </div>
                    </a>

                    <p id="product-price" class="price my-4">RS {{ number_format($product->variations[0]->price, 2) }}/=</p>
                    <input type="hidden" id="original-price" value="{{ $product->variations[0]->price }}">

                    @if ($product->warranty_info)
                        <div class="warrenty-card mb-4">
                            <p class="warrenty-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20"
                                    viewBox="0 0 19.748 20.585">
                                    <path id="features-alt"
                                        d="M4.668,14.831a.792.792,0,0,0,1.352-.561v-3.44a2.929,2.929,0,1,0-4.184,0v3.44a.792.792,0,0,0,1.367.545l.724-.8.739.817ZM1.837,8.787A2.092,2.092,0,1,1,3.929,10.88,2.095,2.095,0,0,1,1.837,8.787Zm.837,5.368V11.423a2.829,2.829,0,0,0,2.511,0v2.732L4.239,13.11a.43.43,0,0,0-.621,0Zm5.021,2.164a.419.419,0,0,1,.418-.418h7.532a.418.418,0,1,1,0,.837H8.113A.419.419,0,0,1,7.695,16.319ZM8.95,10.043a.418.418,0,0,1,0-.837h6.695a.418.418,0,0,1,0,.837Zm-.837,2.511h7.532a.418.418,0,1,1,0,.837H8.113a.418.418,0,1,1,0-.837ZM18.655,4.51,15.738,1.594A5.4,5.4,0,0,0,11.892,0H7.276A3.771,3.771,0,0,0,3.51,3.767a.418.418,0,1,0,.837,0A2.932,2.932,0,0,1,7.276.838h4.615a4.641,4.641,0,0,1,.824.08V5.441a2.1,2.1,0,0,0,2.092,2.092h4.522a4.656,4.656,0,0,1,.08.824V16.32a2.932,2.932,0,0,1-2.929,2.929H7.276a2.927,2.927,0,0,1-2.837-2.2.419.419,0,0,0-.811.209,3.764,3.764,0,0,0,3.647,2.824h9.206a3.771,3.771,0,0,0,3.766-3.766V8.357A5.408,5.408,0,0,0,18.654,4.51ZM14.808,6.7A1.257,1.257,0,0,1,13.553,5.44V1.154a4.586,4.586,0,0,1,1.593,1.031L18.063,5.1a4.58,4.58,0,0,1,1.03,1.593H14.808Z"
                                        transform="translate(-0.749 0.249)" fill="#0db5ab" stroke="#0db5ab"
                                        stroke-width="0.5" />
                                </svg>
                                <span>Warranty</span>
                            </p>
                            <p class="warrenty-description">
                                {{ $product->warranty_info }}
                            </p>
                        </div>
                    @endif

                    <form id="variation-form" action="{{ route('shop.product.price.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="product_variation_id" name="product_variation_id"
                            value="{{ $product->variations[0]->id }}">
                        <div class="row variation-container" id="variation-container">
                            @if ($product->attributes()->count() >= 1)
                                <style>
                                    .variations-container {
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 12px;
                                        background-color: #fff;
                                    }

                                    .variation {
                                        padding: 8px 10px;
                                        border-radius: 8px;
                                        white-space: nowrap;
                                        overflow: hidden text-overflow: ellipsis;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 1px;
                                        border: 1px solid #EEEEEE;
                                        background-color: #fff;
                                        cursor: pointer;
                                    }

                                    .variation.selected,
                                    .variation:hover,
                                    .variation:focus,
                                    .variation:active {
                                        border: 1px solid #c0c0c0;
                                        background-color: #F2F2F2;
                                    }

                                    .variation .color {
                                        width: 24px;
                                        height: 24px;
                                        border: 1px solid #fff;
                                        border-radius: 4px;
                                        display: inline-block;
                                        margin-right: 8px !important;
                                        outline: 1px solid;
                                    }

                                    .variation span {
                                        font-size: 14px;
                                        color: #6A6A6A;
                                        text-transform: uppercase;
                                        font-weight: 500;
                                    }
                                </style>

                                <div class="col-12 variations-container">
                                    @foreach ($product->variations as $variation)
                                        <div class="variation @if ($variation->id == $product->variations[0]->id) selected @endif"
                                            data-id="{{ $variation->id }}" data-price="{{ $variation->price }}"
                                            data-max-qty="{{ $variation->stock }}" onclick="changeAttributesValues(this)">
                                            @foreach ($variation->values as $value)
                                                @if (stripos($value->variationValue->variationName->name, 'Color') !== false ||
                                                        stripos($value->variationValue->variationName->name, 'Colour') !== false)
                                                    <div class="color"
                                                        style="background-color: {{ $value->variationValue->color }}; outline-color: {{ $value->variationValue->color }};">
                                                    </div>
                                                @endif
                                                <span>{{ $value->variationValue->variable }}</span>
                                                @if (!$loop->last)
                                                    &nbsp;|&nbsp;
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="col-12">
                                <label class="form-label" for="qty">Select Quantity</label>
                                <div class="d-flex align-items-center gap-1">
                                    <button type="button" class="btn" onclick="changeQty('-');">-</button>
                                    <input type="number" class="form-control" name="qty" id="qty" min="1"
                                        max="{{ $product->variations[0]->stock }}"
                                        value="{{ $product->variations[0]->stock > 0 ? 1 : 0 }}" readonly>
                                    <button type="button" class="btn" onclick="changeQty('+');">+</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="btn-controllers mt-4">
                        <div class="d-flex align-items-center justify-content-start gap-3">
                            <button id="detail-addtocart-btn" class="btn primary-btn d-inline-flex"
                                onclick="addToCart(this)" @if ($product->variations[0]->stock <= 0) disabled @endif>
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24"
                                    width="22" height="22">
                                    <circle fill="white" cx="7" cy="22" r="2" />
                                    <circle fill="white" cx="17" cy="22" r="2" />
                                    <path fill="white"
                                        d="M23,3H21V1a1,1,0,0,0-2,0V3H17a1,1,0,0,0,0,2h2V7a1,1,0,0,0,2,0V5h2a1,1,0,0,0,0-2Z" />
                                    <path fill="white"
                                        d="M21.771,9.726a.994.994,0,0,0-1.162.806A3,3,0,0,1,17.657,13H5.418l-.94-8H13a1,1,0,0,0,0-2H4.242L4.2,2.648A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.829-2H17.657a5,5,0,0,0,4.921-4.112A1,1,0,0,0,21.771,9.726Z" />
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                            <div class="d-inline-flex align-items-center justify-content-center gap-2 my-auto">
                                <button class="btn share-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                        height="22">
                                        <g id="_01_align_center" data-name="01 align center">
                                            <path fill="black"
                                                d="M19.333,14.667a4.66,4.66,0,0,0-3.839,2.024L8.985,13.752a4.574,4.574,0,0,0,.005-3.488l6.5-2.954a4.66,4.66,0,1,0-.827-2.643,4.633,4.633,0,0,0,.08.786L7.833,8.593a4.668,4.668,0,1,0-.015,6.827l6.928,3.128a4.736,4.736,0,0,0-.079.785,4.667,4.667,0,1,0,4.666-4.666ZM19.333,2a2.667,2.667,0,1,1-2.666,2.667A2.669,2.669,0,0,1,19.333,2ZM4.667,14.667A2.667,2.667,0,1,1,7.333,12,2.67,2.67,0,0,1,4.667,14.667ZM19.333,22A2.667,2.667,0,1,1,22,19.333,2.669,2.669,0,0,1,19.333,22Z" />
                                        </g>
                                    </svg>
                                </button>
                                <span>Share</span>
                            </div>
                        </div>

                        <a type="button"
                            href="{{ route('checkout.quickBuy', ['slug' => $product->slug, 'id' => $product->variations[0]->id]) }}"
                            id="quick-buy" class="btn secondary-btn mt-2"
                            @if ($product->variations[0]->stock <= 0) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                viewBox="0 0 24 24" width="22" height="22">
                                <path fill="white"
                                    d="M11.24,24a2.262,2.262,0,0,1-.948-.212,2.18,2.18,0,0,1-1.2-2.622L10.653,16H6.975A3,3,0,0,1,4.1,12.131l3.024-10A2.983,2.983,0,0,1,10,0h3.693a2.6,2.6,0,0,1,2.433,3.511L14.443,8H17a3,3,0,0,1,2.483,4.684l-6.4,10.3A2.2,2.2,0,0,1,11.24,24ZM10,2a1,1,0,0,0-.958.71l-3.024,10A1,1,0,0,0,6.975,14H12a1,1,0,0,1,.957,1.29L11.01,21.732a.183.183,0,0,0,.121.241A.188.188,0,0,0,11.4,21.9l6.4-10.3a1,1,0,0,0,.078-1.063A.979.979,0,0,0,17,10H13a1,1,0,0,1-.937-1.351l2.19-5.84A.6.6,0,0,0,13.693,2Z" />
                            </svg>
                            <span>Quick Buy</span>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="product-description-section">
        <div class="container-xxl">
            <div class="row mx-auto">
                <div class="col-12">
                    <h3 class="section-title">Description</h3>

                    <div class="overflow-x-auto w-100">
                        {!! $product->description !!}
                    </div>


                </div>
            </div>
        </div>
    </section>

    <section id="reviews-section" class="product-review-section">
        <div class="container">
            <div class="row mx-auto">

                <div class="col-12 col-lg-6">
                    <div class="row align-items-center">

                        <div class="col-auto">
                            <h3 class="section-title d-inline">Reviews</h3>
                            <span class="review-count">({{ $reviews->count() }})</span>
                        </div>
                        <div class="col d-none d-lg-block px-3">
                            <hr class="divider">
                        </div>

                        <div class="col-12 mt-4 px-4">
                            <div class="row">

                                @foreach ($reviews->paginate(5) as $review)
                                    <div class="col-12">
                                        <div class="review-card">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="image-wrapper">
                                                    <img src="https://api.dicebear.com/9.x/initials/svg?seed={{ $review->name }}"
                                                        alt="{{ $review->name }}">
                                                </div>
                                                <div class="d-inline-flex h-100 flex-column align-content-between">
                                                    <p class="name">{{ $review->name }}</p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="stars">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <div
                                                                    class="{{ $i < $review->rating ? 'star-fill' : 'star-outline' }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14px"
                                                                        height="14px" viewBox="0 0 24 24">
                                                                        <path fill="none" stroke="currentColor"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m12 2l2.939 5.955l6.572.955l-4.756 4.635l1.123 6.545L12 17l-5.878 3.09l1.123-6.545L2.489 8.91l6.572-.955z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <p class="m-0"
                                                            style="font-size: 11px; color: var(--text-gray-color);">
                                                            {{ $review->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="review-text">
                                                {{ $review->comment }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="pagination-container mt-4">
                                    {{ $reviews->paginate(5)->links() }}
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <div class="add-review-card">
                        <h3 class="section-title">Add A Review</h3>
                        <p class="section-description">Your Email Address Will Not Be Published.</p>

                        <div class="stars d-flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="star" data-value="{{ $i }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m12 2l2.939 5.955l6.572.955l-4.756 4.635l1.123 6.545L12 17l-5.878 3.09l1.123-6.545L2.489 8.91l6.572-.955z">
                                        </path>
                                    </svg>
                                </div>
                            @endfor
                        </div>

                        <form id="reviewForm" action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', session('name')) }}" placeholder="Name">
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', session('email')) }}" placeholder="Email">
                            <input type="hidden" name="rating" id="rating-input" value="">
                            <textarea class="form-control" name="comment" cols="30" rows="10" placeholder="Comment"></textarea>

                            <div class="d-flex gap-3">
                                <input type="checkbox" class="form-check-input" id="save-my-details" name="save_details"
                                    style="font-size: 14px;">
                                <label for="save-my-details" style="font-size: 14px;">
                                    Save My Name and Email In This Browser For The Next Time I Comment.
                                </label>
                            </div>

                            <button type="submit" class="btn secondary-gradiant-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24"
                                    width="22" height="22">
                                    <path fill="white"
                                        d="M23.119.882a2.966,2.966,0,0,0-2.8-.8l-16,3.37a4.995,4.995,0,0,0-2.853,8.481L3.184,13.65a1,1,0,0,1,.293.708v3.168a2.965,2.965,0,0,0,.3,1.285l-.008.007.026.026A3,3,0,0,0,5.157,20.2l.026.026.007-.008a2.965,2.965,0,0,0,1.285.3H9.643a1,1,0,0,1,.707.292l1.717,1.717A4.963,4.963,0,0,0,15.587,24a5.049,5.049,0,0,0,1.605-.264,4.933,4.933,0,0,0,3.344-3.986L23.911,3.715A2.975,2.975,0,0,0,23.119.882ZM4.6,12.238,2.881,10.521a2.94,2.94,0,0,1-.722-3.074,2.978,2.978,0,0,1,2.5-2.026L20.5,2.086,5.475,17.113V14.358A2.978,2.978,0,0,0,4.6,12.238Zm13.971,7.17a3,3,0,0,1-5.089,1.712L11.762,19.4a2.978,2.978,0,0,0-2.119-.878H6.888L21.915,3.5Z" />
                                </svg>
                                <span>Add Review</span>
                            </button>

                            <div class="mt-2">
                                <p><small id="review-success" class="text-success"></small></p>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="related-products-section">
        <div class="container px-0">
            <div class="row mx-auto">
                <div class="col-12">
                    <h3 class="section-title">Related Product</h3>
                </div>
                <div class="col-12 product-container">
                    @foreach ($related_products as $product)
                        @include('frontend.components.product-card')
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <a href="" id="image-full-view" data-fancybox="gallery">
    </a>

    @include('frontend.layouts.offers-section')
    @include('frontend.layouts.features-section')
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.2.0/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.2.0/dist/js/splide.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
        integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        'use strict';

        var primarySlider = new Splide('#primary_slider', {
            type: 'fade',
            heightRatio: 0.5,
            pagination: false,
            arrows: false,
            cover: false,
        });

        var thumbnailSlider = new Splide('#thumbnail_slider', {
            rewind: true,
            fixedWidth: 100,
            fixedHeight: 64,
            isNavigation: true,
            gap: 10,
            focus: 'center',
            pagination: false,
            cover: false,
            breakpoints: {
                '600': {
                    fixedWidth: 66,
                    fixedHeight: 40,
                }
            }
        }).mount();

        primarySlider.sync(thumbnailSlider).mount();

        function viewImage(element) {
            let image = $(element).find('img').attr('src');
            $('#image-full-view').attr('href', image);
            $('#image-full-view').trigger('click');
        }
    </script>

    <script>
        'use strict';

        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("rating-input");

        stars.forEach((star, index) => {
            star.addEventListener("click", () => {
                const ratingValue = index + 1;
                ratingInput.value = ratingValue;

                stars.forEach((s, i) => {
                    if (i < ratingValue) {
                        s.classList.add("active");
                    } else {
                        s.classList.remove("active");
                    }
                });
            });
        });


        // change attributes
        function changeAttributesValues(element) {

            var attributePrice = element.getAttribute('data-price');
            var attributeMaxQty = element.getAttribute('data-max-qty');
            var productVariationIdInput = document.getElementById('product_variation_id');

            productVariationIdInput.value = element.getAttribute('data-id');

            updatePrice(attributePrice);

            document.querySelectorAll('.variation').forEach(attribute => {
                attribute.classList.remove('selected');
            });


            element.classList.add('selected');

            document.getElementById('quick-buy').href = '/quick-buy/' + element.getAttribute('data-slug') + '/' + element
                .getAttribute('data-id');

            let qty = document.getElementById('qty');
            let availability = document.getElementById('availability');
            let addToCartBtn = document.getElementById('detail-addtocart-btn');
            let quickBuyBtn = document.getElementById('quick-buy');

            if (attributeMaxQty > 0) {
                qty.value = Math.min(qty.value, attributeMaxQty) || 1;
                qty.max = attributeMaxQty;
                availability.innerHTML = 'In Stock';
                availability.classList.replace('red', 'green');
                addToCartBtn.removeAttribute('disabled');
                quickBuyBtn.removeAttribute('disabled');
            } else {
                qty.value = qty.max = 0;
                availability.innerHTML = 'Out of Stock';
                availability.classList.replace('green', 'red');
                addToCartBtn.setAttribute('disabled', true);
                quickBuyBtn.setAttribute('disabled', true);
            }

        }

        var reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                fetch(reviewForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            reviewForm.reset();
                            document.getElementById('review-success').textContent = data.message;
                        }
                        showToast(data.message);
                    })
            })
        }
    </script>
@endsection
