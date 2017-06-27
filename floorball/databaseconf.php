<?php
$server = 'localhost';
$username = 'root';
$password = 'root';
$database = 'floorball';

try {
    $conn = new PDO("mysql:host=$server", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    // use exec() because no results are returned
    $conn->exec($sql);

    $sql = "use $database";
    // use exec() because no results are returned
    $conn->exec($sql);

    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS groupInfo (
    id BIGINT(15) UNSIGNED UNIQUE PRIMARY KEY, 
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    email VARCHAR(50) NOT NULL,
    mobile BIGINT(10),
    category VARCHAR(10),
    type VARCHAR(10),
    reg_date TIMESTAMP,
    tu_status VARCHAR(30),
    ptu_status VARCHAR(30),
    th_status VARCHAR(30),
    pth_status VARCHAR(30),
    comment VARCHAR(500)
    )";
    // use exec() because no results are returned
    $conn->exec($sql);

       // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    match_day VARCHAR(30),
    match_date DATE,
    match_time TIME,
    reg_start TIME,
    reg_end TIME,
    time_zone VARCHAR(30)
    )";
    // use exec() because no results are returned
    $conn->exec($sql);

    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    password VARCHAR(250),
    type VARCHAR(30),
    reg_date TIMESTAMP,
    status VARCHAR(30),
    comment VARCHAR(500)
    )";
    // use exec() because no results are returned
    $conn->exec($sql);

    $stmt = $conn->prepare("SELECT id, firstname, lastname FROM users"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if (count($stmt->fetchAll()) == 0):

        // Enter the admin in the database
        $sql = "INSERT INTO users (firstname, lastname, email, password, type, status) VALUES (:firstname, :lastname,:email, :password, :type, :status)";
        $stmt = $conn->prepare($sql);

        $firstname = 'admin';
        $lastname = 'admin';
        $email = 'admin@admin.com';
        $password = 'admin';
        $pswd = password_hash($password, PASSWORD_BCRYPT);
        $type = 'admin';
        $status = 'accept';

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pswd);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':status', $status);
        if( $stmt->execute() ):
            $message = 'Successfully created admin';
        else:
            $message = 'Sorry there must have been an issue creating the admin account';
        endif;
    endif;

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>