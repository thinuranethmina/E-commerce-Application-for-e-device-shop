@extends('frontend.app')
@section('content')
    <section class="checkout-section">
        <div class="container-xxl">
            <form action="{{ route('checkout.quickStore') }}" id="checkoutForm" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row mx-auto align-items-start">

                    <div class="col-12 col-lg-6 col-xl-7">
                        <h1 class="section-title">Checkout</h1>

                        <div class="row">
                            <div class="col-12">
                                <div class="payment-method-card">
                                    <h2 class="title">Choose Payment Method</h2>

                                    <input type="radio" class="d-none form-check-input" id="card-payment"
                                        name="payment_method" value="card">
                                    <label for="card-payment" class="d-block">
                                        <div class="card">
                                            <div class="circle"></div>
                                            <p>
                                                Credit <span class="d-none d-sm-inline-block">Or</span><span
                                                    class="d-sm-none">/</span> Debit Card
                                            </p>
                                            <div class=" flex-grow-1 text-end">
                                                <img class="payment-methods-image d-none d-xl-block"
                                                    src="{{ asset('assets/frontend/images/footer/payment_methods.webp') }}"
                                                    alt="">
                                                <img class="payment-methods-image d-xl-none"
                                                    src="{{ asset('assets/frontend/images/footer/payment_methods-m.jpg') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </label>

                                    <input type="radio" class="d-none form-check-input" id="bank-transfer"
                                        name="payment_method" value="bank">
                                    <label for="bank-transfer" class="d-block mt-3">
                                        <div class="card">
                                            <div class="circle"></div>
                                            <p>
                                                Bank Transfer
                                            </p>
                                        </div>
                                    </label>

                                    <div class="mt-4 bank-trnsfer-info">

                                        <p class="section-description">Please Transfer The Full Amount To Any Below Bank
                                            Account.
                                        </p>

                                        <pre class="bank-details">{{ $settings['payment.bank_info'] }}</pre>
                                        <p class="section-description">Whatsapp Deposit Slip To This Number PHONE NO :
                                            <a href="https://wa.me/770257357">0770 257 357</a>
                                            Your Order Will Not Ship Until
                                            We Receive Payment.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="buyer-details-card">
                                    <h2 class="title">Buyer Details</h2>
                                    <div class="row">

                                        <input type="hidden" value="{{ $ref }}" name="ref">

                                        <div class="col-12 form-group">
                                            <input type="number" class="form-control" name="phone" placeholder="Phone">
                                        </div>

                                        <div class="col-12 form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Name"
                                                value="">
                                        </div>

                                        <div class="col-12 form-group">
                                            <input type="text" class="form-control" name="address" placeholder="Address">
                                        </div>

                                        <div class="col-12 form-group">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Email (Optional)">
                                        </div>

                                        <h3 class="title">Note</h3>

                                        <div class="col-12 form-group">
                                            <textarea class="form-control" rows="5" name="note" placeholder="Order Notes (Optional)"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-xl-5 ">
                        <div class="order-summery-card">
                            <div class="px-1 px-md-3 px-lg-4">
                                <h2 class="title text-center">Your Order Summary</h2>
                                <div class="cart-items">
                                    <div id="cart-item-{{ $productVariation->id }}" class="cart-item">
                                        <input type="hidden" name="productVariationId" value="{{ $productVariation->id }}">
                                        <div class="item-image">
                                            <img src="{{ asset($productVariation->product->thumbnail) }}" alt="item">
                                        </div>
                                        <div class="item-details flex-grow-1">
                                            <h4 class="item-title">{{ $productVariation->product->name }}
                                            </h4>
                                            <span class="item-color">
                                                @foreach ($productVariation->values as $type)
                                                    {{ $type->variationValue->variable }}
                                                @endforeach
                                            </span>
                                            @php
                                                $qty = $productVariation->stock >= 1 ? 1 : 0;
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between gap-1 mt-2">
                                                <p class="item-price">Rs
                                                    {{ number_format($productVariation->price * $qty, 2) }}
                                                </p>
                                                <div class="item-quantity">
                                                    <input type="hidden" class="price"
                                                        value="{{ $productVariation->price }}">
                                                    <input type="hidden" class="item-id"
                                                        value="{{ $productVariation->id }}">
                                                    <button type="button" class="btn btn-minus">-</button>
                                                    <input type="number" class="quantity" name="product_quantity"
                                                        value="{{ $qty }}" min="1"
                                                        max="{{ $productVariation->stock }}" readonly>
                                                    <button type="button" class="btn btn-plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>Subtotal</span>
                                    <span class="sub-total">Rs
                                        {{ number_format($productVariation->price * $qty, 2) }}</span>
                                </div>

                                <?php $delivery_fee = $settings['payment.delivery_fee']; ?>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <span>Delivery Fee</span>
                                    <span>Rs {{ number_format($delivery_fee * $qty, 2) }}</span>
                                </div>
                            </div>

                            <div class="total-card mt-4">
                                <span class="total-label">Total</span>
                                <span class="total-price">Rs
                                    {{ number_format(($productVariation->price + $delivery_fee) * $qty, 2) }}</span>
                            </div>

                            <button type="submit" class="btn primary-gradiant-btn mt-3">
                                Process To Checkout
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    @include('frontend.layouts.features-section')
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script type="module">
        @php
            if (isset($html)) {
                echo 'openModal(`' . $html . '`);';
            }
        @endphp
    </script>
    <script type="module">
        document.querySelectorAll('.order-summery-card .cart-item .item-quantity .btn').forEach(button => {
            button.addEventListener('click', function(event) {

                let subTotal = 0;
                let grandTotal = 0;

                document.querySelectorAll('.order-summery-card .cart-item .item-quantity').forEach(
                    itemQuantity => {
                        const qty = itemQuantity.querySelector('.quantity');
                        const price = itemQuantity.querySelector('.price');
                        const totalValue = price.value * qty.value;

                        subTotal += totalValue;
                    });

                document.querySelector('.order-summery-card .sub-total').innerHTML = new Intl.NumberFormat(
                    'en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(subTotal);


                document.querySelector('.order-summery-card .total-price').innerHTML = new Intl
                    .NumberFormat(
                        'en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }).format(subTotal + {{ $settings['payment.delivery_fee'] }});

            });
        });


        if (document.getElementById('checkoutForm')) {
            checkoutFormProcess();
        }

        function checkoutFormProcess() {

            var form = document.getElementById('checkoutForm');

            form.addEventListener("submit", (event) => {
                event.preventDefault();


                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                        action: 'submit'
                    }).then(function(token) {

                        const submitButton = form.querySelector('[type="submit"]');
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.innerHTML =
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
                                submitButton.innerHTML;
                        }

                        const formData = new FormData(form);
                        formData.append('g-recaptcha-response', token);


                        fetch(form.action, {
                                method: form.method,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]')
                                        .getAttribute(
                                            'content'),
                                },
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.innerHTML = submitButton.textContent;
                                }

                                if (data.success) {
                                    if (formData.get('payment_method') == 'card') {
                                        payWithPayhere(formData, data.hash, data.total, data
                                            .app_url);
                                    } else {

                                        if (data.html) {
                                            openModal(data.html);
                                        } else {
                                            showToast(data.message);
                                            setTimeout(() => {
                                                window.location.href = data.redirect;
                                            }, 3000);
                                        }

                                    }
                                } else {
                                    showToast(data.message);
                                }
                            })
                            .catch(error => {
                                if (submitButton) {
                                    submitButton.disabled = false;
                                }
                                console.error('Error:', error);
                                showToast('An error occurred.');
                            });
                    });
                });
            });
        }

        function payWithPayhere(form, hash, total, app_url) {

            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                window.location.href = app_url + '/checkout/' + orderId;
            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                // Note: Prompt user to pay again or show an error page
                console.log("Payment dismissed");
                window.location.reload();
            };

            // Error occurred
            payhere.onError = function onError(error) {
                // Note: show an error page
                console.log("Error:" + error);
                window.location.reload();
            };

            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "{{ $settings['payment.payhere_merchant_id'] }}",
                "return_url": app_url + '/{{ $ref }}',
                "cancel_url": app_url + '/checkout',
                "notify_url": app_url + '/notify',
                "order_id": "{{ $ref }}",
                "items": "DigiMax.lk",
                "amount": total,
                "currency": "LKR",
                "hash": hash,
                "first_name": form.get('name'),
                "last_name": '',
                "email": form.get('email'),
                "phone": form.get('phone'),
                "address": form.get('address'),
                "city": "",
                "country": "Sri Lanka",
                "delivery_address": "",
                "delivery_city": "",
                "delivery_country": "Sri Lanka",
                "custom_1": "",
                "custom_2": ""
            };

            payhere.startPayment(payment);

        }
    </script>
@endsection
