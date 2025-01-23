@include('layouts.header')
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <img width="210" src="images/logo/logo.png" alt="#" />
                     </div>
                  </div>
                  <div class="login_form">
                  <form action="{{ route('login') }}" method="POST">
                  @csrf
                        <fieldset>
                           <div class="field">
                              <label for="email" class="label_field">Email Address</label>
                              <input type="email" id="email" name="email" placeholder="E-mail" />
                           </div>
                           <div class="field">
                              <label for="password" class="label_field">Password</label>
                              <input type="password" id="password" name="password" placeholder="Password" />
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input type="checkbox" class="form-check-input"> Remember Me</label>
                              <a class="forgot" href="">Forgotten Password?</a>
                           </div>
                           <div class="field ">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" style="margin-right: 120px;">Sing In</button>
                              <!-- <button class="main_bt" style="background-color: blue; color: white;">Sing Up</button> -->
                              <a href="{{ route('register') }}" style="background-color: blue; color: white; padding: 10px 20px; text-decoration: none; border: none; border-radius: 5px;">Sign Up</a>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @include('layouts.footer')