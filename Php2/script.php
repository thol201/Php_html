 <?php
error_reporting(E_ERROR | E_PARSE);     
  
$name = trim($_POST['name']);
$mail = trim($_POST['mail']);
$mess = trim($_POST['mess']);
date_default_timezone_set('UTC');
$for='31480,,2@stud.umk.pl';
$tem = 'Wiadomość ze strony WWW';
$prot = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$web = "$prot://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$date = date('j.m.Y \o \g\o\d\z\. H:m:s');


$text= 'Wiadomość ze strony: '.$web.PHP_EOL.'<br>Imię i Nazwisko: '.$name.'<br>Adres Email: '.$mail.'<br>Treść Wiadomości:<br>'.nl2br($mess).'<br>Wiadomość wysłana dnia '.$date;

$tem = '=?UTF-8?B?' . base64_encode($tem) . '?=';
$lab  = 'Content-type: text/html; charset=UTF-8' . PHP_EOL;
$lab .= 'From: =?UTF-8?B?' . base64_encode($name) . "?= <$mail>" . PHP_EOL;
if (mail($for, $tem, $text, $lab)) {
    echo 1;
} else {
    echo 2;
}


 ?>