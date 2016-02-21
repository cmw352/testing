<?php session_start();
$_SESSION['activetab'] = "none";

include "incl/login_require.php";
include "incl/header.php";?>

<script>

function GetRegexes(str)
{
	var words = str.split(" ");
	var regexes = new Array();
	for(var i = 0; i < words.length; i++)
	{
		regexes.push(new RegExp("("+words[i]+")", "gi"));
	}
	return regexes;
}

$(document).ready(function(){
	var enddata = new Array();
	$.ajax({
		url:"ajaxtargets/get_tasks_ajax.php",
		method:"POST",
		dataType:"JSON",
		data:{	operation:"all",
				ctime:getCTime(),
				},
		success:function(data)
		{
			console.log(data[0]);
			enddata = new Array();
			var regexes = GetRegexes("<?php echo $_GET['str'] ?>");
			for(var i = 0; i < data.length; i++)
			{
				var mcount = 0;
				for(var j = 0; j < regexes.length; j++)
				{
					var matches = regexes[j].exec(data[i][1]);
					if(matches != null)
					{
						for(var k = 1; k < matches.length; k++)
						{
							mcount += matches[k].length;
						}
					}
				}
				var score = mcount * (mcount / data[i][1].length);
				
				data[i].push(score);
			}
			data.sort(function(a,b){return b[b.length - 1] - a[a.length - 1];});
			for(var i = 0; i < data.length && data[i][data[i].length - 1] > 0.05; i++)
			{
				enddata.push(data[i]);
			}
			render();
		}
	});


	function render()
	{
		var table = $("#tappend");
		table.html("");
		if(enddata.length > 0)
		{
			for(var i = 0; i < enddata.length; i++)
					
				table.append("<tr class='" + priorityClass(enddata[i][7]) + " taskpage' taskid="+enddata[i][0]+"><td>" + i + "</td>"
								+"<td><strong>" + enddata[i][1] + "</strong></td>"
								+"<td>" + priorityString(enddata[i][7]) + "</td>"
								+"<td>" + timeString(enddata[i][3]) + "</td>"
								+"<td>" + dateString(enddata[i][4]) + "</td>"
								+"</tr>");				
				
			$(".taskpage").click(function(){
				TaskPage($(this).attr("taskid"));
			});
		}
		else
		{
			$("#displayNoData").show();
		}
	}
	
});


</script>
<div class="row page-header" id="show_on_data">

	<div class="col-lg-8 well well-sm" style="text-align:left">
		<h1> Search results: </h1>
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
		
		<div class="jumbotron" style="display:none" id="displayNoData">
			<h1>No results found</h1>
		</div>
	</div>
	
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