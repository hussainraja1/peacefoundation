
<?php  
//action.php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit();
}
else if ($_SESSION['membertype'] != "admin"){
	header('Location: ../home.php');
	exit();
}
include_once("../db.php");

if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['name'])) {
		$updateField.= "name='".$_POST['name']."'";
	} else if(isset($_POST['gender'])) {
		$updateField.= "gender='".$_POST['gender']."'";
	} else if(isset($_POST['age'])) {
		$updateField.= "age='".$_POST['age']."'";
	}
	if($updateField && $_POST['id']) {
		$sqlQuery = "UPDATE individualmember SET $updateField WHERE id='" . $_POST['id'] . "'";	
		mysqli_query($con, $sqlQuery) or die("database error:". mysqli_error($con));	
		$data = array(
			"message"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "DELETE FROM individualmember WHERE id='" . $_POST['id'] . "'";	
	mysqli_query($con, $sqlQuery) or die("database error:". mysqli_error($con));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1
	);
	echo json_encode($data);	
}

?>