<?php
//this page is for school member search

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit();
}
else if ($_SESSION['membertype'] == "admin" || $_SESSION['membertype'] == "volunteer"){
}
else
{
		header('Location: ../home.php');
	exit();
}

// for editing the database
if($_SESSION['membertype'] == "admin"){
if(isset($_POST['sub'])){
$schoolid = $_POST['accID'];
$schoolname = $_POST['schoolname'];
$email = $_POST['email'];
$trainedby = $_POST['trainedby'];
$annotations = $_POST['annotations'];
$schooltype = $_POST['schooltype'];
$partnershipid = $_POST['partnershipid'];
$decile = $_POST['decilerating'];	
$maori = $_POST['maoripercentage'];
$fulltraining = $_POST['fulltraining'];
$revisittraining = $_POST['revisittraining'];
$primarycontact = $_POST['primarycontact'];
$principal = $_POST['principal'];
$principalemail = $_POST['principalemail'];
$phonenum = $_POST['phonenum'];
$interest = $_POST['interest'];
$emailsent = $_POST['emailsent'];
$replydate = $_POST['replydate'];
$trainingbooked = $_POST['trainingbooked'];
$address = trim($_POST['address']);
$suburb = trim($_POST['suburb']);
$city = trim($_POST['city']);
$country = trim($_POST['country']);

if(!empty($schoolname)&&!empty($phonenum)){
	
$query =  "

	UPDATE school, address,accounts SET school.schoolname='$schoolname',
	accounts.Email='$email',
	school.trainedby='$trainedby',
	school.annotations='$annotations',
	school.schooltype='$schooltype',
	school.partnershipid='$partnershipid',
	school.DecileRating='$decile',
    school.MaoriPercentage='$maori',
    school.FullTraining='$fulltraining',            
    school.RevisitTraining='$revisittraining',
    school.PrimaryContact='$primarycontact',
    school.Principal='$principal',
	school.PrincipalEmail='$principalemail',
	school.PhoneNumber='$phonenum',
    school.Interest='$interest',
    school.EmailSent='$emailsent',
    school.ReplyDate='$emailsent',
    school.TrainingBooked='$trainingbooked',
	address.address=' $address',
	address.suburb='$suburb',
	address.city='$city',
	address.country='$country'
	WHERE school.id=address.id AND accounts.id = school.id
	AND school.id = $schoolid;";
	
	$search_result = filterTable($query);

}
else{
echo '<script>alert("Please enter the something in the fields");</script>';
}
}

//If Remove Button is set, remove the associated contents of the individualmember, account and address tables
else if(isset($_POST['remove'])){

$accID = $_POST['accID'];	

	$query ="DELETE school, address, accounts FROM school 
LEFT join address on school.id = address.id
LEFT join accounts on school.id = accounts.id
where school.id = $accID;";


    $search_result = filterTable($query);

}		
	
}
else{
}

if(isset($_POST['search']) && isset($_POST['searchIN']))
{
	$searchColumn = $_POST['searchIN'];
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT school.SchoolID,school.id,school.SchoolName,accounts.Email,school.TrainedBy,school.Annotations,school.SchoolType,school.PartnershipID,school.DecileRating,
	school.MaoriPercentage,school.FullTraining,school.RevisitTraining,school.PrimaryContact,school.Principal,school.PrincipalEmail
	,school.PhoneNumber,school.Interest,school.EmailSent,school.ReplyDate,school.TrainingBooked,address.Address,address.City,address.Suburb,address.Country
FROM address ,school, accounts
WHERE  address.id =school.id AND accounts.id = school.id AND $searchColumn LIKE '%".$valueToSearch."%'";

    $search_result = filterTable($query); 
}
 else {

    $query = "SELECT school.SchoolID,school.id,school.SchoolName,accounts.Email,school.TrainedBy,school.Annotations,school.SchoolType,school.PartnershipID,school.DecileRating,
	school.MaoriPercentage,school.FullTraining,school.RevisitTraining,school.PrimaryContact,school.Principal,school.PrincipalEmail,
	school.PhoneNumber,school.Interest,school.EmailSent,school.ReplyDate,school.TrainingBooked,address.Address,address.City,address.Suburb,address.Country
FROM address ,school, accounts
WHERE  address.id =school.id AND accounts.id = school.id";

    $search_result = filterTable($query);
}

if(isset($_POST['submitButtonSchool'])){
	include('../db.php');

$username = mysqli_real_escape_string($con, $_REQUEST['username']);
$password = mysqli_real_escape_string($con, $_REQUEST['password']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);
$membertype = "school";

$sname = mysqli_real_escape_string($con, $_REQUEST['schoolname']);
$trainedby = mysqli_real_escape_string($con, $_REQUEST['trainedby']);
$annotations = mysqli_real_escape_string($con, $_REQUEST['annotations']);
$schooltype = mysqli_real_escape_string($con, $_REQUEST['schooltype']);
$partnershipID = mysqli_real_escape_string($con, $_REQUEST['partnershipID']);
$decilerating = mysqli_real_escape_string($con, $_REQUEST['decilerating']);
$maoripercentage = mysqli_real_escape_string($con, $_REQUEST['maoripercentage']);
$fulltraining = mysqli_real_escape_string($con, $_REQUEST['fulltraining']);
$revisittraining = mysqli_real_escape_string($con, $_REQUEST['revisittraining']);
$primarycontact = mysqli_real_escape_string($con, $_REQUEST['primarycontact']);
$principal = mysqli_real_escape_string($con, $_REQUEST['principal']);
$principalemail = mysqli_real_escape_string($con, $_REQUEST['principalemail']);
$phonenum = mysqli_real_escape_string($con, $_REQUEST['phonenumber']);
$interest = mysqli_real_escape_string($con, $_REQUEST['interest']);
$emailsent = mysqli_real_escape_string($con, $_REQUEST['emailsent']);
$replydate = mysqli_real_escape_string($con, $_REQUEST['replydate']);
$trainingbooked = mysqli_real_escape_string($con, $_REQUEST['trainingbooked']);



$street = mysqli_real_escape_string($con, $_REQUEST['street']);
$suburb = mysqli_real_escape_string($con, $_REQUEST['suburb']);
$city = mysqli_real_escape_string($con, $_REQUEST['city']);
$country = mysqli_real_escape_string($con, $_REQUEST['country']);

 
// Attempt insert query execution
$sql = "INSERT INTO accounts (id, Username, Password,Email,membertype) VALUES (Null, '$username','$password', '$email','$membertype')";

if(mysqli_query($con, $sql)){
$user_id = mysqli_insert_id($con);
$sql_information = "INSERT INTO school (SchoolID, id, SchoolName, TrainedBy,Annotations,SchoolType,PartnershipID,DecileRating,MaoriPercentage,FullTraining,RevisitTraining,PrimaryContact,Principal,PrincipalEmail,PhoneNumber,Interest,EmailSent,ReplyDate,TrainingBooked) 
VALUES (Null, '$user_id','$sname','$trainedby','$annotations','$schooltype','$partnershipID','$decilerating','$maoripercentage','$fulltraining','$revisittraining','$primarycontact','$principal','$principalemail','$phonenum','$interest','$emailsent','$replydate','$trainingbooked')";
$sql_address = "INSERT INTO address (AddressID, id, Address,Suburb,City,Country) VALUES (Null, '$user_id','$street', '$suburb', '$city','$country')";

	if(mysqli_query($con, $sql_information) && mysqli_query($con, $sql_address) ){
header("refresh:1"); 
	echo '<script>alert("Record added successfully");</script>';	
	}
	else{
	echo '<script>alert("Record cannot be added");</script>';	

	}
	
} else{
	echo '<script>alert("Record cannot be added");</script>';	
}
 
// Close connection
mysqli_close($con);
}

// function to connect and execute the query
function filterTable($query)
{
	$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'peacefoundation';
// Try and connect using the info above.
$connect = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
    /*exit();*/

}
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}
?>
<!DOCTYPE html>
<html>
    <head>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $("#individualB").click(function(){
    $("#tableview").hide();
	$("#school").show();
  });
  $("#viewT").click(function(){
    $("#tableview").show();
	$("#school").hide();
  });
});
</script>
	
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

th {
	text-align: left;
}
.tablecontent { overflow-x:scroll;
overflow-y:scroll;
    width:100%;
	height:500px;
	border-style: inset;
	}
</style>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Tables</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

 <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php"><img src="logo_1.png"  title="Peace Logo" alt="Logo"></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Member Edit Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Display & Edit:</h6>
          <a class="dropdown-item" href="tables.php">Display&Edit Members</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Admin Settings:</h6>
          <a class="dropdown-item" href="xeroapi/private.php">Display Invoices - Xero</a>

        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
    </ul>

    <div id="content-wrapper">
		  
    </head>
    <body>
        <div class="container-fluid" id="tableview">
			<?php
			if($_SESSION['membertype'] == "admin"){
			echo "<button id='individualB'>Add New Member</button> <b><-- Click to add a new member</b><br><br>";
			}
			?>
        <form action="school.php" method="post">
			
		<p><b>Please select the the column you want to search in, type in the keyword and click filter button to search:</b></p> 
			<select name="searchIN">
  <option  value="school.id">Account ID</option>
  <option  value="school.SchoolName">School Name</option> 
  <option  value="accounts.Email">Email</option
  <option  value="school.PhoneNumber">Phone Number</option>
  <option  value="school.TrainedBy"> Trained By</option>
  <option  value="school.Annotations">Annotations</option>
  <option  value="school.SchoolType"> School Type </option>
  <option  value="school.PartnershipID"> PartnershipID</option>
  <option  value="school.DecileRating"> DecileRating</option>
  <option  value="school.MaoriPercentage"> MaoriPercentage</option>
  <option  value="school.FullTraining"> FullTraining</option>
  <option  value="school.RevisitTraining"> RevisitTraining</option>
  <option  value="school.PrimaryContact"> PrimaryContact</option>
  <option  value="school.Principal"> Principal</option>
  <option  value="school.PrincipalEmail"> PrincipalEmail</option>
  <option  value="school.Interest"> Interest</option>
  <option  value="school.EmailSent"> EmailSent</option>
  <option  value="school.ReplyDate"> ReplyDate</option>
  <option  value="school.TrainingBooked"> TrainingBooked</option>
  <option  value="address.Address"> Address</option>
  <option  value="address.City"> City</option>
  <option  value="address.Suburb"> Suburb</option>
  <option  value="address.Country"> Country</option>

</select>
			<input type="text" name="valueToSearch" placeholder="Keyword To Search"><br><br>


            <input type="submit" name="search" value="Filter"><br><br>
            <input type="submit" name="all" value="Show All Rows"><br><br>
			
			
<div class ="tablecontent">
     <?php          
	 echo "<table style='width: 100%'>
<tr>
<th>Account ID</th>
<th>School Name</th>
<th>Email</th>
<th>TrainedBy</th>
<th>Annotations</th>
<th>SchoolType</th>
<th>PartnershipID</th>
<th>DecileRating</th>
<th>MaoriPercentage</th>
<th>FullTraining</th>
<th>RevisitTraining</th>
<th>PrimaryContact</th>
<th>Principal</th>
<th>PrincipalEmail</th>
<th>Phone Number</th>
<th>Interest</th>
<th>EmailSent</th>
<th>ReplyDate</th>
<th>TrainingBooked</th>
<th>Address</th>
<th>Suburb</th>
<th>City</th>
<th>Country</th>
</tr>";
if($_SESSION['membertype'] == "admin"){
while($row = mysqli_fetch_array($search_result)) {
    echo "<tr><form action=school.php method=post>";
	echo "<td><input readonly type=text name=accID value='" . $row['id'] . "'</td>";
    echo "<td><input type=text name=schoolname value='" . $row['SchoolName'] . "'</td>";
    echo "<td><input type=text name=email value='" . $row['Email'] . "'</td>";
    echo "<td><input type=text name=trainedby value='" . $row['TrainedBy'] . "'</td>";
    echo "<td><input type='text' name=annotations value='" . $row['Annotations'] . "'</td>";
    echo "<td><input type='text' name=schooltype value='" . $row['SchoolType'] . "'</td>";
    echo "<td><input type='text' name=partnershipid value='" . $row['PartnershipID'] . "'</td>";
    echo "<td><input type='text' name=decilerating value='" . $row['DecileRating'] . "'</td>";
    echo "<td><input type='text' name=maoripercentage value='" . $row['MaoriPercentage'] . "'</td>";
    echo "<td><input type='date' name=fulltraining value='" . $row['FullTraining'] . "'</td>";
    echo "<td><input type='date' name=revisittraining value='" . $row['RevisitTraining'] . "'</td>";
    echo "<td><input type='text' name=primarycontact value='" . $row['PrimaryContact'] . "'</td>";
    echo "<td><input type='text' name=principal value='" . $row['Principal'] . "'</td>";
    echo "<td><input type='text' name=principalemail value='" . $row['PrincipalEmail'] . "'</td>";
    echo "<td><input type='text' name=phonenum value='" . $row['PhoneNumber'] . "'</td>";
    echo "<td><input type='text' name=interest value='" . $row['Interest'] . "'</td>";
    echo "<td><input type='date' name=emailsent value='" . $row['EmailSent'] . "'</td>";
    echo "<td><input type='date' name=replydate value='" . $row['ReplyDate'] . "'</td>";
    echo "<td><input type='text' name=trainingbooked value='" . $row['TrainingBooked'] . "'</td>";
	echo "<td><input type=text name=address value='".$row['Address'] . "'</td>";
	echo "<td><input type=text name=suburb value='".$row['Suburb'] . "'</td>";
    echo "<td><input type=text name=city value='".$row['City'] . "'</td>";
    echo "<td><input type=text name=country value='".$row['Country'] . "'</td>";
    echo "<td><input type=submit name='sub'></td>";
	echo "<td><input type=submit name='remove' value='Remove'></td>";

    echo "</form></tr>";


    echo "</tr>";
	}
echo "</table>";
}
else if($_SESSION['membertype'] == "volunteer"){
while($row = mysqli_fetch_array($search_result)) {
   
	echo "<td>".$row['id']. "</td>";
    echo "<td>" . $row['SchoolName'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['TrainedBy'] . "</td>";
    echo "<td>" . $row['Annotations'] . "</td>";
    echo "<td>" . $row['SchoolType'] . "</td>";
    echo "<td>" . $row['PartnershipID'] . "</td>";
    echo "<td>" . $row['DecileRating'] . "</td>";
    echo "<td>" . $row['MaoriPercentage'] . "</td>";
    echo "<td>" . $row['FullTraining'] . "'</td>";
    echo "<td>" . $row['RevisitTraining'] . "</td>";
    echo "<td>" . $row['PrimaryContact'] . "</td>";
    echo "<td>" . $row['Principal'] . "</td>";
    echo "<td>" . $row['PrincipalEmail'] . "</td>";
    echo "<td>" . $row['PhoneNumber'] . "</td>";
    echo "<td>" . $row['Interest'] . "</td>";
    echo "<td>" . $row['EmailSent'] . "</td>";
    echo "<td>" . $row['ReplyDate'] . "</td>";
    echo "<td>" . $row['TrainingBooked'] . "</td>";
	echo "<td>".$row['Address'] . "</td>";
	echo "<td>".$row['Suburb'] . "</td>";
    echo "<td>".$row['City'] . "</td>";
    echo "<td>".$row['Country'] . "</td>";
    echo "</tr>";
	}
echo "</table>";
}
?>
        </form>
        </div>
      </div>
	  
	  	  	<?php
		
	if($_SESSION['membertype'] == "admin"){
		
echo '<div class ="contents" style="display: none" id="school"><b>Please fill in the member information and click Create button</b><br>';
echo ' <form method="post" action="school.php">
<div class="form-group row">
    <label for="username" class="col-4 col-form-label">Username</label> 
    <div class="col-8">
      <input id="username" name="username" placeholder="Username" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-4 col-form-label">Password</label> 
    <div class="col-8">
      <input id="password" name="password" placeholder="Enter Password" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="col-4 col-form-label">Email</label> 
    <div class="col-8">
      <input id="email" name="email" placeholder="Enter Email" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="schoolname" class="col-4 col-form-label">School Name</label> 
    <div class="col-8">
      <input id="title" name="schoolname" placeholder="School Name" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="trainedby" class="col-4 col-form-label">Trained By</label> 
    <div class="col-8">
      <input id="trainedby" name="trainedby" placeholder="Enter Trainedby" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="annotations" class="col-4 col-form-label">Annotations</label> 
    <div class="col-8">
      <input id="annotations" name="annotations" placeholder="Enter Annotations" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="schooltype" class="col-4 col-form-label">School Type</label> 
    <div class="col-8">
      <input id="schooltype" name="schooltype" placeholder="Enter School Type" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="partnershipID" class="col-4 col-form-label">Partnership ID</label> 
    <div class="col-8">
      <input id="partnershipID" name="partnershipID" placeholder="Enter Partnership ID" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="decilerating" class="col-4 col-form-label">Decilerating</label> 
    <div class="col-8">
      <input id="decilerating" name="decilerating" placeholder="Enter DecileRating" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="maoripercentage" class="col-4 col-form-label">Maori Percentage</label> 
    <div class="col-8">
      <input id="maoripercentage" name="maoripercentage" placeholder="Enter MaoriPercentage" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="fulltraining" class="col-4 col-form-label">Full Training</label> 
    <div class="col-8">
      <input id="fulltraining" name="fulltraining" type="date" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="revisittraining" class="col-4 col-form-label">Revisit Training</label> 
    <div class="col-8">
      <input id="revisittraining" name="revisittraining" type="date" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="primarycontact" class="col-4 col-form-label">Primary Contact</label> 
    <div class="col-8">
      <input id="primarycontact" name="primarycontact" placeholder="Enter Primary Contact" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="principal" class="col-4 col-form-label">Principal</label> 
    <div class="col-8">
      <input id="principal" name="principal" placeholder="Enter Principal" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="principalemail" class="col-4 col-form-label">Principal Email</label> 
    <div class="col-8">
      <input id="principalemail" name="principalemail" placeholder="Enter Principal Email" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="phonenumber" class="col-4 col-form-label">Phone Number</label> 
    <div class="col-8">
      <input id="phonenumber" name="phonenumber" placeholder="Enter Phone Number" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="interest" class="col-4 col-form-label">Interest</label> 
    <div class="col-8">
      <input id="interest" name="interest" placeholder="Enter Interest" type="text" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="emailsent" class="col-4 col-form-label">Email Sent</label> 
    <div class="col-8">
      <input id="emailsent" name="emailsent" type="date" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="replydate" class="col-4 col-form-label">Reply Date</label> 
    <div class="col-8">
      <input id="replydate" name="replydate"  type="date" class="form-control">
    </div>
  </div>
    <div class="form-group row">
    <label for="trainingbooked" class="col-4 col-form-label">Training Booked</label> 
    <div class="col-8">
      <input id="trainingbooked" name="trainingbooked" placeholder="Enter Training Booked" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="street" class="col-4 col-form-label">Address</label> 
    <div class="col-8">
      <input id="street" name="street" placeholder="Enter Address" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="suburb" class="col-4 col-form-label">Suburb</label> 
    <div class="col-8">
      <input id="suburb" name="suburb" placeholder="Enter Suburb" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="city" class="col-4 col-form-label">City</label> 
    <div class="col-8">
      <input id="city" name="city" placeholder="Enter City" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="country" class="col-4 col-form-label">Country</label> 
    <div class="col-8">
      <input id="country" name="country" placeholder="Enter Country" type="text" class="form-control">
    </div>
  </div> 
    <div class="form-group row">
    <div class="col-8">
<b><input type="submit" class="radio" value ="Create" name="submitButtonSchool"></b><br>
<br><button id="viewT"><b>View Tables</b></button><br><br>
    </div>
  </div> </form></div>
  ';

	}
?>
      <!-- /.container-fluid -->


    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
    </body>
</html>