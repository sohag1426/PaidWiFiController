<aside class="main-sidebar {{ config('consumer.app_skin') }} elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ Auth::user()->company }}</span>
    </a>
    <!--/Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @php

                $menu = [
                '0' => 0,
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0,
                '13' => 0,
                '14' => 0,
                '15' => 0,
                '20' => 0,
                ];

                $link = [
                '0' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '1' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0],
                '2' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0],
                '3' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '4' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0, '6' => 0, '7' => 0],
                '5' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0],
                '6' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' =>
                0],
                '7' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '8' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '9' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '10' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '11' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '12' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '13' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '14' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '15' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                '20' => ['0' => 0,'1' => 0,'2' => 0, '3' => 0 , '4' => 0, '5' => 0],
                ];

                if(isset($active_menu)){
                $menu[$active_menu] = 1;
                }

                if(isset($active_link)){
                $link[$active_menu][$active_link] = 1;
                }

                @endphp

                <!--Dashboard menu[0]-->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if ($menu['0']) active @endif ">
                        <i class="fas fa-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!--/Dashboard-->

                <!--Routers & Packages menus[2]-->
                <li class="nav-item has-treeview @if ($menu['2']) menu-open @endif ">

                    <a href="#" class="nav-link @if ($menu['2']) active @endif ">
                        <i class="fas fa-asterisk"></i>
                        <p>
                            Routers & Packages
                            <i class="fas fa-caret-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!--Routers-->
                        <li class="nav-item">
                            <a href="{{ route('routers.index') }}"
                                class="nav-link @if ($link['2']['1']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Routers</p>
                            </a>
                        </li>
                        <!--/Routers-->

                        <!--Master packages-->
                        <li class="nav-item">
                            <a href="{{ route('master_packages.index') }}"
                                class="nav-link @if ($link['2']['6']) active @endif ">
                                <i class="fas fa-angle-right text-danger nav-icon"></i>
                                <p>Master Packages</p>
                            </a>
                        </li>
                        <!--/Master packages-->

                        <!--packages-->
                        <li class="nav-item">
                            <a href="{{ route('packages.index') }}"
                                class="nav-link @if ($link['2']['7']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Packages</p>
                            </a>
                        </li>
                        <!--/packages-->

                    </ul>

                </li>
                <!--/Routers & Packages menu[2]-->

                <!--Recharge Card [13]-->
                <li class="nav-item has-treeview @if ($menu['13']) menu-open @endif ">

                    <a href="#" class="nav-link @if ($menu['13']) active @endif ">
                        <i class="fas fa-store"></i>
                        <p>
                            Recharge Card
                            <i class="fas fa-caret-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!--Card Distributors-->
                        <li class="nav-item">
                            <a href="{{ route('card_distributors.index') }}"
                                class="nav-link @if ($link['13']['1']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Card Distributors</p>
                            </a>
                        </li>
                        <!--/Card Distributors-->

                        <!--Recharge Cards-->
                        <li class="nav-item">
                            <a href="{{ route('recharge_cards.index') }}"
                                class="nav-link @if ($link['13']['3']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Recharge Cards</p>
                            </a>
                        </li>
                        <!--/Recharge Cards-->

                    </ul>

                </li>
                <!--/Recharge Card[13]-->

                <!--Customers menus[5]-->
                <li class="nav-item has-treeview @if ($menu['5']) menu-open @endif ">

                    <a href="#" class="nav-link @if ($menu['5']) active @endif ">
                        <i class="far fa-user-circle"></i>
                        <p>
                            Customers
                            <i class="fas fa-caret-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!--New Customers-->
                        <li class="nav-item">
                            <a href="#" class="nav-link @if ($link['5']['0']) active @endif ">
                                <i class="fas fa-plus nav-icon nav-icon"></i>
                                <p>New Customer</p>
                            </a>
                        </li>
                        <!--/New Customers-->

                        <!--Customers-->
                        <li class="nav-item">
                            <a href="#" class="nav-link @if ($link['5']['1']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <!--/Customers-->

                        <!--Online Customers-->
                        <li class="nav-item">
                            <a href="#" class="nav-link @if ($link['5']['2']) active @endif ">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Online Customers</p>
                            </a>
                        </li>
                        <!--/Online Customers-->

                    </ul>

                </li>
                <!--/Customers menu[5]-->

            </ul>

        </nav>
        <!-- /sidebar-menu -->

    </div>
    <!-- /sidebar -->

</aside>
