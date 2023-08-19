<!doctype html>
<html lang="{{App::currentLocale()}}" dir="{{ App::currentLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if(App::currentLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.rtl.min.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    @endif

    <link rel="stylesheet" href="{{asset('css/headers.css')}}">
    <title>{{ config('app.name') }}</title>
    @stack('styles')
</head>
<body>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 link-secondary">{{ __('Overview') }}</a></li>
                <li><a href="#" class="nav-link px-2 link-body-emphasis">{{ __('Inventory') }}</a></li>
                <li><a href="#" class="nav-link px-2 link-body-emphasis">{{ __('Customers') }}</a></li>
                <li><a href="#" class="nav-link px-2 link-body-emphasis">{{ __('Products') }}</a></li>
            </ul>

            <form method="get" action="{{route('questions.index')}}" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>

            <div class="dropdown text-end p-3">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" id="locale" data-bs-toggle="dropdown" aria-expanded="false">
                    {{__('Language')}}
                </a>
{{--                    <ul class="dropdown-menu text-small" aria-labelledby="locale">--}}
{{--                        <li><a class="dropdown-item" href="{{URL::current()}}?lang=ar">العربية</a></li>--}}
{{--                        <li><a class="dropdown-item" href="{{URL::current()}}?lang=en">English</a></li>--}}

{{--                    </ul>--}}

                <ul class="me-2 dropdown-menu text-small" aria-labelledby="locale">
                    @foreach(LaravelLocalization::getSupportedLocales() as $code => $locale)
                        <li>
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $code }}" href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}">
                                {{ $locale['native'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>

            @auth
            <x-notifications-menu />

            <div class="ms-2 dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->photo_url }}" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
{{--                    <li><a class="dropdown-item" href="#">New project...</a></li>--}}
{{--                    <li><a class="dropdown-item" href="#">Settings</a></li>--}}
                    <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" onclick="document.getElementById('logout').submit()" href="javascript:;">Sign out</a></li>
                    <form action="{{ route('logout') }} " method="POST" id="logout" style="display: none">
                        @csrf
                    </form>
                </ul>
            </div>
                @else
                <a href="{{route('login')}}" class="btn btn-outline-primary me-2">{{__('Login')}}</a>
                <a href="{{route('register')}}" class="btn btn-primary">{{__('Sign-up')}}</a>
                @endauth
        </div>
    </div>
</header>

    <div class="container py-5">
        <header class="mb-4 bg-light">
            <h2> @yield('title' , 'page Title')</h2>
            <hr>
        </header>
        @yield('content')


        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="" class="rounded me-2" alt="...">
                    <strong class="me-auto" id="notification-title"></strong>
                    <small id="notification-time"></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="notification-body">
                </div>
            </div>
        </div>


    </div>

    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script>
        const userId="{{Auth::id()}}"
    </script>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
