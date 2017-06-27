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
	<span>or <br /> <a href="admin_user_update.php">login here</a></span>

	<form action="register.php" method="POST">
		<input type="text" placeholder="Firstname" name="firstname">
		<input type="text" placeholder="Lastname" name="lastname">
		<input type="text" placeholder="Email" name="email">
		<input type="password" placeholder="Password" name="password">
		<input type="password" placeholder="Confirm Password" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>