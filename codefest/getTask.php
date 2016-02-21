<?php session_start();
$_SESSION['activetab'] = "gettask";
include "incl/login_require.php";
include "incl/header.php"; ?>
<div class="row page-header">
	<span id="HideOnSelect">
		<h1>Want to get something done?</h1>
		<div class="col-lg-6 col-lg-offset-3 well well-sm">
			<div class="form-group">
				<label class="control-label">How much time do you have?</label>
				<div class="input-group">
					<input class="form-control" type="text" id="timein" placeholder="hh:mm">
					<span class="input-group-btn">
						<button class="btn btn-success" type="button" id="subtime">Submit</button>
					</span>
				</div>
			</div>
		</div>
	</span>
</div>
<div class="row">
	<h2>Suggestions:</h2>
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
<script>
var total = 9999;
var top20;
var allData;
$(document).ready(function(){

	$("#subtime").click(function(){
		var time = $("#timein").val();
		var regex = /([0-9]*)(:([0-9]+))?/gi;
		var matches = regex.exec(time);
		var hours = parseInt(0+matches[1]);
		var mins = 0;
		if(matches[3])
		{
			mins = parseInt(matches[3]);
		}
		mins = Math.floor(mins / 15);
		hours *= 4;
		
		total = hours + mins;
		top20 = new Array();
		
		if($("#timein").val() == "")
		{
			total = 9999;
		}
		
		for (var i in allData){
			if (typeof allData[i] !== 'function') {
				if(parseInt(allData[i][3]) <= total)
				{
					top20.push(allData[i]);
				}
			}
		}
		Render();
	});
	$.ajax({
		url:"ajaxtargets/get_tasks_ajax.php",
		method:"POST",
		dataType:"JSON",
		data:{	operation:"all",
				ctime:getCTime(),
				},
		success:function(data)
		{
			allData = new Array();
			for(var i = 0; i < data.length; i++)
			{
				allData[data[i][0]] = data[i];
			}
			top20 = new Array();
			
			for (var i in allData){
				if (typeof allData[i] !== 'function') {
					allData[i].push(0);
					$.ajax({
						url:"ajaxtargets/getdata.php",
						method:"POST",
						dataType:"JSON",
						data:{	operation:"prereqs",
								eid:allData[i][0],
								row:i
								},
						success:function(data)
						{
							var score = (parseInt(data[0].Priority)+1) * (parseInt(data[0].RequiredTime)) / (daysToCompletion(data[0].Deadline));
							for(var j = 0; j < data.length - 1; j++)
							{
								allData[parseInt(data[j].ID)][8] += score;
							}
						
							top20 = new Array();
							for (var i in allData){
								if (typeof allData[i] !== 'function') {
									if(parseInt(allData[i][3]) <= total)
									{
										top20.push(allData[i]);
									}
								}
							}
							top20.sort(function(a,b){
										return b[b.length - 1] - a[a.length - 1];
									});
							Render();
						}
					});
				}
			}
		}
	});
});


function daysToCompletion(timestamp)
{
	timestamp = parseInt(timestamp);
	var currentTime = new Date().getTime() / 1000;
	var dif = timestamp - currentTime;
	return ((dif / 60 / 24));
}

function Render()
{
	var table = $("#tappend");
	table.html("");
	for (var i in top20){
		if (typeof top20[i] !== 'function') {
			table.append("<tr class='" + priorityClass(top20[i][7]) + " taskpage' taskid="+top20[i][0]+"><td>" + (parseInt(i)+1) + "</td>"
							+"<td><strong>" + top20[i][1] + "</strong></td>"
							+"<td>" + priorityString(top20[i][7]) + "</td>"
							+"<td>" + timeString(top20[i][3]) + "</td>"
							+"<td>" + dateString(top20[i][4]) + "</td>"
							+"</tr>");
		}
	}
	$(".taskpage").click(function(){
		TaskPage($(this).attr("taskid"));
	});
}

</script>
<?php include "incl/footer.php" ?>