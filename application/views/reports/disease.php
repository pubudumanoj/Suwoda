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

        var data = new google.visualization.DataTable(<?php echo json_encode($result_disease_type); ?>);

        var options = {
          title: 'Number of inserted diseases for each type'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_disease_type'));

        chart.draw(data, options);
      }
    </script>
    <div id="piechart_disease_type" style="width: 900px; height: 500px;"></div>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = new google.visualization.DataTable(<?php echo json_encode($result_disease_status); ?>);

        var options = {
          title: 'Inserted Disease Status(Reviewd or Not)',
          colors: ['#03c03c', '#ffd526']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_disease_status'));

        chart.draw(data, options);
      }
    </script>
    <div id="piechart_disease_status" style="width: 900px; height: 500px;"></div>
    
    <script type="text/javascript">
     
         
       google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable(<?php echo json_encode($result_disease_amount_by_year); ?>);
     

        var options = {
          title: 'Submitted Diseases per Year ',
                  colors: ['#fbe99d'],
                  hAxis: {
          title: 'Year',
          
        },
        vAxis: {
          title: 'Number of diseases'
        }
          

        }
   
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_disease_by_year"));
     

        chart.draw(data, options);
    }
     
     
    </script>
    
   
    <div id="barchart_disease_by_year" style="width: 900px; height: 500px;"></div>

     <div id="piechart_disease_by_month_options">
         <span style="font-size: 18px; font-weight: bold">Select Year to view disease count by month: </span><select id="piechart_disease_by_month_options_select_year">
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
     $("#piechart_disease_by_month_options_select_year").on('change', function(event) {
         
       google.load("visualization", "1", {packages:["corechart"]});
     
      
   
        var year =$( "#piechart_disease_by_month_options_select_year" ).val();
        $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('reports_control/disease_report_by_month'); ?>",
                data: { select_year:year  },
        success: function(data){

        var data = new google.visualization.DataTable(data);
     

        var options = {
          title: 'Submitted Diseases per Month for year '+year,
                  colors: ['#fc89ac'],
                  hAxis: {
          title: 'Month',
          
        },
        vAxis: {
          title: 'Number of diseases'
        }
          

        }
    //   var chart = new google.charts.Bar(document.getElementById('piechart_disease_by_month'));
        var chart = new google.visualization.ColumnChart(document.getElementById("piechart_disease_by_month"));
      // var chart = new google.visualization.PieChart(document.getElementById('piechart_disease_by_month'));

        chart.draw(data, options);
      

                          }
            }).done(function(data) {
           
            }).fail(function() {
                alert( "Data Not Send" );
            });
     });
     
     
    </script>
    
   
    <div id="piechart_disease_by_month" style="width: 900px; height: 500px;"></div>

     </div>
</div>