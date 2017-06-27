<?php

session_start();

if( isset($_SESSION['user_id']) ){
	// header("Location: /welcomeadmin.php");
}

$message = '';

require 'databaseconn.php';

if (isset($_POST["newUser"]) && !empty($_POST["newUser"])):
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST['email']))):

    $records = $conn->prepare('SELECT * FROM groupInfo WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    // var_dump($results);
    // print_r($results);

    if (is_bool($results)):
        // Enter the new user in the database
        $sql = "INSERT INTO groupInfo (id, firstname, lastname, email, category, type, tu_status) VALUES (:id, :firstname, :lastname, :email, :category, :type, :tu_status)";
        $stmt = $conn->prepare($sql);
        
        $id = randNum(14);
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $category = $_POST['category'];
        $type = 'user';
        $tu_status = 'noanswer';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':tu_status', $tu_status);

        if( $stmt->execute() ):
            $message = 'Successfully created new user';
            //echo $message;
            header("Location: /welcomeadmin.php");
        else:
            $message = 'Sorry there must have been an issue registering this entry';
            echo $message;
            //header("Location: /welcomeadmin.php");
        endif;
    else:
        $message = 'Entry with this email address is already registered';
        echo $message;
        //header("Location: /welcomeadmin.php");
    endif;
else:
	$message = 'Email address is missing';
    echo $message;
    //header("Location: /welcomeadmin.php");
endif;
elseif (isset($_POST["newMultipleUser"]) && !empty($_POST["newMultipleUser"])):
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST['multipleUsersString']))):

    $multipleUsersString = $_POST['multipleUsersString'];
    $multipleUsersArray = explode(';', $multipleUsersString);
    // print_r($multipleUsersArray);

    foreach ($multipleUsersArray as $email) {

    $records = $conn->prepare('SELECT * FROM groupInfo WHERE email = :email');
    $records->bindParam(':email', $email);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    // var_dump($results);
    // print_r($results);

    if (is_bool($results)):
        // Enter the new user in the database
        $sql = "INSERT INTO groupInfo (id, email, type, tu_status) VALUES (:id, :email, :type, :tu_status)";
        $stmt = $conn->prepare($sql);
        
        $id = randNum(14);
        $email = $email;
        $type = 'user';
        $tu_status = 'noanswer';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':tu_status', $tu_status);

        if( $stmt->execute() ):
            $message = 'Successfully created new user';
            //echo $message;
            header("Location: /welcomeadmin.php");
        else:
            $message = 'Sorry there must have been an issue registering this entry';
            echo $message;
            //header("Location: /welcomeadmin.php");
        endif;
    else:
        $message = 'Entry with this email address is already registered';
        echo $message;
        //header("Location: /welcomeadmin.php");
    endif;
    }
else:
    $message = 'Email addresses missing';
    echo $message;
    //header("Location: /welcomeadmin.php");
endif;
elseif (isset($_POST["updateUser"]) && !empty($_POST["updateUser"])):
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST['email']))):

    $records = $conn->prepare('SELECT * FROM groupInfo WHERE id = :id');
    $records->bindParam(':id', $_POST['userid']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    // var_dump($results);
    // print_r($results);

    if (!is_bool($results)):
        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $category = $_POST['category'];

        // Enter the new user in the database
        $sql = "UPDATE groupInfo SET firstname='$firstname', lastname='$lastname', email='$email', category='$category' WHERE id=$userid";
        $stmt = $conn->prepare($sql);

        if( $stmt->execute() ):
            $message = 'Successfully created new user';
            //echo $message;
            header("Location: /welcomeadmin.php");
        else:
            $message = 'Sorry there must have been an issue on updating this entry';
            echo $message;
            //header("Location: /welcomeadmin.php");
        endif;
    else:
        $message = 'Entry can not be found';
        echo $message;
        //header("Location: /welcomeadmin.php");
    endif;
else:
    $message = 'Email address is missing';
    echo $message;
    //header("Location: /welcomeadmin.php");
endif;
elseif (isset($_POST["deleteUser"]) && !empty($_POST["deleteUser"])):
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST['email']))):

    $records = $conn->prepare('SELECT * FROM groupInfo WHERE id = :id');
    $records->bindParam(':id', $_POST['userid']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    // var_dump($results);
    // print_r($results);

    if (!is_bool($results)):
        $userid = $_POST['userid'];
        // Enter the new user in the database
        $sql = "DELETE FROM groupInfo WHERE id=$userid";
        $stmt = $conn->prepare($sql);
    

        if( $stmt->execute() ):
            $message = 'Successfully created new user';
            //echo $message;
            header("Location: /welcomeadmin.php");
        else:
            $message = 'Sorry there must have been an issue on deleting this entry';
            echo $message;
            //header("Location: /welcomeadmin.php");
        endif;
    else:
        $message = 'Entry with this email address is not found';
        echo $message;
        //header("Location: /welcomeadmin.php");
    endif;
else:
    $message = 'Email address is missing';
    echo $message;
    //header("Location: /welcomeadmin.php");
endif;
elseif (isset($_POST["editUser"]) && !empty($_POST["editUser"])):
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!empty($_POST['email']))):

    $records = $conn->prepare('SELECT * FROM groupInfo WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    // var_dump($results);
    // print_r($results);

    if (is_bool($results)):
        $userid = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $category = $_POST['category'];
        // Enter the new user in the database

        if( $stmt->execute() ):
            $message = 'Successfully created new user';
            //echo $message;
            header("Location: /welcomeadmin.php");
        else:
            $message = 'Sorry there must have been an issue registering this entry';
            echo $message;
            //header("Location: /welcomeadmin.php");
        endif;
    else:
        $message = 'Entry with this email address is already registered';
        echo $message;
        //header("Location: /welcomeadmin.php");
    endif;
else:
    $message = 'Email address is missing';
    echo $message;
    //header("Location: /welcomeadmin.php");
endif;
endif;

function randNum($length)
{
    $str = mt_rand(1, 9); // first number (0 not allowed)
    for ($i = 1; $i < $length; $i++)
    {
        $str .= mt_rand(0, 9);
    }
    return $str;
}

?>