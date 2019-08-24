<?php ?>
<div id="wrapper" style="width: 100%; ">

    <div class="page-container" style="overflow: hidden; margin-top: 1%; margin-left: auto; margin-right: auto; width: 70%">
        <?php
        if ($logged_in) {
            $attributes = array('id' => 'print_voucher_form');
            echo form_open("booking/print_voucher_control/validate_information", $attributes);
            ?>
            <div>
                <div class="form-title"><h2 style="text-align: center">Your Voucher Details</h2></div>
                <input type="hidden" name="physician" value="<?php echo $physician_default_setup[0]->email ?>" />
                <input type="hidden" name="region" value="<?php echo $physician_default_setup[0]->region ?>" />
                <input type="hidden" name="center_name" value="<?php echo $physician_default_setup[0]->name ?>" />
                <input type="hidden" name="start_time" value="<?php
                if ($custom_booking_details!=FALSE) {
                    echo $custom_booking_details[0]->start_time;
                  
                } else {
                     
                    echo $physician_default_setup[0]->start_time;
                }
                ?>" />
                <input type="hidden" name="number" value="<?php if ($booking_count!=FALSE) {
                 echo  $booking_count[0]->count + 1;
                  
                } else {
                     
                    echo 1;
                }
                ?>" />
                <input type="hidden" name="booking_date" value="<?php echo $booking_date; ?>" />
                <input type="hidden" name="physician_name" value="<?php echo $physician_default_setup[0]->fname . " " . $physician_default_setup[0]->lname; ?>" />


                <div class="page-body">Name of the physician: <?php echo $physician_default_setup[0]->fname . " " . $physician_default_setup[0]->lname; ?></div>
                <div class="page-body">Region: <?php echo $physician_default_setup[0]->region ?></div>
                <div class="page-body">Medical Centre: <?php echo $physician_default_setup[0]->name ?></div>
                <div class="page-body">Date: <?php echo $booking_date; ?></div>
                <div class="page-body">Treatment start time: <?php
                   if ($custom_booking_details!=FALSE) {
                        echo $custom_booking_details[0]->start_time;
                   } else {
                         echo $physician_default_setup[0]->start_time;
                    
                   }
                ?></div>
                <div class="page-body" >Your Number: </div>
                <h1 style="margin-left: auto;margin-right: auto; text-align: center;font-size: 150px"><?php if ($booking_count!=FALSE) {
                 echo  $booking_count[0]->count + 1;
                  
                } else {
                     
                    echo 1;
                }
                ?></h1>
                <div class="form-title">
                    Name of the patient:<span style="color: red">*</span> 
                    <input type="text" id="patient_name" name="patient_name" class="form-field" value="<?php echo set_value('patient_name'); ?>" placeholder="Type the patient's name with initials here" required />
                    Contact No:<span style="color: red">*</span> <input style="width: 240px;"type="tel" id="patient_contact_no" name="patient_contact_no" class="form-field" value="<?php echo set_value('patient_contact_no'); ?>" placeholder="Type the contact no" required />
                    <input style="margin-right: auto;margin-right: auto;" class="submit-button" type="submit" value="Print Voucher" />
                </div>
            </div>




    <?php
    echo form_close();

    echo validation_errors('<p class="error">');
} else {
    echo '<h3 class=\'error\'>Please <a href=\'';
    echo base_url();
    echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add New Information</h3>';
}
?>

    </div>


</div>