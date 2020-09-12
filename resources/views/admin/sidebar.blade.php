<div id="openSidebar"><i class="fas fa-bars"></i></div>
  <aside class="sidebar">
        <header>
        {{ Auth::user()->name }}
        <i class="fas fa-times-circle" id="closeSidebar"></i>
      </header>
    <nav class="sidebar-nav">
      <ul>
        <li>
          <a href="#"><i class="ion-bag"></i> <span>Pasiūlymai</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-color-filter-outline"></i>Visi pasiūlymai</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-clock-outline"></i>Kurti naują</a>
            </li>
            <li>
              <a href="#"><i class="ion-android-star-outline"></i>Pasiūlymų rikiavimas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-settings"></i> <span class="">Controls</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-alarm-outline"></i>Watch</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-camera-outline"></i>Creeper</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-chatboxes-outline"></i>Hate</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-cog-outline"></i>Grinder</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="ion-ios-briefcase-outline"></i> <span class="">Folio</span></a>
          <ul class="nav-flyout">
            <li>
              <a href="#"><i class="ion-ios-flame-outline"></i>Burn</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-lightbulb-outline"></i>Bulbs</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-location-outline"></i>Where You</a>
            </li>
            <li>
              <a href="#"><i class="ion-ios-locked-outline"></i>On Lock</a>
            </li>
             <li>
              <a href="#"><i class="ion-ios-navigate-outline"></i>Ghostface</a>
            </li>
          </ul>
        </li>
        @if (Auth::user()->isSuperAdmin())
          <li>
            <a href="{{ route('superAdminUsers') }}"><i class="ion-ios-briefcase-outline"></i> <span class="">Vartotojai</span></a>
            <ul class="nav-flyout">
              <li>
                <a href="#"><i class="ion-ios-flame-outline"></i>Administratoriai</a>
              </li>
              <li>
                <a href="#"><i class="ion-ios-lightbulb-outline"></i>Klientai</a>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </nav>
  </aside>