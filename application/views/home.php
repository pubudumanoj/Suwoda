<section>
    <aside>
        <div style="padding-top: 1%;">
            Latest Plant: 
              <span><?php echo $latest_plant[0]->e_name?></span>
              <?php 
              $path_parts = pathinfo(base_url().'/assests/images/plants/'.$latest_plant[0]->plant_image);?>
              <img alt="latest-plant" src="<?php echo base_url(); ?>/assests/images/plants/<?php echo $path_parts['filename']."_thumb.".$path_parts['extension'];?>  "/>
                          
              <p><?php echo word_limiter($latest_plant[0]->charac, 35); ?> <br /><a href="<?php echo base_url();
                            echo 'index.php/plant/' . $latest_plant[0]->plant_id  ?>">Read More...</a></p>
           
        </div>
        <!-- disease information div<-->
        
        <div style="padding-top: 1%;">
            Latest Disease: 
              <span><?php echo $latest_disease[0]->disease_name?></span>
                        <img alt="latest-disease" src="<?php echo base_url(); ?>/assests/images/disease-image.jpg"/>
            
              <p><?php echo word_limiter($latest_disease[0]->disease_symptoms, 35); ?> <br /><a href="<?php echo base_url();
                            echo 'index.php/disease/' . $latest_disease[0]->disease_id  ?>">Read More...</a></p>
           
        </div>
        <!-- medical information div <-->
       <div style="padding-top: 1%;">
            Latest Medical Information: 
              <span><?php echo $latest_medical_information[0]->title?></span>
            
             
              <img alt="medical-information" src="<?php echo base_url(); ?>/assests/images/medical-information.jpg "/>
                          
              <p><?php echo word_limiter($latest_medical_information[0]->desc, 46); ?> <br /><a href="<?php echo base_url();
                            echo 'index.php/information/' . $latest_medical_information[0]->id  ?>">Read More...</a></p>
           
        </div>

    </aside>
</section>
<div id="wrapper" >
    <br/>

    <!--    <a href="index.php/disease">Reservation</a><br />
        <a href="index.php/reports">Reports</a><br />
        <a href="index.php/reports">Backup</a><br />
        <a href="index.php/settings">Settings</a><br />
       
    -->
    <?php
    if ($logged_in) {
        //   echo '<a href="index.php/edit">Edit Profile</a><br />';
    } else {
        
    }
    ?>


</div>