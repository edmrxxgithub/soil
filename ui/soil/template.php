<?php
// error_reporting(0);

include_once 'connectdb.php';
include_once 'function.php';
session_start();


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}


include_once "header.php";



?>


	
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


  <!-- Main content -->
<div class="content">
    <div class="container-fluid">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-sm-6">
    				<input type="text" id="sampleid" class="form-control" value="God is good, life is good!">
    				<input type="text" id="sampleid" class="form-control" value="God above all things">
    				<button  class="btn btn-md btn-primary mt-3" id="confirmbutton">Confirm</button>
    			</div>
    		</div>
    	</div>
    </div>
</div>
	<!-- Main content -->


</div>



<?php

include_once "footer.php";



?>





<script>
  
$(document).ready(function()
{



		$(document).on('click','#confirmbutton',function()
		{

			var sampleid = $('#sampleid').eq(1).val();

			alert(sampleid);

		})


		// $(document).on('click','#confirmbutton',function()
		// {

		// 	var sampleid = $('#sampleid').val();

		// 	alert(sampleid);

		// })


})



</script>













