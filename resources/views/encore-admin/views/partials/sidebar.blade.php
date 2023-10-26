<aside class="main-sidebar elevation-4 sidebar-{{ config('admin.theme.sidebar') }}">

    <a href="{{ admin_url('/') }}" class="brand-link {{ config('admin.theme.logo') ? 'navbar-'.config('admin.theme.logo') : '' }}">
        <img src="{!! config('admin.logo.image') !!}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{!! config('admin.logo.text', config('admin.name')) !!}</span>
    </a>

    <!-- sidebar: style can be found in sidebar.less -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Admin::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/admin" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>

                @hasanyrole('Administrator')

                <li class="nav-item">
                    <a href="/admin/products" class="nav-link">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>Products <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>

                @endhasanyrole

                {{-- <li class="nav-item">
                    <a href="/admin/record-sales" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Record Sales <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="/admin/sales" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Sales <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/product-sales-per-day" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Sales Per Day <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="/admin/product-sales-per-month" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Sales Per Month <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="/admin/product-sales-per-product" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>Sales Per Product <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/suppliers" class="nav-link">
                        <i class="nav-icon fas fa-car-side"></i>
                        <p>Suppliers <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                    </a>
                <li>
                

                @hasanyrole('Administrator')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/roles" class="nav-link">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Roles <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/auth/users" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Users <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Permissions <span class="fi fi-gr"></span> <span class="fi fi-gr fis"></span></p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                @endhasanyrole

                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
