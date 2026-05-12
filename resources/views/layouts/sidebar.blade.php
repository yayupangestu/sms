<style id="custom-sidebar-style">
    /* Sidebar Background - Modern Dark Navy */
    .main-sidebar,
    .main-sidebar::before {
        background-color: #101a2eff !important;
        /* Premium Dark Navy */
        box-shadow: 4px 0 15px rgba(255, 254, 254, 1) !important;
    }

    /* Brand Header */
    .brand-link {
        background-color: #111827 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1rem 0.5rem !important;
    }

    .brand-text {
        font-weight: 700 !important;
        letter-spacing: 1px;
        color: #E0E7FF !important;
        /* Indigo 100 */
    }

    /* Link and Typography Styling */
    .main-sidebar .nav-link {
        border-radius: 0px 20px 20px 0px !important;
        margin-right: 12px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        padding: 0.7rem 1rem !important;
    }

    .main-sidebar .nav-link p {
        font-size: 15px !important;
        letter-spacing: 0.3px;
        color: #9CA3AF !important;
        /* Gray 400 */
        transition: color 0.3s ease, transform 0.3s ease;
    }

    /* .main-sidebar .nav-icon {
        font-size: 24px !important;
        margin-right: 12px !important;
        color: rgb(167, 192, 192) !important;
        text-shadow: 6px 5px 7px #000000;
        transition: all 0.3s ease !important;
    } */

    /* Category Headers */
    .main-sidebar .nav-header {
        font-size: 15px !important;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: #4F46E5 !important;
        /* Indigo 600 */
        text-transform: uppercase;
        padding-top: 1.5rem !important;
        padding-bottom: 0.5rem !important;
    }

    /* ACTIVE MENU STATE - Extremely Premium Gradient and Glow */
    .nav-legacy.nav-sidebar .nav-item>.nav-link.active {
        background: linear-gradient(90deg, rgba(79, 70, 229, 0.2) 0%, rgba(79, 70, 229, 0.0) 100%) !important;
        border-left: 4px solid #ffffffff !important;
        /* Indigo 500 */
        box-shadow: inset 1px 0px 5px rgba(99, 102, 241, 0.1) !important;
    }

    .nav-legacy.nav-sidebar .nav-item>.nav-link.active p {
        color: #ffffff !important;
        font-weight: 500 !important;
    }

    .nav-legacy.nav-sidebar .nav-item>.nav-link.active .nav-icon {
        color: #6366F1 !important;
        /* Bright Indigo for Active Icons */
        text-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
    }

    /* HOVER STATE */
    .main-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    .main-sidebar .nav-link:hover p {
        color: #E5E7EB !important;
        /* Gray 200 */
        transform: translateX(4px);
    }

    .main-sidebar .nav-link:hover .nav-icon {
        color: #9CA3AF !important;
        transform: translateX(4px) scale(1.05);
    }

    /* Custom Scrollbar for Webkit */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .sidebar:hover::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-2">
    <a class="brand-link border-0">
        <img src="dist/img/pie.png" alt="AdminLTE Logo" class="brand-image">
        <span class="brand-text font-weight-bold"><b>SmS</b></span>
    </a>

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact"
                data-widget="treeview" role="menu" data-accordion="false">
                @if (auth()->user()->level == '')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>

                @elseif (auth()->user()->level == 'UserB3')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('dashboardplanning') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('dashboardplanning') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Dashboard B3 C1 C2
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanning.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanning') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmp.index') }}"
                                    class="nav-link {{ Request::is('scaninstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        SCAN IN STMP
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        SCAN OUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanreturnrm.index') }}"
                                    class="nav-link {{ Request::is('scanreturnrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-arrow-u-left-down"></i>
                                    <p>
                                        Scan Return RM
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'UserB12')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('dashboardplanningb12', 'scaninstmpB12', 'scanoutstmp', 'kanbanstmpb1', 'prosesqr1', 'scanreturnrm', 'kanbanstmpb2', 'kanbanstmpc2', ) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninstmpb12', 'scanoutstmp', 'kanbanstmp', 'kanbanstmpc1', 'kanbanstmpc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                Stamping Line
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmpb12.index') }}"
                                    class="nav-link {{ Request::is('scaninstmpb12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN (B1,B2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT (B1,B2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningb12.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningb12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard (B1,B2)
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('prosesqr1.index') }}"
                                    class="nav-link {{ Request::is('prosesqr1') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Trace
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmp.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP B3
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc1.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C1
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc2.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'UserA12')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('dashboardplanninga12', 'scaninstmpa12', 'scanoutstmp', 'kanbanstmpb1', 'prosesqr1', 'scanreturnrm', 'kanbanstmpb2', 'kanbanstmpc2', ) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninstmpa12', 'scanoutstmp', 'kanbanstmp', 'kanbanstmpc1', 'kanbanstmpc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                Stamping Line A
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmpa12.index') }}"
                                    class="nav-link {{ Request::is('scaninstmpa12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN (A1,A2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT (A1,A2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanninga12.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanninga12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard (A1,A2)
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('prosesqr1.index') }}"
                                    class="nav-link {{ Request::is('prosesqr1') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Trace
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmp.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP B3
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc1.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C1
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc2.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'User3000')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('dashboardplanningatransfers', 'scaninstmptransfers', 'scanoutstmp', 'kanbanstmpb1', 'prosesqr1', 'scanreturnrm', 'kanbanstmpb2', 'kanbanstmpc2', ) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninstmptransfers', 'scanoutstmp', 'kanbanstmp', 'kanbanstmpc1', 'kanbanstmpc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                Stamping Transfers
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmptransfers.index') }}"
                                    class="nav-link {{ Request::is('scaninstmptransfers') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN TRANSFERS
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT TRANSFERS
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningatransfers.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningatransfers') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard TRANSFERS
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('prosesqr1.index') }}"
                                    class="nav-link {{ Request::is('prosesqr1') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Trace
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmp.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP B3
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc1.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C1
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc2.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'AdminRM2')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('material', 'supplierrm') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('material', 'supplierrm') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Master Data
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('material.index') }}"
                                    class="nav-link {{ Request::is('material') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-grid-nine"></i>
                                    <p>
                                        Material
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('supplierrm.index') }}"
                                    class="nav-link {{ Request::is('supplierrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-thin ph-truck"></i>
                                    <p>
                                        Supplier Material
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{ Request::is('dashboardrmstok', 'dashboardrm', 'dashboardmps') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('dashboardrmstok', 'dashboardrm', 'dashboardmps') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrm.index') }}"
                                    class="nav-link {{ Request::is('dashboardrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard RM
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrmstok.index') }}"
                                    class="nav-link {{ Request::is('dashboardrmstok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard Stok
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardmps.index') }}"
                                    class="nav-link {{ Request::is('dashboardmps') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashbaord Supply
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{ Request::is('rmdnincoming', 'inmaterial', 'rmreturn', 'rmstok') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('rmdnincoming', 'inmaterial', 'rmreturn', 'rmstok') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Transaksi
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('inmaterial.index') }}"
                                    class="nav-link {{ Request::is('inmaterial') ? 'active' : '' }}">
                                    <i class="nav-icon ph ph-arrow-square-down"></i>
                                    <p>
                                        Create Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('rmreturn.index') }}"
                                    class="nav-link {{ Request::is('rmreturn') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-arrow-u-left-down"></i>
                                    <p>
                                        MATERIAL RETURN
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('rmstok.index') }}"
                                    class="nav-link {{ Request::is('rmstok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Stok Material
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('dashboardmps') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('dashboardmps') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Scan
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlabel.index') }}"
                                    class="nav-link {{ Request::is('scaninlabel') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutrm.index') }}"
                                    class="nav-link {{ Request::is('scanoutrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabel2.index') }}"
                                    class="nav-link {{ Request::is('taglabel2') ? 'active' : ''}}">
                                    <i class="nav-icon fas fa fa-pencil"></i>
                                    <p>
                                        Tag Label Opsional
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'AdminRM')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('dashboardrmstok', 'dashboardrm', 'dashboardmps') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('dashboardrmstok', 'dashboardrm', 'dashboardmps') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <p>
                                    Raw Material (MPC)
                                    <i class="right fas fa-chevron-left"></i>
                                </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrm.index') }}"
                                    class="nav-link {{ Request::is('dashboardrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard RM
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrmstok.index') }}"
                                    class="nav-link {{ Request::is('dashboardrmstok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard Stok
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardmps.index') }}"
                                    class="nav-link {{ Request::is('dashboardmps') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashbaord Outgoing
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlabel.index') }}"
                                    class="nav-link {{ Request::is('scaninlabel') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlabel2.index') }}"
                                    class="nav-link {{ Request::is('scaninlabel2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Label Opsional
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutrm.index') }}"
                                    class="nav-link {{ Request::is('scanoutrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabel2.index') }}"
                                    class="nav-link {{ Request::is('taglabel2') ? 'active' : ''}}">
                                    <i class="nav-icon fas fa fa-pencil"></i>
                                    <p>
                                        Tag Label Opsional
                                    </p>
                                </a>
                            </li>
                        </ul>

                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('rmreturn.index') }}"
                                    class="nav-link {{ Request::is('rmreturn') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-arrow-u-left-down"></i>
                                    <p>
                                        MATERIAL RETURN
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    </li>

                @elseif (auth()->user()->level == 'AdminLS')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('scaninlsrepair', 'linestorestok', 'linestoreindex', 'linestoreindex2', 'linestoreupload') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninlsrepair', 'linestorestok', 'linestoreindex', 'linestoreindex2', 'linestoreupload') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-storefront"></i>
                            <p>
                                Line Store
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboard1ls.index') }}"
                                    class="nav-link {{ Request::is('dashboard1ls') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Dashbaord LS d
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Outhouse
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex2.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Inhouse
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex3.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex3') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Inhouse
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('tabelb3', 'tabelc1', 'tabelc2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('tabelb3', 'tabelc1', 'tabelc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-hand-pointing"></i>
                            <p>
                                Button Push
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanweldingpart.index') }}"
                                    class="nav-link {{ Request::is('scanweldingpart') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan Request Welding
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{ Request::is('tabelstoksbc', 'taglabelsubcont', 'scanoutls') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('tabelstoksbc', 'taglabelsubcont', 'scanoutls') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-truck"></i>
                            <p>
                                Subcont
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelstoksbc.index') }}"
                                    class="nav-link {{ Request::is('tabelstoksbc') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Subcont
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabelsubcont.index') }}"
                                    class="nav-link {{ Request::is('taglabelsubcont') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tag Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutls.index') }}"
                                    class="nav-link {{ Request::is('scanoutls') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Scan Out LS
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>



                @elseif (auth()->user()->level == 'userWelding')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda userWelding
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('taglabelwelding') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('taglabelwelding') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-fire"></i>
                            <p>
                                Welding Line
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardwelding1.index') }}"
                                    class="nav-link {{ Request::is('dashboardwelding1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabelwelding.index') }}"
                                    class="nav-link {{ Request::is('taglabelwelding') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tag Label
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="http://asi.adyawinsa.com:814/" target="_blank" class="nav-link">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        E-SPB STORE ROOM
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpswelding2.index') }}"
                                    class="nav-link {{ Request::is('scaninpswelding2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan PC-STORE
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'PlanerPPIC')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Planning (PPIC)
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('planninglineb3.index') }}"
                                    class="nav-link {{ Request::is('planninglineb3', ) ? 'active' : '' }}">
                                    <i class="nav-icon 	fas fa-edit"></i>
                                    <p>
                                        Planning Stamping
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadrekap.index') }}"
                                    class="nav-link {{ Request::is('uploadrekap') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Upload Order TMMIN
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadrekapadm.index') }}"
                                    class="nav-link {{ Request::is('uploadrekapadm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Upload Order ADM
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('boardd26adm.index') }}"
                                    class="nav-link {{ Request::is('boardd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        BOARDD26 ADM KAP-1
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstoktmmin.index') }}"
                                    class="nav-link {{ Request::is('dshstoktmmin') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok D26 TMMIN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstokd26adm.index') }}"
                                    class="nav-link {{ Request::is('dshstokd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok D26 ADM
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'lineStoreIn')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('scaninls2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('scaninls2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Line Store
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninls2.index') }}"
                                    class="nav-link {{ Request::is('scaninls2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN Part
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'userPcStore')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('scaninpswelding') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('scaninpswelding') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                PC-STORE Welding
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpswelding.index') }}"
                                    class="nav-link {{ Request::is('scaninpswelding') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan In Welding
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'userPcStore2')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('scaninpsdirect') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('scaninpsdirect') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                PC-STORE Welding
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpsdirect.index') }}"
                                    class="nav-link {{ Request::is('scaninpsdirect') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan Direct Stamping
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'PlanerPPIC2')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Preparation ADM
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapd26adm.index') }}"
                                    class="nav-link {{ Request::is('listrekapd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        List Prepare ADM
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>
                @elseif (auth()->user()->level == 'PlanerPPIC3')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Preparation TMMIN
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapd26.index') }}"
                                    class="nav-link {{ Request::is('listrekapd26') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        List Prepare TMMMIN
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>
                @elseif (auth()->user()->level == 'PrepareAdm4')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Preparation ADM 4
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapdadmp4.index') }}"
                                    class="nav-link {{ Request::is('listrekapdadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        List Prepare ADM 4
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>

                @elseif (auth()->user()->level == 'PrepareTmminAdm')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Preparation ADM & TMMIN
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapd26.index') }}"
                                    class="nav-link {{ Request::is('listrekapd26') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        List Prepare TMMIN
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapdadmp4.index') }}"
                                    class="nav-link {{ Request::is('listrekapdadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        List Prepare ADM 4
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>
                @elseif (auth()->user()->level == 'StokOpname')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('planninglineb3', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('planninglineb3', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                PC-STORE Stok
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstoktmmin.index') }}"
                                    class="nav-link {{ Request::is('dshstoktmmin') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok D26 TMMIN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstokd26adm.index') }}"
                                    class="nav-link {{ Request::is('dshstokd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok D26 ADM
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'userBlank')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('blankstok', 'scaninblank', 'scanoutblank', 'taglabelblank', 'taglabel2') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('blankstok', 'scaninblank', 'scanoutblank', 'taglabelblank', 'taglabel2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-squares-four"></i>
                            <p>
                                Line Blank
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('blankstok.index') }}"
                                    class="nav-link {{ Request::is('blankstok') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Tabel Blank Stok (DB)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninblank.index') }}"
                                    class="nav-link {{ Request::is('scaninblank') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan In Material
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutblank.index') }}"
                                    class="nav-link {{ Request::is('scanoutblank') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Out
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutblank2.index') }}"
                                    class="nav-link {{ Request::is('scanoutblank2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Out 2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningblank.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningblank') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Dashboard Proses
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabel3.index') }}"
                                    class="nav-link {{ Request::is('taglabel3') ? 'active' : ''}}">
                                    <i class="nav-icon fas fa fa-pencil"></i>
                                    <p>
                                        Tag Label Manual
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'adminDm')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-wrench"></i>
                            <p>
                                Dies MTC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabellistdies.index') }}"
                                    class="nav-link {{ Request::is('tabellistdies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel List Dies
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelprev.index') }}"
                                    class="nav-link {{ Request::is('tabelprev') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel Prev
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andonts.index') }}"
                                    class="nav-link {{ Request::is('andonts') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardsummarydies.index') }}"
                                    class="nav-link {{ Request::is('dashboardsummarydies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Dashboard Summary
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andontanrian.index') }}"
                                    class="nav-link {{ Request::is('andontanrian') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon Antrian
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('lkhdies.index') }}"
                                    class="nav-link {{ Request::is('lkhdies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        LKH Dies
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'userDm')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li class="nav-item {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-wrench"></i>
                            <p>
                                Dies MTC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelprev.index') }}"
                                    class="nav-link {{ Request::is('tabelprev') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel Prev
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andonts.index') }}"
                                    class="nav-link {{ Request::is('andonts') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardsummarydies.index') }}"
                                    class="nav-link {{ Request::is('dashboardsummarydies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Dashboard Summary
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andontanrian.index') }}"
                                    class="nav-link {{ Request::is('andontanrian') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon Antrian
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('lkhdies.index') }}"
                                    class="nav-link {{ Request::is('lkhdies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        LKH Dies
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (auth()->user()->level == 'userRak')
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('storeroom') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('scanraksatu', 'scanraktujuhbelas', 'scanraksepuluh', 'innut', 'scanraklimabelas') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scanraksatu', 'scanraktujuhbelas', 'innut', 'scanraklimabelas') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                Scan Rak
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraksatu.index') }}"
                                    class="nav-link {{ Request::is('scanraksatu') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>
                                        Scan Rak 6
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraksepuluh.index') }}"
                                    class="nav-link {{ Request::is('scanraksepuluh') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>
                                        Scan Rak 2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraklimabelas.index') }}"
                                    class="nav-link {{ Request::is('scanraklimabelas') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>
                                        Scan Rak 1
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraklimabelasout.index') }}"
                                    class="nav-link {{ Request::is('scanraklimabelasout') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>
                                        Scan Rak 15 OUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraktujuhbelas.index') }}"
                                    class="nav-link {{ Request::is('scanraktujuhbelas') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>
                                        Scan Rak 17
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('innut.index') }}"
                                    class="nav-link {{ Request::is('innut') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        IN NUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('standartnut.index') }}"
                                    class="nav-link {{ Request::is('standartnut') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Standart NUT
                                    </p>
                                </a>
                            </li>
                        </ul>


                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardnut.index') }}"
                                    class="nav-link {{ Request::is('dashboardnut') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Dashboard NUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('dashboardnut') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('dashboardnut') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-database"></i>
                            <p>
                                DASHBOARD
                                <i class="right fas fa-chevron-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardnut.index') }}"
                                    class="nav-link {{ Request::is('dashboardnut') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Dashboard NUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                @else





                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-house"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">APPLICATIONS</li>
                    <li
                        class="nav-item {{ Request::is('line', 'welding', 'model', 'partname', 'costumer', 'dashboard2') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('line', 'welding', 'model', 'partname', 'costumer', 'dashboard2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-folder-notch"></i>
                            <p>
                                Master Data Produksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('line.index') }}"
                                    class="nav-link {{ Request::is('line') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data Line Stamping
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('welding.index') }}"
                                    class="nav-link {{ Request::is('welding') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data Line Welding
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('datafg.index') }}"
                                    class="nav-link {{ Request::is('datafg') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data FG Stamping
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('partname.index') }}"
                                    class="nav-link {{ Request::is('partname') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data Part Number
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('costumer.index') }}"
                                    class="nav-link {{ Request::is('costumer') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data Line Costumer
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('databom.index') }}"
                                    class="nav-link {{ Request::is('databom') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Data Bom
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- PPIC SECTION --}}
                    <li
                        class="nav-item {{ Request::is('planninglineb3', 'planninglinec1', 'planninglinec2', 'uploadrekap', 'boardd26', 'listrekapd26', 'uploadrekapadm', 'boardd26adm', 'listrekapd26adm', 'boardd26adm2', 'listrekapdadmp4', 'boardadmp4', 'uploadrekapadmp4', 'uploadforcast') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('planninglineb3', 'planninglinec1', 'planninglinec2', 'uploadrekap', 'boardd26', 'listrekapd26', 'uploadrekapadm', 'boardd26adm', 'listrekapd26adm', 'boardd26adm2', 'listrekapdadmp4', 'boardadmp4', 'uploadrekapadmp4', 'uploadforcast') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-chart-bar"></i>
                            <p>
                                PPIC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('planninglineb3.index') }}"
                                    class="nav-link {{ Request::is('planninglineb3') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-calendar-check"></i>
                                    <p>
                                        Planning Stamping
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('mpsplanning.index') }}"
                                    class="nav-link {{ Request::is('mpsplanning') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-calendar-check"></i>
                                    <p>
                                        Planning Welding
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboard2.index') }}"
                                    class="nav-link {{ Request::is('dashbord2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-squares-four"></i>
                                    <p>
                                        Dashbaord PPS
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('boardd26.index') }}"
                                    class="nav-link {{ Request::is('boardd26') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-clipboard-text"></i>
                                    <p>
                                        Board TMMIN
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('boardd26adm.index') }}"
                                    class="nav-link {{ Request::is('boardd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-clipboard-text"></i>
                                    <p>
                                        Board KAP-1
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('boardd26adm2.index') }}"
                                    class="nav-link {{ Request::is('boardd26adm2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-clipboard-text"></i>
                                    <p>
                                        Board KAP-2
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('boardadmp4.index') }}"
                                    class="nav-link {{ Request::is('boardadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-clipboard-text"></i>
                                    <p>
                                        Board ADM P4
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadrekap.index') }}"
                                    class="nav-link {{ Request::is('uploadrekap') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-cloud-arrow-up"></i>
                                    <p>
                                        Upload Order TMMIN
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadrekapadm.index') }}"
                                    class="nav-link {{ Request::is('uploadrekapadm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-cloud-arrow-up"></i>
                                    <p>
                                        Upload Order ADM
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadrekapadmp4.index') }}"
                                    class="nav-link {{ Request::is('uploadrekapadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-cloud-arrow-up"></i>
                                    <p>
                                        Upload Order ADM P4
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadforcast.index') }}"
                                    class="nav-link {{ Request::is('uploadforcast') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-trend-up"></i>
                                    <p>
                                        Upload Forcast
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapd26.index') }}"
                                    class="nav-link {{ Request::is('listrekapd26') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-list-bullets"></i>
                                    <p>
                                        List Prepare
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapd26adm.index') }}"
                                    class="nav-link {{ Request::is('listrekapd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-list-bullets"></i>
                                    <p>
                                        List Prepare ADM KAP
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('listrekapdadmp4.index') }}"
                                    class="nav-link {{ Request::is('listrekapdadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-list-bullets"></i>
                                    <p>
                                        List Prepare ADM P4
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('planninglinec1.index') }}"
                                    class="nav-link {{ Request::is('planninglinec1') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Planning Line C1
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('planninglinec2.index') }}"
                                    class="nav-link {{ Request::is('planninglinec2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Planning Line C2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    {{-- Raw Material Section --}}
                    <li
                        class="nav-item {{ Request::is('material', 'supplierrm', 'inmaterial', 'scan', 'history', 'rmstok', 'materialb3', 'scandnrm', 'scanoutrm', 'traceability', 'rmreturn', 'dashboardrm', 'rmdnincoming', 'scaninlabel', 'dashboardrmstok', 'materialbyupload', 'dashboardrmps', 'scaninlabel2') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('material', 'supplierrm', 'inmaterial', 'scan', 'history', 'rmstok', 'materialb3', 'traceability', 'dashboardrm', 'rmdnincoming', 'dashboardrmstok', 'dashboardrmps', 'scaninlabel2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-gear"></i>
                            <p>
                                MPC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('rmdnincoming.index') }}"
                                    class="nav-link {{ Request::is('rmdnincoming') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-grid-nine"></i>
                                    <p>
                                        DN INPUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uploadmonthly.index') }}"
                                    class="nav-link {{ Request::is('uploadmonthly') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-grid-nine"></i>
                                    <p>
                                        materialbyupload
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('material.index') }}"
                                    class="nav-link {{ Request::is('material') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-grid-nine"></i>
                                    <p>
                                        Material
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('supplierrm.index') }}"
                                    class="nav-link {{ Request::is('supplierrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-thin ph-truck"></i>
                                    <p>
                                        Supplier Material
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scandnrm.index') }}"
                                    class="nav-link {{ Request::is('scandnrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan DN
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlabel.index') }}"
                                    class="nav-link {{ Request::is('scaninlabel') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Incoming
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlabel2.index') }}"
                                    class="nav-link {{ Request::is('scaninlabel2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Incoming 2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutrm.index') }}"
                                    class="nav-link {{ Request::is('scanoutrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OutGoing
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('inmaterial.index') }}"
                                    class="nav-link {{ Request::is('inmaterial') ? 'active' : '' }}">
                                    <i class="nav-icon ph ph-arrow-square-down"></i>
                                    <p>
                                        Crate Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardblank.index') }}"
                                    class="nav-link {{ Request::is('dashboardblank') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-arrow-u-left-down"></i>
                                    <p>
                                        dashboardblank
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('rmstok.index') }}"
                                    class="nav-link {{ Request::is('rmstok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Stok Material (DB)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('materialb3.index') }}"
                                    class="nav-link {{ Request::is('materialb3') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Plan Material
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrm.index') }}"
                                    class="nav-link {{ Request::is('dashboardrm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard Incoming
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardrmstok.index') }}"
                                    class="nav-link {{ Request::is('dashboardrmstok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashboard Stok
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardmps.index') }}"
                                    class="nav-link {{ Request::is('dashboardmps') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-paper-plane-tilt"></i>
                                    <p>
                                        Dashbaord Outgoing
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- RM Standart Part --}}
                    <li
                        class="nav-item {{ Request::is('materialnut*', 'standartnut*', 'supplierrmnut*', 'innut*', 'scan2*', 'scan3*', 'scan4*', 'stoknut*', 'dashboardnut*', 'tracesswnut*', 'scanraksatu*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('materialnut*', 'standartnut*', 'supplierrmnut*', 'innut*', 'scan2*', 'scan3*', 'scan4*', 'stoknut*', 'dashboardnut*', 'tracesswnut*', 'scanraksatu*') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-package"></i>
                            <p>
                                RM S/P
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('supplierrmnut.index') }}"
                                    class="nav-link {{ Request::is('supplierrmnut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-truck"></i>
                                    <p>Supplier Nut</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('materialnut.index') }}"
                                    class="nav-link {{ Request::is('materialnut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-cube"></i>
                                    <p>Material NUT</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('standartnut.index') }}"
                                    class="nav-link {{ Request::is('standartnut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-clipboard-text"></i>
                                    <p>Standart NUT</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('innut.index') }}"
                                    class="nav-link {{ Request::is('innut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-arrow-square-in"></i>
                                    <p>IN NUT</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scan2.index') }}"
                                    class="nav-link {{ Request::is('scan2*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-barcode"></i>
                                    <p>Scan IN</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scan3.index') }}"
                                    class="nav-link {{ Request::is('scan3*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-barcode"></i>
                                    <p>Scan OUT</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scan4.index') }}"
                                    class="nav-link {{ Request::is('scan4*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-package"></i>
                                    <p>Scan Kedatangan</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('tracesswnut.index') }}"
                                    class="nav-link {{ Request::is('tracesswnut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-magnifying-glass"></i>
                                    <p>Trace SSW</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('stoknut.index') }}"
                                    class="nav-link {{ Request::is('stoknut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-stack"></i>
                                    <p>Stok Nut</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanraksatu.index') }}"
                                    class="nav-link {{ Request::is('scanraksatu*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-browsers"></i>
                                    <p>Scan Rak Satu</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardnut.index') }}"
                                    class="nav-link {{ Request::is('dashboardnut*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-chart-pie-slice"></i>
                                    <p>Dashboard NUT</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- LINE BLANK SECTION --}}
                    <li
                        class="nav-item {{ Request::is('blankstok*', 'scaninblank*', 'scanoutblank*', 'taglabel*', 'datablank*', 'dashboardblank*', 'scanoutblank2*', 'dashboardplanningblank*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('blankstok*', 'scaninblank*', 'scanoutblank*', 'taglabel*', 'datablank*', 'dashboardblank*', 'scanoutblank2*', 'dashboardplanningblank*') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-squares-four"></i>
                            <p>
                                Line Blank
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('datablank.index') }}"
                                    class="nav-link {{ Request::is('datablank*') ? 'active' : ''}}">
                                    <i class="nav-icon ph-duotone ph-database"></i>
                                    <p>DB Part Blank</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('blankstok.index') }}"
                                    class="nav-link {{ Request::is('blankstok*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-stack"></i>
                                    <p>Tabel Blank Stok (DB)</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardblank.index') }}"
                                    class="nav-link {{ Request::is('dashboardblank*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-chart-pie"></i>
                                    <p>Dashboard Blank</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninblank.index') }}"
                                    class="nav-link {{ Request::is('scaninblank*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-barcode"></i>
                                    <p>Scan In Material</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutblank.index') }}"
                                    class="nav-link {{ Request::is('scanoutblank*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-barcode"></i>
                                    <p>Scan Out</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutblank2.index') }}"
                                    class="nav-link {{ Request::is('scanoutblank2*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-barcode"></i>
                                    <p>Scan Out 2</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningblank.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningblank*') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-chalkboard"></i>
                                    <p>Dashboard Proses Blank</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabel2.index') }}"
                                    class="nav-link {{ Request::is('taglabel2*') ? 'active' : ''}}">
                                    <i class="nav-icon ph-duotone ph-tag"></i>
                                    <p>Tag Label 2</p>
                                </a>
                            </li>
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabel3.index') }}"
                                    class="nav-link {{ Request::is('taglabel3*') ? 'active' : ''}}">
                                    <i class="nav-icon ph-duotone ph-tag"></i>
                                    <p>Tag Label 3</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- STAMPING LINE STAMPING B3,C1,C2 SECTION --}}
                    <li
                        class="nav-item {{ Request::is('dashboardplanning', 'scaninstmp', 'scanoutstmp', 'kanbanstmp', 'prosesqr1', 'scanreturnrm', 'kanbanstmpc1', 'kanbanstmpc2', ) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninstmp', 'scanoutstmp', 'kanbanstmp', 'kanbanstmpc1', 'kanbanstmpc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                STAMPING LINE
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmp.index') }}"
                                    class="nav-link {{ Request::is('scaninstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN (B3,C1,C2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT (B3,C1,C2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="{{ route('scanreturnrm.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="nav-link {{ Request::is('scanreturnrm') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="nav-icon ph-fill ph-scan"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                Scan Return RM (B3,C1,C2)
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                    </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                </ul> -->
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanning.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanning') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard (B3,C1,C2)
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmpb12.index') }}"
                                    class="nav-link {{ Request::is('scaninstmpb12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN (B1,B2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT (B1,B2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningb12.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningb12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard (B1,B2)
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmpa12.index') }}"
                                    class="nav-link {{ Request::is('scaninstmpa12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN (A1,A2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan OUT (A1,A2)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanninga12.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanninga12') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard (A1,A2)
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninstmptransfers.index') }}"
                                    class="nav-link {{ Request::is('scaninstmptransfers') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan In Transfers
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutstmp.index') }}"
                                    class="nav-link {{ Request::is('scanoutstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Out Transfers
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardplanningatransfers.index') }}"
                                    class="nav-link {{ Request::is('dashboardplanningatransfers') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashboard Transfers
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('prosesqr1.index') }}"
                                    class="nav-link {{ Request::is('prosesqr1') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa fa-tasks"></i>
                                    <p>
                                        Trace
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmp.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmp') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP B3
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc1.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C1
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanbanstmpc2.index') }}"
                                    class="nav-link {{ Request::is('kanbanstmpc2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-pencil-simple-line"></i>
                                    <p>
                                        Crate KNB STMP C2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    {{-- LINE STAMPING REPORT --}}
                    <!-- <li
                                                                                                                                                                                                                                                                                                                                                                                                                        class="nav-item {{ Request::is('lkhb3', 'reportb3', 'reportc1', 'reportc2', 'lkhc1', 'lkhc2', ) ? 'menu-open' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="#"
                                                                                                                                                                                                                                                                                                                                                                                                                            class="nav-link {{ Request::is('lkhb3', 'reportb3', 'reportc1', 'reportc2', 'lkhc1', 'lkhc2', ) ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="nav-icon ph-duotone ph-file-text"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                            <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                Report & LKH Stamping
                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="right fas fa-angle-left"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('lkhb3.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('lkhb3') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        LKH B3
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('lkhc1.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('lkhc1') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        LKH C1
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('lkhc2.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('lkhc2') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        LKH C2
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('reportb3.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('reportb3') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        Report B3
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('reportc1.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('reportc1') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        Report C1
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                        <ul class="nav nav-treeview">
                                                                                                                                                                                                                                                                                                                                                                                                                            <li class="nav-item ml-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="{{ route('reportc2.index') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                    class="nav-link {{ Request::is('reportc2') ? 'active' : '' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="nav-icon fas fa fa-tasks"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                                                                                                                                                        Report C2
                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                            </li>
                                                                                                                                                                                                                                                                                                                                                                                                                        </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                    </li> -->
                    {{-- LINE STORE SECTION --}}
                    <li
                        class="nav-item {{ Request::is('scaninlsrepair', 'linestorestok', 'linestoreindex', 'linestoreindex2', 'linestoreupload', 'scaninls2', 'dashboard1ls', 'tabelstoksbc', 'scanoutls') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('scaninlsrepair', 'linestorestok', 'linestoreindex', 'linestoreindex2', 'linestoreupload', 'scaninls2', 'dashboard1ls', 'tabelstoksbc', 'scanoutls') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-storefront"></i>
                            <p>
                                Line Store
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboard1ls.index') }}"
                                    class="nav-link {{ Request::is('dashboard1ls') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Dashbaord LS d
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninlsrepair.index') }}"
                                    class="nav-link {{ Request::is('scaninlsrepair') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan Incoming Repair
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninls2.index') }}"
                                    class="nav-link {{ Request::is('scaninls2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN Part
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreupload.index') }}"
                                    class="nav-link {{ Request::is('linestoreupload') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Master Data DN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestorestok.index') }}"
                                    class="nav-link {{ Request::is('linestorestok') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok (DB)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex2.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Inhouse
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Outhouse
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('linestoreindex3.index') }}"
                                    class="nav-link {{ Request::is('linestoreindex3') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Dashbaord Incoming
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelstoksbc.index') }}"
                                    class="nav-link {{ Request::is('tabelstoksbc') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tabel Stok Subcont
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabelsubcont.index') }}"
                                    class="nav-link {{ Request::is('taglabelsubcont') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tag Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutls.index') }}"
                                    class="nav-link {{ Request::is('scanoutls') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Scan Out LS
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- LINE PC STORE SECTION --}}
                    <li
                        class="nav-item {{ Request::is('scaninpcs', 'dashboard1', 'pcstoredirect', 'dashboardmps', 'scaninpcs', 'dashboardducking', 'scanoutpcs', 'scaninpswelding', 'dshstokd26adm', 'dshstoktmmin', 'dshstokadmp4') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('dashboard1', 'pcstoredirect', 'dashboardmps', 'scaninpcs', 'dashboardducking', 'scanoutpcs', 'scaninpswelding', 'dshstokd26adm', 'dshstoktmmin', 'dshstokadmp4') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-desktop"></i>
                            <p>
                                PC Store
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('pcstoredirect.index') }}"
                                    class="nav-link {{ Request::is('pcstoredirect') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Tabel Stok (DB)
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstoktmmin.index') }}"
                                    class="nav-link {{ Request::is('dshstoktmmin') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok TMMIN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstokadmp4.index') }}"
                                    class="nav-link {{ Request::is('dshstokadmp4') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok ADM P4
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dshstokd26adm.index') }}"
                                    class="nav-link {{ Request::is('dshstokd26adm') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-stack-plus"></i>
                                    <p>
                                        Dshabord Stok ADM P5
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboard1.index') }}"
                                    class="nav-link {{ Request::is('dashboard1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashbaord Stok
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpsdirect.index') }}"
                                    class="nav-link {{ Request::is('scaninpsdirect') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        Scan IN DIRECT
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpswelding.index') }}"
                                    class="nav-link {{ Request::is('scaninpswelding') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan In Welding
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpcs.index') }}"
                                    class="nav-link {{ Request::is('scaninpcs') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        SCAN IN PC STORE
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanoutpcs.index') }}"
                                    class="nav-link {{ Request::is('scanoutpcs') ? 'active' : '' }}">
                                    <i class="nav-icon ph-fill ph-scan"></i>
                                    <p>
                                        SCAN OUT PC STORE
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardducking.index') }}"
                                    class="nav-link {{ Request::is('dashboardducking') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chalkboard"></i>
                                    <p>
                                        Dashbaord Delivery
                                        {{-- <i class="ph-light ph-archive"></i> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Button Push Section --}}
                    <li class="nav-item {{ Request::is('scanweldingpart') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('scanweldingpart') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-hand-pointing"></i>
                            <p>
                                Button Push
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scanweldingpart.index') }}"
                                    class="nav-link {{ Request::is('scanweldingpart') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan Request Welding
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Button Push Section --}}
                    <li class="nav-item {{ Request::is('taglabelwelding') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('taglabelwelding') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-fire"></i>
                            <p>
                                Welding Line
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardwelding1.index') }}"
                                    class="nav-link {{ Request::is('dashboardwelding1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('taglabelwelding.index') }}"
                                    class="nav-link {{ Request::is('taglabelwelding') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tag Label
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('scaninpswelding2.index') }}"
                                    class="nav-link {{ Request::is('scaninpswelding2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Scan PC-STORE
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('tabellistdies', 'tabelprev', 'lkhdies') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-wrench"></i>
                            <p>
                                Dies MTC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabellistdies.index') }}"
                                    class="nav-link {{ Request::is('tabellistdies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel List Dies
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelprev.index') }}"
                                    class="nav-link {{ Request::is('tabelprev') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel Prev
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andonts.index') }}"
                                    class="nav-link {{ Request::is('andonts') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dashboardsummarydies.index') }}"
                                    class="nav-link {{ Request::is('dashboardsummarydies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Dashboard Summary
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('andontanrian.index') }}"
                                    class="nav-link {{ Request::is('andontanrian') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Andon Antrian
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('lkhdies.index') }}"
                                    class="nav-link {{ Request::is('lkhdies') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        LKH Dies
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item {{ Request::is('trackingloc', 'proses1', 'proses2', 'logactivity') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('trackingloc', 'proses1', 'proses2', 'logactivity') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-path"></i>
                            <p>
                                Tracking Proses
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('trackingloc.index') }}"
                                    class="nav-link {{ Request::is('trackingloc') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tracking 1
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('proses1.index') }}"
                                    class="nav-link {{ Request::is('proses1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tracking 2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('proses2.index') }}"
                                    class="nav-link {{ Request::is('proses2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tracking 3
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('logactivity.index') }}"
                                    class="nav-link {{ Request::is('logactivity') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        logactivity
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Request::is('trackingloc', 'proses1', 'proses2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('trackingloc', 'proses1', 'proses2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-truck"></i>
                            <p>
                                Subcont
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('trackingloc.index') }}"
                                    class="nav-link {{ Request::is('trackingloc') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        ASI-2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('proses1.index') }}"
                                    class="nav-link {{ Request::is('proses1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tracking 2
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('proses2.index') }}"
                                    class="nav-link {{ Request::is('proses2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-bold ph-chart-line"></i>
                                    <p>
                                        Tracking 3
                                    </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    {{-- <li class="nav-item {{ Request::is('tabelb3','tabelc1','tabelc2') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('tabelb3','tabelc1','tabelc2') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-circles-four"></i>
                            <p>
                                Tabel
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelb3.index') }}"
                                    class="nav-link {{ Request::is('tabelb3') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel B3
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelc1.index') }}"
                                    class="nav-link {{ Request::is('tabelc1') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel C1
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('tabelc2.index') }}"
                                    class="nav-link {{ Request::is('tabelc2') ? 'active' : '' }}">
                                    <i class="nav-icon ph-duotone ph-table"></i>
                                    <p>
                                        Tabel C2
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}


                    <li class="nav-header">STORE ROOM SYSTEM</li>
                    <li
                        class="nav-item {{ Request::is('masterliststr', 'category', 'uom', 'supplier', 'dept') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('masterliststr', 'category', 'uom', 'supplier', 'dept') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                MASTER DATA
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('masterliststr.index') }}"
                                    class="nav-link {{ Request::is('masterliststr', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>
                                        Item List
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('uom.index') }}"
                                    class="nav-link {{ Request::is('uom', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        UoM ( Unit )
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('category.index') }}"
                                    class="nav-link {{ Request::is('category', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Category
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('supplier.index') }}"
                                    class="nav-link {{ Request::is('supplier', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-truck-moving"></i>
                                    <p>
                                        Supplier
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('dept.index') }}"
                                    class="nav-link {{ Request::is('dept', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>
                                        Departement
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item {{ Request::is('stokatk', 'stokrtk', 'stokconsum', 'stokgas', 'stokti', 'stokcuptip') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('stokatk', 'stokrtk', 'stokconsum', 'stokgas', 'stokti', 'stokcuptip') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                ITEM STOK
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokatk.index') }}"
                                    class="nav-link {{ Request::is('stokatk') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-pencil-alt"></i>
                                    <p>ATK</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokrtk.index') }}"
                                    class="nav-link {{ Request::is('stokrtk') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>RTK</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokconsum.index') }}"
                                    class="nav-link {{ Request::is('stokconsum') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>CONSUMABLE</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokgas.index') }}"
                                    class="nav-link {{ Request::is('stokgas') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gas-pump"></i>
                                    <p>GAS</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokti.index') }}"
                                    class="nav-link {{ Request::is('stokti') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>TOOL & INSERT</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokcuptip.index') }}"
                                    class="nav-link {{ Request::is('stokcuptip') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-horse"></i>
                                    <p>CUPTIP</p>
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="nav-item {{ Request::is('strout', 'strin', 'exportall') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('strout', 'strin', 'exportall') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                TRANSAKSI
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout.index') }}"
                                    class="nav-link {{ Request::is('strout', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-dolly"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    Item Out
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strin.index') }}"
                                    class="nav-link {{ Request::is('strin', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-dolly"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    Item IN
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('exportall.index') }}"
                                    class="nav-link {{ Request::is('exportall', ) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-dolly"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    Export All
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item {{ Request::is('strout2', 'strout3', 'strout4', 'strout5', 'strout6', 'strout7') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('masterliststr', 'category', 'uom', 'supplier', 'dept') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB STAMPING
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout5.index') }}"
                                    class="nav-link {{ Request::is('strout5') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB LINE A1 & A2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout4.index') }}"
                                    class="nav-link {{ Request::is('strout4') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB LINE B1 & B2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout3.index') }}"
                                    class="nav-link {{ Request::is('strout3') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB LINE B3
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout2.index') }}"
                                    class="nav-link {{ Request::is('strout2', ) ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    E-SPB LINE C1 & C2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout6.index') }}"
                                    class="nav-link {{ Request::is('strout6') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    E-SPB LINE Transfers
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout7.index') }}"
                                    class="nav-link {{ Request::is('strout7') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    E-SPB LINE Blank
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item {{ Request::is('strout8', 'strout9', 'strout10', 'strout11', 'strout12', 'strout13', 'strout14') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('strout8', 'strout9', 'strout10', 'strout11', 'strout12', 'strout13', 'strout14') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB WELDING AREA
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout8.index') }}"
                                    class="nav-link {{ Request::is('strout8') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB PSW ROBOT
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout9.index') }}"
                                    class="nav-link {{ Request::is('strout9') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB PSW MANUAL
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout10.index') }}"
                                    class="nav-link {{ Request::is('strout10') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB TAIL GATE
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout11.index') }}"
                                    class="nav-link {{ Request::is('strout11') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(38, 252, 0);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB SSW
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout12.index') }}"
                                    class="nav-link {{ Request::is('strout12') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(38, 252, 0);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB D60
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout13.index') }}"
                                    class="nav-link {{ Request::is('strout13') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(38, 252, 0);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB PSW CO2
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout14.index') }}"
                                    class="nav-link {{ Request::is('strout14') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(38, 252, 0);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB DCWA
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Request::is('strout15', 'strout16', 'strout17') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('strout15', 'strout16', 'strout17') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB PROD-2
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout15.index') }}"
                                    class="nav-link {{ Request::is('strout15') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB Fuel Tank
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout16.index') }}"
                                    class="nav-link {{ Request::is('strout16') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB Service Part
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout17.index') }}"
                                    class="nav-link {{ Request::is('strout17') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB Painting
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Request::is('strout18', 'strout19', 'strout20') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('strout18', 'strout19', 'strout20') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB SUPPORT
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout18.index') }}"
                                    class="nav-link {{ Request::is('strout18') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        Tool Making MACHINING
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout20.index') }}"
                                    class="nav-link {{ Request::is('strout20') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        Tool Making ASSY
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('strout19.index') }}"
                                    class="nav-link {{ Request::is('strout19') ? 'active' : '' }}">
                                    <i class="nav-icon 	far fa-file-alt"
                                        style="font-size:20px;color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        E-SPB MIP
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Request::is('dashboardstr', 'kanban', 'dashboardinfo') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('dashboardstr', 'kanban', 'dashboardinfo') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB PROD-2
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanban.index') }}"
                                    class="nav-link {{ Request::is('kanban', ) ? 'active' : '' }}">
                                    <i class="nav-icon 	fas fa-edit"
                                        style="font-size:20px; color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        Dashboard Kanban
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-header">STORE ROOM SYSTEM ASI-02</li>
                    <li
                        class="nav-item {{ Request::is('stokatk2', 'stokrtk2', 'stokconsum2', 'stokgas2', 'stokti2', 'stokcuptip2') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('stokatk2', 'stokrtk2', 'stokconsum2', 'stokgas2', 'stokti2', 'stokcuptip2') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                ITEM STOK
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokatk2.index') }}"
                                    class="nav-link {{ Request::is('stokatk2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-pencil-alt"></i>
                                    <p>ATK</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokrtk2.index') }}"
                                    class="nav-link {{ Request::is('stokrtk2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>RTK</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokconsum2.index') }}"
                                    class="nav-link {{ Request::is('stokconsum2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>CONSUMABLE</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokgas2.index') }}"
                                    class="nav-link {{ Request::is('stokgas2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-gas-pump"></i>
                                    <p>GAS</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokti2.index') }}"
                                    class="nav-link {{ Request::is('stokti2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>TOOL & INSERT</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('stokcuptip2.index') }}"
                                    class="nav-link {{ Request::is('stokcuptip2') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-horse"></i>
                                    <p>CUPTIP</p>
                                </a>
                            </li>
                        </ul>
                    </li>













                    <li class="nav-item {{ Request::is('dashboardstr', 'kanban', 'dashboardinfo') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('dashboardstr', 'kanban', 'dashboardinfo') ? 'active' : '' }}">
                            <i class="nav-icon ph-duotone ph-factory"></i>
                            <p>
                                E-SPB PROD-2
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-3">
                                <a href="{{ route('kanban.index') }}"
                                    class="nav-link {{ Request::is('kanban', ) ? 'active' : '' }}">
                                    <i class="nav-icon 	fas fa-edit"
                                        style="font-size:20px; color:rgb(167, 192, 192);text-shadow:6px 5px 7px #000000;"></i>
                                    <p>
                                        Dashboard Kanban
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class=" nav-header">CONFIGURATIONS
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Manajemen User
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>