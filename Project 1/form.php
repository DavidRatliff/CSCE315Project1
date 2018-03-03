<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$startErr = $endErr = "";
$start = $end = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["start"])) {
    $startErr = "start time is required";
  } else {
    $start = test_input($_POST["start"]);
  }
  
  if (empty($_POST["end"])) {
    $endErr = "end time is required";
  } else {
    $end = test_input($_POST["end"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Rec Time Stamp(Date and Time)</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="/action_page.php"
<?php 
	echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>
  Begin: <input type="datetime-local" name="begin">
  <span class="error">* <?php echo $startErr;?></span>
  <br><br>
  End: <input type="datetime-local" name="end">
  <span class="error">* <?php echo $endErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>