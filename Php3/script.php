<?php

error_reporting(E_ALL ^ E_WARNING); 
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    echo 'Zostaniesz wyglogowany ze 3 sekundy';
    header("refresh: 3; url=index.html");
}
else if (isset($_SESSION['name'])) 
{
echo 'Witaj '.$_SESSION['name'];
}
else
{
    
$database = new PDO('sqlite:database.db');
$login = trim($_POST['name']);
$pass = trim($_POST['pass']);
$sql ='SELECT * FROM users WHERE username = :username AND password = :password';
$statement = $database->prepare("SELECT * FROM users WHERE username = :name AND password = :pass");
$statement->execute(array(':name' => $login, ':pass' => $pass));
$row = $statement->fetch();
        if ($row['username'] == $login && $row['password'] == $pass){
            echo "<h1>Witaj " .$row['username']. "</h1>zostałeś poprawnie zalogowany(<a href='?logout'>Wyloguj</a>)<br/ >";
        }else{
            echo "<h1 style='color:red;'>Podałeś niepoprawne dane!</h1><br/>Za 5 sekund zostaniesz przekieroany na strone logowania...";
            header("refresh: 5; url=index.html");
        }   

}



 ?>