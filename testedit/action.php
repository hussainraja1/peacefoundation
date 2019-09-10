<?php
include_once("inc/db_connect.php");
if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['id'])) {
		$updateField.= "id='".$_POST['id']."'";
	} else if(isset($_POST['FirstName'])) {
		$updateField.= "FirstName='".$_POST['FirstName']."'";
	} else if(isset($_POST['LastName'])) {
		$updateField.= "LastName='".$_POST['LastName']."'";
	}
	if($updateField && $_POST['id']) {
		$sqlQuery = "UPDATE nonmember SET $updateField WHERE id='".$_POST['id']."'";	
		mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
		$data = array(
			"message"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "DELETE FROM nonmember WHERE id='" . $_POST['id'] . "'";
	
	mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1
	);
	echo json_encode($data);	
}

