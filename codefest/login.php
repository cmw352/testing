<?php 
include "phpscript/sqlconnect.php";
include "incl/header_nonav.php"; 
?>

<div class="container">
	<div class="row col-lg-6 col-lg-offset-3 well">
	
			<form class="form-horizontal">
				<fieldset>
					<legend style="text-align:center">Login</legend>
					<div class="form-group regonly" style="display:none">
						<label for="inputName" class="col-lg-2 control-label">Name</label>
						<div class="col-lg-10">
							<input class="form-control" id="inputName" placeholder="Name (optional)" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-lg-2 control-label">Email</label>
						<div class="col-lg-10">
							<input class="form-control" id="inputEmail" placeholder="Email" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-lg-2 control-label">Password</label>
						<div class="col-lg-10">
							<input class="form-control" id="inputPassword" placeholder="Password" type="password">
						</div>
					</div>
					<div class="form-group regonly"  style="display:none">
						<label for="inputPasswordConfirm" class="col-lg-2 control-label">Confirm Password</label>
						<div class="col-lg-10">
							<input class="form-control" id="inputPasswordConfirm" placeholder="Confirm Password" type="password">
						</div>
					</div>
					<div class="form-group">
						<div class="checkbox">
							<label id="registerbox">

							<div class="col-lg-10">
								<input type="checkbox" id="cbox"> Register New Account
								</div>
								
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="reset" class="btn btn-default" id="cancelButton">Cancel</button>
							<button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
						</div>
					</div>
					<div class="alert alert-dismissible alert-danger" style="display:none" id="failedAlert">
						<button type="button" class="close" id="closealert"><tt>x</tt></button>
						<strong>Oops! </strong><span id="appendTextHere"></span>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script>

$.ajax({
				url:"ajaxtargets/login_ajax.php",
				method:"POST",
				data:{	operation:"cookie_login"},
				type:"text",
				success:function(data)
				{
					if(data.substr(0,1) == '0')
					{
					}
					else
					{
						window.location.href = "index.php";
					}
				}
			});

function validateEmail(email)
{
	var regex = /([a-z0-9\/\.\!\?\%]|\@)+@[0-9a-zA-Z]+\.[0-9a-zA-Z]+/gi
	return regex.test(email);
}
function fail(message)
{
	$("#failedAlert").slideDown(500);
	$("#appendTextHere").html(message);
}


$(document).ready(function(){
	$("#submitButton").click(function(event){
		$("#failedAlert").slideUp(500);
		event.preventDefault();
		
		var isCreatingAccount = $("#cbox").prop("checked");
		var email = $("#inputEmail").val();
		var password = $("#inputPassword").val();
		var passwordconfirm = $("#inputPasswordConfirm").val();
		var name = $("#inputName").val();
		if(email == "")
		{
			fail("Please enter an e-mail address.");
		}
		else if(password == "")
		{
			fail("Please enter a password.");
		}
		else if(isCreatingAccount && password != passwordconfirm)
		{
			fail("Passwords don't match.");
		}
		else if(!validateEmail(email))
		{
			fail("\"" + email + "\" is not a valid email address.");
		}
		else
		{
			// INITIAL VALIDATION PASSED
			$.ajax({
				url:"ajaxtargets/login_ajax.php",
				method:"POST",
				data:{	operation:isCreatingAccount ? "register" : "login",
						email:email,
						password:password,
						name:name},
				type:"text",
				success:function(data)
				{
					if(data.substr(0,1) == '0')
					{
						fail(data.substr(1));
					}
					else
					{
						window.location.href = "index.php";
					}
				}
			});
		}
	});
	$("#cancelButton").click(function(){
	
	
	});
	$("#registerbox").click(function(){
		if($("#cbox").prop("checked"))
		{
			$(".regonly").slideDown(600);
		}
		else
		{
			$(".regonly").slideUp(600);
		}
	
	});
	$("#closealert").click(function(event){
		event.preventDefault();
		$("#failedAlert").slideUp(500);
	});
});

</script>
<?php include "incl/footer.php" ?>