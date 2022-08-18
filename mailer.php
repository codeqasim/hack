<?php 

$random_hash = md5(date('r', time()));

$subject  = 'PHPTRAVELS Information';
$headers  = "From: PHPTRAVELS <info@phptravels.com>\r\nReply-To: PHPTRAVELS <info@phptravels.com>"; 
// $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

ob_start(); ?>

<?php 
include "mailer_template.php";
?>

<?php

$message = ob_get_clean();
$emails = file('mailer_emails.txt', FILE_IGNORE_NEW_LINES);
$x = 1;
foreach ($emails as $email) {
	$mail_sent = @mail($email, $subject, $message, $headers);
	echo $mail_sent ? $x . ', ' : '0, '; 
	$x++;
}
