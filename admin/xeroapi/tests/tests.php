<?php
echo'

<!DOCTYPE html>
<html>
    <head>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


	
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

  <title>SB Admin - Invoices</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

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
        <a class="nav-link" href="../index.php">
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
          <a class="dropdown-item" href="../tables.php">Display&Edit Members</a>
          <a class="dropdown-item" href="../resetp.php">User Password Reset</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
    </ul>

    <div id="content-wrapper">
		  
    </head>
    <body>
';
if (isset($_REQUEST)){
	if (!isset($_REQUEST['where'])) $_REQUEST['where'] = "";
}
	
if ( isset($_REQUEST['wipe'])) {
  session_destroy();
  header("Location: {$here}");

// already got some credentials stored?
} elseif(isset($_REQUEST['refresh'])) {
    $response = $XeroOAuth->refreshToken($oauthSession['oauth_token'], $oauthSession['oauth_session_handle']);
    if ($XeroOAuth->response['code'] == 200) {
        $session = persistSession($response);
        $oauthSession = retrieveSession();
    } else {
        outputError($XeroOAuth);
        if ($XeroOAuth->response['helper'] == "TokenExpired") $XeroOAuth->refreshToken($oauthSession['oauth_token'], $oauthSession['session_handle']);
    }

} elseif ( isset($oauthSession['oauth_token']) && isset($_REQUEST) ) {

    $XeroOAuth->config['access_token']  = $oauthSession['oauth_token'];
    $XeroOAuth->config['access_token_secret'] = $oauthSession['oauth_token_secret'];
    $XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];


    
	//PRINT THE TOTAL NUMBER OF INVOICE DETAILS
    if (isset($_REQUEST['invoice'])) {
        if (!isset($_REQUEST['method'])) {
            $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoices', 'core'), array('order' => 'Total DESC'));
            if ($XeroOAuth->response['code'] == 200) {
                $invoices = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                echo "There are " . count($invoices->Invoices[0]). " invoices in this Xero organisation, the first one is: </br>";
               $invoiceNumber =  count($invoices->Invoices[0]);
			   $x=0;
				$count = 1;
			   		echo'<div class ="tablecontent" id= "tableview">';
			echo "<table width='100%'>
			<tr>
			<th>Send Email</th>
			<th>name</th>
			<th>date</th>
			<th>duedate</th>
			<th>status</th>
			<th>subtotal</th>
			<th>totaltax</th>
			<th>total</th>
			<th>InvoiceID</th>
			<th>InvoiceNumber</th>
			<th>AmountDue</th>
			<th>AmountPaid</th>
			<th>AmountCredited</th>
			</tr>";
			   for ($x; $x < $invoiceNumber; $x++) {
			
			$name = $invoices->Invoices[0]->Invoice[$x]->Contact->Name;
		    $date = $invoices->Invoices[0]->Invoice[$x]->Date;
		    $duedate = $invoices->Invoices[0]->Invoice[$x]->DueDate;
		    $status = $invoices->Invoices[0]->Invoice[$x]->Status;
			$subtotal = $invoices->Invoices[0]->Invoice[$x]->SubTotal;
			$totaltax = $invoices->Invoices[0]->Invoice[$x]->TotalTax;
			$total = $invoices->Invoices[0]->Invoice[$x]->Total;
			$InvoiceID = $invoices->Invoices[0]->Invoice[$x]->InvoiceID;
			$InvoiceNumber = $invoices->Invoices[0]->Invoice[$x]->InvoiceNumber;
			$AmountDue = $invoices->Invoices[0]->Invoice[$x]->AmountDue;
			$AmountPaid = $invoices->Invoices[0]->Invoice[$x]->AmountPaid;
			$AmountCredited = $invoices->Invoices[0]->Invoice[$x]->AmountCredited;

			echo "<form id='sendingemail' action='?invoice=pdf' method='POST'>";


			echo"<tr>";
			echo "<td> <input type='checkbox' value=$x name='checkbox[]'></td>";
			echo "<td>".$name."</td>";
			echo "<td>".$date."</td>";
			echo "<td>".$duedate."</td>";
			echo "<td>".$status."</td>";
			echo "<td>NZ$".$subtotal."</td>";
			echo "<td>NZ$".$totaltax."</td>";
			echo "<td> NZ$".$total."</td>";
			echo "<td>".$InvoiceID."</td>";
			echo "<td>".$InvoiceNumber."</td>";
			echo "<td>NZ$".$AmountDue."</td>";
			echo "<td>NZ$".$AmountPaid."</td>";
			echo "<td>NZ$".$AmountCredited."</td>";
	    echo "</tr>";
			$count++;
				}
						

 echo "</table><br><input type='submit' value='Download'></form></div>";

                if ($_REQUEST['invoice']=="pdf") {
                    $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoice/'.$invoices->Invoices[0]->Invoice->InvoiceID, 'core'), array(), "", 'pdf');
				
					if ($XeroOAuth->response['code'] == 200) {
					$invoiceNumber =  count($invoices->Invoices[0]);
			$counting = 0;
			$objectNo=0;
			if(!empty($_POST['checkbox'])){
				//Count the check boxes with their values
				foreach($_POST['checkbox'] as $objectNo) {
			          
					  $newON = (int)$objectNo;
					   //File PDF download location EDIT ACCORDING TO THE USER
					   $fileLocation = "../../../../../Users/Hussain/Desktop/Invoices/";
                       $myFile = $fileLocation.$invoices->Invoices[0]->Invoice[$newON]->InvoiceNumber.".pdf";
                       $fh = fopen($myFile, 'w') or die("can't open file");
                       fwrite($fh, $XeroOAuth->response['response']);
					   fclose($fh);

						$counting++;
				}
				 echo "<br>",$counting, " number of PDF downloaded...</br>";
			}
			else{
				echo "Please check the boxes and submit it..";
			}
                    } else {
                        outputError($XeroOAuth);
                    }
                }
            } else {
                outputError($XeroOAuth);
            }

    }

}
}
