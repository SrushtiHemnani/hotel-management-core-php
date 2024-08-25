<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="index.php"><img class="img-fluid for-light" src="<?=BASE_PATH?>assets/images/logo/logo.png"
                                                           alt=""><img class="img-fluid for-dark"
                                                                       src="<?=BASE_PATH?>assets/images/logo/logo_dark.png"
                                                                       alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.php"><img class="img-fluid" src="<?=BASE_PATH?>assets/images/logo/logo-icon.png"
                                                                alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="index.php"><img class="img-fluid"
                                                                  src="<?=BASE_PATH?>assets/images/logo/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan1">Hotel Management</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="/">
                            <svg class="stroke-icon">
                                <use href="<?=BASE_PATH?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <span class="lan3">Dashboard </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="<?=BASE_PATH?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <span class="lan6">Bookings</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="booking-create">New Booking</a></li>
                            <li><a href="booking">View Booking</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="<?=BASE_PATH?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <span class="lan7">Rooms</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="room-create">New Room</a></li>
                            <li><a href="rooms">View Rooms</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="staff.php">
                            <svg class="stroke-icon">
                                <use href="<?=BASE_PATH?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <span class="lan9">Staff</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="reports.php">
                            <svg class="stroke-icon">
                                <use href="<?=BASE_PATH?>assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <span class="lan10">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>