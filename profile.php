<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit();
}

include('db.php');

// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, membertype FROM accounts WHERE id = ?');

// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email,$membertype);
$stmt->fetch();
$stmt->close();


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
<?php
if($_SESSION['membertype'] == "admin" || $_SESSION['membertype'] == "volunteer"){
	echo "Username: ";
	echo $_SESSION['name'];"<br>";
	echo "<br>Email: ";
	echo $email;
	echo"<br><a href='admin/index.php'>Admin Panel</a><br>";
	
}
else{
	echo "Username:<br>";
	echo $_SESSION['name'];"<br>";
	echo "Email:<br>";
	echo $email;"<br>";
}

?>
		</div>
	</body>
</html>