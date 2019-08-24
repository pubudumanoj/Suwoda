<?php ?>
<div id="wrapper" style="overflow: auto; margin-left: 20%">
    <div class='body-left'>

        <?php
        if ($logged_in) {
            $attributes = array('id' => 'add_disease_form'); // form id and other attributes can be initilized here
            echo form_open("disease/disease_edit_control/validate_information", $attributes);
            ?>
            <div>
                <div class="form-container" style="float: left">
                    <div class="form-title"><h2>Edit Disease Information</h2></div>
                    <div class="form-title">
                        Name of the Disease: 
                        <input type="text" id="disease_name" name="disease_name" class="form-field" value="<?php echo $result[0]; ?>" placeholder="Type Common Disease Name here" required />
                    </div>
                    <input type="hidden" name="disease_id" value="<?php echo $result[6]; ?>">
                    <div class="form-title">
                        Type/Area of the Disease:
                        <select class="form-field" name="disease_type">
                            <?php
                            foreach ($result2 as $row) {
                                echo '<option value="' . $row->field_id . '">' . $row->name . '</option>';
                            }
                            ?>
                            <script>
                                $("select[name='disease_type'] option:contains(<?php echo $result[3] ?>)").attr("selected", "selected");
                                //  $('select[name=disease_type] option:eq(<?php echo $result[3] - 4 ?>)').attr('selected', 'selected');
                            </script>
                        </select>

                    </div>
                    <div class="form-title">
                        Related treatment herbal plants: 
                        <input class="form-field" type="text" id="autocomplete-disease" placeholder="Type English Name here" style="margin-bottom: 2px;"/>

                        <textarea name="disease_plant" class="form-field" id="autocomplete-disease-pool" rows="6"><?php
                            foreach ($result3 as $pl) {

                                echo $pl->plant_name . "\n";
                            }
                            ?>
                        </textarea></div>
                    <div class="form-title">
                        Symptoms:
                        <textarea class="form-field" id="disease_symptoms" name="disease_symptoms" rows="4" cols="25" placeholder="Brief Description about symptoms" value="<?php echo set_value('disease_symptoms'); ?>"><?php echo $result[1]; ?></textarea>
                    </div>
                </div>
                <div class="form-container" style="float: left; margin-left: 20px"> 

                    <div class="form-title">
                        Treatments:
                        <textarea class="form-field" id="disease_treatment" name="disease_treatments" rows="4" cols="25" placeholder="Treatment methods and brief description about treatment" value="<?php echo set_value('disease_treatments'); ?>"><?php echo $result[2]; ?></textarea>
                    </div>
                    <div class="form-title">
                        Avoid Instructions:
                        <textarea class="form-field" id="disease_avoid" name="disease_avoid" rows="4" cols="25" placeholder="Brief description about disease avoid instructions" value="<?php echo set_value('disease_avoid'); ?>"><?php echo $result[4]; ?></textarea>
                    </div>
                    <div class="form-title">
                        Status
                        <select <?php
                        if ($role != 3) {
                            
                        } else {
                            echo 'disabled';
                        }
                            ?> class="form-field" name="review">
                            <?php
                            if ($result[5] == 'rev') {
                                ?>
                                <option  value="rev" selected>Reviewed</option>
                                <option value="unr">Un-Reviewed</option>
                                <?php
                            } else {
                                ?>
                                <option value="rev" >Reviewed</option>
                                <option value="unr" selected>Un-Reviewed</option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="submit-container">
                        <input class="submit-button" type="submit" value="Update" />
                    </div></div></div>
            <?php
            echo form_close();

            echo validation_errors('<p class="error">');
        } else {
            echo '<h3 class=\'error\'>Please <a href=\'';
            echo base_url();
            echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Edit disease Information</h3>';
        }
        ?>
    </div>



    <script type="text/javascript">


        $(document).ready(function() {
            $(function() {
                $("#autocomplete-disease").autocomplete({
                    source: function(request, response) {
                        $.ajax({url: "<?php echo site_url('autocomplete_control/plant_sugeesion'); ?>",
                            data: {term: $("#autocomplete-disease").val()},
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
            $('#autocomplete-disease').bind("enterKey", function(e) {
                $('#autocomplete-disease-pool').val($('#autocomplete-disease-pool').val() + $('#autocomplete-disease').val() + '\n');
                $('#autocomplete-disease').val('');


            });
            $('#autocomplete-disease').keyup(function(e) {
                if (e.keyCode === 13)
                {
                    $(this).trigger("enterKey");
                }
            });
        });


    </script>
</div>