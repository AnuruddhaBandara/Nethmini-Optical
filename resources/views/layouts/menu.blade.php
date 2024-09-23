<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme bg-white shadow"
       style="background-color: #080F25;">
    <div class="app-brand mt-3 menu-disable">
        <a href="./dashboard" class="app-brand-link">
            <img src="{{asset('assets/img/optical.png')}}" alt="logo" style="width: 3090px;height: 100px"
                 class="img-fluid ic-site-logo">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor" fill-opacity="0.6"/>
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor" fill-opacity="0.38"/>
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        @can('view_dashboard')
            <li class="menu-item menu-disable">
                <a href="" class="menu-link">
                    <i class="mdi mdi-home-outline me-2"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

        @endcan
        <!--category-->
        @can('view_category')

            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-label-multiple-outline me-2"></i>
                    <div data-i18n="User Management">Category</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('category.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Category</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Items -->
        @can('view_item')
            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-view-list me-2"></i>
                    <div data-i18n="Orders">Items</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('item.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Item</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Products -->
        @can('view_suppler')
            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-account-circle me-2"></i>
                    <div data-i18n="Products">Supplier</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('supplier.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Supplier</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- customers -->
        @can('view_customer')
            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-account-outline me-2"></i>
                    <div data-i18n="Reg. Requests">Customers</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('customer.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Customers</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- stock -->
        @can('view_stock')
            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-weight me-2"></i>
                    <div data-i18n="Push Notifications">Stock</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('stock.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Stock</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Orders -->
        @can('view_orders')

            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-cart me-2"></i>
                    <div data-i18n="Push Notifications">Orders</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('order.index')}}" class="menu-link">
                            <div data-i18n="All Orders">All Orders</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Reports -->
        @can('view_report')

            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-poll me-2"></i>
                    <div data-i18n="Reports">Reports</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item menu-disable">
                        <a href="{{route('report.sales')}}" class="menu-link">
                            <div data-i18n="Heart Rate History">Sales Report</div>
                        </a>
                    </li>
                    <li class="menu-item menu-disable">
                        <a href="{{route('report.inventory')}}" class="menu-link">
                            <div data-i18n="SOS Alerts">Inventory Report</div>
                        </a>
                    </li>
                    <li class="menu-item menu-disable">
                        <a href="{{route('report.stock-management')}}" class="menu-link">
                            <div data-i18n="Tracking History">Stock Management Report</div>
                        </a>
                    </li>
                    <li class="menu-item menu-disable">
                        <a href="{{route('report.profit-loss')}}" class="menu-link">
                            <div data-i18n="Tracking History">Financial Report</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Admin Management -->
        @can('view_admin')
            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-account me-2"></i>
                    <div data-i18n="Admin Management">Admin Management</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('admin.index')}}" class="menu-link">
                            <div data-i18n="Admin Accounts">All Users</div>
                        </a>
                    </li>

                </ul>
            </li>
        @endcan
        <!-- Settings -->
        @can('view_setting')

            <li class="menu-item menu-disable">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="mdi mdi-cog-outline me-2"></i>
                    <div data-i18n="Settings">Settings</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="My Profile">My Profile</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Log Out -->
        <li class="menu-item menu-disable">
            <a href="{{route('logout')}}" class="menu-link">
                <i class="mdi mdi-logout me-2"></i>
                <div data-i18n="Log Out">Log Out</div>
            </a>
        </li>
    </ul>

</aside>
