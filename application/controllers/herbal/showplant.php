<?php
class Showplant extends CI_Controller{

    function __construct() {
        parent::__construct();
    }
    function index(){
        $data['title'] = ucfirst('add New Plant | Herbal Plants');
         $this->load->view('templates/header', $data);
        $this->load->view('herbal/showplant', $data);
        $this->load->view('templates/footer', $data);
    }
    
    function show(){
        
        if($_POST)
{
$q=$_POST['searchword'];
$q=str_replace("@","",$q);
$q=str_replace(" ","%",$q);
$sql_res=mysql_query("select * from plant where b_name like '%$q%' or e_name like '%$q%' order by plant_id LIMIT 5");
while($row=mysql_fetch_array($sql_res))
{
$bname=$row['e_name'];


?>
<div class="display_box" >
<img src="assests/images/plants/<?php echo $bname; ?>" class="image" />
<a href="#" class='addname' title='<?php echo $bname; ?>'>
<?php echo $bname; ?></a>
</div>
<?php
}
}
    }
}

?>
