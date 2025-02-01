<div class="product-card card">
    <a href="{{ route('shop.detail', $product->slug) }}">
        <div class="card-header">
            <h5 class="card-title">{{ $product->name }}</h5>
        </div>
        <div class="card-body">
            <div class="position-relative">
                <img src="{{ asset($product->thumbnail) }}" alt="Card image" class="card-img-top">
                @if ($product->totalStock() <= 0)
                    <p class="out-of-stock-label">Out of Stock</p>
                @endif
            </div>
            <div class="details">
                <span class="price-value">LKR {{ number_format($product->variations[0]->price) }}</span>
                <p class="warranty">{{ $product->warranty_period }}
                    @if ($product->warranty_period)
                        Warranty
                    @endif
                </p>
            </div>
        </div>
        <div class="card-footer">
            <a type="button"
                href="{{ $product->attributes()->count() >= 1 ? route('shop.detail', $product->slug) : 'javascript:void(0);' }}"
                class="btn primary-btn mb-2 {{ $product->totalStock() <= 0 ? 'disabled' : '' }}"
                data-variation-id="{{ $product->variations[0]->id ?? '' }}"
                @if ($product->totalStock() > 0 && $product->attributes()->count() == 0) onclick="addToCart(this)" @endif>
                <p class="w-100">
                    {{ $product->attributes()->count() >= 1 ? 'Select Options' : 'Add to Cart' }}
                </p>

                <div class="icon-box">
                    <svg id="shopping-cart" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 20 20">
                        <g id="shopping-cart-2" data-name="shopping-cart">
                            <path id="Path_43" data-name="Path 43"
                                d="M18.927,3.4a2.494,2.494,0,0,0-1.919-.9H3.535L3.5,2.207A2.5,2.5,0,0,0,1.018,0H.833a.833.833,0,0,0,0,1.667h.185a.833.833,0,0,1,.827.736l1.147,9.75a4.167,4.167,0,0,0,4.138,3.681h8.7a.833.833,0,0,0,0-1.667h-8.7A2.5,2.5,0,0,1,4.781,12.5h9.933a4.167,4.167,0,0,0,4.1-3.428l.654-3.628A2.5,2.5,0,0,0,18.927,3.4ZM17.833,5.148l-.655,3.628a2.5,2.5,0,0,1-2.464,2.057H4.516L3.732,4.167H17.008a.833.833,0,0,1,.825.982Z"
                                transform="translate(0)" fill="#fff" />
                            <circle id="Ellipse_2" data-name="Ellipse 2" cx="1.667" cy="1.667" r="1.667"
                                transform="translate(4.167 16.667)" fill="#fff" />
                            <circle id="Ellipse_3" data-name="Ellipse 3" cx="1.667" cy="1.667" r="1.667"
                                transform="translate(12.5 16.667)" fill="#fff" />
                        </g>
                        <g id="Frame_Icon" data-name="Frame Icon" transform="translate(0)">
                            <rect id="Rectangle_1" data-name="Rectangle 1" width="20" height="20"
                                fill="none" />
                        </g>
                    </svg>
                </div>
            </a>
            <a href="{{ $product->attributes()->count() >= 1 ? route('shop.detail', $product->slug) : route('checkout.quickBuy', ['slug' => $product->slug, 'id' => $product->variations[0]->id]) }}"
                type="button" class="btn secondary-btn {{ $product->totalStock() <= 0 ? 'disabled' : '' }}">
                <p class="w-100">Quick Buy</p>
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16.796" height="24.751" viewBox="0 0 16.796 24.751">
                        <path id="bolt"
                            d="M11.737,24A1.752,1.752,0,0,1,11,23.835a1.687,1.687,0,0,1-.93-2.03L11.827,16H6.5a2.5,2.5,0,0,1-2.393-3.224L7.13,1.788A2.49,2.49,0,0,1,9.526,0H13.9a2.1,2.1,0,0,1,1.966,2.835L13.705,9H17.5a2.5,2.5,0,0,1,2.069,3.9l-6.41,10.312A1.7,1.7,0,0,1,11.737,24ZM9.527,1A1.491,1.491,0,0,0,8.091,2.066L5.069,13.054A1.5,1.5,0,0,0,6.5,15h6a.5.5,0,0,1,.478.644l-1.947,6.442a.716.716,0,0,0,1.287.587l6.412-10.315A1.5,1.5,0,0,0,17.5,10H13a.5.5,0,0,1-.472-.666l2.4-6.84A1.1,1.1,0,0,0,13.9,1H9.526Z"
                            transform="translate(-3.613 0.375)" fill="#fff" stroke="#fff" stroke-width="0.75" />
                    </svg>
                </div>
            </a>
        </div>
    </a>
</div>
