<?php ?>
<div id="wrapper" style="overflow: auto; ">
    <div class="wrapper-single">

        <?php
        if ($logged_in) {
            $attributes = array('id' => 'add_disease_form');
            echo form_open("medical/allocate_center_control/allocate_me", $attributes);
            ?>

            <div class="form-container" style="float: left">
                <div class="form-title">
                    <h2>Allocate <?php
                        if ($role == 1) {
                            echo "Physician";
                        } else {
                            echo "Me";
                        }
                        ?> to a Center</h2>
                </div>
                <h6 style="color: red">Required fields *</h6>
                <?php //if physician = get the email. if a admin allow to select the physician also
                if ($role == 1) { ?>
                
                <div class="form-title">
                    Name of the physician:<span style="color: red">*</span> 
                    <select class="form-field" name="physician">
                        <?php
                        foreach ($physicians as $row) {
                            echo '<option value="' . $row->email . '">' . $row->fname . " " . $row->lname . '</option>';
                        }
                        ?>
                    </select>

                </div>
                <?php }
                else{
                   ?>
                <input type="hidden" name="physician" value="<?php echo $email;?>"/>
                <?php
                }?>
                <div class="form-title">
                    Center:<span style="color: red">*</span> 
                    <select class="form-field" name="center">
                        <?php
                        foreach ($centers as $row) {
                            echo '<option value="' . $row->center_id . '">' . $row->name . '</option>';
                        }
                        ?>
                    </select>

                </div>

                <div class="submit-container">
                    <input class="greenButton submit-button" type="submit" class="greenButton" value="Allocate" />
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