@extends('frontend.app')
@section('content')
    <section class="mission-section">
        <div class="container">
            <div class="row mx-auto justify-content-center mt-4 mt-lg-0">
                <div class="col-12 col-lg-6 pe-lg-5">
                    <div class="image-wrapper">
                        <img class="image" src="https://images.pexels.com/photos/269077/pexels-photo-269077.jpeg"
                            alt="We Belive The Best Experience Always Wins">
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <h2 class="section-subtitle">Our Mission, About Us</h2>
                    <h1 class="section-title">We Belive The Best <br class="d-none d-md-block"> Experience Always Wins</h1>

                    <p class="section-description">
                        Our Commitment To Excellence Drives Us To Constantly Enhance Our Services, Bringing You The Best
                        Deals And An Unmatched Online Shopping Experience. With iMax, You're Not Just Purchasing
                        Products; You're Becoming Part Of A Community That Values Trust, Quality, And Satisfaction Above All
                        Else.
                    </p>

                    <p class="section-description">
                        We Redefine The Ecommerce Experience By Offering A Seamless Blend Of Innovation, Quality, And
                        Convenience. As A Customer-Centric Platform, We Pride Ourselves On Delivering A Wide Range Of
                        Products Across Various Categories To Meet Your Every Need. From The Latest Tech Gadgets To Everyday
                        Essentials, Our Mission Is To Ensure You Enjoy A Hassle-Free And Secure Shopping Journey.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.features-section')

    @include('frontend.layouts.offers-section')
@endsection
