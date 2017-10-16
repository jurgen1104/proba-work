// загрузка данных доменов 1 уровня
<html>
<head>
</head>
<body>

<br/>
<?php
//Внимание. Перед запуском этого скрипта сначала нужно запустить скрипт getdata_whois.php
//чтобы остановить прогу по своему желанию в основную директорию вашего хоста,  $_SERVER['DOCUMENT_ROOT'] загрузите файл stop.txt
 set_time_limit(60);

$url="http://www.iana.org/whois?q=";
//$control = 2; //циклы по 1 в сек. 130 циклов = 130 сек работы проги.
//Значение нужно менять от настроек вашего хостинга - времени в секундах максимально допустимой работы одного скрипта минус 10%

if(file_exists($_SERVER['DOCUMENT_ROOT']."/php/whois/signal.txt")){
echo 'Данные уже обновлены, запустите другой скрипт';
exit();
}
//грузим данные из файла
$file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/basedomains.txt");
if ($file) {echo 'Данные из файла успешно загружены.';}
else {echo 'Ошибка при считывания файла.' ;
break;
}

//грузим селектор из файла
$globpos1 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/datawhois.ini");
echo "Селектор вначале: ".$globpos1;

if ($globpos1 == 0) {
$fp = fopen($_SERVER['DOCUMENT_ROOT']."/php/whois/whois_res.txt", 'wb');//открываем файл с удалением старого содержимого
fclose($fp); //Закрытие файла
//$globpos1 = 5;//пропустить начальные символы в документе
}



//while ($control) {

// берем имя домена в конце строки напр. auction.html">.auction
 
$pos1 = strpos($file, "\n",$globpos1);//позиция от начала файла по переносу строки

if (!$pos1) {

$globpos1 = 0;

$fp = fopen($_SERVER['DOCUMENT_ROOT']."/php/whois/signal.txt", "w");
if ($fp) echo 'Создан сигнальный файл.';
else echo 'Ошибка при создании сигнального файла.';
fclose($fp);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/datawhois.ini", $globpos1); // Запись в файл
if ($test) echo 'Данные  в whois_res.txt обновлены.';
else echo 'Ошибка при записи селектора в файл.';

echo 'break pos1=0.';
break;}

$pos2 = strpos($file, '>.',$globpos1);//позиция от начала файла по точке и значку
//прибавляем смещение к глобальному селектору позиции


$pos2 = $pos2 + 2 ;

$size = $pos1 - $pos2;
$text =  substr($file,$pos2,$size);//выдираем имя домена

$globpos1 = $pos1 + 1 ;

$path = $url.$text;//компонуем адресную строку
echo $path;
// получаем веб страницу
 function browser($path) {
$ch = curl_init($path);
curl_setopt($ch, CURLOPT_URL,$path);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$html = curl_exec($ch);
curl_close($ch);
return $html;
}



$pos = strpos(browser($path), 'whois:');

if ($pos) {
echo "Начало парсинга вебстраницы";
$pos = $pos + 6 ;

$pos3 = strpos(browser($path), "\n",$pos);//позиция по переносу строк

$pos3 = $pos3 - $pos;
$line = 'array("'.$text.'","'.ltrim(substr(browser($path),$pos,$pos3)).'","Domain Not Found"),'."\n";//выдираем имя whois домена и сразу компонуем
//записываем в файл строку
$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/whois_res.txt", $line,FILE_APPEND); // Запись в файл
if ($test) echo 'Данные в файл успешно занесены.';
else echo 'Ошибка при записи в файл.';
}
//это защита от бесконечого цикла работы программы из за возможных ошибок программирования
// clearstatcache();//обязательно вызвать
// if(file_exists($_SERVER['DOCUMENT_ROOT']."/stop.txt")){
// echo 'Принудительное прерывание работы';
// exit("Принудительное прерывание работы");
// }
// sleep(10);
// echo "Селектор: ".$globpos1;

 //--$control;
//if ($control == 0) {
//сохраняем селектор в файл для последующего продолжения
$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/datawhois.ini", $globpos1); // Запись в файл
if ($test) echo 'Данные селектора в файл успешно занесены.';
else echo 'Ошибка при записи селектора в файл.';
// }

//}



?>

</body></html>