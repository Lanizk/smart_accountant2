@include(layouts.header)
<body class="inner_page login">
<div class="full_container">
   <div class="container">
      <div class="center verticle_center full_height">
         <div class="login_section">
            <div class="logo_login">
               <div class="center">
                  <img width="210" src="/images/logo/logo.png" alt="#" />
               </div>
            </div>
            <div class="login_form">
               <form action="{{ route('register') }}" method="POST">
        @csrf
                  <fieldset>
                   
                     <div class="field">
                        <label for="school_name" class="label_field">School Name</label>
                        <input type="text" id="school_name"  name="school_name" placeholder="School Name" />
                     </div>
                     <div class="field">
                        <label for="email" class="label_field">Email</label>
                        <input type="email" id="email"  name="email" placeholder="E-Mail" />
                     </div>
                     <div class="field">
                        <label for="phone" class="label_field">Phone Number</label>
                        <input type="text" id="phone"  name="phone" placeholder="Phone Number" />
                     </div>
                     <div class="field">
                        <label for="address" class="label_field">Address</label>
                        <input type="text" id="address"  name="address" placeholder="Address" />
                     </div>
                     <div class="field">
                        <label for="admin_name" class="label_field">Admin Name</label>
                        <input type="text" id="admin_name"  name="admin_name" placeholder="Admin Name" />
                     </div>
                     <div class="field">
                        <label for="password" class="label_field">Password</label>
                        <input type="password" id="password"  name="password" placeholder="Password" />
                     </div>
                    
                    
                      
                  </fieldset>
                  <button type="submit" class="btn btn-primary">Register</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@include(layouts.footer);

