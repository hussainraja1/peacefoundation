<?php
include('db.php');

/*
CHECK THE PAID MEMBER TABLE AND TRY TO FIND A SOLUTION FOR SEPERATION OF PAYING AND NON PAYING MEMBERS.
THIS PHP FILE STORE USERNAME AND PASSWORD INTO ACCOUNTS TABLE AND IT STORES THE USER INFORMATION INTO individualmember TABLE
AND ADDRESS TABLES.
*/
$username = mysqli_real_escape_string($con, $_REQUEST['username']);
$password = mysqli_real_escape_string($con, $_REQUEST['psw']);
$hashed = password_hash($password, PASSWORD_BCRYPT);


$password_repeat = mysqli_real_escape_string($con, $_REQUEST['psw-repeat']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);
$membertype = "school";

$sname = mysqli_real_escape_string($con, $_REQUEST['sname']);
$phonenum = mysqli_real_escape_string($con, $_REQUEST['phonenum']);

$street = mysqli_real_escape_string($con, $_REQUEST['street']);
$suburb = mysqli_real_escape_string($con, $_REQUEST['suburb']);
$city = mysqli_real_escape_string($con, $_REQUEST['city']);
$country = mysqli_real_escape_string($con, $_REQUEST['country']);

 
// Attempt insert query execution
$sql = "INSERT INTO accounts (id, Username, Password,Email,membertype) VALUES (Null, '$username','$hashed', '$email','$membertype')";

if(mysqli_query($con, $sql)){
$user_id = mysqli_insert_id($con);
$sql_information = "INSERT INTO school (SchoolID, id, SchoolName, PhoneNumber) VALUES (Null, '$user_id','$sname','$phonenum')";
$sql_address = "INSERT INTO address (AddressID, id, Address,Suburb,City,Country) VALUES (Null, '$user_id','$street', '$suburb', '$city','$country')";

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