<?php 
  session_start();
  if(isset($_SESSION["locked"])){
    $difference = time() - $_SESSION["locked"];
    if($difference > 10){
      unset($_SESSION["locked"]);
      unset($_SESSION["login_attempts"]);
      }
    }
  //$_SESSION ['start'] = true;
  $_SESSION['login'] = $_POST['user'];
  if($_SERVER["REQUEST_METHOD"] == "POST")
      {
         $user=$_POST['user'];
         $pass=$_POST['pass'];
         $link = mysqli_connect("mysql.ct8.pl", $dbuser="m27034_test", $dbpassword="Audiquatro80*", $dbname="m27034_dysksieciowy");
         if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }
         mysqli_query($link, "SET NAMES 'utf8'");
         $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'");
         $rekord = mysqli_fetch_array($result);
        
         if(mysqli_num_rows($result) > 0){
           if(!$rekord){
             mysqli_close($link); // zamknięcie połączenia z BD
              //echo "Brak użytkownika o takim loginie !";
              $_SESSION["login_attempts"] +=1;
              $_SESSION["error"] = "Brak użytkownika o takim loginie!";
             }else{
               if($rekord['password']==$pass){
                    $_SESSION ['loggedin'] = true;
                    header('Location: dysk2.php');
                 }else{
                   //echo "Błąd w haśle !";
                   $_SESSION["login_attempts"] +=1;
                   $_SESSION["error"] = "Błąd w haśle !";
                   
                   }
               
               }
           
           }
           

        
      }
  
  
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<BODY>

<form method="post" action="">
 Login:<input type="text" name="user" maxlength="20" size="20"><br>
 Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>
    <?php
    if($_SESSION["login_attempts"] > 2){
      $_SESSION["locked"] = time();
      echo"<p>Czekaj 10 sekund</p>";
      
      }else{
  ?>
 <input type="submit" value="Send"/>
 <?php } ?>
 <br>
<a href = "rejestruj.php"> Zarejestruj </a><br>
</form>
                      <?php if (isset($_SESSION["error"])) { ?>
                    <?= $_SESSION["error"]; ?>
                    <?php unset($_SESSION["error"]); } ?>
  
</BODY>
</HTML>