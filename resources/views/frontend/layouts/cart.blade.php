<div class="sidecart" id="sidecart">
    <div class="cart-container">
        <div class="cart-content">
            <div class="cart-header">
                <h3 class="title">Shopping Cart</h3>
                <div class="cart-close"><button class="btn btn-close" onclick="cartToggle();"></button></div>
            </div>
            <div id="cart-items" class="cart-items">
                @foreach ($cartProducts as $cart_product)
                    @include('frontend.components.product-card-checkout')
                @endforeach
            </div>
            <div class="cart-footer">
                <div class="total-display">
                    <p class="total-label">Total</p>
                    <p class="sub-total" id="sidebar-cart-total">Rs {{ number_format($cartTotal, 2) }}</p>
                </div>
                <a type="button" href="{{ route('checkout.index') }}" class="btn primary-gradiant-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 56 56">
                        <path fill="currentColor"
                            d="M20.008 39.649H47.36c.913 0 1.71-.75 1.71-1.758s-.797-1.758-1.71-1.758H20.406c-1.336 0-2.156-.938-2.367-2.367l-.375-2.461h29.742c3.422 0 5.18-2.11 5.672-5.461l1.875-12.399a7 7 0 0 0 .094-.89c0-1.125-.844-1.899-2.133-1.899H14.641l-.446-2.976c-.234-1.805-.89-2.72-3.28-2.72H2.687c-.937 0-1.734.822-1.734 1.76c0 .96.797 1.781 1.735 1.781h7.921l3.75 25.734c.493 3.328 2.25 5.414 5.649 5.414m31.054-25.454L49.4 25.422c-.188 1.453-.961 2.344-2.344 2.344l-29.906.023l-1.993-13.594ZM21.86 51.04a3.766 3.766 0 0 0 3.797-3.797a3.78 3.78 0 0 0-3.797-3.797c-2.132 0-3.82 1.688-3.82 3.797c0 2.133 1.688 3.797 3.82 3.797m21.914 0c2.133 0 3.82-1.664 3.82-3.797c0-2.11-1.687-3.797-3.82-3.797c-2.109 0-3.82 1.688-3.82 3.797c0 2.133 1.711 3.797 3.82 3.797">
                        </path>
                    </svg>
                    <span>Proccess To Checkout</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function reloadCartFunction() {

        document.querySelectorAll('.cart-item .item-quantity .btn').forEach(button => {
            button.addEventListener('click', function(event) {

                if (event.target.classList.contains('btn')) {
                    const itemQuantity = event.target.closest('.item-quantity');

                    const quantityElement = itemQuantity.querySelector('.quantity');
                    let quantity = parseInt(quantityElement.value);
                    const maxQuantity = parseInt(quantityElement.max ||
                        Infinity);

                    if (event.target.classList.contains('btn-plus')) {
                        quantity += 1;
                        if (quantity > maxQuantity) {
                            showToast('Maximum quantity reached');
                            quantity = maxQuantity;
                        }
                    } else if (event.target.classList.contains('btn-minus') && quantity > 1) {
                        quantity -= 1;
                    }

                    const pricePerItem = parseFloat(itemQuantity.querySelector('.price').value || 0);
                    let totalPrice = pricePerItem * quantity;

                    totalPrice = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(totalPrice);

                    const itemDetails = itemQuantity.closest('.item-details');
                    if (itemDetails) {
                        itemDetails.querySelector('.item-price').innerHTML = 'Rs ' + totalPrice;
                    }

                    quantityElement.value = quantity;

                    const itemId = itemQuantity.querySelector('.item-id').value;
                    cartItemQuantityUpdate(itemId, quantity);
                }
            });
        });

        document.querySelectorAll('.sidecart .cart-item .item-quantity .btn').forEach(button => {
            button.addEventListener('click', function(event) {

                let subTotal = 0;
                let grandTotal = 0;

                document.querySelectorAll('.sidecart .cart-item .item-quantity').forEach(
                    itemQuantity => {
                        const qty = itemQuantity.querySelector('.quantity');
                        const price = itemQuantity.querySelector('.price');
                        const totalValue = price.value * qty.value;

                        subTotal += totalValue;
                    });

                const formattedTotal = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(subTotal);

                document.querySelector('.sidecart .sub-total').innerHTML = 'Rs ' + formattedTotal;
                document.getElementById('header-cart-total').innerHTML = 'Rs ' + formattedTotal;


            });
        });
    }

    reloadCartFunction();
</script>
