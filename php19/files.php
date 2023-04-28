<?php
ini_set('display_errors',1);
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zad 18</title>
    <link type="text/css" rel="stylesheet" href="style.css">
    
</head>
<body>
     
    <div id="box">
        <h1>Upload plików z logowaniem</h1>
         
        <div id="fil">
            <?php
            
            require("script.php");
            ?>
        </div>
    </div>
    
</body>

</html>




