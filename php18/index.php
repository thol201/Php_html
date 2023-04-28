<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zad 18</title>
    <link type="text/css" rel="stylesheet" href="style.css">
    
</head>
<body>
     
    <div id="box">
        <h1>Upload plików na serwer</h1>
    <div id="for">
        <form name="form" action="" method="POST" enctype="multipart/form-data">
			<label for="files">files</label>
			<input multiple type="file" name="files[]"  ><br>
			
            <button type="submit" id="but2">Wyślij</button>            
            <button type="reset" id="but">Wyczyść</button>
            
        </form>
    </div>
        <div id="fil">
            <?php
            require("script.php");
            ?>
        </div>
    </div>
    
</body>

</html>




