
<?php

define("SITE_NAME", "Our Cybercom Floorball Website!"); // I added that

$subject = "Respond to innebady event at " . SITE_NAME;

$eventid = 12345678901234;


require 'databaseconn.php';
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$records = $conn->prepare('SELECT * FROM groupInfo ORDER BY firstname ASC');
$records->execute();
//$results = $records->fetch(PDO::FETCH_ASSOC);
$users = $records->fetchAll();

$message = '';

echo count($users);

if(count($users) > 0) {

	foreach ($users as $user) {

		$to = $user['email'];

		$userid = $user['id'];
  
		$mail_content = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Floorball booking reminder email</title>
		</head>
		<body>

		<div>
		        <p>' . $user['firstname'] . ' ' . $user['lastname'] . ', welcome to ' . SITE_NAME . '.</p>
		        <p>Please click the following link to respond to this event "<a href ="http://localhost/welcome.php?userid=' . $userid . '&eventid=' . $eventid . '">localhost:8080/welcome.php?userid=' . $userid . '&eventid=' . $eventid . '</a>"</p>


		</div>
		</body>
		</html>';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To:' . $user['firstname'] . ' ' . $user['lastname'] . '<' . $to . '>' . "\r\n";
		$headers .= 'From: FloorBall <innebandy.floorball@gmail.com>' . "\r\n";
		//$headers .= 'Cc: tinashe.kurewaseka@cybercom.com' . "\r\n";
		//$headers .= 'Bcc: TinasheKurehwaseka@hotmail.com' . "\r\n";

		// Mail it
		if ($to == 'tklogbaman@gmail.com'):
			mail($to, $subject, $mail_content, $headers);
			echo 'Mail sent!';
			echo $mail_content;
		endif;
	}

}

$conn = NULL;

?>