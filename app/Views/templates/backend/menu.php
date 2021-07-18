<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= route_to('admin.dashboard.index') ?>">
                    <h2 class="brand-text">NinhHoaRaoVat</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a class="d-flex align-items-center" href="index.html"><i
                        data-feather="home"></i><span class="menu-title text-truncate">Thống Kê</span><span
                        class="badge badge-light-warning badge-pill ml-auto mr-1">2</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="dashboard-analytics.html"><i
                                data-feather="circle"></i><span class="menu-item text-truncate"
                                data-i18n="Analytics">Analytics</span></a>
                    </li>
                    <li class="<?= getMenuActive('/') ?>"><a class="d-flex align-items-center"
                            href="dashboard-ecommerce.html"><i data-feather="circle"></i><span
                                class="menu-item text-truncate" data-i18n="eCommerce">eCommerce</span></a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header"><span>Quản lý đăng tin</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Danh Mục Đăng Tin</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('category') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.category.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                    <li class="<?= getMenuActive('category/recycle') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.category.recycle') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thùng Rác</span></a>
                    </li>
                    <li class="<?= getMenuActive('category/create') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.category.create') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thêm Mới</span></a>
                    </li>
                </ul>
            </li>
            
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Bài Đăng</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('post') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.post.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                    <li class="<?= getMenuActive('post/recycle') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.post.recycle') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thùng Rác</span></a>
                    </li>
                </ul>
            </li>

            <li class=" navigation-header"><span>Quản lý giao diện</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Banner</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('banner') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.banner.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                    <li class="<?= getMenuActive('banner/recycle') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.banner.recycle') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thùng Rác</span></a>
                    </li>
                    <li class="<?= getMenuActive('banner/create') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.banner.create') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thêm Mới</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Quản Lý Trang</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('pages') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.pages.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                    <li class="<?= getMenuActive('pages/create') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.pages.create') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thêm Mới</span></a>
                    </li>
                </ul>
            </li>

            <li class=" navigation-header"><span>Quản lý người dùng</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Group User</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('group') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.group.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                    <li class="<?= getMenuActive('group/create') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.group.create') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Thêm Mới</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                        class="menu-title text-truncate">Administator</span></a>
                <ul class="menu-content">
                    <li class="<?= getMenuActive('admin') ?>"><a class="d-flex align-items-center"
                            href="<?= route_to('admin.admin.index') ?>"><i data-feather="circle"></i><span
                                class="menu-item text-truncate">Danh Sách</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>