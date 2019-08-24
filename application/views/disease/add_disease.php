<?php ?>
<div id="wrapper" style="overflow: auto; margin-left: 20%">
    <div class='body-left'>

        <?php
        if ($logged_in) {
            $attributes = array('id' => 'add_disease_form');
            echo form_open("disease/add_disease_control/validate_information", $attributes);
            ?>
            <div>
                <div class="form-container" style="float: left">
                    <div class="form-title"><h2>Add New Disease</h2></div>
                    <h6 style="color: red">Required fields *</h6>
                    <div class="form-title">
                        Name of the Disease:<span style="color: red">*</span> 
                        <input type="text" id="disease_name" name="disease_name" class="form-field" value="<?php echo set_value('disease_name'); ?>" placeholder="Type Common Disease Name here" required />
                    </div>
                    <div class="form-title">
                        Type/Area of the Disease:<span style="color: red">*</span> 
                        <select class="form-field" name="disease_type">
                            <?php
                            foreach ($result as $row) {
                                echo '<option value="' . $row->field_id . '">' . $row->name . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-title">
                        Related treatment herbal plants: 
                        <input class="form-field" type="text" id="autocomplete-plant" placeholder="Type English Name here" style="margin-bottom: 2px;"/>

                        <textarea name="disease_plant" class="form-field" id="autocomplete-plant-pool" rows="6" ><?php echo set_value('disease_plant'); ?></textarea></div>
                </div>
                <div class="form-container" style="float: left; margin-left: 20px"> 
                    <div class="form-title">
                        Symptoms:
                        <textarea class="form-field" id="disease_symptoms" name="disease_symptoms" rows="4" cols="25" placeholder="Brief Description about symptoms" ><?php echo set_value('disease_symptoms'); ?></textarea>
                    </div>
                    <div class="form-title">
                        Treatments:
                        <textarea class="form-field" id="disease_treatment" name="disease_treatments" rows="4" cols="25" placeholder="Treatment methods and brief description about treatment" ><?php echo set_value('disease_treatments'); ?></textarea>
                    </div>
                    <div class="form-title">
                        Avoid Instructions:
                        <textarea class="form-field" id="disease_avoid" name="disease_avoid" rows="4" cols="25" placeholder="Brief description about disease avoid instructions" ><?php echo set_value('disease_avoid'); ?></textarea>
                    </div>

                    <div class="form-title">
                        Status
                        <select <?php
                        if ($role === 3) {
                            echo 'disabled';
                        }
                        ?> class="form-field" name="review">

                            <option value="rev" >Reviewed</option>
                            <option value="unr" selected>Un-Reviewed</option>
                            <?php
                            ?>

                        </select>
                    </div>

                    <div class="submit-container">
                        <input class="submit-button" type="submit" value="Submit" />
                    </div></div></div>
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



    <script type="text/javascript">


        $(document).ready(function() {
            $(function() {
                $("#autocomplete-plant").autocomplete({
                    source: function(request, response) {
                        $.ajax({url: "<?php echo site_url('autocomplete_control/plant_sugession'); ?>",
                            data: {term: $("#autocomplete-plant").val()},
                            dataType: "json",
                            type: "POST",
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2

                });
            });
            $('#autocomplete-plant').bind("enterKey", function(e) {
                $('#autocomplete-plant-pool').val($('#autocomplete-plant-pool').val() + $('#autocomplete-plant').val() + '\n');
                $('#autocomplete-plant').val('');


            });
            $('#autocomplete-plant').keyup(function(e) {
                if (e.keyCode === 13)
                {
                    $(this).trigger("enterKey");
                }
            });
        });


    </script>
</div>