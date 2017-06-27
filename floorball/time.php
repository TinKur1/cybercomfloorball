<?php 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Floorball</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>
	<?php
		//set timezone
		date_default_timezone_set('GMT');

		//set an date and time to work with
		$start = '2014-06-01 14:00:00';

		//display the converted time
		echo date('Y-m-d H:i',strtotime('+1 hour +20 minutes',strtotime($start)));
	?>

	<br />
	<br />

	<?php
		echo "Today is " . date("Y/m/d") . "<br>";
		echo "Today is " . date("Y.m.d") . "<br>";
		echo "Today is " . date("Y-m-d") . "<br>";
		echo "Today is " . date("l");
	?>

	<br />
	<br />
	
	<?php
		$d=mktime(11, 14, 54, 8, 12, 2014);
		echo "Created date is " . date("Y-m-d h:i:sa", $d);
	?>

	<br />
	<br />
	
	<?php
	$startdate=strtotime("Saturday");
	$enddate=strtotime("+6 weeks", $startdate);

	while ($startdate < $enddate) {
	  echo date("M d", $startdate) . "<br>";
	  $startdate = strtotime("+1 week", $startdate);
	}
	?>

	<br />
	<br />
	
	<?php
		$d=strtotime("tomorrow");
		echo date("Y-m-d h:i:sa", $d) . "<br>";
		$day = date("l", $d);
		echo $day . "<br>";

		$d=strtotime("next Saturday");
		echo date("Y-m-d h:i:sa", $d) . "<br>";

		$d=strtotime("+3 Months");
		echo date("Y-m-d h:i:sa", $d) . "<br>";
	?>

</body>
</html>