<div class="wrapper-single" >
    
    
   <?php echo validation_errors(); 
    $attributes = array('class' => 'form-container', 'id' => 'login-form'); 
   echo form_open('registration/login_control/userlogin',$attributes); 
   echo form_open('verifyLogin'); ?>
    <div class="form-title"><h2>Sign In</h2></div> 
    <div class="form-title">Email
     <input class="form-field" type="text" size="20" id="email" name="email"/>
    </div>
     <div class="form-title">Password:
     <input class="form-field" type="password" size="20" id="passowrd" name="password"/>
     </div>
     <div class="submit-container">
     <input class="submit-button" type="submit" value="Login"/>
     </div>
   </form>
   
</div>