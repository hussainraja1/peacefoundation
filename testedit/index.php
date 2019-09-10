<?php 
include("inc/header.php"); 
?>
<title>webdamn.com : Demo Create Editable Bootstrap Table with jQuery, PHP & MySQL</title>
<?php include('inc/container.php');?>
<style>
table {
    background-color: #181818;
}
table, .table {
    color: #fff;
}
</style>
<div class="container">	
	<div class="row">
		<h2>Example: Create Editable Bootstrap Table with jQuery, PHP & MySQL</h2>		
		<?php
		include_once("inc/db_connect.php");
		$sqlQuery = "SELECT id, Title, FirstName, LastName FROM nonmember LIMIT 5";
		$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
		?>
		<table id="editableTable" class="table table-bordered">
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>FirstName</th>
					<th>LastName</th>													
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
  </div>
</div>
<script src="plugin/bootstable.js"></script>
<script src="js/editable.js"></script>
<?php include('inc/footer.php');?>




  