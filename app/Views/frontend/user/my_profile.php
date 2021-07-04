<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Thông tin cá nhân
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-profile.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/page-profile.min.js') ?>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<div class="content-header-left col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <section id="default-breadcrumb">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <nav>
                                    <ol class="breadcrumb d-flex">
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang
                                                Chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Thông Tin Cá Nhân</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="page-user-profile">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="user-profile-images">
                    <?= img('app-assets/images/profile/user-uploads/timeline.jpg', false, ['class' => 'w-100', 'alt' => 'User Image']) ?>
                    <?= img(userShowImage(user()->avatar), false, ['class' => 'user-profile-image rounded', 'width' => 140, 'height' => 140, 'alt' => esc(user()->fullname)]) ?>
                </div>
                <div class="user-profile-text">
                    <h4 class="mb-0 text-bold-500 profile-text-color"><?= esc(user()->fullname) ?></h4>
                    <small><?= esc(user()->job) ?></small>
                </div>
                <div class="card-body px-0">
                    <ul class="nav user-profile-nav justify-content-center justify-content-md-start nav-pills border-bottom-0 mb-0" role="tablist">
                        <li class="nav-item mb-0">
                            <a class=" nav-link d-flex px-1 active" id="feed-tab" data-toggle="tab" href="#feed" aria-controls="feed" role="tab" aria-selected="true"><i class="bx bx-home"></i><span class="d-none d-md-block">Feed</span></a>
                        </li>
                        <li class="nav-item mb-0">
                            <a class="nav-link d-flex px-1" id="activity-tab" data-toggle="tab" href="#activity" aria-controls="activity" role="tab" aria-selected="false"><i class="bx bx-user"></i><span class="d-none d-md-block">Activity</span></a>
                        </li>
                        <li class="nav-item mb-0">
                            <a class="nav-link d-flex px-1" id="friends-tab" data-toggle="tab" href="#friends" aria-controls="friends" role="tab" aria-selected="false"><i class="bx bx-message-alt"></i><span class="d-none d-md-block">Friends</span></a>
                        </li>
                        <li class="nav-item mb-0 mr-0">
                            <a class="nav-link d-flex px-1" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false"><i class="bx bx-copy-alt"></i><span class="d-none d-md-block">Profile</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="feed" aria-labelledby="feed-tab" role="tabpanel">
                            
                        </div>
                        <div class="tab-pane " id="activity" aria-labelledby="activity-tab" role="tabpanel">
                           
                        </div>
                        <div class="tab-pane" id="friends" aria-labelledby="friends-tab" role="tabpanel">
                          
                        </div>
                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                            <!-- user profile nav tabs profile start -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-sm-3 text-center mb-1 mb-sm-0">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-16.jpg" class="rounded" alt="group image" height="120" width="120" />
                                                </div>
                                                <div class="col-12 col-sm-9">
                                                    <div class="row">
                                                        <div class="col-12 text-center text-sm-left">
                                                            <h6 class="media-heading mb-0">valintini_007<i class="cursor-pointer bx bxs-star text-warning ml-50 align-middle"></i></h6>
                                                            <small class="text-muted align-top">Martina Ash</small>
                                                        </div>
                                                        <div class="col-12 text-center text-sm-left">
                                                            <div class="mb-1">
                                                                <span class="mr-1">122 <small>Posts</small></span>
                                                                <span class="mr-1">4.7k <small>Followers</small></span>
                                                                <span class="mr-1">652 <small>Following</small></span>
                                                            </div>
                                                            <p>Algolia helps businesses across industries quickly create relevant😎, scalable😀, and
                                                                lightning😍
                                                                fast search and discovery experiences.</p>
                                                            <div>
                                                                <div class="badge badge-light-primary badge-round mr-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="with 7% growth @valintini_007 is on top 5k"><i class="cursor-pointer bx bx-check-shield"></i>
                                                                </div>
                                                                <div class="badge badge-light-warning badge-round mr-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="last 55% growth @valintini_007 is on weedday"><i class="cursor-pointer bx bx-badge-check"></i>
                                                                </div>
                                                                <div class="badge badge-light-success badge-round mb-1" data-toggle="tooltip" data-placement="bottom" title="got premium profile here"><i class="cursor-pointer bx bx-award"></i>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-sm d-none d-sm-block float-right btn-light-primary">
                                                                <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>Edit</span>
                                                            </button>
                                                            <button class="btn btn-sm d-block d-sm-none btn-block text-center btn-light-primary">
                                                                <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>Edit</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Basic details</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>California</li>
                                        <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i>(+56) 454 45654 </li>
                                        <li><i class="cursor-pointer bx bx-time mb-1 mr-50"></i>July 10</li>
                                        <li><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i>Jonnybravo@gmail.com</li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <h6><small class="text-muted">Cell Phone</small></h6>
                                            <p>(+46) 456 54432</p>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <h6><small class="text-muted">Family Phone</small></h6>
                                            <p>(+46) 454 22432</p>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <h6><small class="text-muted">Reporter</small></h6>
                                            <p>John Doe</p>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <h6><small class="text-muted">Manager</small></h6>
                                            <p>Richie Rich</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><small class="text-muted">Bio</small></h6>
                                            <p>Built-in customizer enables users to change their admin panel look & feel based on their
                                                preferences Beautifully crafted, clean & modern designed admin theme with 3 different demos &
                                                light - dark versions.</p>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm d-none d-sm-block float-right btn-light-primary mb-2">
                                        <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>Edit</span>
                                    </button>
                                    <button class="btn btn-sm d-block d-sm-none btn-block text-center btn-light-primary">
                                        <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>Edit</span></button>
                                </div>
                            </div>
                            <!-- user profile nav tabs profile ends -->
                        </div>
                    </div>
                </div>
                <!-- user profile nav tabs content ends -->
                <!-- user profile right side content start -->
                <div class="col-lg-3">
                    <!-- user profile right side content birthday card start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <div class="avatar mr-50">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg" alt="avtar images" height="32" width="32">
                                </div>
                                <h6 class="mb-0 d-flex align-items-center"> Nile's Birthday!</h6>
                            </div>
                            <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                            <div class="user-profile-birthday-image text-center p-2">
                                <img class="img-fluid" src="../../../app-assets/images/profile/pages/birthday.png" alt="image">
                            </div>
                            <div class="user-profile-birthday-footer text-center text-lg-left">
                                <p class="mb-0"><small>Leave her a message with your best wishes on her profile page!</small></p>
                                <a class="btn btn-sm btn-light-primary mt-50" href="JavaScript:void(0);">Send Wish</a>
                            </div>
                        </div>
                    </div>
                    <!-- user profile right side content birthday card ends -->
                    <!-- user profile right side content related groups start -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-1">Related Groups
                                <i class="cursor-pointer bx bx-dots-vertical-rounded align-top float-right"></i>
                            </h5>
                            <div class="media d-flex align-items-center mb-1">
                                <a href="JavaScript:void(0);">
                                    <img src="../../../app-assets/images/banner/banner-30.jpg" class="rounded" alt="group image" height="64" width="64" />
                                </a>
                                <div class="media-body ml-1">
                                    <h6 class="media-heading mb-0"><small>Play Guitar</small></h6><small class="text-muted">2.8k
                                        members (7 joined)</small>
                                </div>
                                <i class="cursor-pointer bx bx-plus-circle text-primary d-flex align-items-center "></i>
                            </div>
                            <div class="media d-flex align-items-center mb-1">
                                <a href="JavaScript:void(0);">
                                    <img src="../../../app-assets/images/banner/banner-31.jpg" class="rounded" alt="group image" height="64" width="64" />
                                </a>
                                <div class="media-body ml-1">
                                    <h6 class="media-heading mb-0"><small>Generic memes</small></h6><small class="text-muted">9k
                                        members (7 joined)</small>
                                </div>
                                <i class="cursor-pointer bx bx-plus-circle text-primary d-flex align-items-center "></i>
                            </div>
                            <div class="media d-flex align-items-center">
                                <a href="JavaScript:void(0);">
                                    <img src="../../../app-assets/images/banner/banner-32.jpg" class="rounded" alt="group image" height="64" width="64" />
                                </a>
                                <div class="media-body ml-1">
                                    <h6 class="media-heading mb-0"><small>Cricket fan club</small></h6><small class="text-muted">7.6k
                                        members</small>
                                </div>
                                <i class="cursor-pointer bx bx-lock text-muted d-flex align-items-center"></i>
                            </div>
                        </div>
                    </div>
                    <!-- user profile right side content related groups ends -->
                    <!-- user profile right side content gallery start -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-1">Gallery
                                <i class="cursor-pointer bx bx-dots-vertical-rounded align-top float-right"></i>
                            </h5>
                            <div class="row">
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-10.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-11.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-12.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-13.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-05.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-06.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-07.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-08.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                                <div class="col-md-4 col-6 pl-25 pr-0 pb-25">
                                    <img src="../../../app-assets/images/profile/user-uploads/user-09.jpg" class="img-fluid" alt="gallery avtar img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- user profile right side content gallery ends -->
                </div>
                <!-- user profile right side content ends -->
            </div>
            <!-- user profile content section start -->
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->