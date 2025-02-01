<section class="offers-section">
    <div class="container">
        <div class="row mx-auto g-2">

            <div class="col-12">
                <h3 class="section-title text-center">Special Offers and Discount</h3>
            </div>
            @foreach ($banners->where('type', 'bottom_bar') as $bottomBanner)
                <div class="col-6 col-lg-3 p-1 p-lg-3">
                    <a href="{{ $bottomBanner->url }}">
                        <div class="card">
                            <img src="{{ asset($bottomBanner->image) }}" alt="{{ $bottomBanner->title }}">
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</section>
