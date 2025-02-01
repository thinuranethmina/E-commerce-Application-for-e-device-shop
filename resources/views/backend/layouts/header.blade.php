<header class="app-header">
    <div class="container-fluid main-header-container">
        <div class="header-content-left">
            <div class="header-element">
                <div class="header-link" onclick="hideSidebar()">
                    <i class="fi fi-rr-bars-staggered header-link-icon"></i>
                </div>
            </div>
        </div>
        <div class="header-content-right">
            <div class="header-element">
                {{-- <div class="header-link" onclick="hideSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M15.019 17h-6.04m6.04 0h3.614c1.876 0 1.559-1.86.61-2.804C15.825 10.801 20.68 3 11.999 3s-3.825 7.8-7.243 11.196c-.913.908-1.302 2.804.61 2.804H8.98m6.039 0c0 1.925-.648 4-3.02 4s-3.02-2.075-3.02-4">
                        </path>
                    </svg>
                </div> --}}
                <div class="header-link d-none" class="dropdown-toggle" id="notificationDropdown"
                    data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M15.019 17h-6.04m6.04 0h3.614c1.876 0 1.559-1.86.61-2.804C15.825 10.801 20.68 3 11.999 3s-3.825 7.8-7.243 11.196c-.913.908-1.302 2.804.61 2.804H8.98m6.039 0c0 1.925-.648 4-3.02 4s-3.02-2.075-3.02-4">
                        </path>
                    </svg>
                    {{-- @if (Auth::user()->notifications()->where('is_read', 0)->count() > 0)
                        <div class="notification-count">
                            {{ Auth::user()->notifications()->where('is_read', 0)->count() }}
                        </div>
                    @endif --}}
                </div>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                    <div class="notification-dropdown">
                        <ul class="p-0 m-0">
                            {{-- @if (Auth::user()->notifications()->latest()->take(6)->count() > 0)
                                @foreach (Auth::user()->notifications()->latest()->take(6)->get() as $item)
                                    <li class="dropdown-item {{ $item->is_read == 1 ? 'read' : '' }} mb-2">
                                        <a href="{{ route('admin.notifications.index') }}">
                                            <p class="notification-title">{{ $item->alert->title }}</p>
                                            <p class="notification-message">
                                                {{ $item->alert->message }}
                                            </p>
                                            <span
                                                class="notification-time">{{ $item->created_at->diffForHumans() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="dropdown-item">
                                    <a href="{{ route('admin.notifications.index') }}">
                                        <p class="notification-title text-center">No Notifications</p>
                                    </a>
                                </li>
                            @endif --}}
                        </ul>
                    </div>
                    {{-- @if (Auth::user()->notifications()->latest()->take(6)->count() > 0)
                        <div class="view-all-notifications">
                            <a href="{{ route('admin.notifications.index') }}">
                                <p class="text-center">View Notifications</p>
                            </a>
                        </div>
                    @endif --}}
                </div>
            </div>
            <div class="header-element">
                <div class="header-link" class="dropdown-toggle" id="userProfileDropdown" data-bs-toggle="dropdown">
                    <div class="main-profile-user">
                        <img
                            src="{{ Auth::user()->avatar ? asset('assets/uploads/user/' . Auth::user()->avatar) : asset('assets/backend/images/user/default.png') }}">
                    </div>
                </div>
                <div class="dropdown-menu" aria-labelledby="userProfileDropdown">
                    <ul class="p-0 m-0">
                        <li class="dropdown-item disabled">
                            <div class="text-center">
                                <h5>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h5>
                                <small>{{ Auth::user()->role }}</small>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <a href="/admin/profile" class="d-flex align-items-center gap-2">
                                <i class="fi fi-rr-settings"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="dropdown-item">
                            <a href="https://www.digitalnext.lk/contact/" class="d-flex align-items-center gap-2"
                                target="_blank">
                                <i class="fi fi-rr-headset"></i>
                                <span>Support</span>
                            </a>
                        </li>
                        <li class="dropdown-item">
                            <a href="/admin/logout" class="d-flex align-items-center gap-2">
                                <i class="fi fi-rr-info"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
</header>
