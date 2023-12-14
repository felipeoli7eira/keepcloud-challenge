<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark h-100">
    <a href="{{ route('dashboard.home') }}" class="d-flex align-items-center justify-content-center w-100 mb-3 mb-md-0 me-md-auto text-white text-decoration-none p-3">
        <img src="{{ asset('svg/laravel-white.svg') }}" loading="lazy" width="100" class="d-block">
    </a>

    <ul class="nav nav-pills flex-column mb-auto mt-5">
        <li class="nav-item mt-1">
            <a href="{{ route('dashboard.partner.list') }}" class="nav-link {{ request()->is('dashboard/partner*') ? 'active' : '' }}" aria-current="page">
                <span class="text-white">Sócios</span>
            </a>
        </li>
        <li class="nav-item mt-1">
            <a href="{{ route('dashboard.users.index') }}" class="nav-link {{ request()->is('dashboard/users*') ? 'active' : '' }}" aria-current="page">
                <span class="text-white">Usuários</span>
            </a>
        </li>
    </ul>


    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('svg/user-white.svg') }}" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ auth()->user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <a class="dropdown-item @if(request()->is('dashboard/profile')) active @endif" href="{{ route('dashboard.user.profile.show') }}">Meu perfil</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout_form').submit()">LogOut</a>

                <form action="{{ route('logout') }}" method="post" id="logout_form" class="d-none"> @csrf </form>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-link.active, .nav-link.active:hover
    {
        background-color: #393c41 !important
    }
</style>
