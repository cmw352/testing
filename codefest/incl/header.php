<!DOCTYPE html>
<html>
	<head>
		<title>CAL 9000</title>
		<meta charset="utf-8"></meta>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap-override.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<!--Calendar CSS-->
		<link href="//arshaw.com/js/fullcalendar-1.5.3/fullcalendar/fullcalendar.css" rel="stylesheet" />
		<link href="http://arshaw.com/js/fullcalendar-1.5.3/fullcalendar/fullcalendar.print.css" rel="stylesheet" />
		
		<!--Calendar Scripts-->
		<script class="cssdesk" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js" type="text/javascript"></script>
		<script class="cssdesk" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.0/js/bootstrap.min.js" type="text/javascript"></script>
		<script class="cssdesk" src="//arshaw.com/js/fullcalendar-1.5.3/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	</head>
	<body>
<script>	// LOGOUT SCRIPT
function getCTime()
{
	return new Date().getTime() / 1000;
}
$(document).ready(function(){
	$("#logoutButton").click(function(event){
		console.log("click");
		event.preventDefault();
		$.ajax({
			url:"ajaxtargets/logout_ajax.php",
			method:"POST",
			data:"",
			dataType:"text",
			success:function(data)
			{
				window.location.href = "login.php";
			},
			fail:function()
			{
				console.log("):");
			}
		});
	});
});

function TaskPage(id)
{
	window.location.href = "taskPage.php?eid="+id;
}

function fixed_2(i)
{
	i = "" + i;
	while(i.length < 2)
		i = "0" + i;
	return i;
}
<!--Used to get the priority of the task in question; useful for determining priority and the color to assign to that task-->
function priorityString(i)
{
	switch(parseInt(i))
	{
		case 0:
			return "Low";
		case 1:
			return "Moderately Low";
		case 2:
			return "Moderate";
		case 3:
			return "Moderately High";
		case 4:
			return "High";
	}
}
	
function dateString(i)
{
	var date = new Date(i * 1000);
	return (date.getMonth() + 1)+"/"+(date.getDate())+"/" + (date.getFullYear()) + " " + (date.getHours()) + ":" + fixed_2(date.getMinutes()) + ":" + fixed_2(date.getSeconds());
}

function timeString(i)
{
	var hours = Math.floor(i / 4);
	var minutes = 15 * (i % 4);
	return fixed_2(hours) + ":" + fixed_2(minutes);
}
<!--Used to call several diferent colors available in bootstrap; used for color coding on many of the charts-->
function priorityClass(i)
{
	i=parseInt(i);
	switch(i)
	{
		case 0:
			return "active";
		case 1:
			return "info";
		case 2:
			return "success";
		case 3:
			return "warning";
		case 4:
			return "danger";
	}
}

</script>
<!--Makes the icon less buggy on mobile and when the screen is made smaller-->
<style>
@media screen and (min-width: 1400px){
	.bgimg{
		background:url('images/CalLogo.jpg');
		background-size:100% 100%;
		background-repeat:no-repeat;
		background-position:5% 0;
	}
	}
</style>
<!--Creation of the NavBar at the top of every screen; used to navigate from screen to screen easily-->
<nav class="navbar navbar-default navbar-fixed-top" >
  <div class="container">
  <p align="left">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<!--<img src="images/CalLogo.jpg" style = "height:100%" />-->
      <a class="navbar-brand bgimg" href="index.php" style="width:80px"></a>
      <!--<a class="navbar-brand" href="index.php">Home</a>-->
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li <?php if($_SESSION['activetab'] == "home"){echo  'class="active"';}?> ><a href="index.php">Home</a></li>
        <li <?php if($_SESSION['activetab'] == "gettask"){echo  'class="active"';}?> ><a href="getTask.php">I'm Bored<span class="sr-only">(current)</span></a></li>
        <li <?php if($_SESSION['activetab'] == "maketask"){echo  'class="active"';}?>><a href="addTask.php">Create Task</a></li>
		<li <?php if($_SESSION['activetab'] == "calendar"){echo  'class="active"';}?>  ><a href="CalendarTest.php">Calendar</a></li>
		<li><a href="about.php">About Us</a><li>
      </ul>
      <form class="navbar-form navbar-left" role="search" action="search.php" method="GET">
        <div class="form-group">
          <input class="form-control" placeholder="Search Tasks" type="text" name="str">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li id="logoutButton"><a href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container" style="margin-top:60px">
<!--
	<div class="page-header">
	<span style="color:white">
		spacer
	</span>
	</div>-->