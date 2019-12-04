<?php
	require "loginValidation.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Nintendo 64 Database</title>
        <link href="styles/main.css" rel="stylesheet">
    </head>
    <body>
        <div class="content">
            <div class="header">
                <div class="main-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="gamedatabase.php">Games</a></li>
                    <li><a href="userinfo.php">Account Info</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </div>
            </div>
            <div class="background">
                <div class="subSection">
	<?php

	if(!isset($_SESSION["loggedin"])) {

	echo '
	<h2>Create an Account</h2>
	<form action="" method="post">
		<span>Username:</span>
		<br>
		<input type="text" name="creationUsername">
		<br><br>
		<span>Password:</span>
		<br>
		<input type="text" name="creationPassword">
		<br><br>
		<span>Email address:</span>
		<br>
		<input type="text" name="creationEmail">
		<br><br>
		<input type="submit" name="submit">
	</form>';

	}

	?>

	<?php

		if(isset($_POST['submit'])) {

			$creationUsernameValidation = false;
			$creationPasswordValidation = false;
			$creationEmailValidation = false;

			$userArray = array();

			$creationUsername = $_POST["creationUsername"];

			echo '<br>';

			if (!preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $creationUsername)) {
				echo '<span><b>Username should be no more than 20 characters long and not contain underscores or dots.</b></span><br><br>';
			} else {
				array_push($userArray, $creationUsername);
				$creationUsernameValidation = true;
			}

			$creationPassword = $_POST["creationPassword"];

			if (!preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $creationPassword)) {
				echo '<span><b>Password should be no more than 20 characters long and not contain underscores or dots.</b></span><br><br>';
			} else {
				array_push($userArray, $creationPassword);
				$creationPasswordValidation = true;
			}

			$creationEmail = $_POST["creationEmail"];

			if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $creationEmail)) {
				echo '<span><b>Please enter a valid email. (example@example.com) </b></span><br><br>';
			} else {
				array_push($userArray, $creationEmail);
				$creationEmailValidation = true;
			}

			if ($creationUsernameValidation == true && $creationPasswordValidation == true && $creationEmailValidation == true) {

				include 'connection.php';

				/*

				$server = "students.cah.ucf.edu";
				$username = "ca631855";
				$password = "Abcdef1@";
				$databaseName = "ca631855";

				*/

				$connection = mysqli_connect("$server", "$username", "$password", "$databaseName") or die('Error');

				$sql = "INSERT INTO userpass (Username, Password, Email) VALUES ('$userArray[0]', sha1('$userArray[1]'), '$userArray[2]')";

				// print_r($userArray);

				mysqli_query($connection, $sql) or die("ERROR!");

				header("refresh:5; url=index.php");
				echo '<span><b>You have successfully created an account ' . $userArray[0] . '. The page will refresh in 5 seconds.<br><br></b></span>';

			}

		}

	?>

	<?php

	if(!isset($_SESSION["loggedin"])) {

	echo '
	<br><hr>
	<h2>Login</h2>
	<form action="loginValidation.php" method="post">
		<span>Username:</span>
		<br>
		<input type="text" name="loginUsername">
		<br><br>
		<span>Password:</span>
		<br>
		<input type="text" name="loginPassword">
		<br><br>
		<input type="submit">
	</form>';
	}

	?>

	<?php

		if(isset($_SESSION["loggedin"])) {
			echo 'You are currently logged in.';
		}

	?>

</body>
</html>
