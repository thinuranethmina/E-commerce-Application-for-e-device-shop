<footer>
    <div class="container">
        <div class="row mx-auto">
            <div class="col-12 col-lg-6">
                <h3 class="company-name">iMax.lk</h3>
                <p class="section-description">
                    iMax.Lk Gives You A Chance To Quickly And Easily Find The Device You Want And Ave It Delivered To
                    Your Home In No Time, Regardless Of Your Location
                </p>
                <div class="image-wrapper">
                    <img src="{{ asset('assets/frontend/images/footer/payment_methods.webp') }}" alt="">
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                <h6 class="title">Product Categories</h6>
                <ul class="categories-list">
                    @foreach ($categories as $category)
                        <li><a href="{{ route('shop.index') }}?category={{ $category->id }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                <h6 class="title">Company Information</h6>

                <div class="mb-3">
                    <p class="contact-info">Address:</p>
                    <p class="contact-info">
                        No:27 Nugegoda, Colombo, Sri Lanka
                    </p>
                </div>

                <div class="mb-3">
                    <p class="contact-info">Conatct:</p>
                    <a class="contact-info" href="tel:0770257357">0770 257 357</a>
                </div>

                <div class="mb-3">
                    <p class="contact-info">Email:</p>
                    <a class="contact-info" href="mailto:info@imax.lk">Info@imax.Lk</a>
                </div>

            </div>
        </div>
    </div>
    <hr class="divider">
    <div class="container">
        <div class="row mx-auto">
            <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                <p class="copyright text-center">Copyright&copy;{{ date('Y') }} iMax.Lk (PVT) Ltd | Web Solutions By
                    <a href="https://example.lk/" target="_blank">EXAMPLE</a>
                </p>
                <div class="social-icons">
                    <a href="#">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path id="Path_45" data-name="Path 45"
                                    d="M10,24h6V18.5H14V16h2V14a3,3,0,0,1,3-3h2v2.5H20c-.552,0-1-.052-1,.5v2h2.5l-1,2.5H19V24h3a2,2,0,0,0,2-2V10a2,2,0,0,0-2-2H10a2,2,0,0,0-2,2V22A2,2,0,0,0,10,24Z"
                                    transform="translate(-8 -8)" fill="#ff0001" />
                            </svg>
                        </div>
                    </a>
                    <a href="#">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.002"
                                viewBox="0 0 16 16.002">
                                <path id="Union_2" data-name="Union 2"
                                    d="M-1199.65-6116.349c-1.516-1.516-1.342-3.542-1.342-6.653,0-3.041-.2-5.115,1.342-6.653a4.786,4.786,0,0,1,3.357-1.294c1.474-.066,5.119-.069,6.592,0,3.011.14,4.519,1.843,4.65,4.653.066,1.473.069,5.118,0,6.59-.234,5.052-4.264,4.7-7.946,4.7-.623,0-1.206.009-1.754.009C-1196.849-6115-1198.426-6115.125-1199.65-6116.349Zm12.277-1.019c.992-1,.929-2.34.929-5.635,0-6.125.068-6.555-6.555-6.555l-.029-.02c-6.176,0-6.556-.086-6.556,6.564,0,2.722-.2,4.518.92,5.636.976.977,2.313.928,5.645.928C-1189.78-6116.449-1188.38-6116.358-1187.372-6117.368ZM-1197.1-6123a4.1,4.1,0,0,1,4.105-4.1,4.105,4.105,0,0,1,4.105,4.1A4.105,4.105,0,0,1-1193-6118.9,4.105,4.105,0,0,1-1197.1-6123Zm1.44,0a2.664,2.664,0,0,0,2.665,2.665,2.665,2.665,0,0,0,2.665-2.665,2.665,2.665,0,0,0-2.665-2.665A2.664,2.664,0,0,0-1195.661-6123Zm5.973-4.267a.959.959,0,0,1,.959-.96.96.96,0,0,1,.96.96.959.959,0,0,1-.96.958A.959.959,0,0,1-1189.688-6127.269Z"
                                    transform="translate(1200.999 6131)" fill="#ff0001" />
                            </svg>
                        </div>
                    </a>
                    <a href="#">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.001"
                                viewBox="0 0 16 16.001">
                                <path id="Union_3" data-name="Union 3"
                                    d="M-1241.869-6119.107a7.889,7.889,0,0,1-1.064-3.962,8,8,0,0,1,13.612-5.631l-.009.027a7.865,7.865,0,0,1,2.331,5.606,7.981,7.981,0,0,1-11.777,6.966L-1243-6115Zm3.53,1.688a6.637,6.637,0,0,0,10.007-5.669,6.521,6.521,0,0,0-1.938-4.66,6.581,6.581,0,0,0-4.681-1.941,6.6,6.6,0,0,0-5.617,10.1l.159.251-.67,2.429,2.5-.649Zm4.672-1.992c-1.762-.6-2.728-1.042-4.536-3.409-.921-1.3-1.192-2.517-.115-3.7a.993.993,0,0,1,.911-.228c.123,0,.288-.049.448.339s.565,1.372.616,1.472a.368.368,0,0,1,.017.349c-.373.7-.782.751-.585,1.088a6.01,6.01,0,0,0,1.107,1.381,5.409,5.409,0,0,0,1.6.99c.2.089.314.08.431-.051s.5-.577.628-.774c.191-.285.343-.186,1.809.543l.006-.049c.2.089.331.14.379.229a1.663,1.663,0,0,1-.12.95,2.045,2.045,0,0,1-1.344.951,3.337,3.337,0,0,1-.48.037A2.53,2.53,0,0,1-1233.668-6119.411Z"
                                    transform="translate(1242.999 6131)" fill="#ff0001" />
                            </svg>
                        </div>
                    </a>
                    <a href="#">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.999" height="11.333"
                                viewBox="0 0 15.999 11.333">
                                <path id="Path_53" data-name="Path 53"
                                    d="M23.646,11.953l.02.13a2.029,2.029,0,0,0-1.379-1.408l-.014,0a47.36,47.36,0,0,0-6.266-.339,46.425,46.425,0,0,0-6.266.339,2.027,2.027,0,0,0-1.389,1.4l0,.014a22.3,22.3,0,0,0,.021,7.965l-.021-.132a2.029,2.029,0,0,0,1.379,1.408l.014,0a47.352,47.352,0,0,0,6.266.339,47.459,47.459,0,0,0,6.266-.339,2.027,2.027,0,0,0,1.389-1.4l0-.014A20.745,20.745,0,0,0,24,16.151c0-.049,0-.1,0-.147s0-.1,0-.154a21.462,21.462,0,0,0-.354-3.9ZM14.4,18.434V13.572l4.178,2.435Z"
                                    transform="translate(-8.001 -10.333)" fill="#ff0001" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
