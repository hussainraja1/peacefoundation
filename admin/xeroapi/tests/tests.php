<?php
require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge

		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'peacefoundation';
		// Try and connect using the info above.
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if ( mysqli_connect_errno() ) {
			// If there is an error with the connection, stop the script and display the error.
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
			exit();

		}
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

    <a class="navbar-brand mr-1" href="../index.php"><img src="../logo_1.png"  title="Peace Logo" alt="Logo"></a>

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


//PRINT CONTACTS
  if (isset($_REQUEST['contact'])) {
        $response = $XeroOAuth->request('GET', $XeroOAuth->url('Contacts', 'core'), array());

        if ($XeroOAuth->response['code'] == 200) {
            $contact = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
            echo "There are " . count($contact->Contacts[0]). " contacts in this Xero organisation, the first one is: </br>";
			$contactsCount = count($contact->Contacts[0]);
			 $x=0;
			 
			echo'<div class ="tablecontent" id= "tableview">';
			echo "<table width='100%'>
			<tr>
			<th>Contact ID</th>
			<th>Name</th>
			<th>Email</th>
			</tr>";
			   for ($x; $x < $contactsCount; $x++) {
			
			$ContactID = $contact->Contacts[0]->Contact[$x]->ContactID;
		    $name = $contact->Contacts[0]->Contact[$x]->Name;
		    $email = $contact->Contacts[0]->Contact[$x]->EmailAddress;

			
	

			echo"<tr>";
			echo "<td>".$ContactID."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$email."</td>";
	    echo "</tr>";
				}
		 echo "</table>";
		  echo "<form id='contactsEmail' action='?invoice' method='POST'><br><input type='submit' value='Invoice Details'></form>";
		 //CONNECT TO TEH DATABASE, CHECK IF XEROACCOUNTS TABLE EXISTS, CREATE THE TABLE.

		$query = "SELECT contactID FROM xeroaccounts";
		$result = mysqli_query($con, $query);

		if(empty($result)) {
                $query = "CREATE TABLE xeroaccounts (
                          contactID varchar(255) PRIMARY KEY,
                          name varchar(255) NOT NULL,
                          email varchar(255) NOT NULL UNIQUE
                          )";
                $result = mysqli_query($con, $query);
		}

			$contactsCount = count($contact->Contacts[0]);
			 $x=0;
			 
			   for ($x; $x < $contactsCount; $x++) {
			
			$ContactID = $contact->Contacts[0]->Contact[$x]->ContactID;
		    $name = $contact->Contacts[0]->Contact[$x]->Name;
		    $email = $contact->Contacts[0]->Contact[$x]->EmailAddress;
			
			$query ="INSERT INTO xeroaccounts (contactID, name, email)
SELECT * FROM (SELECT '$ContactID', '$name', '$email') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM xeroaccounts WHERE contactID = '$ContactID'
) LIMIT 1;";
			$result = mysqli_query($con, $query);
				}
		
			
        } else {
            outputError($XeroOAuth);
  }}
	//PRINT THE TOTAL NUMBER OF INVOICE DETAILS
    if (isset($_REQUEST['invoice'])) {
        if (!isset($_REQUEST['method'])) {
            $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoices', 'core'),array('order' => 'Total DESC'));
		   
		   if ($XeroOAuth->response['code'] == 200) {
                $invoices = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);			  
				
		$query = "SELECT invoiceID FROM xeroinvoices";
		$result = mysqli_query($con, $query);

		if(empty($result)) {
                $query = "CREATE TABLE xeroinvoices (
                          invoiceID varchar(255) PRIMARY KEY,
                          contactID varchar(255) not null,
						  emailsent varchar(255) null,
						  foreign key(contactID) references xeroaccounts(contactID) 
                          )";
                $result = mysqli_query($con, $query);
		}
			  
			  echo "There are " . count($invoices->Invoices[0]). " invoices in this Xero organisation, the first one is: </br>";
               $invoiceNumber =  count($invoices->Invoices[0]);
			   $x=0;
				$count = 1;
			   		echo'<div class ="tablecontent" id= "tableview">';
			echo "<table width='100%'>
			<tr>
			<th>Send Email</th>
			<th>Email Sent</th>
			<th>name</th>
			<th>Contact ID</th>
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
			$ContactID = $invoices->Invoices[0]->Invoice[$x]->Contact->ContactID;
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
		
				$query2 = "SELECT invoiceID, emailsent FROM xeroinvoices
						WHERE  InvoiceID = '$InvoiceID'";
				$result = mysqli_query($con, $query2);
												
				$row = mysqli_fetch_assoc($result);		

		$query ="INSERT INTO xeroinvoices (invoiceID, contactID)
				SELECT * FROM (SELECT '$InvoiceID', '$ContactID') AS tmp
				WHERE NOT EXISTS (
					SELECT invoiceID FROM xeroinvoices WHERE invoiceID = '$InvoiceID'
				) LIMIT 1;";
			$result = mysqli_query($con, $query);
			
			echo "<form id='sendingemail' action='?invoice=pdf' method='POST'>";


			echo"<tr>";
			echo "<td> <input type='checkbox' value=$x name='checkbox[]'></td>";
			echo "<td>".$row['emailsent']."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$ContactID."</td>";
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

 echo "</table></div>
 <b>Subject</b><br>
 <input type='text' cols='15' name='subject' rows='1' placeholder='Subject' required>
 <br><b>Email Body Content</b><br>
 
<textarea cols='75' name='text' rows='5' placeholder='Enter Body Paragraph...' required></textarea>
 <br><input type='submit' value='Download & Send Email'><-Note: Sending email may take couple of seconds. Please do not refresh the page.</form>
<form id='contactsEmail' action='?contact' method='POST'><br><input type='submit' value='Contact Details'></form> ";

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
                      $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoice/'.$invoices->Invoices[0]->Invoice[$newON]->InvoiceID, 'core'), array(), "", 'pdf');
						
		
					  

					   //File PDF download location EDIT ACCORDING TO THE USER
					   $fileLocation = "../../../../../Users/Hussain/Desktop/Invoices/";
					   $inID = $invoices->Invoices[0]->Invoice[$newON]->InvoiceID;
       				   $myFile = $fileLocation.$invoices->Invoices[0]->Invoice[$newON]->InvoiceID.".pdf";
                       $fh = fopen($myFile, 'w') or die("can't open file");
                       fwrite($fh, $XeroOAuth->response['response']);
					   fclose($fh);
					  
					  $query = "SELECT xeroinvoices.invoiceID, xeroaccounts.email 
						FROM xeroinvoices ,xeroaccounts
						WHERE  xeroinvoices.contactID = xeroaccounts.contactID 
						AND xeroinvoices.invoiceID = '$inID'";
						$result = mysqli_query($con, $query);
												
						$row = mysqli_fetch_assoc($result);											
						
						
						//EMAIL PART------------------------------------------------------------------------
								$from = "123phptest@gmail.com";
								$to = $row['email'];
								$subject = $_POST['subject'];
								$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
								 
								// text and html versions of email.
								$text = $_POST['text'];
								 
								// attachment
								$pdffile = $row['invoiceID'];
								$file = 'C:\Users\Hussain\Desktop\Invoices\\'.$pdffile.'.pdf';
								$crlf = "\n";

								$mime = new Mail_mime();

								$mime->setTXTBody($text);

								$mime->addAttachment($file, 'application/pdf', false, 'base64');
								 
								$body = $mime->get();
								$headers = $mime->headers($headers);

								$host = "ssl://smtp.gmail.com";
								$port = "465";
								$username = "123phptest@gmail.com";
								$password = "pass123.22";
								 
								$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true,
								 'username' => $username,'password' => $password));
								 
								$mail = $smtp->send($to, $headers, $body);
								 
								if (PEAR::isError($mail)) {
									echo("<p>" . $mail->getMessage() . "</p>");
								}
								else {
									echo "<b>Message successfully sent to:</b> ".$to."<br>";
									$sql = "UPDATE xeroinvoices SET emailsent = 'Yes' WHERE invoiceID = '$pdffile'";
									$done = mysqli_query($con, $sql);

								}
						//EMAIL PART END--------------------------------------------------------------------
						
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
