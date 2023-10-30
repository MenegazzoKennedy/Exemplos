<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src='{{ asset("img/logo.png") }}' alt="Horse 4 U Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Horse4U</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
      <!-- Sidebar user panel (optional) -->
      
      <a href="#" class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src='{{ asset("img/avatar.png") }}' class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">{{ Auth::user()->name }}</div>
      </a>

    
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child nav-compact" data-widget="treeview" role="menu" data-accordion="false">

            
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Início
                </p>
              </a>              
            </li>

            @hasrole('admin')
            <li class="nav-header">Explore</li> 
            
            @php /*
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon  fas fa-hand-holding-usd"></i>
                <p>Relatórios</p>
              </a>
            </li>

            <li class="nav-header">Gestão</li> */ 
            @endphp

            <li class="nav-item">
              <a href="{{ route('dashboard.usuarios.index') }}" class="nav-link {{ request()->routeIs('dashboard.usuarios.index') ? 'active' : '' }} {{ (request()->is('dashboard.usuarios.index')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Usuários
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('dashboard.tags.index') }}" class="nav-link {{ request()->routeIs('dashboard.tags.index') ? 'active' : '' }} {{ (request()->is('dashboard.tags.index')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-hashtag"></i>
                <p>
                  Tags
                </p>
              </a>
            </li>

              <li class="nav-item has-treeview {{ request()->routeIs('dashboard.denuncia.index') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.denuncia.edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.denuncia-new') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.tipoDenuncia') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.denuncia.create') ? 'menu-is-opening menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('dashboard.denuncia.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.denuncia.edit') ? 'active' : '' }} {{ request()->routeIs('dashboard.denuncia-new') ? 'active' : '' }} {{ request()->routeIs('dashboard.tipoDenuncia') ? 'active' : '' }} {{ request()->routeIs('dashboard.denuncia.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-flag"></i>
                  <p>
                    Denúncia
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('dashboard.denuncia.index') }}" class="nav-link {{ request()->routeIs('dashboard.denuncia.index') ? 'active' : '' }} {{ (request()->is('dashboard.denuncia.index')) ? 'active' : '' }} w-100">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Exibir Denúncias</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('dashboard.tipoDenuncia') }}" class="nav-link {{ request()->routeIs('dashboard.tipoDenuncia') ? 'active' : '' }} {{ (request()->is('dashboard.tipoDenuncia')) ? 'active' : '' }} w-100">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Exibir Tipo de Denúncias</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('dashboard.denuncia.create') }}" class="nav-link {{ request()->routeIs('dashboard.denuncia.create') ? 'active' : '' }} {{ (request()->is('dashboard.denuncia.create')) ? 'active' : '' }} w-100">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cadastrar Tipo</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{ route('dashboard.publicacoes.index') }}" class="nav-link {{ request()->routeIs('dashboard.publicacoes.index') ? 'active' : '' }} {{ (request()->is('dashboard.publicacoes.index')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-align-left"></i>
                  <p>Publicações</p>
                </a>
              </li>

              <li class="nav-item has-treeview {{ request()->routeIs('dashboard.anuncios.index') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.anuncios.create') ? 'menu-is-opening menu-open' : '' }} ">
                <a href="#" class="nav-link {{ request()->routeIs('dashboard.anuncios.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.anuncios.create') ? 'active' : '' }}">
                <i class="nav-icon fab fa-adversal"></i>
                  <p>Anúncios <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('dashboard.anuncios.index') }}" class="nav-link {{ request()->routeIs('dashboard.anuncios.index') ? 'active' : '' }} {{ (request()->is('dashboard.anuncios.index')) ? 'active' : '' }} w-100">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listar Anúncios</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('dashboard.anuncios.create') }}" class="nav-link {{ request()->routeIs('dashboard.anuncios.create') ? 'active' : '' }} {{ (request()->is('dashboard.anuncios.create')) ? 'active' : '' }} w-100">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Adicionar Anúncio</p>
                    </a>
                  </li>                
                </ul>
              </li>
            @endhasrole

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
              
            </ul>
        </nav>
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>