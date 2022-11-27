<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('home')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Users Management</span>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-circle"></i>
                  <span>Vendors</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-circle"></i>
                  <span>Artists</span>
                </a>
              </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav1" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Event Management</span>
        </a>
        <ul id="icons-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('category.index')}}">
                    <i class="bi bi-circle"></i>
                  <span>Category</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('sub_category.index')}}">
                    <i class="bi bi-circle"></i>
                  <span>SubCategory</span>
                </a>
              </li>              
              <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('event.index')}}">
                    <i class="bi bi-circle"></i>
                  <span>Events</span>
                </a>
              </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav2" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear-fill"></i><span>Places</span>
        </a>
        <ul id="icons-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Restaurant</span>
                </a>
              </li>
              <li>
                <a href="{{ route('admin.bar') }}">
                  <i class="bi bi-circle"></i><span>Bars</span>
                </a>
              </li>
              <li>
                <a href="{{ route('admin.club')}}">
                  <i class="bi bi-circle"></i><span>Clubs</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Country</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>State</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>City</span>
                </a>
              </li>             
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Status</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Locations</span>
                </a>
              </li>                           
        </ul>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav3" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear-fill"></i><span>Booking</span>
        </a>
        <ul id="icons-nav3" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Booking Type</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Vendor Service</span>
                </a>
              </li>  
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Tickets</span>
                </a>
              </li> 
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Tables</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Menu Items</span>
                </a>
              </li>                   
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav4" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear-fill"></i><span>Account Settings</span>
        </a>
        <ul id="icons-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="#">
            <i class="bi bi-circle"></i><span>User Type</span>
            </a>
        </li>
         <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Role</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Permissions</span>
            </a>
          </li>
        </ul>
      </li>     

      <li class="nav-item">
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                </form>
      </li>
    </ul>
  </aside><!-- End Sidebar-->
