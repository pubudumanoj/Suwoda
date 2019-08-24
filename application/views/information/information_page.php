<div class="wrapper-page" >


    <div class="page-container">
        <div><div class="form-title" style="text-align: center"><h2>Information Page</h2>
                <div style="float: right;width: 23%;">
                    <?php if ($logged_in) {
     if ($role==3 ) {
                        
                    }else{
 ?>
                    <span class="icon-trash"><a id='delete-page'href="<?php echo base_url(); echo 'index.php/information_page/'.$result[0]->id.'/del'?>">Delete</a></span>
                    <span class="icon-edit"><a href="<?php echo base_url(); echo 'index.php/information_edit/'.$result[0]->id?>">Edit</a></span>
                    <?php } } ?> </div>

            </div>
            <script type="text/javascript">
                $('#delete-page').click( function() {            
            var r=confirm("Are you sure want to delete this information");
if (r===true) {
  return true;
} else {
    
   return false;
   
}  } );
              
         
                
            </script>
        </div> 
        <div class="page-body"><?php echo $result[0]->title; ?>

        </div>
        <div class="form-title">Type: <?php echo $result[0]->type; ?>

        </div>
        <div class="page-body"> <?php echo $result[0]->desc; ?>
        </div>
        <div class="form-title">Submitted by: <?php echo $result[0]->sfname . " " . $result[0]->slname; ?>

        </div>
        <div class="form-title">Reviewed by: <?php
            if ($result[0]->review === "rev") {
                echo $result[0]->rfname . " " . $result[0]->rlname;
            } else {
                echo 'Un-Reviewed';
            }
            ?>

        </div>
      
        </form>
    </div>
</div>
