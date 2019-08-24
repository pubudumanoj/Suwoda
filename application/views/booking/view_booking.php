<?php ?>
<div id="wrapper" style="overflow: auto;">

    <div >

        <div class="CSSTableGenerator">

            <table>
                <tr>
                    <td>
                        Patient's Name
                    </td>
                    <td >
                        Contact No
                    </td>
                    <td>
                        Booking Date
                    </td> 
                    <td>
                        Booking Voucher Data/Time
                    </td> 
                </tr>

                <?php foreach ($result as $row) { ?>
                   <tr>
               
                        <td> <?php echo $row->patient_name; ?></td>
                        <td>
                            <?php
                            echo $row->contact_no;
                            ?></td>
                        <td><?php
                            echo $row->booking_date;
                            ?>
                        </td>
                        <td><?php
                            echo $row->booking_time;
                            ?>
                        </td>
            </tr>
                <?php } ?>

            </table>
        </div>
        
        </div>

    </div>
  </div>