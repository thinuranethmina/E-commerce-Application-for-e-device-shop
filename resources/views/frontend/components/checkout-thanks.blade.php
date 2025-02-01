@if ($order->payment->payment_status == 'Pending' || $order->payment->payment_status == 'Paid')
    <div class="row purchase-success-modal">
        <div class="col-12 p-3 px-lg-5 my-lg-4">
            <div class="text-center">
                <svg id="checkbox" xmlns="http://www.w3.org/2000/svg" width="50px" height="50px"
                    viewBox="0 0 99.012 99.012">
                    <path id="Path_341" data-name="Path 341"
                        d="M78.384,0H20.628A20.652,20.652,0,0,0,0,20.628V78.384A20.652,20.652,0,0,0,20.628,99.012H78.384A20.652,20.652,0,0,0,99.012,78.384V20.628A20.652,20.652,0,0,0,78.384,0ZM82.51,33.33,44.332,71.507a8.251,8.251,0,0,1-11.669,0l0,0L16.5,55.352a4.134,4.134,0,0,1,5.846-5.846L38.5,65.661,76.684,27.484A4.126,4.126,0,0,1,82.51,33.33Z"
                        fill="#0db5ab" />
                </svg>
                <h2 class="title">Thank You For Your Purchase!</h2>
                <p class="text-center description">
                    Dear {{ $order->customer_first_name . ' ' . $order->customer_last_name }}, Your Order Has Been
                    Successfully
                    Placed! <br>
                    <strong class="order-number">Order Number: #{{ $order->ref }} &nbsp; Date:
                        {{ $order->created_at->format('Y-m-d') }}</strong>
                    @if ($order->email)
                        <br><br>
                        A Confirmation Email Has Been Sent To Your Inbox. Please Check It For The Details Of
                        Your Order.
                    @endif
                </p>
                <a href="{{ route('home') }}" type="button" class="btn secondary-btn">Back to Home</a>
            </div>
        </div>
    </div>
@else
    <div class="row purchase-success-modal">
        <div class="col-12 p-3 px-lg-5 my-lg-4">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="60px" height="60px" viewBox="0 0 24 24">
                    <path fill="#FF4646"
                        d="M12 23c6.075 0 11-4.925 11-11S18.075 1 12 1S1 5.925 1 12s4.925 11 11 11M8.818 7.403L12 10.586l3.182-3.182l1.414 1.414L13.414 12l3.182 3.182l-1.415 1.414L12 13.414l-3.182 3.182l-1.415-1.414L10.586 12L7.403 8.818z">
                    </path>
                </svg>
                <h2 class="title">Payment Failed!</h2>
                <p class="text-center description">
                    We're sorry! Your payment could not be processed. Please check your payment details and try again.
                    If the issue persists, contact customer support.
                </p>
                <a href="{{ route('checkout.index') }}" type="button" class="btn btn-dark text-white">Try Again</a>
            </div>
        </div>
    </div>
@endif
