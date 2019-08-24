<div class="wrapper-single" >
    
    
   <?php echo validation_errors(); 
    $attributes = array('class' => 'form-container', 'id' => 'change-email-form'); 
   echo form_open('registration/email_control/validate_information',$attributes); 
 ?>
    <div class="form-title"><h2>Change E-mail Address</h2></div> 
    <div class="form-title">New Email
     <input class="form-field" type="text" size="20" id="user_email" name="email"/>
    </div>
    <div class="form-title">Confirm New Email
     <input class="form-field" type="text" size="20" id="user_cemail" name="cemail"/>
    </div>
     <div class="form-title">Password:
     <input class="form-field" type="password" size="20" id="user_passowrd" name="password"/>
     </div>
     <div class="submit-container">
     <input class="submit-button" type="submit" value="Change Email"/>
     </div>
   </form>
   
</div>