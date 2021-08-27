<header class="navbar navbar-expand-md navbar-dark navbar-overlap d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="/">
                <img src="{{asset("{$themeAssets}/img/logo-white.png")}}" alt="HStack" class="navbar-brand-image">
            </a>
        </h1>

        <div class="navbar-nav flex-row order-md-last">
            @auth()
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
            <div class="nav-item dropdown">
                @guest()
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <div class="d-none d-xl-block ps-2">
                            <div>{{__('Account')}}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{route('login')}}" class="dropdown-item">{{__('Login')}}</a>
                        <a href="{{route('register')}}" class="dropdown-item">{{__('Register')}}</a>
                        <div class="dropdown-divider"></div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="dropdown-item">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                @endguest

                @auth()
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ Auth::user()->profile_photo_url }})"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Set status</a>
                        <a href="#" class="dropdown-item">Profile &amp; account</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>

                @endauth

            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.html">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="5 12 3 12 12 3 21 12 19 12"></polyline><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                    </span>
                            <span class="nav-link-title">
                      Home
                    </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline><line x1="12" y1="12" x2="20" y2="7.5"></line><line x1="12" y1="12" x2="12" y2="21"></line><line x1="12" y1="12" x2="4" y2="7.5"></line><line x1="16" y1="5.25" x2="8" y2="9.75"></line></svg>
                    </span>
                            <span class="nav-link-title">
                      Interface
                    </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="./empty.html">
                                        Empty page
                                    </a>
                                    <a class="dropdown-item" href="./accordion.html">
                                        Accordion
                                    </a>
                                    <a class="dropdown-item" href="./blank.html">
                                        Blank page
                                    </a>
                                    <a class="dropdown-item" href="./buttons.html">
                                        Buttons
                                    </a>
                                    <a class="dropdown-item" href="./cards.html">
                                        Cards
                                    </a>
                                    <a class="dropdown-item" href="./cards-masonry.html">
                                        Cards Masonry
                                    </a>
                                    <a class="dropdown-item" href="./colors.html">
                                        Colors
                                    </a>
                                    <a class="dropdown-item" href="./dropdowns.html">
                                        Dropdowns
                                    </a>
                                    <a class="dropdown-item" href="./icons.html">
                                        Icons
                                    </a>
                                    <a class="dropdown-item" href="./modals.html">
                                        Modals
                                    </a>
                                    <a class="dropdown-item" href="./maps.html">
                                        Maps
                                    </a>
                                    <a class="dropdown-item" href="./map-fullsize.html">
                                        Map fullsize
                                    </a>
                                    <a class="dropdown-item" href="./maps-vector.html">
                                        Vector maps
                                    </a>
                                </div>
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="./navigation.html">
                                        Navigation
                                    </a>
                                    <a class="dropdown-item" href="./charts.html">
                                        Charts
                                    </a>
                                    <a class="dropdown-item" href="./pagination.html">
                                        Pagination
                                    </a>
                                    <a class="dropdown-item" href="./skeleton.html">
                                        Skeleton
                                    </a>
                                    <a class="dropdown-item" href="./tabs.html">
                                        Tabs
                                    </a>
                                    <a class="dropdown-item" href="./tables.html">
                                        Tables
                                    </a>
                                    <a class="dropdown-item" href="./carousel.html">
                                        Carousel
                                    </a>
                                    <a class="dropdown-item" href="./lists.html">
                                        Lists
                                    </a>
                                    <a class="dropdown-item" href="./typography.html">
                                        Typography
                                    </a>
                                    <a class="dropdown-item" href="./markdown.html">
                                        Markdown
                                    </a>
                                    <div class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                            Authentication
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="./sign-in.html" class="dropdown-item">Sign in</a>
                                            <a href="./sign-up.html" class="dropdown-item">Sign up</a>
                                            <a href="./forgot-password.html" class="dropdown-item">Forgot password</a>
                                            <a href="./terms-of-service.html" class="dropdown-item">Terms of service</a>
                                            <a href="./auth-lock.html" class="dropdown-item">Lock screen</a>
                                        </div>
                                    </div>
                                    <div class="dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#sidebar-error" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                            Error pages
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="./error-404.html" class="dropdown-item">404 page</a>
                                            <a href="./error-500.html" class="dropdown-item">500 page</a>
                                            <a href="./error-maintenance.html" class="dropdown-item">Maintenance page</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact')}}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->

                    </span>
                            <span class="nav-link-title">
                      {{__('Contact Us')}}
                    </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
