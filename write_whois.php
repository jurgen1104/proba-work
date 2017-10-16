// загрузка данных в файл html-php
<html>
<head>
</head>
<body>

<br/>

<?php

if(file_exists($_SERVER['DOCUMENT_ROOT']."/php/whois/signal.txt")){

//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/whois_res.txt");
if ($cont) {echo 'Данные из файла whois_res.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла whois_res.txt.' ;
break;
}

$docum = file_get_contents($_SERVER['DOCUMENT_ROOT']."/registrazia-domena.php");
if ($docum) {echo 'Данные из файла registrazia-domena.php успешно загружены.';}
else {echo 'Ошибка при считывания файла registrazia-domena.php.' ;
break;
}

$pos1 = strpos($docum, "start-blok",0);//позиция от начала файла по замене блока
if (!$pos1) {
echo 'Не найдено начало блока. break pos1=0.';
break;}

$base = $pos1+11;
$pos2 = strpos($docum, "end-blok",$base);//позиция конца по замене блока
if (!$pos2) {
echo 'Не найден конец блока. break pos2=0.';
break;}
$lenght = $pos2 - $base -2;

$result = substr_replace($docum, $cont, $base, $lenght);

if (!$result) {
echo 'Не получилось замены блока. break result=0.';
break;}

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/registrazia-domena.php", $result); // Запись в файл
if ($test) echo 'Данные  в registrazia-domena.php обновлены.';
else echo 'Ошибка при записи данных в файл registrazia-domena.php';


$test = unlink($_SERVER['DOCUMENT_ROOT']."/php/whois/signal.txt"); // Удаление сигнального файла
if ($test) echo 'Удаление сигнального файла успешно.';
else echo 'Ошибка при удалении сигнального файла';

}
else echo 'Данные в файле registrazia-domena.php уже обновлены. Используйте другой скрипт для обновления данных';


?>
</body></html>