<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
        <i class="cil-menu"></i>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
        Admin
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true">
        <i class="cil-menu"></i>
    </button>
    <ul class="c-header-nav ml-auto mr-0">
        <li class="c-header-nav-item mx-1">
            <a class="c-header-nav-link" href="{{ route('consultation') }}">
                {{ __('Get Consultation') }}
            </a>
        </li>
        <li class="c-header-nav-item mx-1">
            <a class="c-header-nav-link" href="{{ route('welcome') }}">
                <i class="cil-settings"></i>
            </a>
        </li>
    </ul>
    <ul class="c-header-nav mr-4">
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <i class="cil-user mr-1"></i> {{ auth()->user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-1">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-from').submit();">
                    <i class="cil-account-logout mr-2"></i> {{ __('Logout') }}
                </a>
                <form id="logout-from" action="{{ route('logout') }}" method="post" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>
