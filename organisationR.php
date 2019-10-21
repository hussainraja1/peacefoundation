<?php
include('db.php');


$username = mysqli_real_escape_string($con, $_REQUEST['username']);
$password = mysqli_real_escape_string($con, $_REQUEST['psw']);
$password_repeat = mysqli_real_escape_string($con, $_REQUEST['psw-repeat']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);
$membertype = "organisation";

$orgname = mysqli_real_escape_string($con, $_REQUEST['org_name']);
$phonenum = mysqli_real_escape_string($con, $_REQUEST['phonenum']);

$street = mysqli_real_escape_string($con, $_REQUEST['street']);
$city = mysqli_real_escape_string($con, $_REQUEST['city']);
$zip = mysqli_real_escape_string($con, $_REQUEST['zip']);
$country = mysqli_real_escape_string($con, $_REQUEST['country']);

 
// Attempt insert query execution
$sql = "INSERT INTO accounts (id, Username, Password,Email,membertype) VALUES (Null, '$username','$password', '$email','$membertype')";

if(mysqli_query($con, $sql)){
$user_id = mysqli_insert_id($con);
$sql_information = "INSERT INTO organisation (OrgID, id, OrgName,PhoneNum, Response, Annotations, OrgMembership) VALUES (Null, '$user_id','$orgname','$phonenum',Null, Null, Null)";
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