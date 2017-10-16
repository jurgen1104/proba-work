
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>

<?php 
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}
$GLOBALS["data"] = $data;
?>
<br/>Ввод или удаление данных в базе цен на домены.
<form method="post" style="border-radius: 20px;border:2px solid #808080;background-color:#c0c0c0;margin: 5px;">
<table width="100%" >
<tr><td>
Зона: 
<br/><input type="text"  size="8" name="zone" > Пример.: .ORG
<br/>
<br/>
<br/>
 <input type="submit" value="Сохранить в базе">
<input type="reset" value="Сброс">
<input type="text" name="control" style="display:none">
<input type="hidden" value="post">
<br/>################################
<br/>Удалить зону:
<br/><input type="text"  size="8" name="del-zone" > Пример.: .ORG
<br/>
<br/>
<br/><input type="submit" value="Удалить из базы">
</td>
<td>
Регистратор: 
<br/><select name = "registrator">
  <option value = "0">0 -НИК "БП"
  <option value = "1">1 -ЗАО "РСИЦ"
  <option value = "2">2 -ООО "РДИ"
  <option value = "3">3 -реселлер REG.ru
  <option value = "4">4 -ООО "ИИ"
  <option value = "5">5 -ООО "101-РД"
  <option value = "6">6 -DomainContext Inc.
  <option value = "7">7
  <option value = "8">8
  <option value = "9">9
 </select>
 </td>
 <td>
Цена регистрации (руб.): 
<br/><input type="text"  size="8" name="price-reg" > Пример.: 3200
<br/>Если пустое поле, то изменений не будет.
</td>
<td>
Цена продления (руб.): 
<br/><input type="text"  size="8" name="price-long" > Пример.: 1000
<br/>Если пустое поле, то изменений не будет.

 </td></tr>
 </table>
 </form>
 <?php 
global $data;
// require_once('idna_convert.class.php');

//	  header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF'])."#fix"); 
//print header();

  if(!empty($_POST))
  {	if($_POST['control']=="") {
  if($_POST['del-zone']=="") {
      $zone = mb_strtoupper(trim($_POST['zone']), "UTF-8");
	  $reg = trim($_POST['registrator']);
	  if($_POST['price-reg'] !== "") {
	  $price = trim($_POST['price-reg']);
	  $data[$zone][$reg][0] = $price;
	  }
	  if($_POST['price-long'] !== "") {
	  $price2 = trim($_POST['price-long']);
	  $data[$zone][$reg][1] = $price2;
	  }

	  echo "<br/>Введено в базу: Зона: ".$zone."<br/>Регистратор: ".$reg."<br/>Цена регистрации: ".$price."<br/>Цена продления: ".$price2;
  
  
    } else {$zone = trim($_POST['del-zone']);
	unset($data[$zone]);
	echo 'Удалена зона из базы: '.$zone;}
	  }
	else  exit();
	
	$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
	if ($test) echo 'Данные в файл базы успешно занесены.';
	else echo 'Ошибка при записи в файл базы.';
  }


?>

</body></html>


