<?php
include('db.php');

/*
CHECK THE PAID MEMBER TABLE AND TRY TO FIND A SOLUTION FOR SEPERATION OF PAYING AND NON PAYING MEMBERS.
THIS PHP FILE STORE USERNAME AND PASSWORD INTO ACCOUNTS TABLE AND IT STORES THE USER INFORMATION INTO individualmember TABLE
AND ADDRESS TABLES.
*/
$username = mysqli_real_escape_string($con, $_REQUEST['username']);
$password = mysqli_real_escape_string($con, $_REQUEST['psw']);
$password_repeat = mysqli_real_escape_string($con, $_REQUEST['psw-repeat']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);
$membertype = "individual";

$title = mysqli_real_escape_string($con, $_REQUEST['title']);
$firstname = mysqli_real_escape_string($con, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($con, $_REQUEST['lastname']);
$dob = mysqli_real_escape_string($con, $_REQUEST['dob']);
$phonenum = mysqli_real_escape_string($con, $_REQUEST['phonenum']);

$street = mysqli_real_escape_string($con, $_REQUEST['street']);
$city = mysqli_real_escape_string($con, $_REQUEST['city']);
$zip = mysqli_real_escape_string($con, $_REQUEST['zip']);
$country = mysqli_real_escape_string($con, $_REQUEST['country']);

 
// Attempt insert query execution
$sql = "INSERT INTO accounts (id, Username, Password,Email,membertype) VALUES (Null, '$username','$password', '$email','$membertype')";

if(mysqli_query($con, $sql)){
$user_id = mysqli_insert_id($con);
$sql_information = "INSERT INTO individualmember (individualMemberID, id, Title,FirstName,LastName,PhoneNum,DOB,Comments) VALUES (Null, '$user_id','$title', '$firstname','$lastname','$phonenum','$dob', Null)";
$sql_address = "INSERT INTO address (AddressID, id, Address,City,Suburb,Country) VALUES (Null, '$user_id','$street', '$city','$zip','$country')";

echo "Record added successfully into accounts. User Id ", $user_id;
	if(mysqli_query($con, $sql_information) && mysqli_query($con, $sql_address) ){
		echo "Record added successfully into individualmember and address. User Id ", $user_id;

	}
	else{
       echo "ERROR: Could not able to execute $sql_information. " . mysqli_error($con);
       echo "ERROR: Could not able to execute $sql_address. " . mysqli_error($con);

	}
	
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
 
// Close connection
mysqli_close($con);
?>