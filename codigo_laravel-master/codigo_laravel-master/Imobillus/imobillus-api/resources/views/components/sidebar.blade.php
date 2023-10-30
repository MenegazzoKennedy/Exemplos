<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src='{{ asset("img/logo.png") }}' alt="CRM Imobillus" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CRM Imobillus</span>
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
          <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">

            
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

            <li class="nav-item has-treeview {{ request()->routeIs('dashboard.produtos.index') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.produtos.edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.cadastrar-view') ? 'menu-is-opening menu-open' : '' }}  ">
              <a href="#" class="nav-link {{ request()->routeIs('dashboard.produtos.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.produtos.edit') ? 'active' : '' }} {{ request()->routeIs('dashboard.cadastrar-view') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Imóveis
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('dashboard.produtos.index') }}" class="nav-link {{ request()->routeIs('dashboard.produtos.index') ? 'active' : '' }} {{ (request()->is('dashboard.produtos.index')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Exibir Imóveis</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dashboard.cadastrar-view') }}" class="nav-link {{ request()->routeIs('dashboard.cadastrar-view') ? 'active' : '' }} {{ (request()->is('dashboard.cadastrar-view')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cadastrar Imóveis</p>
                  </a>
                </li>                
              </ul>
            </li>
            
            <li class="nav-item has-treeview {{ request()->routeIs('dashboard.categoria.index') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.categoria.edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('dashboard.categoria-new') ? 'menu-is-opening menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('dashboard.categoria.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.categoria.edit') ? 'active' : '' }} {{ request()->routeIs('dashboard.categoria-new') ? 'active' : '' }}">
                <i class="nav-icon fas fa-flag"></i>
                <p>
                  Categorias Imóveis
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('dashboard.categoria.index') }}" class="nav-link {{ request()->routeIs('dashboard.categoria.index') ? 'active' : '' }} {{ (request()->is('dashboard.categoria.index')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Exibir Categorias</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dashboard.categoria-new') }}" class="nav-link {{ request()->routeIs('dashboard.categoria-new') ? 'active' : '' }} {{ (request()->is('dashboard.categoria-new')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cadastrar Categoria</p>
                  </a>
                </li>
              </ul>
            </li>

            

            <li class="nav-item has-treeview  d-none">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-hard-hat"></i>
                <p>
                  Construtora
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="{{ route('dashboard.construtora') }}" class="nav-link {{ request()->routeIs('dashboard.teste') ? 'active' : '' }} {{ (request()->is('dashboard.teste')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Configurações da conta</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dashboard.construtora') }}" class="nav-link {{ request()->routeIs('dashboard.teste') ? 'active' : '' }} {{ (request()->is('dashboard.teste')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Catálogo</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('dashboard.construtora') }}" class="nav-link {{ request()->routeIs('dashboard.teste') ? 'active' : '' }} {{ (request()->is('dashboard.teste')) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Corretor</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ route('dashboard.negociacao.index') }}" class="nav-link {{ request()->routeIs('dashboard.negociacao.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.negociacao.edit') ? 'active' : '' }} {{ (request()->is('dashboard.negociacao.index')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-signature"></i>
                <p>
                  Negociações
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('dashboard.visita.index') }}" class="nav-link {{ request()->routeIs('dashboard.visita.index') ? 'active' : '' }} {{ request()->routeIs('dashboard.visita.edit') ? 'active' : '' }} {{ (request()->is('dashboard.visita.index')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  Agendamento Visíta
                </p>
              </a>
            </li>

            <li class="nav-header">Gestão</li> 

            <li class="nav-item">
              <a href="{{ route('dashboard.usuarios.index') }}" class="nav-link {{ request()->routeIs('dashboard.usuarios.edit') ? 'active' : '' }} {{ request()->routeIs('dashboard.usuarios.index') ? 'active' : '' }} {{ (request()->is('dashboard.usuarios.index')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Usuários
                </p>
              </a>
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