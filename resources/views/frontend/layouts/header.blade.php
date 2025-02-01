<header>
    <section class="">
        <div class="container">
            <div class="row align-items-center py-0 py-lg-2 mx-auto">

                <div class="col-auto flex-grow-1 col-lg-3 order-0">
                    <div class="d-inline">
                        <a href="/">
                            <img class="logo" src="{{ $site_light_logo }}" alt="logo">
                        </a>
                    </div>
                </div>

                <div class="col-auto col-lg-3 text-end order-1">
                    <div onclick="cartToggle();"
                        class="cart-detail d-inline-flex justify-content-end align-items-center gap-4"
                        id="header-cart-detail">
                        <div class="position-relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="31.001" height="33.459"
                                viewBox="0 0 31.001 33.459">
                                <g id="bag-outline" transform="translate(0.75 0.75)">
                                    <path id="Path_3" data-name="Path 3"
                                        d="M65.229,176A1.229,1.229,0,0,0,64,177.229v16.594a4.372,4.372,0,0,0,4.3,4.3H89.2a4.289,4.289,0,0,0,4.3-4.206v-16.69A1.229,1.229,0,0,0,92.271,176Z"
                                        transform="translate(-64 -166.166)" fill="none" stroke="#000"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        fill-rule="evenodd" />
                                    <path id="Path_4" data-name="Path 4"
                                        d="M160,57.834V55.375A7.375,7.375,0,0,1,167.375,48h0a7.375,7.375,0,0,1,7.375,7.375v2.458"
                                        transform="translate(-152.625 -48)" fill="none" stroke="#000"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        fill-rule="evenodd" />
                                </g>
                            </svg>
                            <div class="cart-qty">
                                <span id="header-cart-qty">{{ $cartProducts->count() }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-center flex-column gap-0">
                            <span class="total-label">Total</span>
                            <p class="total-price" id="header-cart-total">Rs {{ number_format($cartTotal, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="col-12 col-lg-6 position-relative mt-2 mt-lg-0 order-last order-lg-0 d-flex justify-content-between gap-3">

                    <button class="menu-btn d-lg-none" onclick="toggleNavBar();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 512 512">
                            <path fill="black"
                                d="M0 96c0-17.7 14.3-32 32-32h384c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32m64 160c0-17.7 14.3-32 32-32h384c17.7 0 32 14.3 32 32s-14.3 32-32 32H96c-17.7 0-32-14.3-32-32m384 160c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32h384c17.7 0 32 14.3 32 32">
                            </path>
                        </svg>
                    </button>

                    <div class="input-group search-group">
                        <div class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="search"
                                    d="M63.755,62.394l-3.627-3.627a6.742,6.742,0,1,0-1.361,1.361l3.627,3.627a.964.964,0,0,0,1.361-1.361Zm-13.83-7.659a4.811,4.811,0,1,1,4.811,4.811A4.811,4.811,0,0,1,49.924,54.735Z"
                                    transform="translate(-48 -48)" fill="#7f7f7f" />
                            </svg>
                        </div>
                        <input onkeyup="searchResult();" type="text" class="form-control" id="main-search"
                            name="search" placeholder="Search here" value="{{ request('search') }}" autocomplete="off"
                            onfocusout="searchEnd(event);">
                        <button onclick="searchResult();" type="submit" class="btn  primary-gradiant-btn">
                            Search
                        </button>
                    </div>
                    <div class="search-result" id="searchResult">

                    </div>
                </div>


            </div>
        </div>
    </section>
</header>
<section class="navbar-section" id="navbar">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="main-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/shop">Shop</a></li>
                    <li>
                        <div class="btn-group smartphone">
                            <button type="button" class="btn btn-danger dropdown-toggle smartphone"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Mobile Phones
                            </button>

                            <div class="dropdown-menu brand-menu">
                                <div class="dropdown-icon">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 21 18"
                                        style="enable-background:new 0 0 21 18;" xml:space="preserve">
                                        <g>
                                            <g id="Layer_1_00000063625231363251659210000011243686466390170773_">
                                                <g id="Layer_1-2">
                                                    <g>
                                                        <path fill="none"
                                                            d="M20.13,17.5H0.87L10.5,0.99C10.5,0.99,20.13,17.5,20.13,17.5z" />
                                                        <path fill="#BEBEBE";
                                                            d="M10.5,1.98L1.74,17h17.52L10.5,1.98 M10.5,0L21,18H0L10.5,0z" />
                                                    </g>
                                                </g>
                                                <path fill="#FFFFFF"; d="M19.92,18H1.14l9.39-16.02L19.92,18z" />
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="brand-container">

                                    @foreach ($brands as $brand)
                                        <a href="{{ route('shop.index') }}?brand[]={{ $brand->id }}"
                                            class="brand-wrapper">
                                            <img src="{{ asset($brand->icon) }}" alt="">
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Accessories
                            </button>
                            <div class="dropdown-menu">
                                <ul class="menu">
                                    @foreach ($accessories as $accessory)
                                        <li><a class="dropdown-item"
                                                href="{{ route('shop.index') }}?subcategory_id={{ $accessory->id }}">{{ $accessory->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<aside class="navbar-offcanvas" id="navbar-offcanvas">
    <div class="content">
        <div class="row">
            <div class="col-12 navbar-header">
                <a href="/">
                    <img class="logo" src="{{ asset('assets/frontend/images/logo/invoice.png') }}" alt="logo">
                </a>
            </div>
            <div class="col-12">
                <ul class="menu px-3">
                    <li><a href="/">Home</a></li>
                    <li>
                        <div class="accordion smartphones" id="accordion1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#smartphones" aria-expanded="false"
                                        aria-controls="smartphones">
                                        Mobile Phones
                                    </button>
                                </h2>
                                <div id="smartphones" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        @foreach ($brands as $brand)
                                            <div>
                                                <a href="{{ route('shop.index') }}?brand[]={{ $brand->id }}"
                                                    class="brand-wrapper">
                                                    <img src="{{ asset($brand->icon) }}" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="/shop">Shop</a></li>
                    <li>
                        <div class="accordion" id="accordion2">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#accessories" aria-expanded="false"
                                        aria-controls="accessories">
                                        Accessories
                                    </button>
                                </h2>
                                <div id="accessories" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($accessories as $accessory)
                                                <li><a class="dropdown-item"
                                                        href="{{ route('shop.index') }}?subcategory_id={{ $accessory->id }}">{{ $accessory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</aside>
