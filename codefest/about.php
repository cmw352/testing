<?php session_start();
$_SESSION['activetab'] = "none";
include "incl/header_nonav.php";?>

<!--This page is essentially describing our team and why we decided to do
this project (great work guys!). This is essentially the only page that a
user can access if they are not logged in.-->

<style>
p {
	padding-bottom: 50px;
	line-height: 2;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-style: normal;
	font-variant: normal;
	font-weight: 400;
	margin-top: 35px;

}
body{
	text-align:center;
}
</style>
<div class="container">
<div class="col-lg-8 col-lg-offset-2">
<img src="images/CalLogo.jpg" width = "150" height ="95"; align ="left"; />
<p align="right"><a href="http://nathanhyer.com/codefest/login.php" class="btn btn-primary btn-sm">Login/Register</a></p>

<h1>About Us</h1>
	<h3> The Idea </h3>
		<font size = 3>
			<p>
				It all started with one student, one very unorganized, forgetful student. Team member
				Jonathan Law was always forgetting responsibilities and schoolwork. He decided that he needed
				a system to help him stay on track, so he started making lists. To-do lists, homework lists, lists
				of other lists, too many lists. He needed something that would both create a list <i>and</i> rank them in
				order of importance. He brought this problem to his friends, Christian Webb and Nathan Hyer, and 
				at Philly CodeFest 2016, a 36-hour long hackathon, they got to work.
			</p>
	<h3>Features</h3>
		<font size = 3>
			<p>
				Unlike his brother, HAL, <i>CAL 9000</i> is not homicidal, nor does he have access to the pod bay doors. <i>CAL 9000</i> gives you a helping hand when it comes to your daily grind.
				By creating tasks and assigning attributes to them, such as due date, estimated time to complete the task, and its priority level, 
				<i>CAL 9000</i> creates a priority score and ranks your tasks
				in the order in which they should be done. For example, if you have a paper due in the morning, and you know that it will take you about two hours
				to do, that paper will be given a high priority, whereas a smaller assignment that only takes 30 minutes and isn't due for a few days is given a 
				much lower priority. Using the <i>CAL 9000</i> system, you can be the efficient and effective task-completing machine you've always wanted
				to be!
			</p><p>
				It's really easy to start, too! All you have to do is click the link below to make your account and meet <i>CAL 9000</i>. 
				<br /><b>Welcome to a whole new world of efficiency and productivity!</b>
			<p>
				<a href="http://nathanhyer.com/codefest/login.php" class="btn btn-primary btn-lg">Login/Register</a
			</p>
	<h3>Team Members<h3>
		<div class="row">
		<h4>Nathan Hyer</h4>
				<p align="left">
					<img src="images/nathan_hyer.jpg" width="139" height="150" style="margin: 0 10px 10px 0;float:left;" />
					<font size=2;><b>Nathan Hyer</b> is a first year Computer Science student at Drexel University. He is looking to do a concentration
					in Computer Security later in his college career. Nate enjoys video games, coding his own projects, composing music, and writing slam poetry. </font>
				</p>
				</div>
				<div class="row">
		<h4>Christian Webb</h4>
				<p align="left">
					<img src="images/christian_webb.jpg" width="139" height="150" style = "margin: 0 10px 10px 0; float:left;" />
					<font size=2;><b>Christian Webb</b> is a first year Computer Science student at Drexel University. He has entered into Drexel's video game concentration.
					Christian enjoys playing and creating video games, hanging out with friends, and watching Disney movies.</font>
				</p>
				</div><div class="row" font size =2;>
		<h4>Jonathan Law</h4>
				<p align="left">
					<img src="images/My Face.jpg" width="139" height="150" style = "margin: 0 10px 10px 0; float:left;" />
					<font size=2;><b>Jonathan Law</b> is a first year Computer Science student at Drexel University. He is looking to concentrate on machine learning
					and artificial intelligence later in his college career. Jon likes learning about CS, playing tabletop RPGs, and doing calligraphy.</font>
				</p></div>
	<h3>Credits</h3>
		<font size = 3>
			<p>
				We used several open-source projects we found on the web to build <i>CAL 9000</i> including:
				<ul>
					<li>For our calendar, we borrowed and implemented code from <a href ="http://codepen.io/centerlinescores/pen/EpFzd">http://codepen.io/centerlinescores/pen/EpFzd</a> </li>
					<li>For our graphic design, we used resources from <a href ="https://bootswatch.com/">Bootswatch</a>, in particular the '<a href ="https://bootswatch.com/journal/">Journal</a>' theme. </li>
					<li>We used <a href ="https://jquery.com/">jQuery</a> in order to properly implement our JavaScript code.</li>
				</ul>
				</p>
<?php include "incl/footer.php" ?>