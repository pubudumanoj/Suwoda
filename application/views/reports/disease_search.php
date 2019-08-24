<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="wrapper" style="overflow: auto;">
     <div style="width: 80%;margin-left: auto;margin-right: auto; overflow:hidden;">

  
    
     <div id="barchart_dsearch_by_year_options">
         <span style="font-size: 18px; font-weight: bold">Select Year to view disease search statistics: </span><select id="barchart_dsearch_by_year_options_select_year">
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
      google.load("visualization", "1", {packages:["corechart"]});
     $("#barchart_dsearch_by_year_options_select_year").on('change', function(event) {
         
       google.load("visualization", "1", {packages:["corechart"]});
     
      
   
        var year =$( "#barchart_dsearch_by_year_options_select_year" ).val();
        $.ajax({
                type: "POST",
                
                url: "<?php echo site_url('reports_control/diagnosed_disease_search_by_year'); ?>",
                data: { select_year:year  },
        success: function(data){

        var data = new google.visualization.DataTable(data);


        var options = {
          title: 'Diagnosed diseases for year '+year,
                  colors: ['#ac45ac'],
                  hAxis: {
          title: 'Disease ',
          
        },
        vAxis: {
          title: 'Search hits'
        }
          

        }
  
        var chart = new google.visualization.ColumnChart(document.getElementById("barchart_diagnosed_diseases_by_year"));

        chart.draw(data, options);
      

                          }
            }).done(function(data) {
           
            }).fail(function() {
                alert( "Data Not Send" );
            });
     });
     
     
    </script>
    
   
    <div id="barchart_diagnosed_diseases_by_year" style="width: 900px; height: 500px;"></div>
<!--///////////////////////////////-->


<h3>Click on reports you need</h3>
<?php $attributes = array('id' => 'disease_pdf_report_form');
            echo form_open("reports/disease_search_pdf_control/generate_disease_reports", $attributes);
            ?>

<input type="checkbox" name="disease_by_month">Disease count by month for year <select name ="disease_by_month_year" id="disease_by_month">
            
  <?php 
  $curYear = date("Y");
  
             for($i=2015; $i<$curYear+1;$i++){
                 echo "<option value=$i >$i</option>";
             }
             ?>
         </select>
<input type="checkbox" name="disease_by_year">Count by disease name for year <select name ="disease_cat_by_year" id="disease_by_year">
               
  <?php 
  $curYear = date("Y");
  
             for($i=2015; $i<$curYear+1;$i++){
                 echo "<option value=$i >$i</option>";
             }
             ?>
         </select><br /><br />
<input type="checkbox" name="disease_by_range">Disease count from
<input name="disease_by_range_date1" type="date" id="disease_by_range_date1"> to
<input name="disease_by_range_date2" type="date" id="disease_by_range_date2">
    <input class="submit-button" type="submit" value="Generate pdf Reports" />
 <?php  echo form_close();
 ?>
     </div>
</div>