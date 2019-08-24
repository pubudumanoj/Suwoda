<div class="wrapper-page" style="width: 80%">


    <div class="page-container" style="width: 100%; margin-left: 0px;  min-height:500px;overflow: hidden;">
        <div><div class="form-title" style="text-align: center"><h2>Plant Information Sheet</h2>
                <div style="float: right;width: 23%;">
                    <?php
                    if ($logged_in) {
                        if ($role == 3) {
                            
                        } else {
                            ?>
                            <span class="icon-trash"><a id='delete-plant'href="<?php
                                echo base_url();
                                echo 'index.php/plant_page/' . $result[0]->plant_id . '/del'
                                ?>">Delete</a></span>
                            <span class="icon-edit"><a href="<?php
                                                       echo base_url();
                                                       echo 'index.php/plant_edit/' . $result[0]->plant_id
                                                       ?>">Edit</a></span>
                            <?php
                            }
                        }
                        ?> </div>

            </div>
            <script type="text/javascript">
                $('#delete-plant').click(function() {
                    var r = confirm("Are you sure want to delete this plant");
                    if (r === true) {
                        return true;
                    } else {

                        return false;

                    }
                });
            </script>
        </div>
        <div><div style="float: left; width: 43.5%" ><img style="width: 450px;"alt="hii" src="<?php echo base_url(); ?>/assests/images/plants/<?php echo $result[0]->plant_image ?>">
            </div>
            <div style="margin-left: 0px; margin-top:10px; float: left; width: 56%">
                <div class="page-body"><span class="plant_page_item"> Biological Name: </span><i><?php echo $result[0]->b_name; ?></i>
                </div>
                <div class="page-body"><span class="plant_page_item">English Name: </span><?php echo $result[0]->e_name; ?>
                </div>
                <div class="page-body"> <span class="plant_page_item">Sinhala Name: </span><?php echo $result[0]->s_name; ?>
                </div>
                <div class="page-body"> <span class="plant_page_item">Other Names: </span><?php echo $result[0]->other_names; ?>
                </div>
                <div class="page-body"> <span class="plant_page_item">Plant Characteristics: </span><?php echo $result[0]->charac; ?>
                </div>
                <div class="page-body"> <span class="plant_page_item">Applicable Diseases:  </span><?php
                    foreach ($disease_name as $pl) {
                        echo $pl->disease_name . ", ";
                    }
                    ?>
                </div>

                <div class="form-title"><span class="plant_page_item">Submitted by: </span><?php echo $result[0]->sfname . " " . $result[0]->slname; ?>

                </div>
                <div class="form-title"><span class="plant_page_item">Reviewed by: </span><?php
                    if ($result[0]->plant_review === 'rev') {
                        echo $result[0]->rfname . " " . $result[0]->rlname;
                    } else {
                        echo 'Un-Reviewed';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
