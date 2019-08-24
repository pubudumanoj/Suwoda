<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?> | Suwoda Ayurvedic Information System</title>

        <?php
        echo link_tag('assests/css/style.css');
        echo link_tag('assests/css/js-image-slider.css');
        echo link_tag('assests/css/form-style.css');
        echo link_tag('assests/css/table-style.css');
        echo link_tag('assests/datatables/css/jquery.dataTables.css');
        echo link_tag('assests/css/comment-style.css');
        
        
        ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assests/js/jquery/jquery-2.1.0.js" ></script>
       <link href="<?php echo base_url(); ?>assests/dropdown/styles.css" rel="stylesheet" type="text/css">
       <link href="<?php echo base_url(); ?>assests/css/jquery-ui.css" rel="stylesheet" type="text/css">       
        <script src="<?php echo base_url(); ?>assests/js/js-image-slider.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assests/datatables/js/jquery.dataTables.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        <link rel="icon" href="<?php echo base_url()?>assests/images/favicon.ico">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
       

<script type="text/javascript" src="<?php echo base_url(); ?>assests/js/jquery/jquery-ui.min.js"></script>
  
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>


        <div id="top-image">
            <div style="float: left">
                <div id="top-left-banner">"SUWODA" Ayurvedic Medical Information System
                </div>
                <p>Ayurveda for Better Life....</p>
            </div>
            <div id="top-right-nav">
                <?php 
                       if ($logged_in) {
        ?>
                <ul>
   <li class='has-sub last login-button'><a href='#'><span>Profile</span></a>
      <ul>
          <li><a href='<?php echo base_url(); ?>index.php/edit/'><span>Edit Profile</span></a></li>
          <li><a href='<?php echo base_url(); ?>index.php/email/'><span>Change Email</span></a></li>
         <li><a href='<?php echo base_url(); ?>index.php/registration/login_control/logout' onclick="return confirm('Are sure want to sign out');">Sign out</a></li>
         
      </ul>
   </li>
</ul>
               
                
                <?php
       
        //echo $fname . ' ' . $lname;
        
    } else {

       ?>
                <a class="login-button" href='<?php echo base_url(); ?>index.php/login'>Login</a>
                <a class="login-button" href='<?php echo base_url(); ?>index.php/register'>Sign Up</a>
                <?php
    }
          ?>      
            </div>
        </div>
        <script type="text/javascript">
        $(window).scroll(function(){
      if ($(this).scrollTop() > 1) {
          $('#top-line').addClass('fixed');
      } else {
          $('#top-line').removeClass('fixed');
      }
  });
        </script>
        <div id="top-line"><div id="cssmenu">
<ul>
   <li class="active">
       <a href='<?php echo base_url(); ?>index.php'><span><img id="nav-home-icon"src="<?php echo base_url(); ?>assests/images/nav/home.png" alt="Home" height="14" width="14"> Home</span></a></li>
   <li class='has-sub'><a href='#'><span><img id="nav-information-icon"src="<?php echo base_url(); ?>assests/images/nav/information.png" alt="Information" height="14" width="14"> Information</span></a>
      <ul>
         <li class='has-sub'><a href='<?php echo base_url(); ?>index.php/information'><span>View Medical Information</span></a>
<!--            <ul>
               <li><a href='#'><span>Sub Item</span></a></li>
               <li class='last'><a href='#'><span>Sub Item</span></a></li>
            </ul>-->
         </li>
         <?php if($logged_in) { ?>
         <li class='has-sub'><a href='#'><span>Booking</span></a>
            <ul>
                 <?php
    if ($role==1 || $role==2) {
        ?>
               <li><a href='<?php echo base_url(); ?>index.php/booking_setup'><span>Setup and View Booking</span></a></li>
           <?php   } ?>
               <li class='last'><a href='<?php echo base_url(); ?>index.php/physician'><span>View Physicians and Place New Booking</span></a></li>
            </ul>
         </li>
      <?php } ?>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span><img id="nav-disease-icon"src="<?php echo base_url(); ?>assests/images/nav/disease.png" alt="Disease" height="14" width="14"> Disease</span></a>
      <ul>
         <li ><a href='<?php echo base_url(); ?>index.php/disease'><span>View Disease Records</span></a>
         </li>
         <li><a href='<?php echo base_url(); ?>index.php/add_disease'><span>Add New Disease</span></a>
         </li>
         <li><a href='<?php echo base_url(); ?>index.php/diagnosis'><span>Disease Diagnosis</span></a>
         </li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span><img id="nav-plant-icon"src="<?php echo base_url(); ?>assests/images/nav/plant.png" alt="Plant" height="14" width="14"> Herbal Plants</span></a>
      <ul>
         <li ><a href='<?php echo base_url(); ?>index.php/plant'><span>View Plant Records</span></a>
         </li>
         <li><a href='<?php echo base_url(); ?>index.php/add_plant'><span>Add New Plant</span></a>
         </li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span><img id="nav-hotel-icon"src="<?php echo base_url(); ?>assests/images/nav/hotel.png" alt="Hotel" height="14" width="14"> Medical Centers</span></a>
      <ul>
         <li ><a href='<?php echo base_url(); ?>index.php/medical'><span>View Medical Centers</span></a>
         </li>
          <?php
    if ($logged_in && $role!=3) {
        ?>
         <li><a href='<?php echo base_url(); ?>index.php/add_center'><span>Add New Medical Center</span></a>
         </li>
    <?php }?>
          <?php
    if ($logged_in && $role!=3) {
        ?>
         <li><a href='<?php echo base_url(); ?>index.php/allocate_me'><span>Allocate physician to a medical center</span></a>
         </li>
    <?php }?>
         <li><a href='<?php echo base_url(); ?>index.php/physician'><span>View Ayurvedic Physicians</span></a>
         </li>
         <?php
         
          if ($logged_in && $role==1) {
             
              ?>
         <li><a href='<?php echo base_url(); ?>index.php/settings'><span>Add New Ayurvedic Physician/Administrator</span></a>
         </li>
         <?php } ?>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span><img id="nav-settings-icon"src="<?php echo base_url(); ?>assests/images/nav/settings.png" alt="Options" height="14" width="14"> Options</span></a>
      <ul>
         <li class='has-sub' ><a href='#'><span>Reports</span></a>
             <ul>
               <li><a href='<?php echo base_url(); ?>index.php/reports/disease'><span>Disease</span></a></li>
               <li><a href='<?php echo base_url(); ?>index.php/reports/com_disease'><span>Common Diseases Search</span></a></li>
               <li class='last'><a href='<?php echo base_url(); ?>index.php/reports/plant'><span>Plants</span></a></li>
               <?php
    if ($logged_in && $role==1) {
        ?>
     <li class='last'><a href='<?php echo base_url(); ?>index.php/reports/user'><span>User Registration</span></a></li>
        
       
        <?php
    } else {

      
    }
    ?>
            </ul>
         </li>
         <li><a target="_blank" href='<?php echo base_url(); ?>index.php/backup'><span>Backup</span></a>
         </li>

      </ul>
   </li>
   <li><a href='<?php echo base_url(); ?>index.php/site/about'><span><img id="nav-about-icon"src="<?php echo base_url(); ?>assests/images/nav/about.png" alt="About" height="14" width="14"> About</span></a></li>
   <li class='last'><a href='<?php echo base_url(); ?>index.php/site/contact'><span><img id="nav-contact-icon"src="<?php echo base_url(); ?>assests/images/nav/contact.png" alt="Contact" height="14" width="14"> Contact</span></a></li>
</ul>
</div></div>
        <div id="main-container">
            
            
<!--Do not delete this  other half is in footer--> 

            <?php
            ?>
