@forelse ($products as $product)
    <a href="{{ route('shop.detail', $product->slug) }}" class="result-card">
        <div class="image-wrapper">
            <img src="{{ asset($product->thumbnail) }}" alt="">
        </div>
        <div>
            <p class="product-name">{{ $product->name }}</p>
            <div class="d-flex align-items-center gap-2">
                <span
                    class="stock-availability {{ $product->variations[0]->stock > 0 ? 'green' : 'red' }}">{{ $product->variations[0]->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                <span class="price">LKR {{ number_format($product->variations[0]->price, 2) }}/=</span>
            </div>
        </div>
    </a>
    @if (!$loop->last)
        <hr class="divider">
    @endif
@empty
    <a class="result-card">
        <div>
            <p class="product-name">No product found</p>
        </div>
    </a>
@endforelse
