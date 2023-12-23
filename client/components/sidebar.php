<div class="nk-sidebar-element nk-sidebar-head">
    <div class="nk-sidebar-brand">
        <a href="index.php" class="logo-link nk-sidebar-logo">
            <img class="logo-light logo-img" src="../ops_assets/images/logo-default.png" srcset="../ops_assets/images/logo-default.png 2x" alt="logo">
            <img class="logo-dark logo-img" src="../ops_assets/images/logo-default.png" srcset="../ops_assets/images/logo-default.png 2x" alt="logo-dark">
            <img class="logo-small logo-img logo-img-small" src="../ops_assets/images/logo-default.png" srcset="../ops_assets/images/logo-default.png 2x" alt="logo-small">
        </a>
    </div>
    <div class="nk-menu-trigger me-n2">
        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
    </div>
</div><!-- .nk-sidebar-element -->

<div class="nk-sidebar-element">
    <div class="nk-sidebar-content">
        <div class="nk-sidebar-menu" data-simplebar>
            <ul class="nk-menu">
                
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Dashboards</h6>
                </li>
                <li class="nk-menu-item <?php if($page == "index"){echo "active";} ?>">
                    <a href="index.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span>
                        <span class="nk-menu-text">Dashboard</span>
                    </a>
                </li>


                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                        <span class="nk-menu-text">My Offerings</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="offerings.php" class="nk-menu-link"><span class="nk-menu-text">Standards</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="offerings.php" class="nk-menu-link"><span class="nk-menu-text">Services</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nk-menu-item">
                    <a href="gapAssessment.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-clipboard"></em></span>
                        <span class="nk-menu-text">Gap Assessment</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                         <a href="generateReport.php" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                          <span class="nk-menu-text">Generate Report</span></a>
                </li>


                <!-- <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                        <span class="nk-menu-text">Marketplace</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="offerings.php" class="nk-menu-link"><span class="nk-menu-text">Standards</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="offerings.php" class="nk-menu-link"><span class="nk-menu-text">Services</span></a>
                        </li>
                    </ul>
                </li> -->

                

                <li class="nk-menu-item">
                    <a href="myDocument.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-folder"></em></span>
                        <span class="nk-menu-text">My Document</span>
                    </a>
                </li>
            

                
                

                <li class="nk-menu-item">
                    <a href="profile.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                        <span class="nk-menu-text">Profile Settings</span>
                    </a>
                </li>

                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-help"></em></span>
                        <span class="nk-menu-text">Help & Support</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Consultation</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">FAQs</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Life Chat</span></a>
                        </li>
                    </ul>
                </li>
                

              <!--   <li class="nk-menu-item">
                    <a href="../auth/index.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                        <span class="nk-menu-text">Homepage</span>
                    </a>
                </li> -->
                
                <li class="nk-menu-item">
                    <a href="../auth/logout.php" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                        <span class="nk-menu-text">Logout</span>
                    </a>
                </li>
                <!-- <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-grid-alt-fill"></em></span>
                        <span class="nk-menu-text">Profile</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Messages</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Inbox / Mail</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">File Manager</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Chats / Messenger</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Calendar</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Kanban Board</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                        <span class="nk-menu-text">Invoice</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Invoice List</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Invoice Details</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                        <span class="nk-menu-text">Products</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Product List</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Product Card</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">Product Details</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-view-col"></em></span>
                        <span class="nk-menu-text">Pricing Table</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-img"></em></span>
                        <span class="nk-menu-text">Image Gallery</span>
                    </a>
                </li> -->
                

                
            </ul><!-- .nk-menu -->
        </div><!-- .nk-sidebar-menu -->
    </div><!-- .nk-sidebar-content -->
</div><!-- .nk-sidebar-element -->