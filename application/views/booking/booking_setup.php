<?php ?>
<div id="wrapper" style="width: 100%; ">

    <div class="page-container" style="overflow: hidden; margin-top: 1%; margin-left: auto; margin-right: auto; width: 70%">
        <?php
        if ($logged_in) { 
            if (count($default_set)>0) {
                
            
            $attributes = array('id' => 'booking_setup_edit');
            echo form_open("booking/booking_setup_control/edit_booking_validate_information", $attributes);
            ?>
            <div class="form-title" style="text-align: center"><h2>Setup Your Booking Schedule for next 7 days</h2></div>

            <div>
                <input type="radio" value="default_booking_setup" name="booking_setup_type" id="default_booking_setup"/> Default Booking Setup 
                <div id="default_booking_setup_wrapper" class="form-title" style="margin-left: auto; margin-right: auto;width: 90%">

                    <h6 style="color: red">Required fields *</h6>
                    <h5>Important notice to physician: If you want to leave Saturday and Sunday un-check the "work on weekends". If you want to get leave only on Sunday, please go to custom settings and put 0 into max patient on Saturday. If you want to get a leave on any day put 0 to max patient like earlier.</h5>

                    Work on Weekends <input name="work_on_weekends" type="checkbox" id="default_weekdays_chkbx" checked /> 
                    Treatment Start Time:<span style="color: red">*</span> 
                    <input type="time" id="start_time" name="start_time" class="form-field" style="width: 120px;height: 12px;" value="08:00:00" required />
                    Maximum patients for a day: <span style="color: red">*</span> <input type="text" id="max_patients" name="max_patients" class="form-field"  style="width: 60px; height:12px" value="20" required />
                    <input style="margin-left: 1%;" class="submit-button" type="submit" value="Submit" id="submit_default" name="submit_default"/>
                </div>  
                <input type="radio" value="custom_booking_setup"name="booking_setup_type" id="custom_booking_setup"/> Custom Booking Setup : If you wish to remove a date from your next 7 day schedule please un-check it (i.e make as holiday)
                <div id="custom_booking_setup_wrapper"class="form-title" style="margin-left: auto; margin-right: auto;width: 95%">
                    <?php for ($i = 1; $i < 8; $i++) {
                        ?>
                        <div id="custom_day<?php echo $i; ?>_chkbx_container">
                            <h6 style="color: red">Required fields *</h6>

                            <input checked type="checkbox" id="custom_day<?php echo $i; ?>_chkbx" name="custom_day_chkbx<?php echo $i; ?>" class="custom_day_chkbx"/>  
                          
                           Date: <input type="date" id="custom_date<?php echo $i; ?>" name="custom_date<?php echo $i; ?>" class="form-field" style="width: 140px;height: 12px;" value="<?php echo date('Y-m-d', time()+(86400*$i)); ?>" readonly="readonly" />
                            Treatment Start Time:<span style="color: red">*</span> <input type="time" id="start_time<?php echo $i; ?>" name="start_time<?php echo $i; ?>" class="form-field" style="width: 120px;height: 12px;" value="08:00:00" required />
                            Maximum patients for a day: <span style="color: red">*</span> <input type="text" id="max_patients<?php echo $i; ?>" name="max_patients<?php echo $i; ?>" class="form-field"  style="width: 60px; height:12px" value="20" required />
                        </div>

                        <?php
                    }
                    ?> 
                     <div class="submit-container">
                    <input style="margin-left: 1%;" class="submit-button" type="submit" value="Submit" id="submit_custom" name="submit_custom"/>
                </div>
                </div> 
            </div>
                <?php
                echo form_close();

                echo validation_errors('<p class="error">');
        }
        else{
            
            ///////////////start the else part
             $attributes = array('id' => 'booking_setup');
            echo form_open("booking/booking_setup_control/add_booking_validate_information", $attributes);
            ?>
            <div class="form-title" style="text-align: center"><h2>Setup Your Default Booking Schedule for Days You Specifically Not Change it</h2></div>

            <div>
                Default Booking Setup (You have not set the default booking schedule. Please set it first). It helps to automatically place the schedule when you could not able to log into the system in the future.
                <div id="default_booking_setup_wrapper" class="form-title" style="margin-left: auto; margin-right: auto;width: 90%">

                    <h6 style="color: red">Required fields *</h6>

                    Work on Weekends <input name="work_on_weekends" type="checkbox" id="default_weekdays_chkbx" checked/> 
                    Treatment Start Time:<span style="color: red">*</span> 
                    <input type="time" id="start_time" name="start_time" class="form-field" style="width: 120px;height: 12px;" value="08:00:00" required />
                    Maximum patients for a day: <span style="color: red">*</span> <input type="text" id="max_patients" name="max_patients" class="form-field"  style="width: 60px; height:12px" value="20" required />
                    <input style="margin-left: 1%;" class="submit-button" type="submit" value="Submit" id="submit_default" name="submit_default"/>
                </div>  
               
            </div>
                <?php
                echo form_close();

                echo validation_errors('<p class="error">');
        }
        
        } else {
                echo '<h3 class=\'error\'>Please <a href=\'';
                echo base_url();
                echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add New Information</h3>';
            }
            ?>
       
    </div>


    <script type="text/javascript">

        $(document).ready(function() {
           
            $("#custom_booking_setup_wrapper").hide();
            $("#default_booking_setup").prop("checked", true);

            $("#custom_booking_setup").click(function() {

                $('#default_booking_setup_wrapper').find('*').prop('disabled', true);
                $('#default_booking_setup_wrapper').find(':input').css('background', '#d6cdbe');


                $('#default_booking_setup_wrapper').find(':input').prop('disabled', true);
                $("#custom_booking_setup_wrapper").show();
            });

            $("#default_booking_setup").click(function() {
                $('#default_booking_setup_wrapper').find(':input').prop('disabled', false);
                $("#custom_booking_setup_wrapper").hide();
                $('#default_booking_setup_wrapper').find(':input').css('background', '#ffffcc');
                $('#submit_default').css('background', '#6aa436');
            });

            $('input:checkbox[class=custom_day_chkbx]').click(function() {

                var chkbox = $(this).attr("id");
                if ($(this).is(':checked')) {
                    $("#" + chkbox + "_container").find(':input').prop('disabled', false);
                    $("#" + chkbox + "_container").find(':input').css('background', '#ffffcc');
                    $("#" + chkbox).prop('disabled', false);
                     $("#" + chkbox + "_container").find(':input[type=date]').attr("readonly","readonly");
                    

                }
                else {
                    $("#" + chkbox + "_container").find(':input').prop('disabled', true);
                    $("#" + chkbox + "_container").find(':input').css('background', '#d6cdbe');
                    $("#" + chkbox).prop('disabled', false);
                  $("#" + chkbox + "_container").find(':input[type=date]').attr("readonly","readonly");
                }

            });

        });


    </script>
</div>