<?php

session_start();

// require 'databaseconf.php';
require 'databaseconn.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT * FROM groupInfo WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

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
<!-- 	<div class="header">
		<a href="/">Floorball</a>
	</div> 
    <div class=""> -->

    <div style="width:1000px; height:1000px; background-color:#a0c0a0; text-align:center; margin:0 auto;">

    	<?php if( !empty($user)):

            $email = $user['email'];
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];

        ?>
    		<br />You are logged in as <?= $firstname, " ", $lastname ?>
    		<a href="admin_time_update.php">Update game time</a>  
    		<a href="admin_user_update.php">Update users</a>  
    		<a href="logout.php">Logout?</a>
    		<br /><br />

            <?php
                require 'databaseconn.php';
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $records = $conn->prepare('SELECT * FROM admin WHERE id = :id');
                $id = 1;
                $records->bindParam(':id', $id);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC);

                $user = NULL;

                if( count($results) > 0){

                    $settings = $results;
                    $match_day = $settings['match_day'];
                    $match_date = $settings['match_date'];
                    $match_time = $settings['match_time'];
                }

            ?>

            <?php

            function getContent() {
                require 'databaseconn.php';
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = "SELECT * FROM groupInfo ORDER BY reg_date ASC";
                $sql = $conn->prepare($query);
                $sql->execute();
                return $sql->fetchAll();
            }

            $registeredNo = 0;
            $acceptedNo = 0;
            $declineNo = 0;
            $commentNo = 0;
            $noanswerNo = 0;

            $data = getContent();

            // echo count($data);

            $registeredNo = count($data);

            foreach($data as $row) {

                // echo $row['id'];
                // echo $row['firstname'];
                // echo $row['lastname'];
                // echo $row['status'];

                if($row['tu_status'] == 'accept'):
                    $acceptedNo++;
                elseif($row['tu_status'] == 'decline'):
                    $declineNo++;
                elseif($row['tu_status'] == 'comment'):
                    $commentNo++;
                else:
                    $noanswerNo++;
                endif;

            }

            // echo $registeredNo;
            // echo $acceptedNo;
            // echo $declineNo;
            // echo $commentNo;
            // echo $noanswerNo;
            ?>

<!--             <b>Summary:</b> Of <b> <?=$registeredNo; ?> </b> registred, <b> <?=$acceptedNo; ?> </b> accepted, <b> <?=$declineNo; ?> </b> declined, <b> <?=$commentNo; ?> </b> commented only and <b> <?=$noanswerNo; ?> </b> with no answer.
            <br /><br /> -->

            <?php

            // require 'databaseconn.php';
            // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $records = $conn->prepare('SELECT * FROM groupInfo WHERE tu_status="accept" ORDER BY reg_date ASC');
            $records->execute();
            //$results = $records->fetch(PDO::FETCH_ASSOC);
            $users = $records->fetchAll();

            $message = '';

            // echo count($data);

            if(count($users) > 0) {
            ?>
                <table>
                <tr><th>Status</th><th>Name</th><th>Comment</th></tr>

                <?php
                
                foreach ($users as $user) {
                ?>
                <tr>
                <?php if($user['tu_status'] == 'accept'): ?>
                <td><?php echo '<img src="assets/images/accept.png" alt="logo" style="height:20px;width:20px;" align="" hspace="5">';?></td>
                <?php elseif($user['tu_status'] == 'decline'): ?>
                <td><?php echo '<img src="assets/images/decline.png" alt="logo" style="height:20px;width:20px;" align="" hspace="5">';?></td>
                <?php elseif($user['tu_status'] == 'comment'): ?>
                <td><?php echo '<img src="assets/images/comment.png" alt="logo" style="height:20px;width:20px;" align="" hspace="5">';?></td>                
                <?php else: ?>
                <td><?php echo '<img src="assets/images/noanswer.png" alt="logo" style="height:20px;width:20px;" align="" hspace="5">';?></td>                      
                <?php endif ?>
                <td><?php echo $user['firstname']; echo"   ";?><?php echo $user['lastname'];?></td>
                <td><?php echo $user['comment'];?></td>
                </tr>
                <?php } ?>
                </table>

           <?php } ?>

    			
    	<?php else: ?>

    		<h1>Please Login or Register</h1>
    		<a href="login.php">Login</a> or
    		<a href="register.php">Register</a>

    	<?php endif; ?>
    </div>
</body>
</html>