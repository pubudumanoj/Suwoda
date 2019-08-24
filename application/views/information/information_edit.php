<div id="wrapper-page">
    <div style="margin-left: 35%;">
    <?php
    if ($logged_in) {
        $attributes = array('class' => 'form-container', 'id' => 'info-form');
        echo form_open("information/information_edit_control/validate_information", $attributes);
        
        ?>
        <input type="hidden" name="id" value="<?php echo $result[4] ?>">
        <div class="form-title"><h2>Edit Information</h2></div>
        <div class="form-title">
            Title of the Information: 
            <input type="text" id="info-title" name="title" class="form-field" value="<?php echo $result[0] ?>" />
        </div>
        <div class="form-title">
            Type of the information:
            <select class="form-field" name="type">
                <option value="SL">Sloka</option>
                <option value="KS">Kashaya</option>
                <option value="BK">Book</option>
            </select>

        </div>
        <div class="form-title">
            Description:
            <textarea class="form-field" id="infor-desc" name="desc" rows="4" cols="25"><?php echo $result[2] ?></textarea></p>
        </div>
        <div class="form-title">
           Status
           <select <?php if ($role!=3) {
            
        }else{echo 'disabled' ;}?> class="form-field" name="review">
               <?php 
               
    if ($result[3]=="rev") {
        ?>
               <option  value="rev" selected>Reviewed</option>
<option value="unr">Un-Reviewed</option>
               <?php
    }
    else{
        ?>
               <option value="rev" >Reviewed</option>
<option value="unr" selected>Un-Reviewed</option>
               <?php
        
    }
               ?>

           </select>
        </div>
        <div class="submit-container">
            <input class="submit-button" type="submit" class="greenButton" value="Update" />
        </div>
        <?php echo form_close(); ?>
        <?php
        echo validation_errors('<p class="error">');
    } else {
        echo '<h3 class=\'error\'>Please <a href=\'';
        echo base_url();
        echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Edit Information</h3>';
    }
    ?>
    </div>
</div>
