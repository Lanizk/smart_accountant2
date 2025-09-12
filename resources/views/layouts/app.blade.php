@include('layouts.header')
<body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index.html"><img class="logo_icon img-responsive" src="/images/logo/logo_icon.png" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="/images/layout_img/user_img.jpg" alt="#" /></div>
                        <div class="user_info">
                           <h6>Kenyatta Primary</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                  <li>
                        <a href="{{url('/dashboard')}}" class="nav-link  @if (Request::segment(2) == 'dashboard') active 
                     @endif">
                     <i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                  </li>
                  
                     <li>
                        <a href="{{url('/student')}}" class="nav-link  @if (Request::segment(2) == 'student') active 
                     @endif">
                     <i class="fa fa-clock-o orange_color"></i> <span>Students</span></a>
                     </li>
                     <li>
                        <a href="#" data-target="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-diamond purple_color"></i> <span>Level</span></a>
                        <ul class="collapse list-unstyled" id="element">
                           <li><a href="/class"> <span>Class Level</span></a></li>
                           <li><a href="/term"> <span>Term Level</span></a></li>
                           
                           
                        </ul>
                     </li>

                     <li>
                        <a href="#" data-target="#fee" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-diamond purple_color"></i> <span>Fee Module</span></a>
                        <ul class="collapse list-unstyled" id="fee">
                           <li><a href="/classfee"> <span>Class Fee</span></a></li>
                           <li><a href="/extrafee"> <span>Extra Fee</span></a></li>
                           <li><a href="/listextrafeestudents"> <span>Assign Extra Fee</span></a></li>
                           <li><a href="/invoices"> <span>Fee Agregate List</span></a></li>
                           <li><a href="/try"> <span>Try</span></a></li> 
                        </ul>
                     </li>

                      <li>
                        <a href="#" data-target="#expenses" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-diamond purple_color"></i> <span>Expenses</span></a>
                        <ul class="collapse list-unstyled" id="expenses">
                           <li> <a href="{{ route('expenses.index') }}"> <span>Expenses</span></a></li>
                           <li><a href="{{ route('expense_categories.index') }}"> <span>Expense Category</span></a></li>
                        </ul>
                     </li>
                     <!-- <li><a href="tables.html"><i class="fa fa-table purple_color2"></i> <span>Tables</span></a></li>
                     <li>
                        <a href="#apps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-object-group blue2_color"></i> <span>Apps</span></a>
                        <ul class="collapse list-unstyled" id="apps">
                           <li><a href="email.html">> <span>Email</span></a></li>
                           <li><a href="calendar.html">> <span>Calendar</span></a></li>
                           <li><a href="media_gallery.html">> <span>Media Gallery</span></a></li>
                        </ul>
                     </li>
                     <li><a href="price.html"><i class="fa fa-briefcase blue1_color"></i> <span>Pricing Tables</span></a></li>
                     <li>
                        <a href="contact.html">
                        <i class="fa fa-paper-plane red_color"></i> <span>Contact</span></a>
                     </li>
                     <li class="active">
                        <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-clone yellow_color"></i> <span>Additional Pages</span></a>
                        <ul class="collapse list-unstyled" id="additional_page">
                           <li>
                              <a href="profile.html">> <span>Profile</span></a>
                           </li>
                           <li>
                              <a href="project.html">> <span>Projects</span></a>
                           </li>
                           <li>
                              <a href="login.html">> <span>Login</span></a>
                           </li>
                           <li>
                              <a href="404_error.html">> <span>404 Error</span></a>
                           </li>
                        </ul>
                     </li>
                     <li><a href="map.html"><i class="fa fa-map purple_color2"></i> <span>Map</span></a></li>
                     <li><a href="charts.html"><i class="fa fa-bar-chart-o green_color"></i> <span>Charts</span></a></li>
                     <li><a href="settings.html"><i class="fa fa-cog yellow_color"></i> <span>Settings</span></a></li> -->
                  </ul>
               </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href="index.html"><img class="img-responsive" src="/images/logo/logo.png" alt="#" /></a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                                 <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                 <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a></li>
                              </ul>
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="/images/layout_img/user_img.jpg" alt="#" /><span class="name_user">Allan Murimi</span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="profile.html">My Profile</a>
                                       <a class="dropdown-item" href="settings.html">Settings</a>
                                       <a class="dropdown-item" href="help.html">Help</a>
                                       <a class="dropdown-item" href="#"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div> 
               <!-- end topbar -->
               <div class="midde_cont">
               <div class="container-fluid"> 
               @yield('main')
               </div>
               </div>

            </div>
         </div>
      </div>
      @include('layouts.footer')