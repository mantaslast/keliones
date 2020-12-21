<div id="openSidebar"><i class="fas fa-bars"></i></div>
  <aside class="sidebar">
        <header>
        {{ Auth::user()->name }}
        <i class="fas fa-times-circle" id="closeSidebar"></i>
      </header>
    <nav class="sidebar-nav">
      <ul>
        <li>
          <a href="{{ route('offers.index') }}"><i class="ion-bag"></i> <span>Pasiūlymai</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="{{ route('offers.create') }}"><i class="ion-ios-clock-outline"></i>Kurti naują</a>
            </li>
            <li>
              <a href="{{ route('offers.index') }}"><i class="ion-android-star-outline"></i>Pasiūlymų rikiavimas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{{ route('categories.index') }}"><i class="ion-ios-settings"></i> <span class="">Kategorijos</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="{{ route('categories.create') }}"><i class="ion-ios-camera-outline"></i>Kurti naują kategoriją</a>
            </li>
            <li>
              <a style="visibility:hidden;" href="{{ route('categories.create') }}"><i class="ion-ios-camera-outline"></i>Gal dar kas bus</a>
            </li>
          </ul>
        </li>
       
          <li>
            <a href="{{ route('superAdminUsers') }}"><i class="ion-ios-briefcase-outline"></i> <span class="">Vartotojai</span></a>
            <ul class="nav-flyout">
              <li>
                <a href="{{ route('superAdminUsers', 2) }}"><i class="ion-ios-flame-outline"></i>Administratoriai</a>
              </li>
              <li>
                <a href="{{ route('superAdminUsers', 1) }}"><i class="ion-ios-lightbulb-outline"></i>Klientai</a>
              </li>
            </ul>
          </li>
        
        @if (Auth::user()->isSuperAdmin())
          <li>
            <a href="{{ route('superAdminOrders') }}"><i class="ion-ios-briefcase-outline"></i> <span class="">Užsakymai</span></a>
          </li>
        @endif
        @if (Auth::user()->isSuperAdmin())
          <li>
            <a href="/admin"><i class="ion-ios-briefcase-outline"></i> <span class="">Analitika</span></a>
          </li>
        @endif
      </ul>
    </nav>
  </aside>