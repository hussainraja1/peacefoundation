<?php
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
			echo "-----------------INVOICE ".($count)."-----------------<br>";
			
			echo "Name: ".$name."<br>";
			echo "Date: ".$date."<br>";
			echo "Due Date: ".$duedate."<br>";
			echo "Status: ".$status."<br>";
			echo "Sub Total: NZ$".$subtotal."<br>";
			echo "Total Tax: NZ$".$totaltax."<br>";
			echo "Total: NZ$".$total."<br>";
			echo "InvoiceID: ".$InvoiceID."<br>";
			echo "InvoiceNumber: ".$InvoiceNumber."<br>";
			echo "AmountDue: NZ$".$AmountDue."<br>";
			echo "AmountPaid: NZ$".$AmountPaid."<br>";
			echo "AmountCredited: NZ$".$AmountCredited."<br>";
			echo "<br><br>";
			$count++;
				}
			   
                if ($_REQUEST['invoice']=="pdf") {
                    $response = $XeroOAuth->request('GET', $XeroOAuth->url('Invoice/'.$invoices->Invoices[0]->Invoice->InvoiceID, 'core'), array(), "", 'pdf');
                    if ($XeroOAuth->response['code'] == 200) {
                        $myFile = $invoices->Invoices[0]->Invoice->InvoiceID.".pdf";
                        $fh = fopen($myFile, 'w') or die("can't open file");
                        fwrite($fh, $XeroOAuth->response['response']);
                        fclose($fh);
                        echo "PDF copy downloaded, check your the directory of this script.</br>";
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