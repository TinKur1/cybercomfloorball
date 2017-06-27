<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /welcomeadmin.php");
}

require 'databaseconn.php';

if (isset($_POST['email']) || isset($_POST['password'])):
	if(!empty($_POST['email']) && !empty($_POST['password'])):

		$records = $conn->prepare('SELECT id,firstname,lastname,email,password,type FROM users WHERE email = :email');
		$records->bindParam(':email', $_POST['email']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$message = '';

		if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

			$_SESSION['user_id'] = $results['id'];
			// $_SESSION['user_firstname'] = $results['firstname'];
			// $_SESSION['user_lastname'] = $results['lastname'];
			// $_SESSION['user_email'] = $results['email'];
			// $_SESSION['user_type'] = $results['type'];
		    $_SESSION['start'] = time(); // Taking now logged in time.
            // Ending a session in 10 minutes from the starting time.
            $_SESSION['expire'] = $_SESSION['start'] + (10 * 60);
			header("Location: /welcomeadmin.php");

		} else {
			$message = 'Sorry, those credentials do not match';
		}

	endif;
endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'> -->
</head>
<body>

	<div class="header">
		<a>Floorball</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>
	<span>or <br /> <a href="register.php">register here</a></span>

	<form action="login.php" method="POST">		
		<input type="text" id="text_s" placeholder="Email" name="email">
		<input type="password" id="text_s" placeholder="Password" name="password">
		<input type="submit" id="btn_s" value="Login">
	</form>

</body>
</html>