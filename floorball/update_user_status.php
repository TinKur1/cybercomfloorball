<?php

session_start();

$email = $_POST['email'];

$comment = $_POST['comment'];

ini_set('display_errors',1);

if(isset($_POST['form_accept'])):


    try {
        require 'databaseconn.php';
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!empty($comment)):
            $sql = "UPDATE groupInfo SET tu_status='accept', comment='$comment' WHERE email='$email'";

        else:
            $comment = " ";
            $sql = "UPDATE groupInfo SET tu_status='accept', comment='$comment' WHERE email='$email'";

        endif;

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        // echo $stmt->rowCount() . " records UPDATED successfully";
        // require 'welcome.php';
        header("Location: /welcome.php");
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;

elseif(isset($_POST['form_decline'])):

    $comment = $_POST['comment'];

    try {
        require 'databaseconn.php';
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!empty($comment)):

            $sql = "UPDATE groupInfo SET tu_status='decline', comment='$comment' WHERE email='$email'";

        else:
            $comment = " ";
            $sql = "UPDATE groupInfo SET tu_status='decline', comment='$comment' WHERE email='$email'";
        
        endif;

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        // echo $stmt->rowCount() . " records UPDATED successfully";
        // require 'welcome.php';
        header("Location: /welcome.php");
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;


elseif(isset($_POST['form_comment'])):

    $comment = $_POST['comment'];

    try {
        require 'databaseconn.php';
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!empty($comment)):

            $sql = "UPDATE groupInfo SET tu_status='comment', comment='$comment' WHERE email='$email'";

        else:

            $comment = " ";
            $sql = "UPDATE groupInfo SET tu_status='comment', comment='$comment' WHERE email='$email'";
        
        endif;

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        // echo $stmt->rowCount() . " records UPDATED successfully";
        // require 'welcome.php';
        header("Location: /welcome.php");
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
endif;

?>
