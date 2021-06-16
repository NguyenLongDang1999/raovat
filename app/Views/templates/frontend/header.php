<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center" data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav">
            <li class="nav-item"><a class="navbar-brand" href="../../../html/ltr/horizontal-menu-template/index.html"><span class="brand-logo">
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                        </polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                        </polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                        </polygon>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    <h2 class="brand-text mb-0">Vuexy</h2>
                </a></li>
        </ul>
    </div>
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon" data-feather="search"></i></a>
                <div class="search-input">
                    <div class="search-input-icon"><i data-feather="search"></i></div>
                    <input class="form-control input" type="text" placeholder="Search..." tabindex="-1" data-search="search">
                    <div class="search-input-close"><i data-feather="x"></i></div>
                    <ul class="search-list search-list-main"></ul>
                </div>
            </li>
            <?php if (logged_in()) : ?>
                <?php if (is_null(user()->avatar)) : ?>
                    <?php $img = img(PATH_DEFAULT_AVATAR, false, ['class' => 'round', 'alt' => esc(user()->fullname), 'height' => '40', 'width' => '40']) ?>
                <?php else : ?>
                    <?php $img = img(PATH_USER_IMAGE . user()->avatar, false, ['class' => 'round', 'alt' => esc(user()->fullname), 'height' => '40', 'width' => '40']) ?>
                <?php endif ?>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder text-capitalize"><?= user()->fullname ?></span><span class="user-status">Admin</span></div><span class="avatar"><?= $img ?><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="<?= route_to('user.user.myProfile') ?>">
                            <i class="mr-50" data-feather="user"></i>
                            Thông Tin Cá Nhân
                        </a>
                        <a class="dropdown-item" href="<?= route_to('user.post.index') ?>">
                            <i class="mr-50" data-feather='edit'></i>
                            Đăng Tin
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= route_to('user.user.index') ?>">
                            <i class="mr-50" data-feather="settings"></i> Cập Nhật Thông Tin
                        </a>
                        <a class="dropdown-item" href="<?= route_to('logout') ?>">
                            <i class="mr-50" data-feather="power"></i> Đăng Xuất
                        </a>
                    </div>
                </li>
            <?php else : ?>
                <li class="nav-item ml-1">
                    <div class="btn-group">
                        <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button" id="dropdownMenuButton100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather='log-in'></i>
                            <span>Đăng Nhập</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton100">
                            <a class="dropdown-item" href="<?= route_to('login') ?>">
                                <i data-feather='log-in'></i>
                                <span>Đăng Nhập</span>
                            </a>
                            <a class="dropdown-item" href="<?= route_to('register') ?>">
                                <i data-feather='user-plus'></i>
                                <span>Đăng Ký</span>
                            </a>
                            <a class="dropdown-item" href="<?= route_to('user.post.index') ?>">
                                <i data-feather='edit'></i>
                                <span>Đăng Tin</span>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>