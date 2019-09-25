<?php
// Pear Mail Library
require_once "Mail.php";

$from = '<hussainraja2099@gmail.com>';
$to = '<hussainraja2099@gmail.com>';
$subject = 'Hi!';
$body = "Hi,\n\nThis is a sample body text.";

$headers = array(
'From' => $from,
'To' => $to,
'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
'host' => 'ssl://smtp.gmail.com',
'port' => '465',
'auth' => true,
'username' => 'hussainraja2099@gmail.com',
'password' => 'rudb8Ck!a'
));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
echo('<p>' . $mail->getMessage() . '</p>');
} else {
echo('<p>Message successfully sent!</p>');
}
?>


