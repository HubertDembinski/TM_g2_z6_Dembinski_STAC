<?php
  session_start();
 if (!isset($_SESSION['start']) || !isset($_POST['user']) || !isset($_POST['pass']) || !isset($_POST['pass2']))
  {

  header('Location: logowanie.php');

  exit();
 
  } 
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>
<BODY>
<?php

 $user=$_POST['user']; // login z formularza
 $pass=$_POST['pass']; // hasło z formularza
 $pass2=$_POST['pass2']; // hasło z formularza
 
 if(strcmp($pass,$pass2) !== 0 ){
   echo "Hasła nie są identyczne";
   ?>
   <br>
   <a href = "rejestruj.php"> Wróć <br>
   <?php
   exit();
 }
 $link = mysqli_connect("mysql.ct8.pl", $dbuser="m27034_test", $dbpassword="Audiquatro80*", $dbname="m27034_dysksieciowy"); // połączenie z BD – wpisać swoje dane
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
 mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
 
 #$count = mysqli_query($link, "SELECT COUNT(*) FROM users"); // wiersza, w którym login=login z formularza
 $sql = "INSERT INTO users (username,password) VALUES('$user','$pass')";
    if (mysqli_query($link, $sql)) {
    echo "Rejestracja powiodła się !";
                mkdir("/usr/home/hubdem000/domains/hubdem000.ct8.pl/public_html/SEMESTR2/z8/$user");
   } else {
    echo "Error: " . mysqli_error($link);
   }
   mysqli_close($link);

 #$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
 
 ?>
 <a href = "logout.php"> Wróć do logowania </a><br>
 <?php
 
?>
</BODY>
</HTML>
