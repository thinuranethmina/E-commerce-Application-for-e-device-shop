@extends('frontend.app')
@section('content')
    <section class="contact-section">
        <div class="container">
            <div class="row mx-auto justify-content-center mt-4 mt-lg-0">

                <div class="col-12 col-lg-6 pe-lg-4">
                    <h2 class="section-subtitle">You Can Ask Us Questions !</h2>
                    <h1 class="section-title">Contact Us For All Your <br class="d-none d-lg-block"> Questions And Opinions
                    </h1>

                    <p class="section-subtitle-2">Connecting You To Excellence</p>
                    <p class="section-description">
                        Our Commitment To Excellence Drives Us To Constantly Enhance Our Services, Bringing You The Best
                        Deals And An Unmatched Online Shopping Experience. With iMax, You're Not Just Purchasing
                        Products; You're Becoming Part Of A Community That Values Trust, Quality, And Satisfaction Above All
                        Else.
                    </p>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-5">
                            <p class="contact-label">Address</p>
                            <p class="contact-value">No:27 Nugegoda, <br>
                                Colombo, Sri Lanka</p>
                        </div>
                        <div class="col-12 col-md-6 mb-5">
                            <p class="contact-label">Phone Number</p>
                            <p class="contact-value">
                                <a href="tel:0770257357">0770 257 357</a>
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="contact-label">Email</p>
                            <p class="contact-value">
                                <a href="mailto:info@imax.lk">Info@iMax.Lk</a>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <div class="card my-auto">
                        <h3 class="card-title">Ask Question</h3>
                        <form id="contact-form" action="{{ route('contact.submit') }}" method="GET">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Your Name*">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Your Email*">
                            <textarea class="form-control" name="message" placeholder="Your Message*" rows="8">{{ old('message') }}</textarea>

                            <button type="submit" class="btn primary-gradiant-btn g-recaptcha" data-callback='onSubmit'
                                data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-action='submit'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="21.998" height="22"
                                    viewBox="0 0 21.998 22">
                                    <path id="paper-plane"
                                        d="M21.193.809A2.719,2.719,0,0,0,18.626.075L3.959,3.164a4.579,4.579,0,0,0-2.615,7.774l1.575,1.574a.917.917,0,0,1,.269.649v2.9a2.718,2.718,0,0,0,.275,1.178l-.007.006.024.024a2.75,2.75,0,0,0,1.249,1.243l.024.024.006-.007a2.718,2.718,0,0,0,1.178.275h2.9a.917.917,0,0,1,.648.268l1.574,1.574A4.55,4.55,0,0,0,14.289,22a4.628,4.628,0,0,0,1.471-.242A4.522,4.522,0,0,0,18.825,18.1l3.094-14.7a2.727,2.727,0,0,0-.726-2.6ZM4.217,11.218,2.641,9.645a2.7,2.7,0,0,1-.662-2.818A2.73,2.73,0,0,1,4.271,4.969L18.792,1.912,5.019,15.687V13.162A2.73,2.73,0,0,0,4.217,11.218Zm12.807,6.573a2.75,2.75,0,0,1-4.665,1.569l-1.577-1.577a2.73,2.73,0,0,0-1.942-.8H6.314L20.089,3.208Z"
                                        transform="translate(-0.003 -0.001)" fill="#fff" />
                                </svg>
                                Send Question</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>

    @include('frontend.layouts.offers-section')

    @include('frontend.layouts.features-section')
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById('contact-form').submit();
        }
    </script>
@endsection
