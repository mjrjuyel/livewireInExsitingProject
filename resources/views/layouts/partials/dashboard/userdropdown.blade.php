<div class="topbar-item nav-user">
    <div class="dropdown">
        <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{ asset('contents/admin') }}/assets/images/users/avatar-1.jpg" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image">
            <span class="d-lg-flex flex-column gap-1 d-none">
                <h6 class="my-0">{{ Auth::user()->name }}</h6>
            </span>
            <i class="mdi mdi-chevron-down d-none d-lg-block align-middle ms-2"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <div class="dropdown-header bg-primary mt-n3 rounded-top-2">
                <h6 class="text-overflow text-white m-0">Welcome !</h6>
            </div>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
                <i class="mdi mdi-account-outline"></i>
                <span>Profile</span>
            </a>

            <!-- item-->
            <a href="{{ route('dashboard.admin.passwordChange',Auth::user()->slug ) }}" class="dropdown-item notify-item">
                <i class="mdi mdi-cog"></i>
                <span>Update Profile</span>
            </a>

            <div class="dropdown-divider"></div>

            <!-- item-->
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                <i class="mdi mdi-logout-variant"></i>
                <span>Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        </div>
    </div>
</div>
