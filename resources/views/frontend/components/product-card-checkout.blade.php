@if ($cart_product)
    <div id="cart-item-{{ $cart_product->id }}" class="cart-item">
        <div class="item-close">
            <button type="button" class="btn btn-close" onclick="removeCartItem({{ $cart_product->id }},this)"></button>
        </div>
        <div class="item-image">
            <img src="{{ asset($cart_product->productVariation->product->thumbnail) }}" alt="item">
        </div>
        <div class="item-details flex-grow-1">
            <h4 class="item-title">{{ $cart_product->productVariation->product->name }}</h4>
            <span class="item-color">
                @foreach ($cart_product->productVariation->values as $type)
                    {{ $type->variationValue->variable }}
                @endforeach
            </span>
            @php
                $cart_product->productVariation->stock >= $cart_product->qty
                    ? ($qty = $cart_product->qty)
                    : ($qty = $cart_product->productVariation->stock);
            @endphp
            <div class="d-flex align-items-center justify-content-between gap-1 mt-2">
                <p class="item-price">Rs {{ number_format($cart_product->productVariation->price * $qty, 2) }}</p>
                <div class="item-quantity">
                    <input type="hidden" class="price" value="{{ $cart_product->productVariation->price }}">
                    <input type="hidden" class="item-id" value="{{ $cart_product->id }}">
                    <button type="button" class="btn btn-minus">-</button>
                    <input type="number" class="quantity" value="{{ $qty }}" min="1"
                        max="{{ $cart_product->productVariation->stock }}" readonly>
                    <button type="button" class="btn btn-plus">+</button>
                </div>
            </div>
        </div>
    </div>
@else
    <div>
        <p>Product not found in the cart.</p>
    </div>
@endif
