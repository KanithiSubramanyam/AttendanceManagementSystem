<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('employees.index') }}" class="nav-link {{ Request::is('employees*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Employees</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('joinDetails.index') }}" class="nav-link {{ Request::is('joinDetails*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Join Details</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('attendances.index') }}" class="nav-link {{ Request::is('attendances*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Attendances</p>
    </a>
</li>

