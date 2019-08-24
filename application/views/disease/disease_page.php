<div class="wrapper-page" >


    <div class="page-container">
        <div><div class="form-title" style="text-align: center"><h2>Disease Information Sheet</h2>
                <div style="float: right;width: 23%;">
                    <?php
                    if ($logged_in) {
                        if ($role == 3) {
                            
                        } else {
                            ?>
                            <span class="icon-trash"><a id='delete-disease'href="<?php
                                echo base_url();
                                echo 'index.php/disease_page/' . $result[0]->disease_id . '/del'
                                ?>">Delete</a></span>
                            <span class="icon-edit"><a href="<?php
                                echo base_url();
                                echo 'index.php/disease_edit/' . $result[0]->disease_id
                                ?>">Edit</a></span>
                                <?php
                            }
                        }
                        ?> </div>

            </div>
            <script type="text/javascript">
                $('#delete-disease').click(function() {
                    var r = confirm("Are you sure want to delete this disease");
                    if (r === true) {
                        return true;
                    } else {

                        return false;

                    }
                });



            </script>
        </div> 
        <div class="page-body">Name of disease: <?php echo $result[0]->disease_name; ?>

        </div>
        <div class="form-title">Type of disease: <?php echo $result[0]->field_name; ?>

        </div>
        <div class="page-body"> Symptoms: <?php echo $result[0]->disease_symptoms; ?>
        </div>
        <div class="page-body"> Treatments: <?php echo $result[0]->disease_treatments; ?>
        </div>
        <div class="page-body"> Avoid Guidelines: <?php echo $result[0]->disease_avoid_guide; ?>
        </div>
        <div class="page-body"> Related Herbal Plants: <?php
            foreach ($plant_name as $pl) {

                echo $pl->plant_name . ", ";
            }
            ?>
        </div>
        <div class="form-title">Submitted by: <?php echo $result[0]->sfname . " " . $result[0]->slname; ?>

        </div>
        <div class="form-title">Reviewed by: <?php
            if ($result[0]->disease_review === 'rev') {
                echo $result[0]->rfname . " " . $result[0]->rlname;
            } else {
                echo 'Un-Reviewed';
            }
            ?>

        </div>

    </div>
</div>




<!--comment system-->
<div class="comments-wrapper">
    <div class="comment-body">
        ALL COMMENTS(<?php echo $comments_count; ?>)<br /><br />
        <?php
        if ($logged_in) {
            $attributes = array('id' => 'add_new_comment_form');
            $hidden = array('disease_id' => $disease_id);
            echo form_open_multipart('disease/new_comment', $attributes, $hidden);
//This function is absolutely identical to the form_open() tag above except that it adds a multipart attribute, which is necessary if you would like to use the form to upload files with.
            ?>  <div class="new-comment">
                <div class="avatar-div" ></div><textarea  class="form-field new-comment-text-area" name="new_comment_content" rows="4" cols="25" placeholder="Share your thoughts" ><?php echo set_value('new-comment'); ?></textarea>
                                    <div class="submit-container">
                                        <input class="submit-button comment-submit" type="submit" value="Post" id="post" name="post"/>
                                    </div> </div>
            <?php
            echo form_close();
        } else {
            echo '<h3 class=\'error\'><a href=\'';
            echo base_url();
            echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>add and view comments</h3>';
        }
        ?>
      
        <div class="old-comments">
            <?php
            if ($logged_in) {
                
                foreach ($comments as $row) {
                     $check_pass="null";
                     $numResults = count($user_like_unlike);
                $counter = 0;
                    ?>
                                            <div class="old-comments-div">
                                                <div class="avatar-thumb"></div>
                                                <div  style="margin-left: 5%">
                                                    <div class="comment-main-div">
                                                        <a href="<?php echo base_url(); ?>profile/<?php echo $row->email ?>" target="_blank"><?php echo $row->fname . " " . $row->lname; ?>
                                                        </a>
                                                    </div>
                                                    <div class="old-comment-content"><?php echo $row->comment_content; ?></div>
                                                <div class="comment-options">
                                                    <div>
                                                        <a href="#">Reply</a>
                                                    </div>
                                                    
                                                    
                                <?php
                                foreach ($user_like_unlike as $like_row) {
 ++$counter;  
                                    if ($row->id === $like_row->comment_id) {

                                        if ($like_row->decision === 'l') {
                                            $check_pass ='y';
                                            
                                            ?>
                                                                <div class="like-button"><div>
                                                                        <input type="hidden" name="like-image<?php echo $row->id ?>-user-like" id="like-image<?php echo $row->id ?>-user-like" value="<?php echo $like_row->decision ?>" />
                                                                      <a href="#">
                                                                                 <img id="like-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like.png" style="width:20px; margin-left: 3px;"/>
                                                                        
                                                                    </a>
                                                                </div>
                                                                    <div  id="like-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->like; ?></div>
                                                                </div>
                                                                <div class="unlike-button"><div>
                                                                    <a href="#">
                                                                        <img id="unlike-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                    </a>
                                                                </div>
                                                                    <div id="unlike-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->unlike; ?></div>
                                                                </div>
                                            <?php
                                        } elseif ($like_row->decision === 'u') {
                                          $check_pass ='y';   ?>
                                                                <div class="like-button"><div>
                                                                      <input type="hidden" name="like-image<?php echo $row->id ?>-check-like" id="like-image<?php echo $row->id ?>-check-like" value="y" />
                                                                        <a href="#">
                                                                                 <img id="like-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                        
                                                                    </a>
                                                                </div>
                                                                    <div  id="like-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->like; ?></div>
                                                                </div>
                                                                <div class="unlike-button"><div>
                                                                    <a href="#">
                                                                        <img id="unlike-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike.png" style="width:20px; margin-left: 3px;"/>
                                                                    </a>
                                                                </div>
                                                                    <div id="unlike-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->unlike; ?></div>
                                                                </div>
                                                <?php
                                        } elseif ($like_row->decision === 'n') {
                                          $check_pass ='y';   ?>
                                                                <div class="like-button"><div>
                                                                        <input type="hidden" name="like-image<?php echo $row->id ?>-user-like" id="like-image<?php echo $row->id ?>-user-like" value="<?php echo $like_row->decision ?>" />
                                                                        <a href="#">
                                                                                 <img id="like-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                        
                                                                    </a>
                                                                </div>
                                                                    <div  id="like-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->like; ?></div>
                                                                </div>
                                                                <div class="unlike-button"><div>
                                                                    <a href="#">
                                                                        <img id="unlike-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                    </a>
                                                                </div>
                                                                    <div id="unlike-image<?php echo $row->id ?>-count" style="margin-left: 2px"><?php echo $row->unlike; ?></div>
                                                                </div>
                                                <?php
                                            }
                                       
                                            } else {
                                                if ($counter == $numResults) {
                                                if (  $check_pass =="null") {
                                                
                                                
                                            ?>
                                                            <div class="like-button"><div>
                                                                    <input type="hidden" name="like-image<?php echo $row->id ?>-user-like" id="like-image<?php echo $row->id ?>-user-like" value="n" />
                                                                <a href="#">
                                                                             <img id="like-image<?php echo $row->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                    
                                                                </a>
                                                            </div>
                                                                <div  id="like-image<?php echo $row->id; ?>-count" style="margin-left: 2px"><?php echo $row->like; ?></div>
                                                            </div>
                                                            <div class="unlike-button"><div>
                                                                <a href="#">
                                                                    <img id="unlike-image<?php echo $row->id; ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                </a>
                                                            </div>
                                                                <div id="unlike-image<?php echo $row->id; ?>-count" style="margin-left: 2px"><?php echo $row->unlike; ?></div>
                                                            </div>
                                            <?php }
                                            
                                                }
                                            }
                                         //  $like_row->comment_id =0;
                                          }
                                            ?>
                                                    
                                                    
                                                    
                                                    <div style="margin-left: 4px">
                                                        <a href="#"> Delete</a>
                                                    </div>
                                                </div>
                                                    </div>
                                            </div>
                                            
                            <?php
                        foreach ($sub_comments as $row2) {
                             $check_pass_sub="null";
                     $numResults_sub = count($user_like_unlike);
                $counter_sub = 0;
                            if ($row2->parent_comment === $row->id) {
                                ?>
                                                                                                    <div class="old-sub-comments-div">
                                                                                                        <div class="sub-avatar-thumb">
                                                                                                            
                                                                                                        </div><div  style="margin-left: 6%">
                                                                                                            <div class="comment-main-div"><a href="<?php echo base_url(); ?>profile/<?php echo $row2->email ?>" target="_blank"><?php echo $row2->fname . " " . $row2->lname; ?></a>
                                                                                                            </div><div class="old-sub-comment-content"><?php echo $row2->comment_content; ?></div>
                                                                                                      <div class="comment-options">
                                                                                                          <div>
                                                                                                              <a href="#">Reply</a>
                                                                                                          </div>
                                                                                                          
                                        <?php
                                            foreach ($user_like_unlike as $like_row) {
                                            ++$counter_sub;  
                                            if ($row2->id === $like_row->comment_id) {

                                                    if ($like_row->decision === 'l') {
                                                        $check_pass_sub ='y'; ?>
                                                                                                                      <div class="like-button2">
                                                                                                                                 <input type="hidden" name="like-image-sub<?php echo $row2->id ?>-user-like" id="like-image-sub<?php echo $row2->id ?>-user-like" value="<?php echo $like_row->decision ?>" />
                                                                                                                          <a href="#">
                                                                                                                              <img id="like-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                       <div id="like-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->like; ?></div>
                                                                                                                      <div class="unlike-button2">
                                                                                                                          <a href="#">
                                                                                                                              <img id="unlike-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                          <div id="unlike-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->unlike; ?></div>
                                                    <?php
                                                    } elseif ($like_row->decision === 'u') {
                                                      $check_pass_sub ='y';   ?>
                                                                                                                            <div class="like-button2">
                                                                                                                                 <input type="hidden" name="like-image-sub<?php echo $row2->id ?>-user-like" id="like-image-sub<?php echo $row2->id ?>-user-like" value="<?php echo $like_row->decision ?>" />
                                                                                                                          <a href="#">
                                                                                                                              <img id="like-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                       <div id="like-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->like; ?></div>
                                                                                                                      <div class="unlike-button2">
                                                                                                                          <a href="#">
                                                                                                                              <img id="unlike-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                          <div id="unlike-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->unlike; ?></div>
                                                                                                                 
                                                    <?php
                                                } elseif ($like_row->decision === 'n') {
                                               $check_pass_sub ='y';      ?>
                                                                                                                    <div class="like-button2">
                                                                                                                                 <input type="hidden" name="like-image-sub<?php echo $row2->id ?>-user-like" id="like-image-sub<?php echo $row2->id ?>-user-like" value="<?php echo $like_row->decision ?>" />
                                                                                                                          <a href="#">
                                                                                                                              <img id="like-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                       <div id="like-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->like; ?></div>
                                                                                                                      <div class="unlike-button2">
                                                                                                                          <a href="#">
                                                                                                                              <img id="unlike-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                          </a>
                                                                                                                      </div>
                                                                                                                          <div id="unlike-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->unlike; ?></div>
                                                                                                                    
                                                    <?php
                                                }
                                            } else {
                                                 if ($counter_sub == $numResults_sub) {
                                                if (  $check_pass_sub =="null") { ?>
                                                                                                                      <div class="like-button2">
                                                                                                                             <input type="hidden" name="like-image-sub<?php echo $row2->id ?>-user-like" id="like-image-sub<?php echo $row2->id ?>-user-like" value="n" />
                                                                                                                      <a href="#">
                                                                                                                          <img id="like-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                      </a>
                                                                                                                  </div>
                                                                                                                   <div id="like-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->like; ?></div>
                                                                                                                  <div class="unlike-button2">
                                                                                                                      <a href="#">
                                                                                                                          <img id="unlike-image-sub<?php echo $row2->id ?>" src="<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png" style="width:20px; margin-left: 3px;"/>
                                                                                                                      </a>
                                                                                                                  </div>
                                                                                                                      <div id="unlike-image-sub<?php echo $row2->id ?>-count" style="margin-left: 2px"><?php echo $row2->unlike; ?></div>
                                                                                                             
                                                    <?php
                                            }}  } }
                                                    ?>
                                                                                                                  
                                                                                                                  <div style="margin-left: 4px">
                                                                                                                  <a href="#"> Delete</a>
                                                                                                              </div>
                                                                                                          </div>
                                                                                                            </div>
                                                                                                        </div>
                                            <?php
                                    //    }


                                        //  echo '<option value="' . $row->field_id . '">' . $row->name . '</option>';
                                    }
                                }
                            }
                        }
                        ?>
            
           
        </div>
    </div>
</div>

 <script type="text/javascript">
   // $(document).ready(function() {


        $(".like-button").click(function(event) {
            // alert($("#" + event.target.id + "-user-like").val()) ;  
            var like_count = parseInt($("#" + event.target.id + "-count").text());
            var unlike_count = parseInt($("#un" + event.target.id + "-count").text());
            var comment_id = event.target.id.replace(/[^0-9]/g, '');

            if ($("#" + event.target.id + "-user-like").val() === 'l') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png");
                like_count = like_count - 1;
                $("#" + event.target.id + "-user-like").val('n');
                $("#" + event.target.id + "-count").html(like_count);
                //////////////////////////
                
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_non_like'); ?>",
                data: { comm_id:comment_id  }
            }).done(function(data) {
             
            }).fail(function() {
                alert( "Data Not Send" );
            });
            

            }
            else if ($("#" + event.target.id + "-user-like").val() === 'u') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like.png");
                $("#un" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png");
                like_count = 1 + like_count;
                $("#" + event.target.id + "-count").html(like_count);
                $("#un" + event.target.id + "-count").html(parseInt(unlike_count) - 1);
                $("#" + event.target.id + "-user-like").val('l');
               
                
            }
            else if ($("#" + event.target.id + "-user-like").val() === 'n') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like.png");

                like_count = 1 + like_count;
                $("#" + event.target.id + "-count").html(like_count);
                $("#" + event.target.id + "-user-like").val('l');
                
                ////////////////
                
                
                 var deci = $("#" + event.target.id + "-user-like").val();
                    $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('autocomplete_control/user_like_decision'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            }
            
         

like_count = parseInt($("#" + event.target.id + "-count").text());
             unlike_count = parseInt($("#un" + event.target.id + "-count").text());
                  $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/comment_like'); ?>",
                data: { comm_id:comment_id, like: like_count, unlike:unlike_count }
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            
            

            ///////////////////////
            // event.preventDefault();
//var user_name = $("input#name").val();
//var password = $("input#pwd").val();

//////////////////////

            return false;
        });
        $(".like-button2").click(function(event) {
            var like_count = parseInt($("#" + event.target.id + "-count").text());
            var unlike_count = parseInt($("#un" + event.target.id + "-count").text());
             var comment_id = event.target.id.replace(/[^0-9]/g, '');

            if ($("#" + event.target.id + "-user-like").val() === 'l') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png");
                like_count = like_count - 1;
                $("#" + event.target.id + "-user-like").val('n');
                $("#" + event.target.id + "-count").html(like_count);
                
                /////////////////////////
                
                 var deci = $("#" + event.target.id + "-user-like").val();
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_non_like'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
                
            }
            else if ($("#" + event.target.id + "-user-like").val() === 'u') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like.png");
                $("#un" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png");
                like_count = 1 + like_count;
                $("#" + event.target.id + "-count").html(like_count);
                $("#un" + event.target.id + "-count").html(parseInt(unlike_count) - 1);
                $("#" + event.target.id + "-user-like").val('l');
   
                      
            }
            else if ($("#" + event.target.id + "-user-like").val() === 'n') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like.png");

                like_count = 1 + like_count;
                $("#" + event.target.id + "-count").html(like_count);
                $("#" + event.target.id + "-user-like").val('l');
                
                ////////////
                var deci = $("#" + event.target.id + "-user-like").val();
                    $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('autocomplete_control/user_like_decision'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
                
            }
            like_count = parseInt($("#" + event.target.id + "-count").text());
             unlike_count = parseInt($("#un" + event.target.id + "-count").text());
                  $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('autocomplete_control/comment_like'); ?>",
                data: { comm_id:comment_id, like: like_count, unlike:unlike_count }
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            return false;
        });




        $(".unlike-button").click(function(event) {
            var unlike_count = parseInt($("#" + event.target.id + "-count").text());
            var hidden_field = event.target.id.substring(2);
            var like_count = parseInt($("#" + hidden_field + "-count").text());
            var comment_id = event.target.id.replace(/[^0-9]/g, '');

            if ($("#" + hidden_field + "-user-like").val() === 'u') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png");
                unlike_count = unlike_count - 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-user-like").val('n');
                
                
                var deci = $("#" + hidden_field+ "-user-like").val();
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_non_like'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });

            }
            else if ($("#" + hidden_field + "-user-like").val() === 'n') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike.png");
                unlike_count = unlike_count + 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-user-like").val('u');
                
                
                
                var deci = $("#" + hidden_field+ "-user-like").val();
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_like_decision'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            }
            else if ($("#" + hidden_field + "-user-like").val() === 'l') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike.png");
                $("#" + hidden_field).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png");
                unlike_count = unlike_count + 1;
                like_count = like_count - 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-count").html(like_count);
                $("#" + hidden_field + "-user-like").val('u');
            }
            
                            
            unlike_count = parseInt($("#" + event.target.id + "-count").text());
            like_count = parseInt($("#" + hidden_field + "-count").text());
             $.ajax({
                type: "POST",
              
                url: "<?php echo site_url('autocomplete_control/comment_like'); ?>",
                data: { comm_id:comment_id, like: like_count, unlike:unlike_count }
            }).done(function(data) {
              
            }).fail(function() {
                alert( "Data Not Send" );
            });
            return false;
        });





        $(".unlike-button2").click(function(event) {
            var unlike_count = parseInt($("#" + event.target.id + "-count").text());
            var hidden_field = event.target.id.substring(2);
            var comment_id = event.target.id.replace(/[^0-9]/g, '');

            var like_count = parseInt($("#" + hidden_field + "-count").text());

            if ($("#" + hidden_field + "-user-like").val() === 'u') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike-inactive.png");
                unlike_count = unlike_count - 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-user-like").val('n');
                
                
                //////////////
                  var deci = $("#" + hidden_field+ "-user-like").val();
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_non_like'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            }
            else if ($("#" + hidden_field + "-user-like").val() === 'n') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike.png");
                unlike_count = unlike_count + 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-user-like").val('u');
                
                //////////////
                
                  var deci = $("#" + hidden_field+ "-user-like").val();
                    $.ajax({
                type: "POST",
               
                url: "<?php echo site_url('autocomplete_control/user_like_decision'); ?>",
                data: { comm_id:comment_id , decision: deci}
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            }
            else if ($("#" + hidden_field + "-user-like").val() === 'l') {
                $("#" + event.target.id).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/unlike.png");
                $("#" + hidden_field).attr('src', "<?php echo base_url(); ?>/assests/images/buttons/like-inactive.png");
                unlike_count = unlike_count + 1;
                like_count = like_count - 1;
                $("#" + event.target.id + "-count").html(unlike_count);
                $("#" + hidden_field + "-count").html(like_count);
                $("#" + hidden_field + "-user-like").val('u');
            }
            
            like_count = parseInt($("#" + event.target.id + "-count").text());
             unlike_count = parseInt($("#un" + event.target.id + "-count").text());
                  $.ajax({
                type: "POST",
              
                url: "<?php echo site_url('autocomplete_control/comment_like'); ?>",
                data: { comm_id:comment_id, like: like_count, unlike:unlike_count }
            }).done(function(data) {
               
            }).fail(function() {
                alert( "Data Not Send" );
            });
            return false;
        });


    //});
</script>
 