<?php ?>
<div id="wrapper" style="overflow: auto;">
    <div class='body-left'>

        <?php
        if ($logged_in) {
            $attributes = array('class' => 'form-container', 'id' => 'info-form');
            echo form_open("information/information_control/validate_information", $attributes);
            ?>
            <div class="form-title"><h2>Add New Information</h2></div>
            <div class="form-title">
                Title of the Information: 
                <input type="text" id="info-title" name="title" class="form-field" value="<?php echo set_value('name'); ?>" />
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
            <div class="form-title">
                Description:
                <textarea class="form-field" id="infor-desc" name="desc" rows="4" cols="25"></textarea>
            </div>
            <div class="submit-container">
                <input class="submit-button" type="submit" value="Submit" />
            </div>
            <?php echo form_close(); ?>
            <?php
            echo validation_errors('<p class="error">');
        } else {
            echo '<h3 class=\'error\'>Please <a href=\'';echo base_url();echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add New Information</h3>';
        }
        ?>
    </div>
    
    

    <div class='body-right ' >
           
        <div style="width: 97.9%;margin-left: 4px; margin-bottom: 10px;">
            <?php
            $attributes = array('id' => 'select_information_form');
            echo form_open("information/select_view", $attributes);
            ?>
            <div style="height: 45px; padding-top: 1%; padding-left: 2%;">
               Status: <select class="form-field" style="width:100px; margin: 0px;"name="information_status">
                    <option value="all">All</option>
                    <option value="rev">Reviewed</option>
                    <option value="unr">Un-reviewed</option>
                </select>
               Type: <select class="form-field" style="width:100px; margin: 0px;"name="information_type">
                    <option value="all">All</option>
                    <option value="SL">Sloka</option>
                    <option value="KS">Kashaya</option>
                    <option value="BK">Book</option>
                </select>
               
               <input class="form-field" type="text" value="" name="info_search_key"style="margin-left: 80px; width: 28%;"/>
              <input class="submit-button" type="submit" value="Search" />
            </div>
           
        </div>
     
           
         
        <div class="CSSTableGenerator">
       
            <table >
               <tr>
                        <td>
                            Title
                        </td>
                        <td >
                            Type
                        </td>
                        <td>
                           Description
                        </td>
                        
                    </tr>
              
           
    <?php foreach($result as $row){ ?>
                    <tr>
            <td><?php echo '<a href=\''; echo base_url(); echo 'index.php/information_page/'.$row->id.'/show'.'\' target=\'_blank\'>'.$row->title.'</a>'; ?></td>
            <td><?php  if ($row->type=='SL') {
       echo 'SLOKA'  ;} elseif ($row->type=='KS') {echo 'KASHAYA';} else{ echo 'BOOK';}
                           ?></td>
            <td><?php echo word_limiter($row->desc,10); ?></td>
        </tr>
         
    <?php } ?>
               

</table>
        </div>
  <div style="width: 97.9%;margin-left: 4px; border-bottom:  1px solid #000000;">
            <div style="height: 30px; padding-top: 1%; padding-left: 40%;">
                Showing <?php echo $offset + 1; ?> - <?php echo $current_offset; ?> of <?php echo $total_count; ?> Results 
                <?php
           
                if ($current_offset >= $total_count) {
                    ?>
                <a class="not-active-link">Next |</a><?php if ($current_offset >10) {
                   
                ?>
                <a href="<?php echo base_url(); ?>index.php/information/<?php echo $review;
                echo '/';
                echo $type;
                echo '/';
                if ($search != '') {
                    echo $search;
                } else {
                    echo 'none';
                } echo '/';
                 echo $offset - 10;
                echo '/';
                
                    echo $offset;
                
                 
                ?>">Back</a><?php 
                }else {?>
                 <a> Back</a>
                <?php
                } } else {
                    ?>
                    <a href="<?php echo base_url(); ?>index.php/information/<?php echo $review;
                echo '/';
                echo $type;
                echo '/';
                if ($search != '') {
                    echo $search;
                } else {
                    echo 'none';
                } echo '/';
                 echo $offset + 10;
                echo '/';
                 if ($current_offset +10 <= $total_count) {
                    echo $current_offset + 10;
                }
                else{
                echo $current_offset + ($total_count-$current_offset);
                }
                 
                ?>">Next |</a><a href="#"> Back</a>
<?php } ?>
            </div>
        </div>
      
    </div>
</div>