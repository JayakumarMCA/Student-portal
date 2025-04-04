<div class="topnav">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                @can('dashboard-view')
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/dashboard">
                                            <i class="ri-dashboard-line me-1"></i> Dashboard
                                        </a>
                                    </li>
                                @endcan
    
                                @canAny(['user-list','asset-list','event-list','campaign-list'])
                                    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                        >
                                            <i class="ri-mastercard-line me-1"></i>Masters <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                            @can('user-list')
                                                <a href="{{route('users.index')}}" class="dropdown-item">Users</a>
                                            @endcan
                                        </div>
                                    </li>
                                @endcan

                                

                                <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                    >
                                        <i class="ri-apps-2-line me-1"></i>Master <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                        <a href="calendar.html" class="dropdown-item">Events</a>
                                        <a href="apps-chat.html" class="dropdown-item">Register</a>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button"
                                    >
                                        <i class="ri-file-copy-2-line me-1"></i>Pages <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-more">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                                role="button">
                                                Authentication <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                                <a href="auth-login.html" class="dropdown-item">Login</a>
                                                <a href="auth-register.html" class="dropdown-item">Register</a>
                                                <a href="auth-recoverpw.html" class="dropdown-item">Recover Password</a>
                                                <a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"
                                                role="button">
                                                Utility <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                                <a href="pages-starter.html" class="dropdown-item">Starter Page</a>
                                                <a href="pages-maintenance.html" class="dropdown-item">Maintenance</a>
                                                <a href="pages-comingsoon.html" class="dropdown-item">Coming Soon</a>
                                                <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                                <a href="pages-faqs.html" class="dropdown-item">FAQs</a>
                                                <a href="pages-pricing.html" class="dropdown-item">Pricing</a>
                                                <a href="pages-404.html" class="dropdown-item">Error 404</a>
                                                <a href="pages-500.html" class="dropdown-item">Error 500</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                        <i class="ri-layout-3-line me-1"></i><span key="t-layouts">Layouts</span> <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                                role="button">
                                                <span key="t-vertical">Vertical</span> <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                                <a href="layouts-light-sidebar.html" class="dropdown-item" key="t-light-sidebar">Light Sidebar</a>
                                                <a href="layouts-compact-sidebar.html" class="dropdown-item" key="t-compact-sidebar">Compact Sidebar</a>
                                                <a href="layouts-icon-sidebar.html" class="dropdown-item" key="t-icon-sidebar">Icon Sidebar</a>
                                                <a href="layouts-boxed.html" class="dropdown-item" key="t-boxed-width">Boxed Width</a>
                                                <a href="layouts-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                                <a href="layouts-colored-sidebar.html" class="dropdown-item" key="t-colored-sidebar">Colored Sidebar</a>
                                            </div>
                                        </div>
    
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                role="button">
                                                <span key="t-horizontal">Horizontal</span> <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                <a href="layouts-horizontal.html" class="dropdown-item" key="t-horizontal">Horizontal</a>
                                                <a href="layouts-hori-topbar-light.html" class="dropdown-item" key="t-topbar-light">Topbar light</a>
                                                <a href="layouts-hori-boxed-width.html" class="dropdown-item" key="t-boxed-width">Boxed width</a>
                                                <a href="layouts-hori-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                                <a href="layouts-hori-colored-header.html" class="dropdown-item" key="t-colored-topbar">Colored Header</a>
                                            </div>
                                        </div>
                                    </div>
                                </li> -->
    
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>