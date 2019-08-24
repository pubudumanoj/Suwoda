<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="wrapper" style="overflow: auto;">
     <div style="width: 80%;margin-left: auto;margin-right: auto; overflow:hidden;">

    <script type="text/javascript">
     
         
       google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable(<?php echo json_encode($user_registration_by_year); ?>);
     

        var options = {
          title: 'Registered users per Year ',
                  colors: ['#fbe99d'],
                  hAxis: {
          title: 'Year',
          
        },
        vAxis: {
          title: 'Number of Users'
        }
          

        }
   
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_registered_user_by_year"));
     

        chart.draw(data, options);
    }
     
     
    </script>
    
   
    <div id="barchart_registered_user_by_year" style="width: 900px; height: 500px;"></div>
    <script type="text/javascript">
     
         
       google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable(<?php echo json_encode($physician_registration_by_year); ?>);
     

        var options = {
          title: 'Registered physicians per Year ',
                  colors: ['#d8f6d5'],
                  hAxis: {
          title: 'Year',
          
        },
        vAxis: {
          title: 'Number of Physicians'
        }
          

        }
   
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_registered_physicians_by_year"));
     

        chart.draw(data, options);
    }
     
     
    </script>
    
   
    <div id="barchart_registered_physicians_by_year" style="width: 900px; height: 500px;"></div>
  
     <div id="barchat_user_registration_by_month_options">
         <span style="font-size: 18px; font-weight: bold">Select Year to view registered user amount by month: </span><select id="barchart_user_registrationt_by_month_options_select_year">
             <option value="">Select an Year</option>           
  <?php 
  $curYear = date("Y");
  
             for($i=2015; $i<$curYear+1;$i++){
                 echo "<option value=$i >$i</option>";
             }
             ?>
         </select>
     </div>
<script type="text/javascript">
     $("#barchart_user_registrationt_by_month_options_select_year").on('change', function(event) {
         
       google.load("visualization", "1", {packages:["corechart"]});
     
      
   
        var year =$( "#barchart_user_registrationt_by_month_options_select_year" ).val();
        $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('reports_control/user_registration_by_month'); ?>",
                data: { select_year:year  },
        success: function(data){

        var data = new google.visualization.DataTable(data);
     

        var options = {
          title: 'Registered users per Month for year '+year,
                  colors: ['#fc89ac'],
                  hAxis: {
          title: 'Month',
          
        },
        vAxis: {
          title: 'Number of users'
        }
          

        }
    //   var chart = new google.charts.Bar(document.getElementById('piechart_disease_by_month'));
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_user_registration_by_month"));
      // var chart = new google.visualization.PieChart(document.getElementById('piechart_disease_by_month'));

        chart.draw(data, options);
      

                          }
            }).done(function(data) {
           
            }).fail(function() {
                alert( "Data Not Send" );
            });
     });
     
     
    </script>
    
   
    <div id="barchart_user_registration_by_month" style="width: 900px; height: 500px;"></div>
  
     <div id="barchat_physician_registration_by_month_options">
         <span style="font-size: 18px; font-weight: bold">Select Year to view registered physicians amount by month: </span><select id="barchart_physician_registrationt_by_month_options_select_year">
             <option value="">Select an Year</option>           
  <?php 
  $curYear = date("Y");
  
             for($i=2015; $i<$curYear+1;$i++){
                 echo "<option value=$i >$i</option>";
             }
             ?>
         </select>
     </div>
<script type="text/javascript">
     $("#barchart_physician_registrationt_by_month_options_select_year").on('change', function(event) {
         
       google.load("visualization", "1", {packages:["corechart"]});
     
      
   
        var year =$( "#barchart_physician_registrationt_by_month_options_select_year" ).val();
        $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('reports_control/physician_registration_by_month'); ?>",
                data: { select_year:year  },
        success: function(data){

        var data = new google.visualization.DataTable(data);
     

        var options = {
          title: 'Registered physicians per Month for year '+year,
                  colors: ['#234523'],
                  hAxis: {
          title: 'Month',
          
        },
        vAxis: {
          title: 'Number of physicians'
        }
          

        }
    
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_physician_registration_by_month"));
  

        chart.draw(data, options);
      

                          }
            }).done(function(data) {
           
            }).fail(function() {
                alert( "Data Not Send" );
            });
     });
     
     
    </script>
    
   
    <div id="barchart_physician_registration_by_month" style="width: 900px; height: 500px;"></div>

     </div>
</div>