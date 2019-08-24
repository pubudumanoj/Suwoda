<?php ?>
<div id="wrapper" style="overflow: auto;">

    <div >

        <div style="width: 97.9%;margin-left: 4px; border-top: 1px solid #000000; margin-bottom: 10px;margin-top: 10px;">
            <?php
            $attributes = array('id' => 'select_plant_form');
            echo form_open("plant/select_view", $attributes);
            ?>
            <div style="height: 45px; padding-top: 1%; padding-left: 2%;">
                Status: <select class="form-field" style="width:100px; margin: 0px;"name="plant_status">
                    <option value="all">All</option>
                    <option value="rev">Reviewed</option>
                    <option value="unr">Un-reviewed</option>
                </select>
                Region: <select class="form-field" style="width:330px; margin: 0px;"name="plant_region">

                    <option value="all">All</option>
                    <?php
                    foreach ($regions as $row) {
                        echo '<option value="' . $row->plant_region . '">' . $row->plant_region . '</option>';
                    }
                    ?>
                </select>

                <input class="form-field" type="text" name="plant_search_key" value="" style="margin-left: 80px; width: 28%;" placeholder="Type plant name"/>
                <input class="submit-button" type="submit" value="Search" />
            </div>
            <?php echo form_close(); ?>
        </div>


        <div class="CSSTableGenerator">

            <table>
                <tr>
                    <td>
                        Image
                    </td>
                    <td>
                        English Name
                    </td>
                    <td >
                        Region Found
                    </td>
                    <td>
                        Characteristics
                    </td> 
                </tr>

                <?php foreach ($result as $row) { 
                    $path_parts = pathinfo(base_url().'/assests/images/plants/'.$row->plant_image);
                
                    ?>
                    <tr>
                        <td>
                            <img style="width: 120px"src="<?php echo base_url(); ?>/assests/images/plants/<?php echo $path_parts['filename']."_thumb.".$path_parts['extension'];?>"
                            <?php
                            
                            ?>
                        </td>

                        <td><?php
                            echo '<a href=\'';
                            echo base_url();
                            echo 'index.php/plant/' . $row->plant_id . '\' target=\'_blank\'>' . $row->e_name . '</a>';
                            ?></td>
                        <td>
                            <?php
                            echo $row->plant_region;
                            ?></td>
                        <td><?php echo word_limiter($row->charac, 50); ?></td>
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
                        <a href="<?php echo base_url(); ?>index.php/plant/<?php
                        echo $review;
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
                        ?>">Back</a><?php } else {
                        ?>
                        <a> Back</a>
                        <?php
                    }
                } else {
                    ?>
                    <a href="<?php echo base_url(); ?>index.php/plant/<?php
                    echo $review;
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
                    if ($current_offset + 10 <= $total_count) {
                        echo $current_offset + 10;
                    } else {
                        echo $current_offset + ($total_count - $current_offset);
                    }
                    ?>">Next |</a><a href="#"> Back</a>
                   <?php } ?>
            </div>
        </div>

    </div>
</div>