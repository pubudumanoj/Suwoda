<?php ?>
<div id="wrapper" style="width: 100%; ">

    <div class="page-container" style="overflow: hidden; margin-top: 1%; margin-left: auto; margin-right: auto; width: 70%">
        <?php
        if ($logged_in) {

            
            ?>
            <div class="form-title" style="text-align: center"><h2>Booking a Physician</h2></div>
            <?php
            $month1 = date('F', strtotime(date("Y-m-d", time() + (86400 * 1))));
            $month2 = date('F', strtotime(date("Y-m-d", time() + (86400 * 2))));
            $month3 = date('F', strtotime(date("Y-m-d", time() + (86400 * 3))));
            $month4 = date('F', strtotime(date("Y-m-d", time() + (86400 * 4))));
            $month5 = date('F', strtotime(date("Y-m-d", time() + (86400 * 5))));
            $month6 = date('F', strtotime(date("Y-m-d", time() + (86400 * 6))));
            $month7 = date('F', strtotime(date("Y-m-d", time() + (86400 * 7))));

            $year1 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 1))));
            $year2 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 2))));
            $year3 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 3))));
            $year4 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 4))));
            $year5 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 5))));
            $year6 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 6))));
            $year7 = date('Y', strtotime(date("Y-m-d", time() + (86400 * 7))));

            $day1 = date('d', strtotime(date("Y-m-d", time() + (86400 * 1))));
            $day2 = date('d', strtotime(date("Y-m-d", time() + (86400 * 2))));
            $day3 = date('d', strtotime(date("Y-m-d", time() + (86400 * 3))));
            $day4 = date('d', strtotime(date("Y-m-d", time() + (86400 * 4))));
            $day5 = date('d', strtotime(date("Y-m-d", time() + (86400 * 5))));
            $day6 = date('d', strtotime(date("Y-m-d", time() + (86400 * 6))));
            $day7 = date('d', strtotime(date("Y-m-d", time() + (86400 * 7))));

            $weekday1 = date('D', strtotime(date("Y-m-d", time() + (86400 * 1))));
            $weekday2 = date('D', strtotime(date("Y-m-d", time() + (86400 * 2))));
            $weekday3 = date('D', strtotime(date("Y-m-d", time() + (86400 * 3))));
            $weekday4 = date('D', strtotime(date("Y-m-d", time() + (86400 * 4))));
            $weekday5 = date('D', strtotime(date("Y-m-d", time() + (86400 * 5))));
            $weekday6 = date('D', strtotime(date("Y-m-d", time() + (86400 * 6))));
            $weekday7 = date('D', strtotime(date("Y-m-d", time() + (86400 * 7))));
            ?>
            <div>
                <div class="form-title">
                    <table class="booking-labels">
                        <tr>
                            <td>Physician Name: </td>
                            <td> <?php echo $physician_default_setup[0]->fname . " " . $physician_default_setup[0]->lname; ?></td>
                        </tr>
                        <tr>
                            <td>Medical Center: </td>
                            <td> <?php echo $physician_default_setup[0]->name ?></td>

                        </tr>
                        <tr>
                            <td> Location: </td>
                            <td> <?php echo $physician_default_setup[0]->region ?></td>

                        </tr>
                    </table>
                </div>
                <table class="booking-table">
                    <tr>
                        <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday1 == "Sat" || $weekday1 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date1book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 1))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 1)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year1; ?></div>
                                    <div class="booking-table-month"><?php echo $month1 ?></div>
                                    <div class="booking-table-day"><?php echo $day1 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 1))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date1book = 1;
                                break;
                            }
                        }
                        if ($date1book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                        
                        
                        <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday2 == "Sat" || $weekday2 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date2book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 2))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 2)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year2; ?></div>
                                    <div class="booking-table-month"><?php echo $month2 ?></div>
                                    <div class="booking-table-day"><?php echo $day2 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 2))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date2book = 1;
                                break;
                            }
                        }
                        if ($date2book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                        
                        
                         <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday3 == "Sat" || $weekday3 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date3book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 3))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 3)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year3; ?></div>
                                    <div class="booking-table-month"><?php echo $month3 ?></div>
                                    <div class="booking-table-day"><?php echo $day3 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 3))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date3book = 1;
                                break;
                            }
                        }
                        if ($date3book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                       
                        <!-- day 4<-->
                         <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday4 == "Sat" || $weekday4 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date4book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 4))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 4)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year4; ?></div>
                                    <div class="booking-table-month"><?php echo $month4 ?></div>
                                    <div class="booking-table-day"><?php echo $day4 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 4))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date4book = 1;
                                break;
                            }
                        }
                        if ($date4book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                    </tr>
                    <!-- end of first row (4 days) starting the second row<-->
                    <tr>
                         <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday5 == "Sat" || $weekday5 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date5book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 5))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 5)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year5; ?></div>
                                    <div class="booking-table-month"><?php echo $month5 ?></div>
                                    <div class="booking-table-day"><?php echo $day5 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 5))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date5book = 1;
                                break;
                            }
                        }
                        if ($date5book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                        <!-- 6th day<-->
                         <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday6 == "Sat" || $weekday6 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date6book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 6))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 6)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year6; ?></div>
                                    <div class="booking-table-month"><?php echo $month6 ?></div>
                                    <div class="booking-table-day"><?php echo $day6 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 6))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date6book = 1;
                                break;
                            }
                        }
                        if ($date6book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                       
                        <!-- day 7<-->
                        
                         <td>
                            <a <?php
                            if ($physician_default_setup[0]->week_end == 'n' && ($weekday7 == "Sat" || $weekday7 == "Sun")) {
                                echo 'style="pointer-events: none; cursor: default;"';
                                //check the week end is a working day if not disable the cliking of the link
                            } $date7book = 0;
                            foreach ($booking_count as $bdate) {

                                if (($bdate->booking_date == date("Y-m-d", time() + (86400 * 7))) && ($physician_default_setup[0]->max_patients - $bdate->count == 0 || $bdate->max_patients - $bdate->count == 0 )) {
                                    echo 'style="pointer-events: none; cursor: default;"';
                                    echo 'href="#"';

                                    //check if date is equal and if there available seats if not disable the link
                                } else {
                                    
                                    $email_encode = rtrim(strtr(base64_encode($physician_default_setup[0]->physician_id), '+/', '-_'), '=');
                                    ?>
                                        href="<?php echo base_url(); ?>index.php/print_voucher/<?php echo $email_encode ?>/<?php echo date("Y-m-d", time() + (86400 * 7)); ?>"<?php
// if yes activate the link and redirect to the desired location of printing booking voucher
                    }
                            }
                           
                    
                                ?>>
                                    <div class="booking-table-year"><?php echo $year7; ?></div>
                                    <div class="booking-table-month"><?php echo $month7 ?></div>
                                    <div class="booking-table-day"><?php echo $day7 ?></div>
                                    <div class="booking-table-seats"><?php
                                      foreach ($booking_count as $bdate) {
                            if ($bdate->booking_date == date("Y-m-d", time() + (86400 * 7))) {
                                if ($bdate->max_patients == NULL) {
                                    echo $physician_default_setup[0]->max_patients - $bdate->count;
                                } else {
                                    echo $bdate->max_patients - $bdate->count;
                                }
                                $date7book = 1;
                                break;
                            }
                        }
                        if ($date7book == 0) {
                            echo $physician_default_setup[0]->max_patients;
                        }
                            ?> seats available</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
           
        } else {
            echo '<h3 class=\'error\'>Please <a href=\'';
            echo base_url();
            echo 'index.php/login\'>Login</a> to </h3><h3 class=\'error\'>Add New Information</h3>';
        }
        ?>

    </div>


    <script type="text/javascript">

        $(document).ready(function() {

            $("#custom_booking_setup_wrapper").hide();
            $("#default_booking_setup").prop("checked", true);

            $("#custom_booking_setup").click(function() {

                $('#default_booking_setup_wrapper').find('*').prop('disabled', true);
                $('#default_booking_setup_wrapper').find(':input').css('background', '#d6cdbe');


                $('#default_booking_setup_wrapper').find(':input').prop('disabled', true);
                $("#custom_booking_setup_wrapper").show();
            });

            $("#default_booking_setup").click(function() {
                $('#default_booking_setup_wrapper').find(':input').prop('disabled', false);
                $("#custom_booking_setup_wrapper").hide();
                $('#default_booking_setup_wrapper').find(':input').css('background', '#ffffcc');
                $('#submit_default').css('background', '#6aa436');
            });

            $('input:checkbox[class=custom_day_chkbx]').click(function() {

                var chkbox = $(this).attr("id");
                if ($(this).is(':checked')) {
                    $("#" + chkbox + "_container").find(':input').prop('disabled', false);
                    $("#" + chkbox + "_container").find(':input').css('background', '#ffffcc');
                    $("#" + chkbox).prop('disabled', false);
                    $("#" + chkbox + "_container").find(':input[type=date]').attr("readonly", "readonly");


                }
                else {
                    $("#" + chkbox + "_container").find(':input').prop('disabled', true);
                    $("#" + chkbox + "_container").find(':input').css('background', '#d6cdbe');
                    $("#" + chkbox).prop('disabled', false);
                    $("#" + chkbox + "_container").find(':input[type=date]').attr("readonly", "readonly");
                }

            });

        });


    </script>
</div>