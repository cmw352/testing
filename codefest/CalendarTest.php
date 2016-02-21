<?php session_start();
$_SESSION['activetab'] = "none";
include "incl/header.php"; ?>

<style>
#calendar{
	color:black;
}

a.nohighlight
{
	color:black;
}
</style>
<script class="javascript">

var HighlightColors = ["#30C030", "#30C0C0", "#3050C0", "#C03030", "#EE4040"];

var cmonth = new Date().getMonth();
var cyear = new Date().getFullYear();
		
$(function () {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month'
		},
		editable: true
	});
});

function Highlight(day, color)
{
	var elem = $(".fc-day" + day.getDate());
	elem.css("background", color);
}
function GetCell(day)
{
	var elem = $(".fc-day" + day.getDate() + " .fc-day-content>div");
	return elem;
}

function GetCelli(day)
{
	var elem = $(".fc-day" + day + " .fc-day-content>div");
	return elem;
}
function ClearHighlight(dayn)
{
	var elem = $(".fc-day" + dayn);
	elem.css("background", "");
}
var top20 = new Array();
	$.ajax({
		url:"ajaxtargets/get_tasks_ajax.php",
		method:"POST",
		dataType:"JSON",
		data:{	operation:"all",
				ctime:getCTime(),
				},
		success:function(data)
		{
			top20 = data;
			render();
		}
	});

<!--This function is what causes the highlights to appear based on the date and priority assigned to the task displayed-->
	function render()
	{
		for(var i = 0; i < 40; i++)
		{
			ClearHighlight(i);
			GetCelli(i).html("<ul></ul>");
		}
		for(var i = 0; i < top20.length; i++)
		{
			var thisDate = new Date(top20[i][4] * 1000);
			
			if(cmonth == thisDate.getMonth() && cyear == thisDate.getFullYear())
			{
				Highlight(thisDate, HighlightColors[top20[i][7]]);
				GetCell(thisDate).children("ul").append("<li><a class='nohighlight' href='taskPage.php?eid=" +top20[i][0]+"'>"+top20[i][1]+"</a></li>");
				
			}
		}
	}
	
$(document).ready(function(){
	$(".fc-button-next").click(function(){
		cmonth ++;
		if(cmonth == 12)
			cyear++;
		cmonth %= 12;
		render();
	});
	$(".fc-button-prev").click(function(){
		cmonth += 11;
		cmonth %= 12;
		if(cmonth == 11)
			cyear--;
		render();
	});
	$(".fc-button-today").click(function(){
		cmonth = new Date().getMonth();
		cyear = new Date().getYear();
		render();
	});

});
	
		</script>
	
			<h1>Schedule</h1>
			
			<div id='calendar'></div>
<?php include "incl/footer.php" ?>