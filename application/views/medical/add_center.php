<?php ?>
<div id="wrapper" style="overflow: auto; margin-left: 20%">
    <div class='body-left'>
        
        
        
        <script type="text/javascript">
           

$(document).ready(function() {
	$(function() {
		$( "#autocomplete-field" ).autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('autocomplete_control/suggestions'); ?>",
				data: { term: $("#autocomplete-field").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}
			});
		},
		minLength: 2
                
		});
	});
 $('#autocomplete-field').bind("enterKey",function(e){
 $('#autocomplete-field-pool').val( $('#autocomplete-field-pool').val()+$('#autocomplete-field').val()+'\n');
 $('#autocomplete-field').val('');
 
 
});
$('#autocomplete-field').keyup(function(e){
    if(e.keyCode === 13)
    {
        $(this).trigger("enterKey");
    }
});  
});


</script>

     
        <?php
        if ($logged_in) {
            $attributes = array( 'id' => 'medical-form');
            echo form_open("medical/add_medical_center_control/validate_Information", $attributes);
            ?>
<div>
    <div class="form-container" style="float: left">
            <div class="form-title"><h2>Add New Medical Center</h2></div>
            <div class="form-title">
                Name of the Center: 
                <input type="text" id="center_name" name="center_name" class="form-field" value="<?php echo set_value('center_name'); ?>" required/>
            </div>
            <div class="form-title">
                Type of the Center:
                <select class="form-field" name="center_type">
                    <option value="MC">Medical Center</option>
                    <option value="HT">Hotel</option>
                    <option value="OT">Other</option>
                </select>

            </div>
            <div class="form-title">
                Select nearest City:
                <select class="form-field" name="center_region">

                                    <option value="Colombo">Colombo</option>
                                    <option value="Dehiwala-Mount Lavinia">Dehiwala-Mount Lavinia</option>
                                    <option value="Moratuwa">Moratuwa</option>
                                    <option value="Negombo">Negombo</option>
                                    <option value="Kotte">Kotte</option>
                                    <option value="Katunayake">Katunayake</option>
                                    <option value="Battaramulla">Battaramulla</option>
                                    <option value="Daluguma">Daluguma</option>
                                    <option value="Maharagama">Maharagama</option>
                                    <option value="Kotikawatta">Kotikawatta</option>
                                    <option value="Kolonnawa">Kolonnawa</option>
                                    <option value="Hendala">Hendala</option>
                                    <option value="Keselwatta">Keselwatta</option>
                                    <option value="Welisara">Welisara</option>
                                    <option value="Homagama">Homagama</option>
                                    <option value="Kalutara">Kalutara</option>
                                    <option value="Mulleriyawa">Mulleriyawa</option>
                                    <option value="Beruwala">Beruwala</option>
                                    <option value="Ragama">Ragama</option>
                                    <option value="Kandana">Kandana</option>
                                    <option value="Panadraya">Panadraya</option>
                                    <option value="Ja-Ela">Ja-Ela</option>
                                    <option value="Wattala">Wattala</option>
                                    <option value="Kelaniya">Kelaniya</option>
                                    <option value="Peliyagoda">Peliyagoda</option>
                                    <option value="Seethawakapura">Seethawakapura</option>
                                    <option value="Trincomalee">Trincomalee</option>
                                    <option value="Kalmunai">Kalmunai</option>
                                    <option value="Batticaloa">Batticaloa</option>
                                    <option value="Kattankudy">Kattankudy</option>
                                    <option value="Eravur">Eravur</option>
                                    <option value="Ampara">Ampara</option>
                                    <option value="Kandy">Kandy</option>
                                    <option value="Dambulla">Dambulla</option>
                                    <option value="Matale">Matale</option>
                                    <option value="Nuwara Eliya">Nuwara Eliya</option>
                                    <option value="Gampola">Gampola</option>
                                    <option value="Hatton">Hatton</option>
                                    <option value="Nawalapitiya">Nawalapitiya</option>
                                    <option value="Talawakele">Talawakele</option>
                                    <option value="Harispattuwa">Harispattuwa</option>
                                    <option value="Kadugannawa">Kadugannawa</option>
                                    <option value="Sigiriya">Sigiriya</option>
                                    <option value="Vavuniya">Vavuniya</option>
                                    <option value="Jaffna">Jaffna</option>
                                    <option value="Mannar Island">Mannar Island</option>
                                    <option value="Kilinochchi">Kilinochchi</option>
                                    <option value="Galle">Galle</option>
                                    <option value="Matara">Matara</option>
                                    <option value="Weligama">Weligama</option>
                                    <option value="Ambalangoda">Ambalangoda</option>
                                    <option value="Tanggalla">Tanggalla</option>
                                    <option value="Ratnapura">Ratnapura</option>
                                    <option value="Kegalla">Kegalla</option>
                                    <option value="Puttalam">Puttalam</option>
                                    <option value="Kurunegala">Kurunegala</option>
                                    <option value="Puttalam">Puttalam</option>
                                    <option value="Kurunegala">Kurunegala</option>
                                    <option value="Halawata">Halawata</option>
                                    <option value="Kuliyapitiya">Kuliyapitiya</option>
                                    <option value="Anuradhapura">Anuradhapura</option>
                                    <option value="Haputale">Haputale</option>
                                    <option value="Wattegama">Wattegama</option>
                                    <option value="Bandarawela">Bandarawela</option>
                                    <option value="Monaragala">Monaragala</option>
                                    <option value="Gampaha">Gampaha</option>
                                    <option value="Kaduwela">Kaduwela</option>
                                    <option value="Other">Other</option>

                                </select>

            </div>
            <div class="form-title">
                Contact No:
                <input type="tel" id="center_tel" name="center_tel" class="form-field" value="<?php echo set_value('center_tel'); ?>" required />
            </div>
            <div class="form-title">
                email:
                <input type="email" id="center_mail" name="center_mail" class="form-field" value="<?php echo set_value('center_mail'); ?>" required/>
            </div>
           
</div>
    <div class="form-container" style="float: left; margin-left: 20px"> <div class="form-title">
                Web Address:
                <input type="url" id="center_web" name="center_web" class="form-field" value="<?php echo set_value('center_web'); ?>" />
            </div>
            <div class="form-title">
             Add your treatment areas here: 
             <input class="form-field" type="text" id="autocomplete-field" placeholder="Type your treatment area name here" style="margin-bottom: 2px;"/>
            
             <textarea name="center_fields" class="form-field" id="autocomplete-field-pool" rows="6" value="<?php echo set_value('center_fields'); ?>"></textarea></div>
            <div class="form-title">
                Description:
                <textarea class="form-field" id="center-desc" name="center_desc" rows="4" cols="25" ></textarea>
            </div>
            
            <div class="submit-container">
                <input class="submit-button" type="submit" value="Submit" />
            </div></div></div>
            <?php echo form_close(); 
           
            echo validation_errors('<p class="error">');
        } else {
            echo '<h3 class=\'error\'>Please <a href=\'';echo base_url();echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add New Information</h3>';
        }
        ?>
    </div>
    
</div>