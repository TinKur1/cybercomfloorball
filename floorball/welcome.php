<?php

session_start();

require 'databaseconf.php';
require 'databaseconn.php';

if( isset($_SESSION['user_id']) ){

    $now = time(); // Checking the time now when home page starts.

    if ($now > $_SESSION['expire']):
        session_destroy();
        echo "Your session has expired! Please login with the link sent to your email";
    else:

		$records = $conn->prepare('SELECT * FROM groupInfo WHERE id = :id');
		$records->bindParam(':id', $_SESSION['user_id']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$user = NULL;

		if( count($results) > 0){
			$user = $results;
		}
	endif;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Floorball</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'> -->
</head>
<body>

	<div class="header">
		<a>Floorball</a>
	</div>

	<?php if( !empty($user)): ?>
		<?php 
		if($user['type'] == 'admin'):
			require 'admin.php';
			// header("Location: /admin.php");
		elseif($user['type'] == 'user'):
			require 'user.php';
			// header("Location: /user.php");
		else:
			echo "Your Administrative Privilage is not properly inserted to the database, Please contact the administror!";
		endif
		?>
			

	<?php

	    elseif (!empty($_GET['userid']) && !empty($_GET['eventid'])):

	    session_start();

	    $userid = $_GET['userid'];
	    $eventid = $_GET['eventid'];

	    //echo "userid: ".$userid."  eventid: ".$eventid;

		$_SESSION['user_id'] = $userid;
		$_SESSION['event_id'] = $eventid;
        $_SESSION['start'] = time(); // Taking now logged in time.
        // Ending a session in 3 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['start'] + (20 * 60);

		header("Location: /welcome.php");

		else:
	?>

		<h3>You are logged out, please use the link sent to your email <h3> or <h3/> <h3>contact your administrator!</h3>
<!-- 		<h1>Please Login or Register</h1>
		<a href="login.php">Login</a> or
		<a href="register.php">Register</a> -->

	<?php endif; ?>

</body>
</html>