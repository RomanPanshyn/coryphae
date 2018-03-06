<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/Loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id='logo'>
<img align='left' border=0 alt='Корифей продажа компьютерной техники' src='images/LogoCoryphae.jpg'>
<h1 align='center'>Магазин компьютерной техники Корифей</h1>
</div>
<div id=bottom>
<p>Roman Panshyn group TV-61 &copy; Copyright 2009</p>
</div>
<?php
$conn=@mysql_connect('localhost','Roman','panshyn');
$database = "Coryphae";
$table_name = "WebPage";
mysql_select_db($database);
require_once 'class.php';

if ($_GET['show']==NULL){
echo "<title>Магазин компьютерной техники Корифей >> Товары</title>";
$sql = "SELECT * FROM $table_name where ParentId='root'";
$q = mysql_query($sql,$conn) or die();
$n = mysql_num_rows($q);
echo "<div id=content>";
echo "<h1>Корифей >> Список категорий</h1>";
echo "<table width=100% border=0 align=center>";
  $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printCategoryAdmin();
   }
  }
 }
if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printCategory();
   }
  }
} 
echo "</table>";
echo "</div>";
$q = mysql_query($sql,$conn) or die();
$n = mysql_num_rows($q);
echo "<div id=navig>";
echo "<table width=100% border=0 align=left>";
echo "<a href='index.php?show=about'>Корифей > Контакты</a>";
if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenu();
  }
  }
 } 
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenuAdmin();
  }
  }  
 echo "<tr><td>";
 echo "<a href='index.php?show=add_category'>Добавить категорию</a>";
 echo "</td></tr>";
}
echo "</table>";
echo "</div>";
}

if ($_GET['show']==add_category){
 echo "<title>Добавить категорию</title>";
 $check_login = "SELECT Login from Users";
 $check_pass = "SELECT Password from Users";
 $ch_login = mysql_query($check_login,$conn);
 $ch_pass = mysql_query($check_pass,$conn);
 if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
  echo "<div id=navig>";
   echo "<a href='index.php'>Вернуться назад</a>";
 echo "</div>";
  echo "<div id=content>";
  echo "<h2>Добавить новую категорию</h2>";
  echo "<form action='index.php?show=added_category' align='left' method=POST>";
  echo "<table>";
  echo "<tr><td>Id</td><td><p><input type='text' name='id' size='50'/></p></td></tr>";
  echo "<tr><td>Заголовок</td><td><p><input type='text' name='caption' size='50'/></p></td></tr>";
  echo "<tr><td>Текст</td><td><p><textarea name='text' cols='40' rows='8'></textarea></p></td></tr>";
  echo "<tr><td>Картинка</td><td><p><input type='text' name='image' size='50'/></p></td></tr>";
  echo "<tr><td>Дата</td><td><p><input type='text' name='date' size='50'/></p></td></tr>";  
  echo "</table>";
  echo "<br><p align='center'><input type='submit' name='add' value='Добавить' />";
  echo "</form>";
  echo "</div>";
 }
 if ($_SESSION['login']!=mysql_result($ch_login,0)&&$_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
  echo "</div>"; 
 } 

}

if ($_GET['show']==added_category){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 echo "<title>Добавлена категория ".$_POST["caption"]."</title>";
 echo "<div id=content>";
 $sql = "INSERT INTO $table_name values (";
$sql = $sql ."'root', '".$_POST["id"] . "', '". $_POST["caption"]."', '". $_POST["caption"]."', '". $_POST["text"]."', '". $_POST["text"]."', '". $_POST["image"]."', '". $_POST["image"]."', '". $_POST["date"]."');";
$result = mysql_query($sql,$conn);
if (!result) echo "Не получилось добавить запись в $table_name";
    else {
	echo "Запись была успешно добавлена!<br>";
    echo "<a href='index.php'>Вернуться к списку категорий</a>";
	}
  echo "</div>";
  }
  if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
  echo "</div>";
 } 
}

if ($_GET['show']==add_product){
  $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql = "SELECT ShortCaption FROM $table_name where Id='".$_GET['category']."'";
 $resultPrev2 = mysql_query($sql,$conn);
 echo "<title>Добавить продукт в категорию ".mysql_result($resultPrev2,0)."</title>";
 echo "<div id=navig>";
   echo "<a href='index.php?show=".$_GET['category']."'>Вернуться назад</a>";
 echo "</div>";
 echo "<div id=content>";
  $resultPrev2 = mysql_query($sql,$conn);
  echo "<h2>Добавить новый продукт в категорию ".mysql_result($resultPrev2,0)."</h2>";
  echo "<form action='index.php?show=added_product&category=".$_GET['category']."' align='left' method=POST>";
  echo "<table>";
  echo "<tr><td>Id</td><td><p><input type='text' name='id' size='50'/></p></td></tr>";
  echo "<tr><td>Заголовок</td><td><p><input type='text' name='caption' size='50'/></p></td></tr>";
  echo "<tr><td>Короткий Заголовок</td><td><p><input type='text' name='shortcaption' size='50'/></p></td></tr>";
  echo "<tr><td>Вступление</td><td><p><textarea name='intro' cols='40' rows='8'></textarea></p></td></tr>";
  echo "<tr><td>Текст</td><td><p><textarea name='text' cols='40' rows='8'></textarea></p></td></tr>";
  echo "<tr><td>Картинка</td><td><p><input type='text' name='image' size='50'/></p></td></tr>";
  echo "<tr><td>Маленькая Картинка</td><td><p><input type='text' name='imagesmall' size='50'/></p></td></tr>";
  echo "<tr><td>Дата</td><td><p><input type='text' name='date' size='50'/></p></td></tr>";
  echo "</table>";
  echo "<br><p align='center'><input type='submit' name='add' value='Добавить' />";
  echo "</form>";
 echo "</div>";
 }
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
  echo "</div>";
 } 
}

if ($_GET['show']==added_product){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql = "SELECT ShortCaption FROM $table_name where Id='".$_GET['category']."'";
 $resultPrev2 = mysql_query($sql,$conn);
 echo "<title>Добавлен продукт ".$_POST["shortcaption"]." в категорию ".mysql_result($resultPrev2,0)."</title>";
 echo "<div id=content>";
 $sql = "INSERT INTO $table_name values ('".$_GET['category']."', '".$_POST["id"] . "', '". $_POST["caption"]."', '". $_POST["shortcaption"]."', '". $_POST["intro"]."', '". $_POST["text"]."', '". $_POST["image"]."', '". $_POST["imagesmall"]."', '". $_POST["date"]."');";
$result = mysql_query($sql,$conn);
if (!result) echo "Не получилось добавить запись в $table_name";
    else {
	echo "Запись была успешно добавлена!<br>";
    echo "<a href='index.php?show=".$_GET['category']."'>Вернуться к списку продуктов</a>";
	}
  echo "</div>";
  }
  if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
  echo "</div>";
 } 
}

if ($_GET['show']==edit_category){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql3 = "SELECT ShortCaption FROM $table_name where Id='".$_GET['category']."'";
  $resultPrev2 = mysql_query($sql3,$conn);
 echo "<title>Изменить категорию ".mysql_result($resultPrev2,0)."</title>";
 echo "<div id=navig>";
   echo "<a href='index.php'>Вернуться назад</a>";
 echo "</div>";
 echo "<div id=content>";
  $sql2 = "SELECT * FROM $table_name where Id='".$_GET['category']."'";
  $resultPrev1 = mysql_query($sql2,$conn);
  $row = mysql_fetch_array($resultPrev1, MYSQL_ASSOC);
  $resultPrev2 = mysql_query($sql3,$conn);
  echo "<h2>Редактировать категорию ".mysql_result($resultPrev2,0)."</h2>";
  echo "<form action='index.php?show=edited_category&category=".$_GET['category']."' align='left' method=POST>";
  echo "<table>";
  echo "<tr><td>Id</td><td><p><input type='text' name='id' size='50' value='".$row['Id']."' /></p></td></tr>";
  echo "<tr><td>Заголовок</td><td><p><input type='text' name='caption' size='50' value='".$row['Caption']."' /></p></td></tr>";
  echo "<tr><td>Текст</td><td><p><textarea name='text' cols='40' rows='8'>".$row['Text']."</textarea></p></td></tr>";
  echo "<tr><td>Картинка</td><td><p><input type='text' name='image' size='50' value='".$row['Image']."' /></p></td></tr>";
  echo "<tr><td>Дата</td><td><p><input type='text' name='date' size='50' value='".$row['Date']."' /></p></td></tr>";
  echo "</table>";
  echo "<br><p align='center'><input type='submit' name='add' value='Сохранить' />";
  echo "</form>";
  echo "<p><a href='index.php?show=delete_category&category=".$_GET['category']."'>Удалить категорию</a></p>";
 echo "</div>";
 }
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']==edited_category){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 echo "<title>Категория ".$_POST["caption"]." изменена</title>";
 echo "<div id=content>";
 $sql = "UPDATE $table_name Set ";
$sql = $sql ."$table_name.ParentId='root', $table_name.Id='".$_POST["id"] . "', $table_name.Caption='". $_POST["caption"]."', $table_name.ShortCaption='". $_POST["caption"]."', $table_name.Intro='". $_POST["text"]."', $table_name.Text='". $_POST["text"]."', $table_name.Image='". $_POST["image"]."', $table_name.ImageSmall ='". $_POST["image"]."', $table_name.Date='". $_POST["date"]."' where $table_name.Id='".$_GET['category']."';";
$result = mysql_query($sql,$conn);
$sql1 = "UPDATE $table_name Set $table_name.ParentId='".$_POST["id"]."' where $table_name.ParentId='".$_GET['category']."';";
mysql_query($sql1,$conn);
if (!result) echo "Не получилось изменить запись в $table_name";
    else {
	echo "Запись была успешно изменена!<br>";
    echo "<a href='index.php'>Вернуться к списку категорий</a>";
	}
  echo "</div>";
 }
if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']==edit_product){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql2 = "SELECT ShortCaption FROM $table_name where Id='".$_GET['product']."'";
  $resultPrev1 = mysql_query($sql2,$conn);
 echo "<title>Изменить продукт ".mysql_result($resultPrev1,0)."</title>";
 echo "<div id=navig>";
   echo "<a href='index.php?show=".$_GET['category']."'>Вернуться назад</a>";
 echo "</div>";
 echo "<div id=content>";
  $sql = "SELECT * FROM $table_name where Id='".$_GET['product']."'";
  $resultPrev = mysql_query($sql,$conn);
  $row = mysql_fetch_array($resultPrev, MYSQL_ASSOC);
  $resultPrev1 = mysql_query($sql2,$conn);
  $sql3 = "SELECT ShortCaption FROM $table_name where Id='".$_GET['category']."'";
  $resultPrev2 = mysql_query($sql3,$conn);
  echo "<h2>Редактировать продукт ".mysql_result($resultPrev1,0)." в категории ".mysql_result($resultPrev2,0)."</h2>";
  echo "<form action='index.php?show=edited_product&product=".$_GET['product']."&category=".$_GET['category']."' align='left' method=POST>";
  echo "<table>";
  echo "<tr><td>Id</td><td><p><input type='text' name='id' size='50' value='".$row['Id']."' /></p></td></tr>";
  echo "<tr><td>Заголовок</td><td><p><input type='text' name='caption' size='50' value='".$row['Caption']."'/></p></td></tr>";
  echo "<tr><td>Короткий Заголовок</td><td><p><input type='text' name='shortcaption' size='50' value='".$row['ShortCaption']."'/></p></td></tr>";
  echo "<tr><td>Вступление</td><td><p><textarea name='intro' cols='40' rows='8'>".$row['Intro']."</textarea></p></td></tr>";
  echo "<tr><td>Текст</td><td><p><textarea name='text' cols='40' rows='8'>".$row['Text']."</textarea></p></td></tr>";
  echo "<tr><td>Картинка</td><td><p><input type='text' name='image' size='50' value='".$row['Image']."'/></p></td></tr>";
  echo "<tr><td>Маленькая Картинка</td><td><p><input type='text' name='imagesmall' size='50' value='".$row['ImageSmall']."'/></p></td></tr>";
  echo "<tr><td>Дата</td><td><p><input type='text' name='date' size='50' value='".$row['Date']."'/></p></td></tr>";
  echo "</table>";
  echo "<br><p align='center'><input type='submit' name='add' value='Сохранить' />";
  echo "</form>";
  echo "<p><a href='index.php?show=delete_product&product=".$_GET['product']."&category=".$_GET['category']."'>Удалить продукт</a></p>";
 echo "</div>";
 }
  if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']==edited_product){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 echo "<title>Продукт ".$_POST["shortcaption"]." изменен</title>";
 echo "<div id=content>";
 $sql = "UPDATE $table_name SET $table_name.ParentId='".$_GET['category']."', $table_name.Id='".$_POST["id"] . "', $table_name.Caption='". $_POST["caption"]."', $table_name.ShortCaption='". $_POST["shortcaption"]."', $table_name.Intro='". $_POST["intro"]."', $table_name.Text='". $_POST["text"]."', $table_name.Image='". $_POST["image"]."', $table_name.ImageSmall='". $_POST["imagesmall"]."', $table_name.Date='". $_POST["date"]."' where $table_name.Id='".$_GET['product']."';";
$result = mysql_query($sql,$conn);
if (!result) echo "Не получилось изменить запись в $table_name";
    else {
	echo "Запись была успешно изменена!<br>";
    echo "<a href='index.php?show=".$_GET['category']."'>Вернуться к списку продуктов</a>";
	}
  echo "</div>";
  }
   if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
  echo "</div>";
 } 
}

if ($_GET['show']==delete_category){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql2 = "Select ShortCaption from $table_name where Id='".$_GET['category']."';";
 $result2 = mysql_query($sql2,$conn);
 echo "<title>Категория ".mysql_result($result2,0)." удалена</title>";
 $result2 = mysql_query($sql2,$conn);
 echo "<div id=content>";
 $sql = "Delete from $table_name where Id='".$_GET['category']."';";
 $result = mysql_query($sql,$conn);
 $sql1 = "Delete from $table_name where ParentId='".$_GET['category']."';";
 $result1 = mysql_query($sql1,$conn);
 if (!result) echo "Невозможно удалить запись из таблицы $table_name";
    else {
	echo "Категория ".mysql_result($result2,0)." успешно удалена!<br>";
    echo "<a href='index.php'>Вернуться к списку категорий</a>";
	}
 echo "</div>";
 }
if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']==delete_product){
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 $sql2 = "Select ShortCaption from $table_name where Id='".$_GET['product']."';";
 $result2 = mysql_query($sql2,$conn);
 echo "<title>Продукт ".mysql_result($result2,0)." удален</title>";
 $result2 = mysql_query($sql2,$conn);
 echo "<div id=content>";
 $sql = "Delete from $table_name where Id='".$_GET['product']."';";
 $result = mysql_query($sql,$conn);
 if (!result) echo "Невозможно удалить запись из таблицы $table_name";
    else {
	echo "Продукт ".mysql_result($result2,0)." успешно удален!<br>";
    echo "<a href='index.php?show=".$_GET['category']."'>Вернуться к списку продуктов</a>";
	}
 echo "</div>";
 }
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']!=NULL&&$_GET['show']!='about'&&$_GET['show']!='add_category'&&$_GET['show']!='add_product'&&$_GET['show']!='added_category'&&$_GET['show']!='added_product'&&$_GET['show']!='edit_category'&&$_GET['show']!='edited_category'&&$_GET['show']!='edit_product'&&$_GET['show']!='edited_product'&&$_GET['show']!='delete_category'&&$_GET['show']!='delete_product'&&$_GET['show']!='login'&&$_GET['show']!='logged'&&$_GET['show']!='logout'&&$_GET['show']!='changepass'&&$_GET['show']!='changedpass'&&$_GET['show']!='info'){
$sql = "SELECT Caption FROM $table_name where Id='".$_GET['show']."'";
$result = mysql_query($sql,$conn);
echo "<title>Магазин компьютерной техники Корифей >> ".mysql_result($result,0)."</title>";
$sql2 = "SELECT * FROM $table_name where ParentId='".$_GET['show']."';";
$sql3 = "SELECT * FROM $table_name where Id='".$_GET['show']."'";
$q = mysql_query($sql2,$conn) or die();
$n = mysql_num_rows($q);

if ($n>0){
$check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  
echo "<div id=path>";
echo "<a href='index.php'>Товары</a> >> ";
echo "<a href='index.php?show=".$_GET['show']."'>".mysql_result($result,0)."</a>";
echo "</div>";
if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
echo "<div id=content>";
$sql_h1 = "SELECT Caption FROM $table_name where Id='".$_GET['show']."'";
$header = mysql_query($sql_h1,$conn);
echo "<h1>".mysql_result($header,0)."</h1>";
echo "<table width=100% border=0 align=center>";
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printContent();
  }
  }
echo "</table>";
echo "</div>";
echo "<div id=navig>";
echo "<table width=100% border=0 align=left>";
$q = mysql_query($sql2,$conn) or die();
$n = mysql_num_rows($q);
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenu();
  }
  }
  echo "</table>";
 echo "</div>";
} 
$check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
echo "<div id=navig>";
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenuAdmin();
  }
  }  
 echo "<a href='index.php?show=add_product&category=".$_GET['show']."'>Добавить продукт</a>";
echo "</div>";
echo "<div id=content>";
$sql_h1 = "SELECT Caption FROM $table_name where Id='".$_GET['show']."'";
$header = mysql_query($sql_h1,$conn);
echo "<h1>".mysql_result($header,0)."</h1>";
echo "<table width=100% border=0 align=center>";
$q = mysql_query($sql2,$conn) or die();
$n = mysql_num_rows($q);
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printContentAdmin();
  }
  } 
 echo "</div>";
}
} 

if ($n==0){
  $sql = "SELECT ParentId FROM $table_name where Id='".$_GET['show']."'";
  $resultPrev1 = mysql_query($sql,$conn);
  if (mysql_result($resultPrev1,0)=='root'){
   echo "<div id=navig>";
   $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
   echo "<a href='index.php'>Вернуться к списку категорий</a>";
   echo "</div>";
   echo "<div id=content>";
    echo "<p>В данной категории еще нет продуктов</p>";
    $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
     echo "<a href='index.php?show=add_product&category=".$_GET['show']."'>Добавить продукт</a>";
	}
   echo "</div>";
  }
  if (mysql_result($resultPrev1,0)!='root'){
  $sql = "SELECT ShortCaption FROM $table_name where Id='".mysql_result($resultPrev1,0)."'";
  $resultPrev2 = mysql_query($sql,$conn);
  $sql = "SELECT * FROM $table_name where ParentId='".mysql_result($resultPrev1,0)."'";
  $q = mysql_query($sql,$conn);
  $n = mysql_num_rows($q);
  $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  
  echo "<div id=path>";
  echo "<a href='index.php'>Товары</a> >> ";
  echo "<a href='index.php?show=".mysql_result($resultPrev1,0)."'>".mysql_result($resultPrev2,0)."</a>";
  echo " >> ".mysql_result($result,0);    
  echo "</div>";
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
  echo "<div id=navig>"; 
 echo "<table width=100% border=0 align=left>";
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenu();
  }
  }
  echo "</table>";
  echo "</div>";
  }
  echo "<div id=content>";
  echo "<table width=100% border=0 align=center>";  
   $q = mysql_query($sql3,$conn);
   if ($row = mysql_fetch_array($q, MYSQL_ASSOC)){
    $obj1 = new Get_List($row);
    $obj1->printLastContent();
    }
  echo "</table>";
  echo "</div>";
  
 $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){    
 echo "<div id=navig>"; 
$q = mysql_query($sql,$conn);
$n = mysql_num_rows($q);
for($i=0;$i<$n; $i++){
 while($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
  $obj1 = new Get_List($row);
  $obj1->printMenuAdmin();
  }
  }
   echo "</div>";  
 }  
 
  }
}
}

if($_GET['show']==login){
 echo "<title>Вход администратора</title>";
 echo "<div id=content>";
 echo "<form action=index.php?show=logged method=POST>";
 echo "<p>Логин <input type=text name=login value=''></p>";
 echo "<p>Пароль <input type=password name=password value=''></p>";
 echo "<input type=submit value='Вход'>";
 echo "</form>";
 echo "</div>";
}

if ($_GET['show']==logged){
  $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);			
 echo "<div id=content>";
  if ($_POST['login']!=mysql_result($ch_login,0) or $_POST['password']!=mysql_result($ch_pass,0)){
  echo "<p>Неверно введены данные</p>";
  echo "<p><a href='index.php?show=about'>Вернуться к странице Контакты</a></p>";  
 }
 if ($_POST['login']==mysql_result($ch_login,0)&&$_POST['password']==mysql_result($ch_pass,0)){
  echo "<p>Вход администратора выполнен</p>"; 
  $_SESSION['login']=$_POST['login'];
  $_SESSION['password']=$_POST['password']; 
  echo "<a href='index.php?show=about'>Перейти к странице Контакты</a>";
}
echo "</div>";
}

if ($_GET['show']==changepass){
 $check_login = "SELECT Login from Users";
 $check_pass = "SELECT Password from Users";
 $ch_login = mysql_query($check_login,$conn);
 $ch_pass = mysql_query($check_pass,$conn);
if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
 echo "<title>Изменение пароля</title>";
 echo "<div id=content>"; 
 echo "<table align='center'><tr><td>Логин </td><td>".$_SESSION['login']."</td></tr>";
 echo "<form action=index.php?show=changedpass method=POST>";
 echo "<tr><td>Старый Пароль </td><td><input type=password name=password value=''></td></tr>";
 echo "<tr><td>Новый Пароль </td><td><input type=password name=new_password value=''></td></tr>";
 echo "<tr><td colspan=2><input type=submit value='Сохранить'></td></tr>";
 echo "</form>";
 echo "</table></div>";
 }
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
 echo "<div id=content>";
  echo "<p>У Вас нет прав для просмотра этой страницы.</p>";
  echo "<a href='index.php'>Вернуться к списку категорий</a>";
 echo "</div>";
 } 
}

if ($_GET['show']==changedpass){
 $check_login = "SELECT Login from Users";
 $check_pass = "SELECT Password from Users";
 $ch_login = mysql_query($check_login,$conn);
 $ch_pass = mysql_query($check_pass,$conn);
 if ($_SESSION['login']!=mysql_result($ch_login,0) or $_POST['password']!=mysql_result($ch_pass,0)){
  echo "<title>Пароль не удалось изменить</title>";
  echo "<div id=content>";  
  echo "<p>Неверно введен старый пароль</p>";
  echo "<p><a href='index.php?show=about'>Перейти к странице Контакты</a>";
  echo "</div>";
 }
 if ($_SESSION['login']==mysql_result($ch_login,0)&&$_POST['password']==mysql_result($ch_pass,0)){ 
  echo "<title>Пароль изменен</title>";
  echo "<div id=content>";  
  $change = "UPDATE Users SET Users.Password='".$_POST['new_password']."';";
  $_SESSION['password']=$_POST['new_password'];
  $result = mysql_query($change,$conn);
  echo "<p>Пароль успешно изменен!</p>";  
  echo "<a href='index.php?show=about'>Перейти к странице Контакты</a>";  
  echo "</div>";
 }
 
}

if ($_GET['show']==logout){
 echo "<div id=content>";
 unset($_SESSION['login']);
 unset($_SESSION['password']);
 session_destroy();
 echo "<p>Выход администратора выполнен</p>";
 echo "<p><a href='index.php?show=about'>Перейти к странице Контакты</a></p>";
 echo "</div>"; 
}

if ($_GET['show']==info){
 echo "<div id=navig align='center'><a href='index.php'>К категориям</a></div>";   
  $h = "SELECT Header from Information where id='".$_GET['category']."'";
  $t = "Select Text from Information where id='".$_GET['category']."'";
  $head = mysql_query($h,$conn);
  $text = mysql_query($t,$conn);  
  echo "<title>Корифей >> Информация >> ".mysql_result($head,0)."</title>";  
  echo "<div id=content>";  
  echo "<h1>".mysql_result($head,0)."</h1>";
  echo mysql_result($text,0);
  echo "</div>";

}

if ($_GET['show']==about){
 echo "<title>Магазин компьютерной техники Корифей</title>";
 echo "<div id='content'>";
 echo "<h1><strong>Магазин компьютерной техники Корифей</strong></h1>";
 echo "<p><b>Компьютерная техника</b> от лучших мировых производителей для дома и офиса</p>";
 echo "<p>Наш адресс: г.Киев, улица Хмельницкая, 10</p>";
 echo "<p>Телефон: 8(044) 492-73-63</p>";
 echo "<p>Материалы сайта подобраны на основе ресурса <a href='http://vilka.com.ua' target='_blank'>Интернет-магазин Vilka.com.ua</a></p>";
 echo "</div>"; 
 echo "<div id='navig'>";
  $check_login = "SELECT Login from Users";
  $check_pass = "SELECT Password from Users";
  $ch_login = mysql_query($check_login,$conn);
  $ch_pass = mysql_query($check_pass,$conn);
  if ($_SESSION['login']!=mysql_result($ch_login,0) or $_SESSION['password']!=mysql_result($ch_pass,0)){
   echo "<p align='center'><a href='index.php'>Компьютерная техника</a>";
   echo "<p align='center'><a href='index.php?show=login'>Вход администратора</a></p>";  
  }
  if ($_SESSION['login']==mysql_result($ch_login,0)&&$_SESSION['password']==mysql_result($ch_pass,0)){
  echo "<p align='center'><a href='index.php'>Компьютерная техника</a></p>";
  echo "<p align='center'><a href='index.php?show=changepass'>Изменить пароль</a></p>";
  echo "<p align='center'><a href='index.php?show=logout'>Выход</a></p>";
 }
 echo "</div>";
}

?>
</body>
</html>