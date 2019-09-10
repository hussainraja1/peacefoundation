<?php
//THIS PAGE IS UNUSED ONLY FOR REFERENCE PURPOSES

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
?>

<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

td, th {
  text-align: left;
  padding: 8px;
  border: 1px solid black; 
  border-collapse: collapse;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);

include('../db.php');

if($q==1){
	header('Location: test.php');

}
else if($q ==2){
	
	$sql="SELECT * FROM paidmember";
	$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>MemberID</th>
<th>UserID</th>
<th>FirstName</th>
<th>LastName</th>
<th>Response</th>
<th>Annotations</th>
<th>MemberStatus</th>
<th>Email</th>
<th>EndDate</th>
<th>DOB</th>

</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['MemberID'] . "</td>";
    echo "<td>" . $row['UserID'] . "</td>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Response'] . "</td>";
    echo "<td>" . $row['Annotations'] . "</td>";
    echo "<td>" . $row['MemberStatus'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['EndDate'] . "</td>";
    echo "<td>" . $row['DOB'] . "</td>";


    echo "</tr>";
}
echo "</table>";

}
else if($q==3){
	
	$sql="SELECT * FROM organisation";
	$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>OrgID</th>
<th>User Id</th>
<th>OrgName</th>
<th>Email</th>
<th>Response</th>
<th>Annotations</th>
<th>OrgMembership</th>
<th>SchoolSchoolID</th>

</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['OrgID'] . "</td>";
    echo "<td>" . $row['OrgName'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['Response'] . "</td>";
    echo "<td>" . $row['Annotations'] . "</td>";
    echo "<td>" . $row['OrgMembership'] . "</td>";
    echo "<td>" . $row['SchoolSchoolID'] . "</td>";



    echo "</tr>";
}
echo "</table>";

}
else{
	$sql="SELECT * FROM school";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>SchoolID</th>
<th>UserID</th>
<th>SchoolName</th>
<th>TrainedBy</th>
<th>Annotations</th>
<th>SchoolType</th>



</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['SchoolID'] . "</td>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['SchoolName'] . "</td>";
    echo "<td>" . $row['TrainedBy'] . "</td>";
    echo "<td>" . $row['Annotations'] . "</td>";
    echo "<td>" . $row['SchoolType'] . "</td>";

	echo "</tr>";
}
echo "</table>";

}


mysqli_close($con);
?>
</body>
</html>