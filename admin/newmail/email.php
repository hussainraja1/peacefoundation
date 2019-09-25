<?php

require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
 
$from = "123phptest@gmail.com";
$to = "123phptest@gmail.com";
$subject = 'Call Me!';
 
$headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);
 
// text and html versions of email.
$text = 'Hi son, what are you doing?nnHeres an picture of a cat for you.';
$html = 'Hi son, what are you doing?<br /><br />Heres an picture of a cat for you.';
 
// attachment
$file = 'INV-0001.pdf';
$crlf = "n";
 
$mime = new Mail_mime($crlf);
$mime->setTXTBody($text);
$mime->setHTMLBody($html);
//$mime->addAttachment($file, 'application/pdf', 'INV-0001.pdf', false, 'base64');
 
$body = $mime->get();

$headers = $mime->headers($headers);

$host = "ssl://smtp.gmail.com";
$port = "465";
$username = "123phptest@gmail.com";
$password = "pass123.22";
 
$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true,
 'username' => $username,'password' => $password, 'port' => $port));
 
$mail = $smtp->send($to, $headers, $body);
 
if (PEAR::isError($mail)) {
    echo("<p>" . $mail->getMessage() . "</p>");
}
else {
    echo("<p>Message successfully sent!</p>");
}
?>