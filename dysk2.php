<?php declare(strict_types=1);
session_start();
if (!isset($_SESSION['loggedin']))
{
header('Location: logowanie.php');
exit();
}
$ip = $_SERVER["REMOTE_ADDR"];
$user = $_SESSION['login'];
$path_root = $_SERVER['DOCUMENT_ROOT'] . '/SEMESTR2/z8/' . $user . '/';
$path = $_SERVER['DOCUMENT_ROOT'] . '/SEMESTR2/z8/' . $user . '/';
echo ('<form action="logout.php" method="POST">');
echo (' <input type="submit" value="Wyloguj" /></form>');
echo "<p style = 'font-family: Courier New; font-weight: bold;'>Login: " . $_SESSION['login'] . "</p>";


function delete($dirPath) {
 if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
  $dirPath .= '/';
 }
 $files = glob($dirPath . '*', GLOB_MARK);
 foreach ($files as $file) {
  if (is_dir($file)) {
   delete($file);
  } else {
   unlink($file);
  }
 }
 rmdir($dirPath);
}

if (isset($_GET['katalog'])) {
  $path = $path . $_GET['katalog'] . "/";
}

if (isset($_GET['usun'])) {
  $sciezka = $path . "/" . $_GET['usun'];
  $sciezka = preg_replace('/([^:])(\/{2,})/', '$1/', $sciezka);
  if (is_dir($sciezka)) delete($sciezka);
  else unlink($sciezka);
  header('Location: ?katalog=');
}
?>

<form method="POST" enctype="multipart/form-data">
 <br><p style = "font-family: Courier New; font-weight: bold;">Dodaj plik: <input type="file" name="fileToUpload" id="fileToUpload" style="font-family: Courier New; font-weight: bold; color: red;"><br><input type="submit" name="submit" name="submit"></p>
</form>

<form method="POST">
 <p style = "font-family: Courier New; font-weight: bold;">Stwórz nowy folder: <br>Nazwa: <input type="text" name="folder" maxlength="16"></p>
 <input type="submit" value="Stwórz">
</form>

<?php
if (isset($_POST['folder'])) {
 $sciezka = $path . "/" . $_POST['folder'];
 $sciezka = preg_replace('/([^:])(\/{2,})/', '$1/', $sciezka) . "/";
 mkdir($sciezka, 0777);
}

if (isset($_POST['submit'])) {
  if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
    $sciezka = $path . "/" . basename($_FILES["fileToUpload"]["name"]);
    $sciezka = preg_replace('/([^:])(\/{2,})/', '$1/', $sciezka);
  move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $sciezka);
  }
}

echo "<center>";
echo "<p style = 'font-family: Courier New; font-weight: bold;'>Pliki użytkownika:</p>";
echo "<div style='border-style: solid; padding: 5px; width: 500px; font-family: Courier New; font-size: 20px; text-align: left'>";
$files = scandir($path);
foreach ($files as $file){
 if (strcmp($file, '.') == 0) continue;
 $zrodlo = realpath($_SERVER['DOCUMENT_ROOT']. "/SEMESTR2/z8/" . $user . "/" .
   (isset($_GET['katalog']) ? $_GET['katalog'] . "/" : "") . $file);
 $relat1 = substr($zrodlo, strlen($path_root));
 if (strcmp($file, '..') == 0) { $relat1 = ''; }
 $relat2 = $user . '/' . $relat1;
 $format = end(explode('.', $file));
 $ikona = 'file.png';
 if ($format == 'txt' || $format == 'pdf') { $ikona = 'document.png'; }
 if ($format == 'mp3' || $format == 'wav') { $ikona = 'volume.png'; }
 if (is_dir($zrodlo)) {
  echo '<a href=?katalog=' . $relat1 . '>' . $file . ' <img src="go.png"></a>';
  if ($relat1 != '') echo '<a href=?usun=' . $relat1 . '><img src="trash.png"></a><br>';
  else echo '<br>';
 } else {
  echo '<a href="' . $relat2 . '" download>' . $file . '<img src="' . $ikona . '"></a>';
  echo '<a href=?usun=' . $relat1 . '><img src="trash.png"></a><br>';
 }
}
echo "</div>";
echo "</center>";
?>
