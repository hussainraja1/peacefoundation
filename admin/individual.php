<?php
//This page is for individual member search

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
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
$nid = $_POST['Nid'];	
$title = trim($_POST['title']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$phonenum = trim($_POST['phonenum']);
$dob = trim($_POST['dob']);
$comments = trim($_POST['comments']);
$status = trim($_POST['status']);
$address = trim($_POST['address']);
$suburb = trim($_POST['suburb']);
$city = trim($_POST['city']);
$country = trim($_POST['country']);

if(!empty($title)&&!empty($firstname)&&!empty($lastname)&&!empty($phonenum)&&!empty($dob)&&!empty($comments)&&!empty($status)&&!empty($address)&&!empty($suburb)&&!empty($city)&&!empty($country)){
	
$query =  "

	UPDATE nonmember, address SET nonmember.title='$title',
	nonmember.firstname='$firstname',
	nonmember.lastname='$lastname',
	nonmember.phonenum='$phonenum',
	nonmember.dob='$dob',
	nonmember.comments='$comments',
	nonmember.status ='$status',
	address.address='$address',
	address.suburb='$suburb',
	address.city='$city',
	address.country='$country'
	WHERE nonmember.id=address.id
	AND nonmember.nonmemberid = $nid;";
	
	$search_result = filterTable($query);

}
else{
echo '<script>alert("Please enter the something in the fields");</script>';	
}
}
//If Remove Button is set, remove the associated contents of the nonmember, account and address tables
else if(isset($_POST['remove'])){

$accID = $_POST['accID'];	

	$query ="DELETE nonmember, address, accounts FROM nonmember 
LEFT join address on nonmember.id = address.id
LEFT join accounts on nonmember.id = accounts.id
where nonmember.id = $accID;";


    $search_result = filterTable($query);

}		
}

if(isset($_POST['search']) && isset($_POST['searchIN']))
{
	$searchColumn = $_POST['searchIN'];
    $valueToSearch = $_POST['valueToSearch'];
	
    // search in all table columns
    // using concat mysql function
    $query = "SELECT nonmember.NonMemberID,nonmember.id,nonmember.Title,nonmember.FirstName,nonmember.LastName,nonmember.PhoneNum,nonmember.DOB,nonmember.Comments,nonmember.status,address.Address,address.City,address.Suburb,address.Country
FROM address ,nonmember
WHERE  address.id =nonmember.id AND $searchColumn LIKE '%".$valueToSearch."%'";

    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT nonmember.NonMemberID,nonmember.id,nonmember.Title,nonmember.FirstName,nonmember.LastName,nonmember.PhoneNum,nonmember.DOB,nonmember.Comments,nonmember.status,address.Address,address.City,address.Suburb,address.Country
FROM address ,nonmember
WHERE  address.id =nonmember.id";
    $search_result = filterTable($query);
}

if(isset($_POST['submitButtonIndividual'])){
	include('../db.php');

$username = mysqli_real_escape_string($con, $_REQUEST['username']);
$password = mysqli_real_escape_string($con, $_REQUEST['password']);
$email = mysqli_real_escape_string($con, $_REQUEST['email']);
$membertype = mysqli_real_escape_string($con, $_REQUEST['membertype']);

$title = mysqli_real_escape_string($con, $_REQUEST['title']);
$firstname = mysqli_real_escape_string($con, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($con, $_REQUEST['lastname']);
$dob = mysqli_real_escape_string($con, $_REQUEST['dob']);
$phonenum = mysqli_real_escape_string($con, $_REQUEST['phonenumber']);
$comments = mysqli_real_escape_string($con, $_REQUEST['comments']);
$status = mysqli_real_escape_string($con, $_REQUEST['status']);

$address = mysqli_real_escape_string($con, $_REQUEST['address']);
$city = mysqli_real_escape_string($con, $_REQUEST['city']);
$suburb = mysqli_real_escape_string($con, $_REQUEST['suburb']);
$country = mysqli_real_escape_string($con, $_REQUEST['country']);

 
// Attempt insert query execution
$sql = "INSERT INTO accounts (id, Username, Password,Email,membertype) VALUES (Null, '$username','$password', '$email','$membertype')";
if(mysqli_query($con, $sql)){
$user_id = mysqli_insert_id($con);
$sql_information = "INSERT INTO nonmember (NonMemberID, id, Title,FirstName,LastName,PhoneNum,DOB,Comments,status) VALUES (Null, '$user_id','$title', '$firstname','$lastname','$phonenum','$dob', '$comments','$status')";
$sql_address = "INSERT INTO address (AddressID, id, Address,City,Suburb,Country) VALUES (Null, '$user_id','$address', '$city','$suburb','$country')";

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
  $("#individualB").click(function(){
    $("#tableview").hide();
	$("#individual").show();
  });
  $("#viewT").click(function(){
    $("#tableview").show();
	$("#individual").hide();
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

    <a class="navbar-brand mr-1" href="index.php">Start Bootstrap</a>

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
          <a class="dropdown-item" href="resetp.php">User Password Reset</a>
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
			echo "<button id='individualB'>Add New Member</button> <b><-- Click to add a new member, admin or volunteer</b><br><br>";
			}
			?>

        <form action="individual.php" method="post">
			
			<p><b>Please select the the column you want to search in, type in the keyword and click filter button to search:</b></p>
			<select id='selectColumn' name="searchIN">
  <option  value="nonmember.NonMemberID">Member ID</option>
  <option  value="nonmember.Title">Title</option>
  <option  value="nonmember.FirstName">First Name </option>
  <option  value="nonmember.LastName">Last Name</option>
  <option  value="nonmember.PhoneNum">Phone Number</option>
  <option  value="nonmember.DOB"> Date of Birth </option>
  <option  value="nonmember.Comments"> Comments</option>
  <option  value="nonmember.status"> Status</option>  
  <option  value="address.Address"> Address</option>
  <option  value="address.City"> City</option>
  <option  value="address.Suburb"> Suburb</option>
  <option  value="address.Country"> Country</option>

</select>
            <input type="text" name="valueToSearch" placeholder="Keyword To Search"><br><br>
            <!-- <div class="container">
            <br><input type="text" name="valueToSearch" id="valueToSearch" class="form-control" placeholder="Enter search value..." /><br>
            <div id="searchTable"></div>
            </div> -->

            <input type="submit" name="search" value="Filter">
            <input type="submit" name="all" value="Show All Rows"><br><br>
			

<div class ="tablecontent" id= "tableview">
     <?php          echo "<table width='100%'>
<tr>
<th>NonMemberID</th>
<th>Account ID</th>
<th>Title</th>
<th>First name</th>
<th>Last name</th>
<th>Phone Number</th>
<th>Date of Birth</th>
<th>Comments</th>
<th>Membership Status</th>
<th>Address</th>
<th>Suburb</th>
<th>City</th>
<th>Country</th>
</tr>";
if($_SESSION['membertype'] == "admin"){
while($row = mysqli_fetch_array($search_result)) {
	
    echo "<tr><form action=individual.php method=post>";
	echo "<td><input readonly type=text name=Nid value='".$row['NonMemberID']. "'</td>";
	echo "<td><input readonly type=text name=accID value='".$row['id']. "'</td>";
    echo "<td><input type=text name=title value='".$row['Title'] . "'</td>";
    echo "<td><input type=text name=firstname value='".$row['FirstName'] . "'</td>";
    echo "<td><input type=text name=lastname value='".$row['LastName'] . "'</td>";
    echo "<td><input type=text name=phonenum value='".$row['PhoneNum'] . "'</td>";
    echo "<td><input type=text name=dob value='".$row['DOB'] . "'</td>";
    echo "<td><input type=text name=comments value='".$row['Comments'] . "'</td>";
    echo "<td><input type=text name=status value='".$row['status'] . "'</td>";	
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
	
	echo "<tr>";
	echo "<td>".$row['NonMemberID']. "</td>";
	echo "<td>".$row['id']. "</td>";
    echo "<td>".$row['Title'] . "</td>";
    echo "<td>".$row['FirstName'] . "</td>";
    echo "<td>".$row['LastName'] . "</td>";
    echo "<td>".$row['PhoneNum'] . "</td>";
    echo "<td>".$row['DOB'] . "</td>";
    echo "<td>".$row['Comments'] . "</td>";
    echo "<td>".$row['status'] . "</td>";	
    echo "<td>".$row['Address'] . "</td>";
	echo "<td>".$row['Suburb'] . "</td>";
    echo "<td>".$row['City'] ."</td>";
    echo "<td>".$row['Country'] ."</td>";


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
	
	
echo '<div class ="contents" style="display: none" id="individual"><b>Please fill in the member information and click Create button</b><br>';
echo ' <form method="post" action="individual.php">
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
    <label for="title" class="col-4 col-form-label">Title</label> 
    <div class="col-8">
      <input id="title" name="title" placeholder="Enter Title E.g. Mr/Mrs" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="firstname" class="col-4 col-form-label">First Name</label> 
    <div class="col-8">
      <input id="firstname" name="firstname" placeholder="Enter Firstname" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="lastname" class="col-4 col-form-label">Last Name</label> 
    <div class="col-8">
      <input id="lastname" name="lastname" placeholder="Enter Lastname" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="phonenumber" class="col-4 col-form-label">Phone Number</label> 
    <div class="col-8">
      <input id="phonenumber" name="phonenumber" placeholder="Enter Phone Number" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="dob" class="col-4 col-form-label">Date of Birth</label> 
    <div class="col-8">
      <input id="dob" name="dob" type="date" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="comments" class="col-4 col-form-label">Comments</label> 
    <div class="col-8">
      <input id="comments" name="comments" placeholder="Enter Comments" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="status" class="col-4 col-form-label">Membership Status</label> 
    <div class="col-8">
      <input id="status" name="status" placeholder="Enter Membership Status" type="text" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="address" class="col-4 col-form-label">Address</label> 
    <div class="col-8">
      <input id="address" name="address" placeholder="Enter Address" type="text" class="form-control">
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
    <label for="radio" class="col-4 col-form-label">Membership Type</label> 
    <div class="col-8">
      Make Volunteer<input type="radio"  name="membertype" value="volunteer" required>
	  Make Individual<input type="radio"  name="membertype" value="individual" required>
	  Make Admin<input type="radio"  name="membertype" value="admin" required>
    </div>
  </div> 
    <div class="form-group row">
    <div class="col-8">
<b><input type="submit" value ="Create" name="submitButtonIndividual"></b><br>
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
<script>
    $(document).ready(function(){
        $('#valueToSearch').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    url:"search.php",
                    method:"POST",
                    data:{query:query},
                    success:function(data)
                    {
                        $('#searchTable').fadeIn();
                        $('#searchTable').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function(){
            $('#valueToSearch').val($(this).text());
            $('#searchTable').fadeOut();
        });
    });
</script>