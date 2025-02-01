<aside class="app-sidebar">
    <div class="main-sidebar-header">
        <a href="/admin/dashboard" class="sidebar-logo-link">
            <img src="{{ $site_light_logo }}" class="sidebar-logo" alt="Logo">
        </a>
        {{-- <button class="sidebar-close-btn" onclick="hideSidebar()">
            <span class="fi fi-sr-cross-small"></span>
        </button> --}}
    </div>



    <div class="main-sidebar" data-scrollbars>
        <div class="simplebar-content-wrapper">
            <div class="simplebar-content">
                <ul class="main-menu pb-3" id="main-menu">
                    <li class="slide">
                        <a href="/admin/dashboard" id="dashboard" class="side-menu__item active">
                            <i class="fi fi-rr-home side-menu__icon"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>

                    <div class="sidebar-menu-header">APPEARANCE</div>

                    <li class="slide">
                        <a href="{{ route('admin.products.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-box side-menu__icon"></i>
                            <span class="side-menu__label">Products</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('admin.orders.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-cart-shopping-fast side-menu__icon"></i>
                            <span class="side-menu__label">Orders</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('admin.payments.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-money side-menu__icon"></i>
                            <span class="side-menu__label">Order Payments</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('admin.stock.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-database side-menu__icon"></i>
                            <span class="side-menu__label">Stock</span>
                        </a>
                    </li>


                    <li class="slide">
                        <a href="{{ route('admin.review.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-feedback side-menu__icon"></i>
                            <span class="side-menu__label">Reviews</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('admin.testimonial.index') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-review side-menu__icon"></i>
                            <span class="side-menu__label">Testimonial</span>
                        </a>
                    </li>


                    <li class="slide">
                        <a href="{{ route('admin.seasonal_banner.show') }}" id="subject" class="side-menu__item">
                            <i class="fi fi-rr-ticket side-menu__icon"></i>
                            <span class="side-menu__label">Seasonal Banner</span>
                        </a>
                    </li>


                    {{-- <div class="accordion" id="classes">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#classesCollapse" aria-expanded="false"
                                    aria-controls="usersCollapse">
                                    <i class="fi fi-rr-lesson side-menu__icon"></i>
                                    <span class="side-menu__label">Product</span>
                                </button>
                            </h2>
                            <div id="classesCollapse" class="accordion-collapse collapse" data-bs-parent="#classes">
                                <div class="accordion-body">
                                    <ul class="list-unstyled">
                                        <li class="slide">
                                            <a href="" id="logoFavicon" class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Manage classes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                    <div class="sidebar-menu-header">SITE SETTINGS</div>

                    <div class="accordion" id="settings">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#settingsCollapse" aria-expanded="false"
                                    aria-controls="settingsCollapse">
                                    <i class="fi fi-rr-settings side-menu__icon"></i>
                                    <span class="side-menu__label">Settings</span>
                                </button>
                            </h2>
                            <div id="settingsCollapse" class="accordion-collapse collapse" data-bs-parent="#settings">
                                <div class="accordion-body">
                                    <ul class="list-unstyled">

                                        <li class="slide">
                                            <a href="{{ route('admin.banner.index') }}" id="subCategory"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Banner</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.brand.index') }}" id="brand"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Brands</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.category.index') }}" id="category"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Categories</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.sub-category.index') }}" id="subCategory"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Sub Categories</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.variation.index') }}" id="subject"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Variantions</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.system_settings') }}" id="logoFavicon"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">System settings</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.payment_settings') }}" id="admin"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Payment settings</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.notification_settings') }}" id="admin"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Notification settings</span>
                                            </a>
                                        </li>

                                        <li class="slide">
                                            <a href="{{ route('admin.backup.index') }}" id="admin"
                                                class="side-menu__item">
                                                <i class="fi fi-rr-angle-double-small-right side-menu__icon"></i>
                                                <span class="side-menu__label">Database Backups</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="sidebar-menu-header">MY SETTINGS</div>

                    {{-- <li class="slide">
                        <a href="" id="notifications" class="side-menu__item">
                            <i class="fi fi-rr-bell side-menu__icon"></i>
                            <span class="side-menu__label">Notifications</span>
                        </a>
                    </li> --}}

                    <li class="slide">
                        <a href="{{ route('admin.profile.index') }}" id="profile" class="side-menu__item">
                            <i class="fi fi-rr-user side-menu__icon"></i>
                            <span class="side-menu__label">My Profile</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="/admin/logout" class="side-menu__item">
                            <i class="fi fi-rr-power side-menu__icon"></i>
                            <span class="side-menu__label">Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</aside>
