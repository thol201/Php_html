<?php

error_reporting(E_ALL ^ E_WARNING); 

    $login = trim($_POST['name']);
    $pass = trim($_POST['pass']);
    $myfile = fopen("data.txt", "r") or die ("Unable to open file!");    
    while(!feof($myfile)) 
    {
        $dat = fgets($myfile);
        $str_dat = explode(':',$dat);
        if($str_dat[0]==$login && $str_dat[1]==$pass)
        {
            echo "<h1>Witaj " .$str_dat[0]. "</h1>zostałeś poprawnie zalogowany<br/ >";
            break;
        }     
    }
fclose($myfile);    

 ?>