<?php session_start();
$_SESSION['activetab'] = "maketask";
include "incl/login_require.php";
include "incl/header.php"; ?>

<script>

//The following functions define the alert messages that appear when the user fails to properly input their information on the form.
//The fail(message) function makes the alert appear, the following function determines what message appears in the box based on the user's errors.

function fail(message)
{
	$("#failedAlert").slideDown(500);
	$("#appendTextHere").html(message);
}
$(function(){
	
	$("#subbutton").click(function(event){
	
		$("#failedAlert").slideUp(500);
		event.preventDefault();
		var name = $("#inputTaskName").val();
		var descr = $("#description").val();
		var priority = $("#inputTaskPriority").val();
		var timereq = $("#inputTime").val();
		timereq = parseInt(timereq) * 4;
		timereq += parseInt($("[name=minradio]:checked").attr("value"));
		var due = new Date($("#inputDueDate").val());
		
		if(name == "")
		{
			fail("Name must not be empty");
		}
		else if(timereq == 0)
		{
			fail("Time can't be 0");
		}
		else if($("#inputDueDate").val() == "")
		{
			fail("Task must have a due date");
		}
		else if(due.getTime() <= new Date().getTime())
		{
			fail("Due date can't be before now");
		}
		else
		{
			console.log(parseInt(due.getTime()));
			console.log("-");
			console.log(parseInt(due.getTime())/1000);
			$.ajax({
				url:"ajaxtargets/push_events_ajax.php",
				method:"POST",
				dataType:"text",
				data:{	name:name,
						description:descr,
						time:timereq,
						priority:priority,
						due:parseInt(due.getTime()) / 1000,
						req:($("#inputRequisite").prop("disabled") ? $("#inputRequisite").val() : -1),
						},
				success:function(data){
					$("#postcreator").show();
					$("#addform").hide();
					loadall();
				}
			});
		}
	});
	
	$("#closealert").click(function(event){
		event.preventDefault();
		$("#failedAlert").slideUp(500);
	});
	$("#makemore").click(function(event){
		$("#postcreator").hide();
		$("#addform").show();
	});
	$("#nomore").click(function(event){
		window.location.href = "index.php";
	});
});
</script>

<div class="row" style="text-align:left">
	<div class="col-lg-6">
		<div class="page-header">
			<h1>Add New Task</h1>
		</div>
		
<!--This is the main form where the user inputs the information for their task's name, description, priority,
deadline, required time, and whether or not it has a prerequisite.-->
<form class="form-horizontal well well-sm" id="addform">
  <fieldset>
    <div class="form-group">
      <label for="inputTaskName" class="col-lg-2 control-label">Name</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputTaskName" placeholder="Name" type="text" required>
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-lg-2 control-label">Description</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="description"></textarea>
        <span class="help-block">Description of this task (optional)</span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputTaskPriority" class="col-lg-2 control-label">Priority</label>
      <div class="col-lg-10">
		<select class="form-control" type="select" id="inputTaskPriority" required>
			<option value=0>Low</option>
			<option value=1>Moderately Low</option>
			<option value=2>Moderate</option>
			<option value=3>Moderately High</option>
			<option value=4>High</option>
		</select>
      </div>
    </div>
	<div class="form-group">
      <label for="inputDueDate" class="col-lg-2 control-label">Deadline</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputDueDate" type="text" placeholder="mm/dd/yyyy hh:mm" required>
      </div>
    </div>
	<div class="form-group">
      <label for="inputTime" class="col-lg-2 control-label">Time Required</label>
      <div class="col-lg-10">
		<input class="form-control" id="inputTime" placeholder="Hours" type="number" min=0 value=0 required>
		<div class="col-lg-3">
			:00 <input value=0 name="minradio" type="radio" checked />
		</div>
		<div class="col-lg-3">
			:15 <input value=1 name="minradio" type="radio" />
		</div>
		<div class="col-lg-3">
			:30 <input value=2 name="minradio" type="radio" />
		</div>
		<div class="col-lg-3">
			:45 <input value=3 name="minradio" type="radio" />
		</div>
      </div>
    </div>
	<div class="form-group">
      <label for="inputRequisite" class="col-lg-2 control-label">Has Prerequisite</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputRequisite" type="text" placeholder="Other task (optional)">
      </div>
    </div>
	
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-primary" id="subbutton">Submit</button>
      </div>
    </div>
	<div class="alert alert-dismissible alert-danger" style="display:none" id="failedAlert">
						<button type="button" class="close" id="closealert"><tt>x</tt></button>
						<strong>Oops! </strong><span id="appendTextHere"></span>
					</div>
  </fieldset>
</form>

<!--The following form appears when the user has finished submitting their task; they are given
the option to create another task (returning to the same page) or to stop (returning them to the index)-->

	<div class="jumbotron" id="postcreator" style="display:none">
		<h1>Task Created</h1>
		<button class="btn btn-lg btn-success" id="makemore">Create Another</button>
		<button class="btn btn-lg btn-danger" id="nomore">That's all for now</button>
	</div>
	</div>
	
<!--The following forms are used to determine which tasks are to be used as a prerequisite. The search bar given
in the above form for the prerequisite narrows the given lists of tasks, allowing the user to more conveniently
find the task they're searching for. -->

	<div class="col-lg-6">
		<h2>Other Tasks:</h2>
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Priority</th>
					<th>Due Date</th>
					<th>Make Prerequisite</th>
				</tr>
			</thead>
			<tbody id="tappend">
  
			</tbody>
		</table> 
		
	</div>
</div>
<script>
var enddata = new Array();
var alldata;

function loadall(){
enddata = new Array();
alldata;
$.ajax({
	url:"ajaxtargets/get_tasks_ajax.php",
	method:"POST",
	dataType:"JSON",
	data:{	operation:"all",
			ctime:getCTime(),
			},
	success:function(data)
	{
		alldata = data;
		enddata = new Array();
		Search("a b c d e f g h i j k l m n o p q r s t u v w x y z");
	}
});
}
loadall();

function Search(searchString)
{
	enddata = new Array();
	var regexes = GetRegexes(searchString);
	for(var i = 0; i < alldata.length; i++)
	{
		var mcount = 0;
		for(var j = 0; j < regexes.length; j++)
		{
			var matches = regexes[j].exec(alldata[i][1]);
			if(matches != null)
			{
				for(var k = 1; k < matches.length; k++)
				{
					mcount += matches[k].length;
				}
			}
		}
		var score = mcount * (mcount / alldata[i][1].length);
		
		enddata.push(alldata[i]);
		enddata[i].push(score);
	}
	enddata.sort(function(a,b){return b[b.length - 1] - a[a.length - 1];});
	for(var i = enddata.length - 1; i >= 0; i--)
	{
		if(enddata[i][enddata[i].length-1] <= .05)
		{
			enddata.splice(i, 1);
		}
	}
	render();
}

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
var store;
function render()
{
	var table = $("#tappend");
	table.html("");
	if(enddata.length > 0)
	{
		for(var i = 0; i < enddata.length; i++)
			table.append("<tr class='" + priorityClass(enddata[i][7]) + "'><td>" + i + "</td>"
							+"<td><strong>" + enddata[i][1] + "</strong></td>"
							+"<td>" + priorityString(enddata[i][7]) + "</td>"
							+"<td>" + dateString(enddata[i][4]) + "</td>"
							+"<td><button data_id='"+enddata[i][0]+"' class='btn btn-default prereqbtn'>Make Prereq</button></td>"
							+"</tr>");		
		$(".prereqbtn").click(MakeReq);
	}
}

//The following function changes the chosen task to a prerequisite once the button is pressed.
//It also makes sure to change the displayed button to an option to change it back.

function MakeReq()
{
	store = $("#inputRequisite").val();
	$("#inputRequisite").val($(this).attr("data_id"));
	$("#inputRequisite").prop("disabled", true);
	$(this).addClass("unreqButton");
	$(this).removeClass("prereqbtn");
	$(this).removeClass("btn-default");
	$(this).addClass("btn-danger");
	$(this).html("Remove prereq");
	$(".prereqbtn").hide();
	$(this).unbind("click");
	$(this).click(function(){
		$("#inputRequisite").val(store);
		$("#inputRequisite").prop("disabled", false);
		$(this).removeClass("unreqButton");
		$(this).addClass("prereqbtn");
		$(this).addClass("btn-default");
		$(this).removeClass("btn-danger");
		$(this).html("Make Prereq");
		$(".prereqbtn").show();
		$(this).unbind("click");
		$(".prereqbtn").click(MakeReq);
	});
}

$(document).ready(function(){
	$("#inputRequisite").keyup(function(){
		Search($("#inputRequisite").val());
		if($("#inputRequisite").val() == "")
			Search("a b c d e f g h i j k l m n o p q r s t u v w x y z");
	});
});

</script>


<?php include "incl/footer.php" ?>