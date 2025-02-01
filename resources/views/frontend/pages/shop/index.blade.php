@extends('frontend.app')
@section('content')
    <section class="shop-hero-section">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-md-12">
                    <h2 class="section-subtitle text-center">Don't Miss This Special Opportunity Today.</h2>
                    <h1 class="section-title text-center"> {{ $title ?? 'Shop And Save Big On Hottest Products' }} </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="shop-filter-section">
        <form id="filter-form" action="{{ route('shop.index') }}" method="GET">
            <div class="container-xxl">
                <div class="row mx-auto">
                    <div class="col-12 position-relative d-flex gap-3">

                        <div class="filter-container" id="filter-container">
                            <div class="content">
                                <div class="row">

                                    <div class="col-12">
                                        <h3 class="section-title d-flex align-items-center gap-3">
                                            <svg class="my-auto" xmlns="http://www.w3.org/2000/svg" width="18px"
                                                height="18px" viewBox="0 0 20 20">
                                                <g id="settings-sliders" transform="translate(0 0)">
                                                    <path id="Path_199" data-name="Path 199"
                                                        d="M.833,3.958h2.28a3.107,3.107,0,0,0,6,0H19.167a.833.833,0,1,0,0-1.667H9.109a3.107,3.107,0,0,0-6,0H.833a.833.833,0,0,0,0,1.667ZM6.111,1.667A1.458,1.458,0,1,1,4.653,3.125,1.458,1.458,0,0,1,6.111,1.667Z"
                                                        transform="translate(0)" />
                                                    <path id="Path_200" data-name="Path 200"
                                                        d="M19.167,10.541h-2.28a3.106,3.106,0,0,0-6,0H.833a.833.833,0,0,0,0,1.667H10.892a3.106,3.106,0,0,0,5.995,0h2.28a.833.833,0,1,0,0-1.667Zm-5.278,2.292a1.458,1.458,0,1,1,1.458-1.458,1.458,1.458,0,0,1-1.458,1.458Z"
                                                        transform="translate(0 -1.375)" />
                                                    <path id="Path_201" data-name="Path 201"
                                                        d="M19.167,18.792H9.109a3.107,3.107,0,0,0-6,0H.833a.833.833,0,1,0,0,1.667h2.28a3.107,3.107,0,0,0,6,0H19.167a.833.833,0,1,0,0-1.667ZM6.111,21.083a1.458,1.458,0,1,1,1.458-1.458,1.458,1.458,0,0,1-1.458,1.458Z"
                                                        transform="translate(0 -2.75)" />
                                                </g>
                                            </svg>
                                            <span>Filter By Price</span>
                                        </h3>
                                        <div class="ps-4">
                                            <span class="filter-label">Price</span>
                                            <div class="range-slider mt-2">
                                                <div class="slider-track"></div>
                                                <div class="slider-range"></div>
                                                <input type="range" id="min-range" name="min_range" min="0"
                                                    max="1000000" value="{{ request()->min_range ?? 0 }}">
                                                <input type="range" id="max-range" name="max_range" min="0"
                                                    max="1000000" value="{{ request()->max_range ?? 1000000 }}">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="mt-3 filter-label" id="min-value">100,000</span>
                                                <span class="mt-3 filter-label text-primary" id="max-value">1,000,000</span>
                                            </div>
                                        </div>
                                        <h3 class="section-title d-flex align-items-center gap-3 mt-5">
                                            <svg id="apps" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 20 20">
                                                <path id="Path_39" data-name="Path 39"
                                                    d="M5.833,0h-2.5A3.333,3.333,0,0,0,0,3.333v2.5A3.333,3.333,0,0,0,3.333,9.167h2.5A3.333,3.333,0,0,0,9.167,5.833v-2.5A3.333,3.333,0,0,0,5.833,0ZM7.5,5.833A1.667,1.667,0,0,1,5.833,7.5h-2.5A1.667,1.667,0,0,1,1.667,5.833v-2.5A1.667,1.667,0,0,1,3.333,1.667h2.5A1.667,1.667,0,0,1,7.5,3.333Z" />
                                                <path id="Path_40" data-name="Path 40"
                                                    d="M18.833,0h-2.5A3.333,3.333,0,0,0,13,3.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,0ZM20.5,5.833A1.667,1.667,0,0,1,18.833,7.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,3.333Z"
                                                    transform="translate(-2.167)" />
                                                <path id="Path_41" data-name="Path 41"
                                                    d="M5.833,13h-2.5A3.333,3.333,0,0,0,0,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,5.833,13ZM7.5,18.833A1.667,1.667,0,0,1,5.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,7.5,16.333Z"
                                                    transform="translate(0 -2.167)" />
                                                <path id="Path_42" data-name="Path 42"
                                                    d="M18.833,13h-2.5A3.333,3.333,0,0,0,13,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,13ZM20.5,18.833A1.667,1.667,0,0,1,18.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,16.333Z"
                                                    transform="translate(-2.167 -2.167)" />
                                            </svg>
                                            <span>Shop By Category</span>
                                        </h3>

                                        <div class="accordion" id="accordionExample">
                                            @foreach ($categories as $category)
                                                <div class="accordion-item" id="category-{{ $category->id }}">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $category->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse{{ $category->id }}">
                                                            <div class="svg-icon">
                                                                {!! $category->icon !!}
                                                            </div>
                                                            <span>{{ $category->name }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $category->id }}"
                                                        class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <ul>
                                                                @foreach ($category->subcategories as $subcategory)
                                                                    <li>
                                                                        <input type="radio" class="d-none subcategory"
                                                                            name="subcategory_id"
                                                                            value="{{ $subcategory->id }}"
                                                                            id="subCategory{{ $subcategory->id }}"
                                                                            {{ request('subcategory_id') == $subcategory->id ? 'checked' : '' }}>
                                                                        <label class="w-100"
                                                                            for="subCategory{{ $subcategory->id }}">
                                                                            <span>{{ $subcategory->name }}</span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                        <h3 class="section-title d-flex align-items-center gap-3 mt-5">
                                            <svg id="apps" xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 20 20">
                                                <path id="Path_39" data-name="Path 39"
                                                    d="M5.833,0h-2.5A3.333,3.333,0,0,0,0,3.333v2.5A3.333,3.333,0,0,0,3.333,9.167h2.5A3.333,3.333,0,0,0,9.167,5.833v-2.5A3.333,3.333,0,0,0,5.833,0ZM7.5,5.833A1.667,1.667,0,0,1,5.833,7.5h-2.5A1.667,1.667,0,0,1,1.667,5.833v-2.5A1.667,1.667,0,0,1,3.333,1.667h2.5A1.667,1.667,0,0,1,7.5,3.333Z" />
                                                <path id="Path_40" data-name="Path 40"
                                                    d="M18.833,0h-2.5A3.333,3.333,0,0,0,13,3.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,0ZM20.5,5.833A1.667,1.667,0,0,1,18.833,7.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,3.333Z"
                                                    transform="translate(-2.167)" />
                                                <path id="Path_41" data-name="Path 41"
                                                    d="M5.833,13h-2.5A3.333,3.333,0,0,0,0,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,5.833,13ZM7.5,18.833A1.667,1.667,0,0,1,5.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,7.5,16.333Z"
                                                    transform="translate(0 -2.167)" />
                                                <path id="Path_42" data-name="Path 42"
                                                    d="M18.833,13h-2.5A3.333,3.333,0,0,0,13,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,13ZM20.5,18.833A1.667,1.667,0,0,1,18.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,16.333Z"
                                                    transform="translate(-2.167 -2.167)" />
                                            </svg>
                                            <span>Brands</span>
                                        </h3>
                                        <div class="ps-4">
                                            <ul>
                                                @foreach ($brands as $brand)
                                                    <li>
                                                        <label class="filter-label d-flex align-items-center gap-3"
                                                            for="brand{{ $brand->id }}">
                                                            <input type="checkbox" class="form-check-input my-auto"
                                                                name="brand[]" value="{{ $brand->id }}"
                                                                {{ is_array(request('brand')) && in_array($brand->id, request('brand')) ? 'checked' : '' }}
                                                                id="brand{{ $brand->id }}">
                                                            <span class="my-auto">{{ $brand->name }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @foreach ($variations as $variation)
                                            <h3 class="section-title d-flex align-items-center gap-3 mt-5">
                                                <svg id="apps" xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" viewBox="0 0 20 20">
                                                    <path id="Path_39" data-name="Path 39"
                                                        d="M5.833,0h-2.5A3.333,3.333,0,0,0,0,3.333v2.5A3.333,3.333,0,0,0,3.333,9.167h2.5A3.333,3.333,0,0,0,9.167,5.833v-2.5A3.333,3.333,0,0,0,5.833,0ZM7.5,5.833A1.667,1.667,0,0,1,5.833,7.5h-2.5A1.667,1.667,0,0,1,1.667,5.833v-2.5A1.667,1.667,0,0,1,3.333,1.667h2.5A1.667,1.667,0,0,1,7.5,3.333Z" />
                                                    <path id="Path_40" data-name="Path 40"
                                                        d="M18.833,0h-2.5A3.333,3.333,0,0,0,13,3.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,0ZM20.5,5.833A1.667,1.667,0,0,1,18.833,7.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,3.333Z"
                                                        transform="translate(-2.167)" />
                                                    <path id="Path_41" data-name="Path 41"
                                                        d="M5.833,13h-2.5A3.333,3.333,0,0,0,0,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,5.833,13ZM7.5,18.833A1.667,1.667,0,0,1,5.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,7.5,16.333Z"
                                                        transform="translate(0 -2.167)" />
                                                    <path id="Path_42" data-name="Path 42"
                                                        d="M18.833,13h-2.5A3.333,3.333,0,0,0,13,16.333v2.5a3.333,3.333,0,0,0,3.333,3.333h2.5a3.333,3.333,0,0,0,3.333-3.333v-2.5A3.333,3.333,0,0,0,18.833,13ZM20.5,18.833A1.667,1.667,0,0,1,18.833,20.5h-2.5a1.667,1.667,0,0,1-1.667-1.667v-2.5a1.667,1.667,0,0,1,1.667-1.667h2.5A1.667,1.667,0,0,1,20.5,16.333Z"
                                                        transform="translate(-2.167 -2.167)" />
                                                </svg>
                                                <span>{{ $variation->name }}</span>
                                            </h3>
                                            <div class="ps-4">
                                                <ul>
                                                    @foreach ($variation->values as $value)
                                                        <li>
                                                            <label class="filter-label d-flex align-items-center gap-3"
                                                                for="variation{{ $value->id }}">
                                                                <input type="checkbox" class="form-check-input my-auto"
                                                                    name="variation[]" id="variation{{ $value->id }}"
                                                                    value="{{ $value->id }}"
                                                                    {{ is_array(request('variation')) && in_array($value->id, request('variation')) ? 'checked' : '' }}>
                                                                <span class="my-auto">{{ $value->variable }}</span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach

                                        <div class="mt-5 offers-section">
                                            @foreach ($banners->where('type', 'shop_sidebar') as $banner)
                                                @include('frontend.components.offer-card')
                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="result-container ps-lg-3">
                            <div class="row position-relative align-items-center">

                                <div class="col-12 text-center col-lg-auto mt-3 mt-lg-0 order-1 order-lg-0">

                                    @php

                                        $fromCount = $products->firstItem() ?? 0;
                                        $toCount = $products->lastItem() ?? 0;

                                    @endphp

                                    <span>Showing {{ $fromCount }}-{{ $toCount }} of {{ $allProducts }}
                                        results</span>
                                </div>
                                <div class="col d-none d-lg-block px-3">
                                    <hr class="divider">
                                </div>
                                <div class="col-12 col-lg-auto order-0 order-lg-1 border border-1 rounded rounded-3">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto d-flex">
                                            <div>
                                                <select name="order_by" class="form-select filter-select">
                                                    <option value="DESC"
                                                        {{ request('order_by') == 'DESC' ? 'selected' : '' }}>Sort By
                                                        Latest</option>
                                                    <option value="ASC"
                                                        {{ request('order_by') == 'ASC' ? 'selected' : '' }}>Sort By Older
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <select name="rows" class="form-select filter-select">
                                                    <option value="8" {{ request('rows') == 8 ? 'selected' : '' }}>
                                                        Show 8</option>
                                                    <option value="16"
                                                        {{ request('rows', 16) == 16 ? 'selected' : '' }}>
                                                        Show 16</option>
                                                    <option value="24" {{ request('rows') == 24 ? 'selected' : '' }}>
                                                        Show 24</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto d-lg-none">
                                            <button type="button" class="btn border-0" onclick="toggleFilter()">
                                                <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="18px"
                                                    height="18px" viewBox="0 0 20 20">
                                                    <g id="settings-sliders" transform="translate(0 0)">
                                                        <path id="Path_199" data-name="Path 199"
                                                            d="M.833,3.958h2.28a3.107,3.107,0,0,0,6,0H19.167a.833.833,0,1,0,0-1.667H9.109a3.107,3.107,0,0,0-6,0H.833a.833.833,0,0,0,0,1.667ZM6.111,1.667A1.458,1.458,0,1,1,4.653,3.125,1.458,1.458,0,0,1,6.111,1.667Z"
                                                            transform="translate(0)" />
                                                        <path id="Path_200" data-name="Path 200"
                                                            d="M19.167,10.541h-2.28a3.106,3.106,0,0,0-6,0H.833a.833.833,0,0,0,0,1.667H10.892a3.106,3.106,0,0,0,5.995,0h2.28a.833.833,0,1,0,0-1.667Zm-5.278,2.292a1.458,1.458,0,1,1,1.458-1.458,1.458,1.458,0,0,1-1.458,1.458Z"
                                                            transform="translate(0 -1.375)" />
                                                        <path id="Path_201" data-name="Path 201"
                                                            d="M19.167,18.792H9.109a3.107,3.107,0,0,0-6,0H.833a.833.833,0,1,0,0,1.667h2.28a3.107,3.107,0,0,0,6,0H19.167a.833.833,0,1,0,0-1.667ZM6.111,21.083a1.458,1.458,0,1,1,1.458-1.458,1.458,1.458,0,0,1-1.458,1.458Z"
                                                            transform="translate(0 -2.75)" />
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 product-container px-0 px-md-auto order-last">
                                    @foreach ($products as $product)
                                        @include('frontend.components.product-card')
                                    @endforeach
                                </div>

                                @if ($products->count() <= 0)
                                    <div class="col-12 mt-4 order-last">
                                        <h5 class="text-center">No products found.</h5>
                                    </div>
                                @endif

                            </div>

                            <div class="col-12 text-center">
                                <div class="d-flex justify-content-center mt-5">
                                    {{ $products->links() }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </form>
    </section>

    @include('frontend.layouts.offers-section')
    @include('frontend.layouts.features-section')
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to check for checked subcategory and toggle accordion
            function toggleAccordionVisibility() {
                @foreach ($categories as $category)
                    (function() {
                        let categoryId = {{ $category->id }};
                        let selectedSubcategory = document.querySelector(
                            `#category-${categoryId} input:checked`);

                        // Target the category's accordion
                        let accordionCollapse = document.getElementById(`collapse${categoryId}`);

                        if (selectedSubcategory) {
                            // If subcategory is selected, open the accordion for this category
                            if (!accordionCollapse.classList.contains('show')) {
                                new bootstrap.Collapse(accordionCollapse, {
                                    toggle: true
                                });
                            }
                        } else {
                            // If no subcategory is selected, collapse the accordion for this category
                            if (accordionCollapse.classList.contains('show')) {
                                new bootstrap.Collapse(accordionCollapse, {
                                    toggle: false
                                });
                            }
                        }
                    })();
                @endforeach
            }

            // Call the function to set the initial visibility on page load
            toggleAccordionVisibility();

            // Add event listener to handle changes when selecting a subcategory
            document.querySelectorAll('.subcategory').forEach(radio => {
                radio.addEventListener('change', toggleAccordionVisibility);
            });
        });
    </script>


    <script>
        const minRange = document.getElementById('min-range');
        const maxRange = document.getElementById('max-range');
        const sliderRange = document.querySelector('.slider-range');
        const minValueLabel = document.getElementById('min-value');
        const maxValueLabel = document.getElementById('max-value');
        const minGap = 1000; // Minimum gap between min and max values
        const max = parseInt(maxRange.max);

        function updateSlider() {
            const minValue = parseInt(minRange.value);
            const maxValue = parseInt(maxRange.value);

            // Enforce minimum gap
            if (maxValue - minValue < minGap) {
                if (this === minRange) {
                    minRange.value = maxValue - minGap;
                } else {
                    maxRange.value = minValue + minGap;
                }
            }

            // Update slider range styles
            const minPercent = (minRange.value / max) * 100;
            const maxPercent = (maxRange.value / max) * 100;

            sliderRange.style.left = minPercent + '%';
            sliderRange.style.width = (maxPercent - minPercent) + '%';

            // Update dynamic labels
            minValueLabel.textContent = parseInt(minRange.value).toLocaleString();
            maxValueLabel.textContent = parseInt(maxRange.value).toLocaleString();
        }

        minRange.addEventListener('input', updateSlider);
        maxRange.addEventListener('input', updateSlider);

        minRange.addEventListener('change', submitFilter);
        maxRange.addEventListener('change', submitFilter);

        // Initialize slider positions
        updateSlider();

        document.getElementById('filter-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('filter-container')) {
                e.target.classList.toggle('m-view');
            }
        });

        function toggleFilter() {
            document.getElementById('filter-container').classList.toggle('m-view');
        }

        document.querySelectorAll('input').forEach(item => {
            item.addEventListener('change', submitFilter);
        })

        document.querySelectorAll('select').forEach(item => {
            item.addEventListener('change', submitFilter);
        })

        function submitFilter() {
            document.getElementById('filter-form').submit();
        }
    </script>
@endsection
