<?php
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
$sqlQuery = "SELECT id, Title, FirstName, LastName FROM nonmember LIMIT 5";
$resultSet = mysqli_query($con, $sqlQuery) or die("database error:". mysqli_error($con));
?>
<table id="editableTable" class="table table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>First Name</th>
			<th>Last Name</th>													
		</tr>
	</thead>
	<tbody>
		<?php while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
		   <tr id="<?php echo $developer ['id']; ?>">
		   <td><?php echo $developer ['id']; ?></td>
		   <td><?php echo $developer ['Title']; ?></td>
		   <td><?php echo $developer ['FirstName']; ?></td>
		   <td><?php echo $developer ['LastName']; ?></td>  				   				   				  
		   </tr>
		<?php } ?>
	</tbody>
</table>
