<div id="wrapper" style="overflow: auto; margin-left: 20%">
    <div class='body-left'>
        <?php
        if ($logged_in) {
            $attributes = array('id' => 'add_plant_form');
            echo form_open_multipart('herbal/add_plant_control/validate_information', $attributes);
//This function is absolutely identical to the form_open() tag above except that it adds a multipart attribute, which is necessary if you would like to use the form to upload files with.
            ?>
            <div>
                <div class="form-container" style="float: left">
                    <div class="form-title"><h2>Add New Plant</h2></div>
                    <h6 style="color: red">Required fields *</h6>
                    <div class="form-title">
                        Botanical Name<span style="color: red">*</span> <input id="bname" name="bname" class="form-field" type="text" value="<?php echo set_value('bname'); ?>" placeholder="Type Botanical Name of your plant" required/></div>
                    <div class="form-title">
                        English Name<span style="color: red">*</span> <input id="ename" name="ename" class="form-field" type="text" value="<?php echo set_value('ename'); ?>" placeholder="Type English Name of your plant" required/></div>
                    <div class="form-title">
                        Sinhala name<span style="color: red">*</span> </label><input id="sname" name="sname" type="text" class="form-field" type="text" value="<?php echo set_value('sname'); ?>" placeholder="Type Sinhala Name of your plant" required/> </div>
                    <div class="form-title">
                        Other names<textarea class="form-field" id="oname" name="oname" rows="4" cols="25" placeholder="Other names for the plant" ><?php echo set_value('oname'); ?></textarea></div>
                    <div class="form-title">
                        Region<span style="color: red">*</span> <input id="region" name="region" type="text" class="form-field" placeholder="Region which plant was collected" value="<?php echo set_value('region'); ?>" required/></div>
                    <div class="form-title">
                        Similar Plants<textarea class="form-field"  id="similar" name="similar" rows="4" cols="25" placeholder="Similar plant to this plant" ><?php echo set_value('similar'); ?></textarea></div>

                </div>  
                <div class="form-container" style="float: left; margin-left: 20px"> 
                    <div class="form-title" style="margin-bottom: 20px">
                        Diseases  <span style="color: red">*</span> <input class="form-field" type="text" id="autocomplete-disease" placeholder="Type Disease Name here" style="margin-bottom: 2px;"/>
                        <textarea id="autocomplete-disease-pool" name="disease" rows="4" cols="25" class="form-field" style="margin-bottom: 2px; "><?php echo set_value('disease'); ?></textarea><span style="color: red; ">Your disease is not available?</span><a href="<?php echo base_url(); ?>index.php/add_disease" target="_blank">Add it</a> 
                    </div>
                    
                    <div class="form-title">
                        Parts used to make medicine<textarea class="form-field" id="parts" name="parts" rows="3" cols="25" placeholder="Parts used to make medicine"><?php echo set_value('parts'); ?></textarea>
                    </div>
                    <div class="form-title">
                        Characteristics to identify the plants<textarea class="form-field" id="charac" name="charac" rows="6" cols="25" placeholder="Characteristics of the plant"><?php echo set_value('charac'); ?></textarea>
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
                    <div class="form-title"> Image <?php
                        echo form_upload('userfile', '', 'size=40');
                        //echo form_submit('upload', 'Upload', 'id="upload"', 'class="submit-button"');
                            ?> 
                        <div class="submit-container">
                            <input class="submit-button" type="submit" value="Upload" id="uplaod" name="upload"/>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            echo form_close();
        } else {
            echo '<h3 class=\'error\'>Please <a href=\'';
            echo base_url();
            echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add a new plant</h3>';
        }
        ?>
        <div id="ajax1">
    
            <?php echo $result; ?>
        </div>

    </div>
    <script type="text/javascript">
                $(document).ready(function() {
                                  
                    $('#click1').click(function() {
                        //  get_record_id('pl_1');
                    });
                });
                function get_record_id(record_id) {

                    var p = {};
                    p[record_id] = record_id;

                    // $('#ajax1').load('herbal/add_plant_control/ajax1',p,function(str){
                    $('#ajax1').load('herbal/add_plant_control/ajax1', p, function(str) {

                    });

                    ////////////

                    //         $.ajax({
                    //                    'url' : 'add_plant_controller/ajax1',
                    //                    'type' : 'POST', //the way you want to send data to your URL
                    //                    'data' : {'type' : type},
                    //                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                    //                        var container = $('#ajax1'); //jquery selector (get element by id)
                    //                        if(data){
                    //                            container.html(data);
                    //                        }
                    //                    }
                    //                });


                }



                $("#disease").keyup(function() {

                    $('#disease').css("font-size", 24);
                    a = 0;
                });
    </script>

    <script type="text/javascript">


        $(document).ready(function() {
            $(function() {
               
       $("#autocomplete-disease").autocomplete({
                    source: function(request, response) {
                        $.ajax({url: "<?php echo site_url('autocomplete_control/disease_sugession'); ?>",
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

