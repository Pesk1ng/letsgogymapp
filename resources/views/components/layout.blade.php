<!doctype html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Let's go gym - Fitness &amp; Management</title>

        <meta name="description" content="">
        <meta name="author" content="Let's go gym">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="googlebot-news" content="noindex">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" sizes="32x32" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="shortcut icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">

        <!-- Modules -->
        @yield('css')
        @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])

        <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
        {{-- @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xwork.scss', 'resources/js/dashmix/app.js']) --}}
        @yield('js')
    </head>

    <body>
    
        <div id="page-container" class="sidebar-o sidebar-dark side-scroll page-header-fixed main-content-boxed">

            <nav id="sidebar" aria-label="Main Navigation">
                <div class="smini-visible-block">
                    <div class="content-header ps-2 bg-black-10">
                        <a class="fw-semibold text-white" href="/account/overview">
                        <img src="{{ asset('media/logo/logo-sm.png') }}" width="40" alt="">
                        <!-- M<span class="opacity-75">f</span> -->
                        </a>
                    </div>
                </div>
            
                <div class="smini-hidden">
                    <div class="content-header justify-content-lg-start bg-black-10">
                        <a class="fw-semibold text-white tracking-wide" href="/account/overview">
                            <img src="{{ asset('media/logo/logo-light.svg') }}" width="130" alt="">
                        <!-- Monica <span class="fw-normal">Finance</span> -->
                        </a>

                        <div class="d-lg-none">
                        <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                            <i class="fa fa-times-circle"></i>
                        </button>
                        </div>
                    </div>
                </div>

                <div class="js-sidebar-scroll">
                    <!-- <div class="content-side content-side-full smini-hide">
                        <a class="btn btn-primary rounded-pill w-100" href="javascript:void(0)">
                        <i class="fa fa-plus opacity-50 me-1"></i> Nouvel article
                        </a>
                    </div> -->

                    <!-- Side Navigation -->
                    <div class="content-side pt-4">
                        <ul class="nav-main">
                            <li class="nav-main-item">
                                <a class="nav-main-link active" href="{{ route('dashboard') }}">
                                <i class="nav-main-link-icon fa fa-chart-pie"></i>
                                <span class="nav-main-link-name">Tableau de board</span>
                                <span class="nav-main-link-badge badge rounded-pill bg-success">3</span>
                                </a>
                            </li>

                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <x-admin-menu />
                                @elseif (Auth::user()->role === 'receptionist')
                                    <x-receipt-menu />
                                @elseif (Auth::user()->role === 'manager')
                                    <x-manager-menu />
                                @elseif (Auth::user()->role === 'controller')
                                    <x-controller-menu />
                                @else
                                    <x-superadmin-menu />
                                @endif
                            @endauth
                            
                            <!-- -------------------- -->
                            <li class="nav-main-heading">Let's go gym</li>
                            <li class="nav-main-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="d-inline-block text-start btn nav-main-link" style="width: 100%">
                                        <i class="nav-main-link-icon fa fa-fw fa-arrow-alt-circle-left me-1"></i> Déconnexion
                                    </button>
                                </form>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <header id="page-header">
                <div class="content-header">
                    <div class="space-x-1">
                        <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    
                        <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="header_search_on">
                            <i class="fa fa-fw opacity-50 fa-search"></i> <span class="ms-1 d-none d-sm-inline-block">Rechercher</span>
                        </button>
                    </div>

                    <div class="space-x-1">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user-circle"></i>
                                <span class="d-none d-sm-inline-block">{{ Auth::user()->fullname }}</span>
                                <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                                <div class="bg-primary-dark text-capitalize rounded-top fw-semibold text-white text-center p-3">
                                    {{ Auth::user()->role }}
                                </div>
                                <div class="p-2">
                                    {{-- <a class="dropdown-item" href="/account/profil">
                                        <i class="fa fa-fw fa-user-circle me-1"></i> Profil
                                    </a>
                                    <a class="dropdown-item" href="/account/wallet">
                                        <i class="fa fa-fw fa-wallet text-primary me-1"></i> Portefeuille
                                    </a> --}}
                                    <div role="separator" class="dropdown-divider"></div>
                                    <form class="dropdown-item" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn">
                                            <i class="fa fa-fw fa-arrow-alt-circle-left me-1"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-bell"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                                    Notifications
                                </div>
                                <ul class="nav-items my-2">
                                    {{-- <li>
                                        <a class="d-flex text-dark py-2" href="account/notifications/:id">
                                            <div class="flex-shrink-0 mx-3">
                                            <i class="fa fa-fw fa-check-circle text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 fs-sm pe-2">
                                            <div class="fw-semibold">App was updated to v5.6!</div>
                                            <div class="text-muted">3 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex text-dark py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 mx-3">
                                            <i class="fa fa-fw fa-user-plus text-info"></i>
                                            </div>
                                            <div class="flex-grow-1 fs-sm pe-2">
                                            <div class="fw-semibold">New Subscriber was added! You now have 2580!
                                            </div>
                                            <div class="text-muted">10 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex text-dark py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 mx-3">
                                            <i class="fa fa-fw fa-times-circle text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1 fs-sm pe-2">
                                            <div class="fw-semibold">Server backup failed to complete!</div>
                                            <div class="text-muted">30 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex text-dark py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 mx-3">
                                            <i class="fa fa-fw fa-exclamation-circle text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1 fs-sm pe-2">
                                            <div class="fw-semibold">You are running out of space. Please consider
                                                upgrading your plan.</div>
                                            <div class="text-muted">1 hour ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-flex text-dark py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 mx-3">
                                            <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 fs-sm pe-2">
                                            <div class="fw-semibold">New Sale! + $30</div>
                                            <div class="text-muted">2 hours ago</div>
                                            </div>
                                        </a>
                                    </li> --}}
                                </ul>
                                <div class="p-2 border-top">
                                    <a class="btn btn-alt-primary w-100 text-center" href="#">
                                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> Tous voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="page-header-search" class="overlay-header bg-header-dark">
                    <div class="content-header">
                        <form class="w-100" action="/account/" method="POST">
                            @csrf
                            <div class="input-group">
                                <button type="button" class="btn btn-alt-primary" data-toggle="layout" data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                                <input type="text" class="form-control border-0" placeholder="Rechercher ..." id="page-header-search-input" name="page-header-search-input">
                            </div>
                        </form>
                    </div>
                </div>

                <div id="page-header-loader" class="overlay-header bg-header-dark">
                    <div class="bg-white-10">
                        <div class="content-header">
                            <div class="w-100 text-center">
                                <i class="fa fa-fw fa-sun fa-spin text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <main id="main-container">
                {{ $slot }}
            </main>
            
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-0">
                    <div class="row fs-sm">
                        <div class="col-sm-6 order-sm-1 text-center text-sm-start">
                            <a class="fw-semibold" href="https://letsgogyms.com" target="_blank">Let's go gym Fitness</a> &copy;
                            <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @yield('jsbtm')
    </body>
</html>
