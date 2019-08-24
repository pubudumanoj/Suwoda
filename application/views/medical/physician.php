<?php ?>
<div id="wrapper" style="overflow: auto;">

    <div >

        <div style="width: 97.9%;margin-left: 4px; border-top: 1px solid #000000; margin-bottom: 10px;margin-top: 10px;">
            <?php
            $attributes = array('id' => 'select_physician_form');
            echo form_open("medical/physician_control/select_view", $attributes);
            ?>
            <div style="height: 45px; padding-top: 1%; padding-left: 2%;">

                Type: <select class="form-field" style="width:330px; margin: 0px;"name="field_type">
                    <option value="all">All</option>;
                    <?php
                    foreach ($field_result as $row) {
                        ?>
                        <option value="<?php echo $row->field_id ?>"><?php echo $row->name ?></option>;
                        <?php
                    }
                    ?>

                </select>

                <input class="form-field" type="text" name="physician_search_key" value="" style="margin-left: 80px; width: 28%;" placeholder="Type Name of the physician"/>
                <input class="submit-button" type="submit" value="Search" />
            </div>
            <?php echo form_close(); ?>
        </div>


        <div class="CSSTableGenerator">

            <table>
                <tr>
                    <td>
                        Name
                    </td>
                    <td >
                        E mail
                    </td>
                    <td>
                        Working Medical Centre
                    </td> 
                    <td>
                        Treatment areas
                    </td> 

                </tr>

                <?php foreach ($result as $row) { ?>
                    <tr>

                        <td><?php
                                                    if ($row->physician_id!=NULL) {
                                                        
                                                    
                            echo '<a href=\'';
                            echo base_url();
                            echo 'index.php/booking/' .    rtrim(strtr(base64_encode($row->email), '+/', '-_'), '=') . '\' target=\'_blank\'>' . $row->salutation . " " . $row->fname . " " . $row->lname;
                '</a>';}
                                                   else {
                                                        
                            ?>
                            <a href="#"><?php echo $row->salutation . " " . $row->fname . " " . $row->lname."(NB)"; ?></a>
                            <?php
                
                                                   }
                            ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->center; ?></td>
                        <td><?php echo $row->fields; ?></td>
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
                    <a class="not-active-link">Next |</a><?php if ($current_offset > 10) {
                        ?>
                        <a href="<?php echo base_url(); ?>index.php/medical/<?php
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
                        ?>">Back</a><?php } else {
                        ?>
                        <a> Back</a>
                        <?php
                    }
                } else {
                    ?>
                    <a href="<?php echo base_url(); ?>index.php/medical/<?php
                    echo $type;
                    echo '/';
                    if ($search != '') {
                        echo $search;
                    } else {
                        echo 'none';
                    } echo '/';
                    echo $offset + 10;
                    echo '/';
                    if ($current_offset + 10 <= $total_count) {
                        echo $current_offset + 10;
                    } else {
                        echo $current_offset + ($total_count - $current_offset);
                    }
                    ?>">Next |</a><a href="#"> Back</a>
                   
                   <?php } ?>
            </div>
        </div>  Note: NB= No Booking Available

    </div>
</div>