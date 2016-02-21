<?php session_start();
$_SESSION['activetab'] = "home";

include "incl/login_require.php";
include "incl/header.php";?>

<script>

$(document).ready(function(){
	var top20 = new Array();
	$.ajax({
		url:"ajaxtargets/get_tasks_ajax.php",
		method:"POST",
		dataType:"JSON",
		data:{	operation:"upcoming",
				ctime:getCTime(),
				count:20
				},
		success:function(data)
		{
			top20 = data;
			render();
		}
	});

//Displays a table of up to 20 registered tasks that the user has created, color coding them according to their level of priority assigned by the user
//Clicking on the name of one of the displayed tasks takes the user to taskPage, allowing them to edit the parameters that they entered earlier

	function render()
	{
		var table = $("#tappend");
		if(top20.length > 0)
		{
			$("#no_events").hide();
			$("#show_on_data").show();
			console.log(top20[0]);
		}
		table.html("");
		for(var i = 0; i < top20.length; i++)
				
			table.append("<tr class='" + priorityClass(top20[i][7]) + " taskpage' taskid="+top20[i][0]+"><td>" + (i+1) + "</td>"
							+"<td><strong>" + top20[i][1] + "</strong></td>"
							+"<td>" + priorityString(top20[i][7]) + "</td>"
							+"<td>" + timeString(top20[i][3]) + "</td>"
							+"<td>" + dateString(top20[i][4]) + "</td>"
							+"</tr>");				
			
		$(".taskpage").click(function(){
			TaskPage($(this).attr("taskid"));
		});
	}
	
});


</script>
<!--The following is displayed when the user in question has no tasks (whether they never created them or finished all of theirs).
As such, it gives an option to move to the addTask page.-->

<div class="jumbotron page-header" id="no_events">
  <h1>Welcome</h1>
  <p>Any tasks that you haven't done yet will show up here! It appears you that don't have any yet. Create some!</p>
  <p><a class="btn btn-primary btn-lg" href="addTask.php">Add Tasks</a></p>
</div>

<div class="row page-header" id="show_on_data" style="display:none;">

	<div class="col-lg-8 well well-sm" style="text-align:left">
		<h1> Upcoming Tasks </h1>
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Priority</th>
					<th>Required Time</th>
					<th>Due Date</th>
				</tr>
			</thead>
			<tbody id="tappend">
  
			</tbody>
		</table> 
	</div>
	
<!--The following are tables that appear on the version of the page where the user has created tasks.
They are meant to make navigation easier.-->

	<div class="col-lg-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Add new tasks</h3>
			</div>
			<div class="panel-body">
				<a href="addTask.php">Click Here</a> to add new tasks
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Work on tasks</h3>
			</div>
			<div class="panel-body">
				<a href="getTask.php">Click Here</a> to get a task to work on
			</div>
		</div>
	</div>
	
</div>

<?php include "incl/footer.php" ?>