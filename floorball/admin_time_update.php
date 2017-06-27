<?php

session_start();

// if( isset($_SESSION['user_id']) ){
// 	header("Location: /welcome.php");
// }

require 'databaseconn.php';

$message = '';

if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])):
	
	if($_POST['password'] == $_POST['confirm_password']):

		// Enter the new user in the database
		$sql = "INSERT INTO users (firstname, lastname, email, password, type, status) VALUES (:firstname, :lastname,:email, :password, :type, :status)";
		$stmt = $conn->prepare($sql);

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $pswd = password_hash($password, PASSWORD_BCRYPT);
        $type = 'user';
        $status = 'decline';

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pswd);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':status', $status);
	

		if( $stmt->execute() ):
			$message = 'Successfully created new user';
		else:
			$message = 'Sorry there must have been an issue creating your account';
		endif;
	else:
		$message = 'Password doesn\'t match';
	endif;
elseif (!empty($_POST['firstname']) || !empty($_POST['lastname']) || !empty($_POST['email']) || !empty($_POST['password']) || !empty($_POST['confirm_password'])):
	$message = 'Missing input';
endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Floorball</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<span>or <br /> <a href="login.php">login here</a></span>

	<form action="admin_time_update.php" method="POST">
		<input type="text" placeholder="Firstname" name="firstname">
		<input type="text" placeholder="Lastname" name="lastname">
		<input type="text" placeholder="Email" name="email">
		<input type="password" placeholder="Password" name="password">
		<input type="password" placeholder="Confirm Password" name="confirm_password">
		<input type="submit">

	</form>

		<div class="time-container">
		<div>SET UP THE TIME FOR THE MEETING<i id="time-container-expand" style="float:right; margin-right:10px; cursor:pointer;" class="fa fa-chevron-circle-down fa-lg" aria-hidden="true"></i>
		</div>
		<div id="time-input-container" class="container-openning" style="height:70px;">
			<i class="fa fa-clock-o fa-3x left-clock"  aria-hidden="true"></i>
			<div class="right-input"> 
				DATE
				<input id="meeting_date" style="background-color: #007700; " type="date" placeholder="MM DD YYYY" /> 
				START 
				<input id="start_time"  style="background-color: #007700; "  type="time" placeholder="hh:mm" /> 
				END
				<input id="end_time" style="background-color: #007700;"  type="time" placeholder="hh:mm" />
				TIME ZONE
				<select id="time_zone" style="background-color: #007700; " type="timezone">
				  <option value="GMT-08:00">GMT-08:00</option>
				  <option value="GMT-07:00">GMT-07:00</option>
				  <option value="GMT-06:00">GMT-06:00</option>
				  <option value="GMT-05:00">GMT-05:00</option>
				  <option value="GMT-04:00">GMT-04:00</option>	
				  <option value="GMT-03:00">GMT-03:00</option>
				  <option value="GMT-02:00">GMT-02:00</option>
				  <option value="GMT-01:00">GMT-01:00</option>
				  <option value="GMT+00:00">GMT+00:00</option>	
				  <option value="GMT+01:00">GMT+01:00</option>
				  <option value="GMT+02:00">GMT+02:00</option>
				  <option value="GMT+03:00">GMT+03:00</option>
				  <option value="GMT+04:00">GMT+04:00</option>	
				  <option value="GMT+05:00">GMT+05:00</option>
				  <option value="GMT+06:00">GMT+06:00</option>
				  <option value="GMT+07:00">GMT+07:00</option>
				  <option value="GMT+08:00">GMT+08:00</option>								  
				</select>
			</div>
		</div>
		<button id="submit-time" type="button" class="btn btn-sm submit-1">submit</button>
	</div>


</body>
</html>