<!-- Sidebar -->
<div class="sidebar">
  <!-- SidebarSearch Form -->
  <!-- Sidebar Search Form -->
  <div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
    <!-- Profile Image -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid white;width: 100%;">
      <div class="image">
        <img
          src="{{ auth()->check() ? auth()->user()->getProfilePictureUrl() : asset('adminlte/dist/img/user2-160x160.jpg') }}"
          class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ url('/profile') }}" class="d-block">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</a>
      </div>
    </div>
  </div>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <li class="nav-header">User Data</li>
      <li class="nav-item">
        <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
          <i class="nav-icon fas fa-layer-group"></i>
          <p>Level User</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
          <i class="nav-icon far fa-user"></i>
          <p>User Data</p>
        </a>
      </li>

      <li class="nav-header">Item Data</li>
      <li class="nav-item">
        <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
          <i class="nav-icon far fa-bookmark"></i>
          <p>Item Category</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
          <i class="nav-icon far fa-list-alt"></i>
          <p>Item Data</p>
        </a>
      </li>
      <li class="nav-header">Transaction Data</li>
      <li class="nav-item">
        <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
          <i class="nav-icon fa-cubes"></i>
          <p>Stock of Item</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
          <i class="nav-icon fas fa-cash-register"></i>
          <p>Sales Transactions</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/detail') }}" class="nav-link {{ ($activeMenu == 'detail') ? 'active' : '' }}">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>Detail Sales Transactions</p>
        </a>
      </li>
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-link btn btn-link {{ ($activeMenu == 'logout') ? 'active' : '' }}"
            style="padding: 0; margin: 0;">
            <p>Logout</p>
          </button>
        </form>
      </li>
    </ul>
  </nav>
</div>
<!-- /.sidebar -->