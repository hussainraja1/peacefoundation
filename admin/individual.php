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
$address = trim($_POST['address']);
$suburb = trim($_POST['suburb']);
$city = trim($_POST['city']);
$country = trim($_POST['country']);

if(!empty($title)&&!empty($firstname)&&!empty($lastname)&&!empty($phonenum)&&!empty($dob)&&!empty($comments)&&!empty($address)&&!empty($suburb)&&!empty($city)&&!empty($country) ){
	
$query =  "

	UPDATE nonmember, address SET nonmember.title='$title',
	nonmember.firstname='$firstname',
	nonmember.lastname='$lastname',
	nonmember.phonenum='$phonenum',
	nonmember.dob='$dob',
	nonmember.comments='$comments',
	address.address='$address',
	address.suburb='$suburb',
	address.city='$city',
	address.country='$country'
	WHERE nonmember.NonMemberID=address.addressid
	AND nonmember.nonmemberid = $nid;";
	
	$search_result = filterTable($query);

}
else{
echo '<script>alert("Please enter the something in the damn fields");</script>';	
}


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
    $query = "SELECT nonmember.NonMemberID,nonmember.Title,nonmember.FirstName,nonmember.LastName,nonmember.PhoneNum,nonmember.DOB,nonmember.Comments,address.Address,address.City,address.Suburb,address.Country
FROM address ,nonmember
WHERE  address.id =nonmember.id AND $searchColumn LIKE '%".$valueToSearch."%'";

    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT nonmember.NonMemberID,nonmember.Title,nonmember.FirstName,nonmember.LastName,nonmember.PhoneNum,nonmember.DOB,nonmember.Comments,address.Address,address.City,address.Suburb,address.Country
FROM address ,nonmember
WHERE  address.id =nonmember.id";
    $search_result = filterTable($query);
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
    exit();

}
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
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
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
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
          <a class="dropdown-item" href="tables.php">Display Members</a>
          <a class="dropdown-item" href="edituser.php">Edit Members</a>
          <a class="dropdown-item" href="resetp.php">User Password Reset</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Admin Settings:</h6>
          <a class="dropdown-item" href="createadmin.php">Create Admin</a>
          <a class="dropdown-item" href="removeadmin.php">Remove Admin</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">
		  
    </head>
    <body>
        
        <form action="individual.php" method="post">
			
			<p>Please select the the column you want to search in, type in the keyword and click filter button to search:</p>
			  <input type="radio" name="searchIN" value="nonmember.NonMemberID">Member ID
			  <input type="radio" name="searchIN" value="nonmember.Title"> Title
			  <input type="radio" name="searchIN" value="nonmember.FirstName"> First Name 
			  <input type="radio" name="searchIN" value="nonmember.LastName"> Last Name
			  <input type="radio" name="searchIN" value="nonmember.PhoneNum"> Phone Number
			  <input type="radio" name="searchIN" value="nonmember.DOB"> Date of Birth
			  <input type="radio" name="searchIN" value="nonmember.Comments"> Comments
			  <input type="radio" name="searchIN" value="address.Address"> Address
			  <input type="radio" name="searchIN" value="address.City"> City
			  <input type="radio" name="searchIN" value="address.Suburb"> Suburb
			  <input type="radio" name="searchIN" value="address.Country"> Country<br>
            <input type="text" name="valueToSearch" placeholder="Keyword To Search"><br><br>

            <input type="submit" name="search" value="Filter"><br><br>
            <input type="submit" name="all" value="Show All Rows"><br><br>
			
			
<div class ="tablecontent">
     <?php          echo "<table width='100%'>
<tr>
<th>NonMemberID</th>
<th>Title</th>
<th>First name</th>
<th>Last name</th>
<th>Phone Number</th>
<th>Date of Birth</th>
<th>Comments</th>
<th>Address</th>
<th>Suburb</th>
<th>City</th>
<th>Country</th>
</tr>";
if($_SESSION['membertype'] == "admin"){
while($row = mysqli_fetch_array($search_result)) {
	
    echo "<tr><form action=individual.php method=post>";
	echo "<td><input readonly type=text name=Nid value='".$row['NonMemberID']. "'</td>";
    echo "<td><input type=text name=title value='".$row['Title'] . "'</td>";
    echo "<td><input type=text name=firstname value='".$row['FirstName'] . "'</td>";
    echo "<td><input type=text name=lastname value='".$row['LastName'] . "'</td>";
    echo "<td><input type=text name=phonenum value='".$row['PhoneNum'] . "'</td>";
    echo "<td><input type=text name=dob value='".$row['DOB'] . "'</td>";
    echo "<td><input type=text name=comments value='".$row['Comments'] . "'</td>";
    echo "<td><input type=text name=address value='".$row['Address'] . "'</td>";
	echo "<td><input type=text name=suburb value='".$row['Suburb'] . "'</td>";
    echo "<td><input type=text name=city value='".$row['City'] . "'</td>";
    echo "<td><input type=text name=country value='".$row['Country'] . "'</td>";
	echo "<td><input type=submit name='sub'>";
	echo "</form></tr>";


    echo "</tr>";
	}
echo "</table>";
}
else if($_SESSION['membertype'] == "volunteer"){
while($row = mysqli_fetch_array($search_result)) {
	
	echo "<td>".$row['NonMemberID']. "</td>";
    echo "<td>".$row['Title'] . "</td>";
    echo "<td>".$row['FirstName'] . "</td>";
    echo "<td>".$row['LastName'] . "</td>";
    echo "<td>".$row['PhoneNum'] . "</td>";
    echo "<td>".$row['DOB'] . "</td>";
    echo "<td>".$row['Comments'] . "</td>";
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
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

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
          <a class="btn btn-primary" href="login.html">Logout</a>
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