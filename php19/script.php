<?php
error_reporting(E_ALL ^ E_WARNING); 
$uploadDirectory = 'C:\xampp\htdocs\php19\sss';
$files = scandir($uploadDirectory);
$files = array_diff($files,array('.','..'));
$files = array_values($files);
$errors=array();


if(isset($_POST['name']))
{
    $database = new PDO('sqlite:database.db');
    $login = trim($_POST['name']);
    $pass = trim($_POST['pass']);
    $sql ='SELECT * FROM users WHERE username = :username AND password = :password';
    $statement = $database->prepare("SELECT * FROM users WHERE username = :name AND password  = :pass");
    $statement->execute(array(':name' => $login, ':pass' => $pass));
    $row = $statement->fetch();
    if ($row['username'] == $login && $row['password'] == $pass){
            $_SESSION['username']=$_POST['name'];
            header("Location: index.php");
            exit();
        }
        else{
            echo "<h1 style='color:red;'>Podałeś niepoprawne dane!</h1><br/>Za 5 sekund zostaniesz przekieroany na strone logowania...";
            header("refresh: 5; url=index.php");        
            exit();
        }   
}

if(!isset($_SESSION['username']))
echo ' <h1>Upload plików z logowaniem</h1>
        <h2>Formularz logowania</h2>

        <div id="for">
        <form name="form" action="" method="POST">
		
            <label for="name">Login:</label>
            <input type="text" id="name" name="name"><br>
            <label for="pass">Hasło:</label>
            <input type="password" id="pass" name="pass"><br>
         
            <button type="submit" id="but2">Wyślij</button>            
            <button type="reset" id="but">Wyczyść</button>
            <br>
        </form>
    </div>    ';




if(isset($_SESSION['username']))
{
    $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";
    if(!strpos($_SERVER['REQUEST_URI'], "index.php"))
        header("Location: index.php");
    if (!is_dir($userUploadDirectory)) 
    {
        mkdir($userUploadDirectory, 0777);
    }

    if (isset($_GET['logout'])) 
    {
        session_destroy();
        echo 'Zostaniesz wyglogowany ze 3 sekundy';
        header("refresh: 3; url=index.php");
    }
    else
    {
        echo "<h1>Witaj " .$_SESSION['username']. "</h1>zostałeś poprawnie zalogowany(<a href='?logout'>Wyloguj</a>)<br/><h2>Upload plików na serwer</h2>";
        echo "    <div id='for'>
            <form name='form' action='' method='POST' enctype='multipart/form-data'>
            <p>Pliki do przesłania</p>
			<label for='files'>files</label>
			<input multiple type='file' name='files[]'  ><br>
            <button type='submit' id='but2'>Wyślij</button>            
            <button type='eset' id='but'>Wyczyść</button>
            </form> </div> <h2>Pliki znajdujące się w folderze</h2>";
    }
}

function read()
{
    $style="<div style=' width: 300px;
    height: 20px;    text-align: left;
    margin-right: auto;'>";
    $uploadDirectory = 'C:\xampp\htdocs\php19\sss';
    $userUploadDirectory = "$uploadDirectory/$_SESSION[username]";
    $files = scandir($userUploadDirectory);
    $files = array_diff($files,array('.','..'));
    $files = array_values($files);
    for($i=0;$i<count($files);$i++)
    {
        echo $style."<a title='Usuń Plik' style='color: red;' href='?remove=".$files[$i]."'>X</a>".$files[$i]."</div>";
    }
}

function Mess($errors)
{
    $style="class='mes' style='width: 300px;
    text-align: center;
    height: 20px;
    font-size: 10px;
    margin-right: auto; 
    padding-top:5px;
    margin-top:10px;
    border-style: dotted;
    border-width: 2px;
    ";
    $str=implode("+", $errors);
    $str=explode("+", $str);

    for($i=0;$i<count($str);$i++)
    {
        $errors=explode(":",$str[$i]);
        if($errors[0]==1)
        {
            echo "<div ".$style."
            border-color: greenyellow;
            background-color: greenyellow;'>Plik ".$errors[1]." Został zapisany poprawine</div>";
        }
        else if($errors[0]==2)
        {
            echo "<div ".$style."border-color: red;
            background-color: red;'>Plik ".$errors[1]." Został usunięty</div>";
        }
        else if($errors[0]==3)
        {
            echo "<div ".$style."border-color: red;
            background-color: red;'>Niewłaściwy typ pliku ".$errors[1]." </div>";    
        }  
    }
    $errors=array_diff($errors,$errors);
}


if(isset($_GET['remove']))
{
    $fileToRemove = basename($_GET['remove']);
    unlink($userUploadDirectory."/".$fileToRemove);
    $errors=array(0=>"2:".$fileToRemove);
}



if(isset($_FILES['files']))
{
    $errors=array_diff($errors,$errors);
    foreach ($_FILES['files']['error'] as $key => $error) 
    {
        if ($error === UPLOAD_ERR_OK) 
        {
            $tmpName = $_FILES['files']['tmp_name'][$key];
            $fileName = basename($_FILES['files']['name'][$key]);
            $type=explode(".",$fileName);
            if($type[1]!="jpg"&&$type[1]!="gif"&&$type[1]!="png")
                array_push($errors,"3:".$fileName);
            else
            {
                array_push($errors,"1:".$fileName);
                move_uploaded_file($tmpName, "$userUploadDirectory/$fileName");
            }
	   }
    }
}

if(isset($_SESSION['username'])&&!isset($_GET['logout']))
{
    read();
    Mess($errors);
}
?>