<?php
    // Check if user has requested to get detail
    if (isset($_POST["get_data"]))
    {
        // Get the ID of customer user has selected
        $id = $_POST["id"];

        // Connecting with database
        $connection = mysqli_connect("localhost", "root", "", "classicmodels");

        // Getting specific customer's detail
        $sql = "SELECT * FROM customers WHERE customerNumber='$id'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_object($result);

        // Important to echo the record in JSON format
        echo json_encode($row);

        // Important to stop further executing the script on AJAX by following line
        exit();
    }
?>

<?php
    // Connecting with database and executing query
    $connection = mysqli_connect("localhost", "root", "", "classicmodels");
    $sql = "SELECT * FROM customers";
    $result = mysqli_query($connection, $sql);
?>

<!-- Include bootstrap & jQuery -->
<link rel="stylesheet" href="bootstrap.css" />
<script src="jquery-3.3.1.min.js"></script>
<script src="bootstrap.js"></script>

<!-- Creating table heading -->
<div class="container">
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <!-- Display dynamic records from database -->
        <?php while ($row = mysqli_fetch_object($result)) { ?>
            <tr>
                <td><?php echo $row->customerNumber; ?></td>
                <td><?php echo $row->customerName; ?></td>
                <td><?php echo $row->phone; ?></td>
                <!--Button to display details -->
        <td>
            <button class = "btn btn-primary" onclick="loadData(this.getAttribute('data-id'));" data-id="<?php echo $row->customerNumber; ?>">
                Details
            </button>
        </td>
            </tr>
        <?php } ?>
    </table>
</div>

<script>
    function loadData(id) {
        console.log(id);
        $.ajax({
            url: "index.php",
            method: "POST",
            data: {get_data: 1, id: id},
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                var html = "";

                // Displaying city
                html += "<div class='row'>";
                    html += "<div class='col-md-6'>City</div>";
                    html += "<div class='col-md-6'>" + response.city + "</div>";
                html += "</div>";

                // And now assign this HTML layout in pop-up body
                $("#modal-body").html(html);

                $("#myModal").modal();
            }
        });
    }
</script>

<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         
         <div class = "modal-header">
            <h4 class = "modal-title">
               Customer Detail
            </h4>

            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
               ×
            </button>
         </div>
         
         <div id = "modal-body">
            Press ESC button to exit.
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               OK
            </button>
         </div>
         
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
   
</div><!-- /.modal -->