<?php

require_once(dirname(__FILE__) . '/../../../wp-load.php');

$to = 'husyakw@gmail.com.com';
$subject = 'E-mail';

$message = ' Email: ' . $_POST['email'] ;

$headers = array(
  "From:  blog-aqva.com",
);

if (wp_mail($to, $subject, $message, $headers)) {
  exit;
}

exit;
