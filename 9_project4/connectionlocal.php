<?php
session_start();
define('db_server', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_database', 'tr303872');
$conn = mysqli_connect(db_server, db_username, db_password, db_database);

if($conn === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}


if(isset($_POST["login"])){
    $username = $conn->real_escape_string($_POST["username"]);
    $password = sha1($conn->real_escape_string($_POST["password"]));

    $data = $conn->query("SELECT username FROM userinfo WHERE username='$username' AND password='$password'");

    if($data->num_rows > 0){
        $_SESSION["username"] = $username;
        $_SESSION["loggedin"] = 1;
        header("location: index.php");
        exit();
    } else{
        echo "Please try again";

    }
}