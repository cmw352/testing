<?php session_start();
$_SESSION['activetab'] = "none";

include "incl/header.php"; ?>

<div class="page-header">
	<span style="color:white">
		spacer
	</span>
	</div>
	
<table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>#</th>
      <th>Task</th>
      <th>Deadline</th>
      <th>Estimated Time to Completion</th>
	  <th>Priority</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr class="info">
      <td>3</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr class="success">
      <td>4</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr class="danger">
      <td>5</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr class="warning">
      <td>6</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
    <tr class="active">
      <td>7</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
	  <td>Column content</td>
    </tr>
  </tbody>
</table> 




<script>
$(document).ready(function(){





});
</script>
<?php include "incl/footer.php" ?>