@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
$userIsLogged = !is_null(session()->get('user'));
$currentRouteName = Route::currentRouteName();
$routes = [
    [
        'name' => 'home',
        'label' => 'Inicio',
        'url' => '/',
        'icon' => 'home',
    ],
    [
        'name' => 'search',
        'label' => 'Buscar',
        'url' => '/search',
        'icon' => 'magnifier',
    ],
    [
        'name' => '', /* No es necesario que se ponga nada el boton "Crear" */
        'label' => 'Crear',
        'url' => $userIsLogged
            ? route('pagePerfil', ['tab' => 'my-ads', 'modal' => 'modal-form-advertisement'])
            : url('login'),
        'icon' => 'create',
    ],
];

$userAvatar = $userIsLogged
    ? (str_starts_with(session()->get('cliente')['avatar'] , "https:"))
    ? session()->get('cliente')['avatar']
    : config('app.FILES_URL') . session()->get('cliente')['avatar']
    :
    asset('assets/img/avatars/avatar-default.webp');
@endphp


<!-- Guide: Start -->
<div id="top-alert" class="alert alert-primary alert-dismissible fade show text-center mb-0 bg-primary" role="alert" style=" color: white;">
  <div class="container">
    <div class="d-flex align-items-center justify-content-center position-relative">
      <strong>¡Guíame para encontrar un anuncio!</strong>
      <a href="#" class="btn-guia ms-2">Buscar anuncio</a>

      {{-- Botón de cierre --}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: white;"></button>
    </div>
  </div>
</div>
<!-- Guide: End -->

<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0 mb-6">
    <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4 me-xl-8">
                <!-- Mobile menu toggle: Start-->
                <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="ti ti-menu-2 ti-lg align-middle text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{ route('home') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 33, 'width' => 54, 'withbg' => 'fill: #fff;'])</span>
                    {{-- <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ config('variables.templateName') }}</span> --}}
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti ti-x ti-lg"></i>
                </button>
                {{-- Rutas --}}
                <ul class="navbar-nav mx-auto gap-8">

                    @foreach ($routes as $route)
                    <li class="nav-item d-flex align-items-center nav-link {{ $currentRouteName === $route['name'] ? 'active' : '' }}">
                        @include('icons.svg.' . $route['icon'], ['active' => $currentRouteName === $route['name']])
                        <a class="nav-link" href="{{ url($route['url']) }}">{{ $route['label'] }}</a>
                    </li>
                    @endforeach

                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="navbar-nav flex-row align-items-center ms-auto gap-3">
                @if ($configData['hasCustomizer'] == true)
                    <!-- Style Switcher -->
                    <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <i class='ti ti-lg'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                    <span class="align-middle"><i class='ti ti-sun me-3'></i>Light</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                    <span class="align-middle"><i class="ti ti-moon-stars me-3"></i>Dark</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                    <span class="align-middle"><i
                                            class="ti ti-device-desktop-analytics me-3"></i>System</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- / Style Switcher-->
                @endif

                <!-- Chat icon -->
                @if(!is_null(session()->get('user')))
                    <li class="nav-item">
                        {{-- <a class="nav-link fw-medium" href="{{url('app/chat')}}">Chat</a> --}}
                        <a href="{{ Route('chat') }}" class="icon-circle">
                            @include('icons.svg.chat', ['color' => '#52CFC4'])
                        </a>
                    </li>
                @endif

                <!-- navbar button: Start -->
                {{-- <li>
                  <a href="{{url('/login')}}" class="btn btn-primary" target="_blank"><span class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span><span class="d-none d-md-block">Login/Register</span></a>
                </li> --}}

                <!-- Profile -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <div class="avatar {{ $userIsLogged ? 'avatar-online' : '' }}">
                            <img src="{{ $userAvatar }}"
                                alt="Avatar usuario" class="rounded-circle">
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        @if($userIsLogged)
                            <li>
                                <a class="dropdown-item mt-0"
                                    href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar  {{ $userIsLogged ? 'avatar-online' : '' }}">
                                                <img src="{{ $userAvatar }}"
                                                    alt="Avatar usuario" class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">
                                                @if (session()->get('user') && session()->get('cliente'))
                                                    {{ session()->get('cliente')['nombre'] . ' ' . session()->get('cliente')['apellidos']}}
                                                @else
                                                    John Doe
                                                @endif
                                            </h6>
                                            @if(session()->get('user'))
                                                <small class="text-muted">{{session()->get('user')['tipo'] == "autonomo" ? 'Autónomo' : 'Cliente'}}</small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider my-1 mx-n2"></div>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ Route::has('profile.show') ? route('profile.show') : route('pagePerfil') }}">
                                    <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">Mi perfil</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider my-1 mx-n2"></div>
                            </li>
                            {{-- @if (Auth::check())
                                <li>
                                    <div class="d-grid px-2 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <small class="align-middle">Logout</small>
                                            <i class="ti ti-logout ms-2 ti-14px"></i>
                                        </a>
                                    </div>
                                </li>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            @else --}}
                            <li>
                                <div class="d-grid px-2 pt-2 pb-1">

                                    @if($userIsLogged)
                                        <form action="/logout" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-sm w-100 btn-danger d-flex">
                                                <small class="align-middle">Logout</small>
                                                <i class="ti ti-logout ms-2 ti-14px"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ url('login') }}" class="btn btn-sm btn-primary d-flex">
                                            <small class="align-middle">Login</small>
                                            <i class="ti ti-login ms-2 ti-14px"></i>
                                        </a>

                                    @endif


                                </div>
                            </li>
                            {{-- @endif --}}

                        @else

                            <li>
                                <div>
                                    <a href="{{ url('login') }}" class="dropdown-item mb-1">
                                        <i class="ti ti-login me-2 ti-sm"></i>
                                        <small class="align-middle">Login</small>
                                    </a>

                                    <a href="{{ url('login') }}" class="dropdown-item">
                                        <i class="ti ti-user-plus me-2 ti-sm"></i>
                                        <small class="align-middle">Registro</small>
                                    </a>
                                </div>
                            </li>

                        @endif
                    </ul>
                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->
