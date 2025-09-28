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
                        <h6>{{ auth()->user()->school->school_name }}</h6>
                        <p><span class="online_animation"></span> Online</p>
                     </div>
                  </div>
               </div>
            </div>
           <div class="sidebar_blog_2">
    <h4>General</h4>
    <ul class="list-unstyled components">
        <!-- Dashboard -->
        <li>
            <a href="{{ url('/dashboard') }}" 
               class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
               <i class="fa fa-tachometer blue_color"></i> 
               <span>Dashboard</span>
            </a>
        </li>

        <!-- Levels -->
        <li>
            <a href="#levelMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-graduation-cap purple_color"></i> 
               <span>Levels</span>
            </a>
            <ul class="collapse list-unstyled" id="levelMenu">
                <li><a href="/class"><span>Class Levels</span></a></li>
                <li><a href="/term"><span>Term Levels</span></a></li>
            </ul>
        </li>

        <!-- Students -->
        <li>
            <a href="{{ url('/student') }}" 
               class="nav-link @if (Request::segment(2) == 'student') active @endif">
               <i class="fa fa-users orange_color"></i> 
               <span>Students</span>
            </a>
        </li>

        <!-- Fee Module -->
        <li>
            <a href="#feeMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-credit-card-alt red_color"></i> 
               <span>Fees</span>
            </a>
            <ul class="collapse list-unstyled" id="feeMenu">
                <li><a href="/classfee"><span>Class Fees</span></a></li>
                <li><a href="/extrafee"><span>Extra Fees</span></a></li>
                <li><a href="/listextrafeestudents"><span>Assign Extra Fees</span></a></li>
                <li><a href="/invoices"><span>Fee Summary</span></a></li>
                <li><a href="/try"><span>Trial</span></a></li>
            </ul>
        </li>

        <!-- Expenses -->
        <li>
            <a href="#expensesMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-shopping-cart purple_color"></i> 
               <span>Expenses</span>
            </a>
            <ul class="collapse list-unstyled" id="expensesMenu">
                <li><a href="{{ route('expense_categories.index') }}"><span>Expense Categories</span></a></li>
                <li><a href="{{ route('expenses.index') }}"><span>All Expenses</span></a></li>
            </ul>
        </li>

        <!-- Income -->
        <li>
            <a href="#incomeMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-line-chart green_color"></i> 
               <span>Income</span>
            </a>
            <ul class="collapse list-unstyled" id="incomeMenu">
                <li><a href="{{ route('income_categories.index') }}"><span>Income Categories</span></a></li>
                <li><a href="{{ route('other_incomes.index') }}"><span>Other Income</span></a></li>
            </ul>
        </li>

        <!-- Cashbook -->
        <li>
            <a href="#cashbookMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-book blue_color"></i> 
               <span>Cashbook</span>
            </a>
            <ul class="collapse list-unstyled" id="cashbookMenu">
                <li><a href="{{ route('cashbook.index') }}"><span>Cashbook Entries</span></a></li>
            </ul>
        </li>

        <li>
            <a href="#paymentchannellMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <i class="fa fa-book blue_color"></i> 
               <span>Settings</span>
            </a>
            <ul class="collapse list-unstyled" id="paymentchannellMenu">
                <li><a href="{{ route('payment_channels.index') }}"><span>Payment Channels</span></a></li>
            </ul>
        </li>
    </ul>
</div>


                  
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
                     <!-- <div class="right_topbar">
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
                        </div> -->
                     <!-- </div> -->
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