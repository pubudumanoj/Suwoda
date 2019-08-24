<?php ?>
<div id="wrapper" style="overflow: auto;">

    <div >

        <div style="width: 97.9%;margin-left: 4px; border-top: 1px solid #000000; margin-bottom: 10px;margin-top: 10px;">
            <?php
            $attributes = array('id' => 'select_disease_form');
            echo form_open("medical/select_view", $attributes);
            ?>
            <div style="height: 45px; padding-top: 1%; padding-left: 2%;">
               
                Type: <select class="form-field" style="width:330px; margin: 0px;"name="center_type">

                    <option value="all">All</option>
                        <option value="MC">Medical Centre</option>;
                        <option value="HT">Ayurvedic Hotel</option>;
                        <option value="OT">Other</option>;
                  
                </select>

                <input class="form-field" type="text" name="center_search_key" value="" style="margin-left: 80px; width: 28%;" placeholder="Type Center Name"/>
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
                        Type
                    </td>
                    <td>
                       Location
                    </td> 
                    <td>
                      Contacts
                    </td> 
                    <td>
                      E mail
                    </td> 
                    <td>
                   Web Site
                    </td> 
                    <td>
                   Description
                    </td> 
                </tr>

                <?php foreach ($result as $row) { ?>
                   <tr>
               
                        <td><?php
                            echo '<a href=\'';
                            echo base_url();
                            echo 'index.php/medical/' . $row->center_id . '\' target=\'_blank\'>' . $row->name . '</a>';
                            ?></td>
                        <td>
                            <?php
                            if ($row->type=='HT') {
                                echo "Hotel";
                            }
                            elseif ($row->type=='MC') {
                                echo "Medical Centre";
                            }
                            elseif ($row->type=='OT') {
                                echo "Other";
                            }
                            
                            ?></td>
                        <td><?php echo $row->region; ?></td>
                        <td><?php echo $row->tel; ?></td>
                        <td>
                            <a target="_blank" href="mailto:<?php echo $row->mail;?>"><?php echo $row->mail; ?></a> 
                        </td>
                        <td>
                            <a target="_blank" href="<?php echo $row->web;?>"><?php echo $row->web; ?></a> 
                        </td>
                        <td><?php echo word_limiter($row->desc, 10); ?></td>
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
                
                 
                ?>">Back</a><?php 
                }else {?>
                 <a> Back</a>
                <?php
                } } else {
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