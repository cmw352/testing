<?php session_start();
$_SESSION['activetab'] = "none";
include "incl/header.php"; ?>

<style>
.caltable > tbody > tr
{
	height:50px;
}
.center{
	text-align:center;
}
td{
	color:black
}
</style>

<script>
$(document).ready(function(){
	var today = new Date();
	var incrDate = new Date(today);
	incrDate.setDate(1);
	var dotm = incrDate.getDay();
	var table = $("#caltable");
	for(var y = 0; y < 5; y++)
	{
		table.append("<tr>")
		
		for(var x = 0; x < 7; x++)
		{
			table.append("<td x=" + x + " y=" + y + "></td>");
		}
		table.append("</tr>");
	}
	var cY = 0;
	while(incrDate.getMonth() == today.getMonth())
	{
		
		var cX = incrDate.getDay();
		
		$("[x='"+cX+"'][y='"+cY+"']").html(incrDate.getDate());
		console.log(incrDate.getDate() + " x:" + cX + " y:" + cY);
		if(incrDate.getDay() == 6)
			cY++;
		incrDate.setDate(incrDate.getDate() + 1);
	}
});
</script>

<div class="row" style="color:white"> abc</div>
<div class="row">
	<div class="col-lg-4">Previous month</div>
	<div class="col-lg-4" style="text-align:center">Febuary</div>
	<div class="col-lg-4" style="text-align:right">Next month</div>
</div>
<div class="row center">
	<table class="caltable" style="width:100%">
		<tbody id="caltable">
			<tr><td>Sunday</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td></tr>
		</tbody>
	</table>
</div>

<?php include "incl/footer.php" ?>