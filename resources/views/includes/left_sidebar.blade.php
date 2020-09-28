<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="{{ Auth::user()->hasRole('admin') ? route('app.dashboard') : route('user.dashboard') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item "><a class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}" href="{{ Auth::user()->hasRole('admin') ? route('app.dashboard') : route('user.dashboard') }}"><i class="fa fa-fw fa-home"></i>Dashboard</a></li>
                    @can('customer.viewAny')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'customer') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Customer Management</a>
                            <div id="submenu-2" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.index') }}">All Customers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.create') }}">New Customer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.new') }}">Newly Converted Prospects</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('manage.accountant')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'account') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Accounting</a>
                            <div id="submenu-3" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('account.index') }}">All Invoices</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('account.create') }}">New Invoice</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('account.overdue') }}">Overdue Invoices</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('technician.viewAny')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->segment(1) == 'technician') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-users"></i>Vendors/Technicians</a>
                            <div id="submenu-4" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('technician.index') }}">All Vendors/Technicians</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('technician.create') }}">New Vendor/Technician</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('technician.orders') }}">Upcoming Technician Response</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('order.viewAny')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'order') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Orders/Requests</a>
                            <div id="submenu-5" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('order.index') }}">All Orders/Requests</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('order.create') }}">New Order/Request</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('manage-staff')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'staff') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Staff Management </a>
                            <div id="submenu-6" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('staff.index') }}">All Staff</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('staff.create') }}">New Staff</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('manage.prospect')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'prospect') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-inbox"></i>Prospective Customers</a>
                            <div id="submenu-7" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('prospect.index') }}">All Prospects</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('prospect.create') }}">New Prospect</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('manage.settings')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->segment(1) == 'service') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-cogs"></i>Settings</a>
                            <div id="submenu-8" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->segment(1) == 'setting') ? 'active' : '' }}" href="{{ route('setting.index') }}">General Settings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->segment(1) == 'service') ? 'active' : '' }}" href="{{ route('service.index') }}">Service Types</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->segment(1) == 'report') ? 'active' : '' }}" href="{{ route('report.index') }}">Reports</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->segment(1) == 'messaging') ? 'active' : '' }}" href="{{ route('messaging.edit',1) }}">Messaging/Texting</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->segment(1) == 'payment-gateway') ? 'active' : '' }}" href="{{ route('payment-gateway.edit',1) }}">Payment Gateway</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->segment(1) == 'profile') ? 'active' : '' }}" href="{{ route('user.profile') }}"><i class="fas fa-fw fa-user-circle"></i>My Profile</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
