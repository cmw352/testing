<?php session_start();
$_SESSION['activetab'] = "none";
include "phpscript/sqlconnect.php";
include "incl/login_require.php"; 
if(!isset($_GET['eid']) && isValidOwner($_SESSION['loginID'], $_GET['eid']))
{
	header( 'Location: index.php' );
}
else
{
$eid =$_GET['eid'];
$row = getTaskInfo($eid)->fetch_assoc();
}
	

include "incl/header.php";?>
<script>
var DataArray = <?php echo json_encode($row); ?>;
var mins;
var hrs;
var days;

var pre = <?php echo json_encode(FindAllPrequisites($eid))?>;

$(document).ready(function(){
	
	if(pre.length > 1)
	{
		for(var i = 0; i < pre.length; i++)
		{
			$(".breadcrumb").append("<li><a href='taskPage.php?eid=" + pre[i].ID + "'>" + pre[i].Name + "</a></li>");
		}
	}
	setInterval(updateTime, 1000);
	$(".pstring").html(priorityString(parseInt(DataArray.Priority)));
	$(".tstring").html(timeString(DataArray.RequiredTime));
	$("#duedate").html(dateString(DataArray.Deadline));
	
	
	$("#changeDueButton").click(function(event){
	
		$("#changeDue").slideToggle(500);
	});
	$("#changePriorityButton").click(function(event){
	
		$("#changePriority").slideToggle(500);
	});
	$("#changeReqButton").click(function(event){
	
		$("#changeReq").slideToggle(500);
	});
	
	$("#inputDueDate_Submit").click(function(event){
		event.preventDefault();
		var targetDate = new Date($("#inputDueDate").val());
		if(!isNaN(targetDate.getTime()) && targetDate.getTime() - new Date().getTime() > 0)
		{
			$.ajax({
						url:"ajaxtargets/edit_events_ajax.php",
						method:"POST",
						dataType:"text",
						data:{	field:"deadline",
								value:targetDate.getTime() / 1000,
								eid:<?php echo $eid ?>},
						success:function(data)
						{
							console.log(data);
							window.location.href = window.location.href;
						}
			});
		}
	});
	
	
	$("#inputPriority_Submit").click(function(event){
		event.preventDefault();
		var priority = $("#inputPriority").val();
		$.ajax({
					url:"ajaxtargets/edit_events_ajax.php",
					method:"POST",
					dataType:"text",
					data:{	field:"priority",
							value:priority,
							eid:<?php echo $eid ?>},
					success:function(data)
					{
						console.log(data);
						window.location.href = window.location.href;
					}
		});
		
	});
	
	
	$("#inputReq_Submit").click(function(event){
		event.preventDefault();
		var amt = $("#inputReq").val();
		var hrs = parseInt(amt.substring(0, amt.indexOf(":")));
		var mins = parseInt(amt.substring(amt.indexOf(":")+1));
		mins = Math.floor(mins / 15);
		hrs = Math.floor(hrs) * 4;
		console.log("Mins: " + mins + " Hrs: " + hrs);
		$.ajax({
					url:"ajaxtargets/edit_events_ajax.php",
					method:"POST",
					dataType:"text",
					data:{	field:"timeleft",
							value:hrs + mins,
							eid:<?php echo $eid ?>},
					success:function(data)
					{
						console.log(data);
						window.location.href = window.location.href;
					}
		});
		
	});
	
	$("#finisher").click(function(){
		$(".coverall").fadeIn(500);
	});
	
	$(".coverall").click(function(){
		$(".coverall").fadeOut(500);
	});
	
	$("#Yeahbutton").click(function(){
		$.ajax({
					url:"ajaxtargets/edit_events_ajax.php",
					method:"POST",
					dataType:"text",
					data:{	field:"kill",
							value:"1",
							eid:<?php echo $eid ?>},
					success:function(data)
					{
						window.location.href = "index.php";
					}
		});
	
	});
});

function updateTime()
{
	var timeToComplete = DataArray.Deadline - new Date().getTime()/1000;
	mins = timeToComplete / 60;
	hrs = mins /60;
	days = hrs / 24;
	
	$(".days").html(Math.floor(days));
	$(".hours").html(Math.floor(hrs % 24));
	$(".minutes").html(Math.floor(mins % 60));
}

</script>
<div class="jumbotron page-header">
	<h1><?php echo $row['Name']; ?></h1>
	<p><?php echo $row['Description']; ?></p>
	<ul class="breadcrumb">
	</ul>
</div>

<!--The following code allows the user to change the previous information entered into their tasks, aside from name and description-->
<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Due <span id="duedate"></span></h3>
			</div>
			<div class="panel-body">
				<p>You have <span class="days"></span> Days, <span class="hours"-5></span> Hours, and <span class="minutes"></span> Minutes</p>
				<a type="btn btn-default btn-lg btn-block" id="changeDueButton">Change Due Date</a>
			</div>
			<div class="panel-body" style="display:none" id="changeDue">
				<input type="text" id="inputDueDate" placeholder="mm/dd/yyyy hh:mm"></input>
				<a class="btn btn-primary" id="inputDueDate_Submit">Submit</a>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Priority</h3>
			</div>
			<div class="panel-body">
				<p>This task has been given <span class="pstring"></span> priority.</p>
				<a type="btn btn-default btn-lg btn-block" id="changePriorityButton">Change Priority</a>
			</div>
			
			<div class="panel-body" style="display:none" id="changePriority">
				<select id="inputPriority">
					<option value=0>Low</option>
					<option value=1>Moderately Low</option>
					<option value=2>Moderate</option>
					<option value=3>Moderately High</option>
					<option value=4>High</option>
				</select>
				<a class="btn btn-primary" id="inputPriority_Submit">Submit</a>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Work Remaining</h3>
			</div>
			<div class="panel-body">
				<p>You predicted it would take <span class="tstring"></span>:00 to finish this task.</p>
				<a type="btn btn-default btn-lg btn-block" id="changeReqButton">Change Time Remaining</a>
			</div>
			
			<div class="panel-body" style="display:none" id="changeReq">
				<input type="text" id="inputReq" placeholder="hh:mm"></input>
				<a class="btn btn-primary" id="inputReq_Submit">Submit</a>
			</div>
		</div>
	</div>
</div>

<!--The following code all works to remove a task from your list, saying that this task has been completed.
This CANNOT be undone, as it deletes the information relating to the task.-->

<div class="panel panel-success" id="finisher">
  <div class="panel-heading">
    <h3 class="panel-title">Finish Task</h3>
  </div>
  <div class="panel-body">
    Click to finish this task, removing it from the to-do list.
  </div>
</div>

<div class="coverall" style="background-color:black;opacity:.7;position:fixed;top:0;left:0;right:0;bottom:0;z-index:999;display:none">
	
</div>
<div class="coverall" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:999;display:none">
	<div class="container col-lg-8 col-lg-offset-2" style="margin-top:10%">
			<div class="panel panel-basic">
		  <div class="panel-heading">
			<h3 class="panel-title">Are you sure?</h3>
		  </div>
		  <div class="panel-body">
			Clicking "Yes" will remove this task from your list. This <span class="text-danger">CANNOT</span> be undone.
			<div class="row">
				<div class="col-lg-4 col-lg-offset-2">
					<a class="btn btn-primary" id="Nevemindbutton">Cancel</a>
				</div>
				<div class="col-lg-4">
					<a class="btn btn-success" id="Yeahbutton">Yes, I'm sure</a>
				</div>
			</div>
		  </div>
		</div>

	</div>
</div>
<?php include "incl/footer.php" ?>