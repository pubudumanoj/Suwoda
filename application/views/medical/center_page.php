<div class="wrapper-page" >


    <div class="page-container">
        <div><div class="form-title" style="text-align: center"><h2>Medical Centre Information Sheet</h2>
                <div style="float: right;width: 23%;">
                    <?php
                    if ($logged_in) {
                        if ($role == 3) {
                            
                        } else {
                            ?>
                            <span class="icon-trash"><a id='delete-center'href="<?php
                                echo base_url();
                                echo 'index.php/center_page/' . $result[0]->center_id . '/del'
                                ?>">Delete</a></span>
                            <span class="icon-edit"><a href="<?php
                                echo base_url();
                                echo 'index.php/center_edit/' . $result[0]->center_id
                                ?>">Edit</a></span>
                                <?php
                            }
                        }
                        ?> </div>

            </div>
            <script type="text/javascript">
                $('#delete-center').click(function() {
                    var r = confirm("Are you sure want to delete this disease");
                    if (r === true) {
                        return true;
                    } else {

                        return false;

                    }
                });



            </script>
        </div> 
        <div class="page-body">Name of the Centre: <?php echo $result[0]->name; ?>

        </div>
        <div class="form-title">Description: <?php echo $result[0]->desc; ?>

        </div>
        <div class="page-body"> Region: <?php echo $result[0]->region; ?>
        </div>
        <div class="page-body"> Type: <?php
            if ($result[0]->type == "HT") {
                echo "Hotel";
            }
            
            elseif ($result[0]->type == "OT") {
                echo "Other";
            } 
            
            elseif ($result[0]->type == "MC") {
                echo "Medical Centre";
            } 
            ?>
        </div>
        <div class="page-body"> Web site: <a href="<?php echo $result[0]->web; ?>"><?php echo $result[0]->web; ?></a> </div>
        <div class="page-body"> email: <a href="mailto:<?php echo $result[0]->mail; ?>"><?php echo $result[0]->mail; ?></a>
        </div>
        <div class="page-body"> Contact No: <?php echo $result[0]->tel; ?>
        </div>
        <div class="page-body"> Treatments : <?php
            foreach ($treatments as $row) {

                echo $row->name . ", ";
            }
            ?>
        </div>
        <div class="form-title">Submitted by: <?php echo $result[0]->fname . " " . $result[0]->lname; ?>

        </div>
      

    </div>
</div>




