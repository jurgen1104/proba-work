// parser panel R01 price domains
https://panel.reghouse.ru/RES/tariff_konstr.khtml?page=0
https://panel.reghouse.ru/RES/tariff_konstr.khtml?page=1
<html>
<head>
</head>
<body>

<br/>
<?php
// сначала запускается скрипт table-price-domain
// файл HTML для парсинга должен быть расположен на сервере под названием price-panel-r01-№ ;; № - номер страницы от 1
// вызов парсера будет из браузера

	
$str = 1 ;

//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}

do {

$pointer = 0;
$i = 0;


//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-reseller-r01/price-panel-r01-".$str.".htm");
if ($cont) {echo 'Данные из файла price-panel-r01-'.$str.' успешно загружены.';}
else {echo 'Ошибка при считывания файла price-panel-r01-'.$str ;
break;
}


// $conv = iconv("KOI8-R", "windows-1251", $cont);
$conv = iconv("KOI8-R", "UTF-8", $cont);
// $locale = setlocale(LC_ALL, 'ru_RU.UTF-8');
    // echo "Current locale is '$locale'";  
	// $locale = setlocale(LC_ALL, 'ru_RU.WINDOWS-1251');
    // echo "Current locale is '$locale'";  
	
	
 // print $conv ; 
$stroka = "Регистрация доменного имени в зоне ";
$len = mb_strlen($stroka,"UTF-8");
// echo 'Длина строки'.$len;

do {
do {
$pos1 = mb_strpos($conv, $stroka,$pointer,"UTF-8");//позиция от начала файла по замене блока
if (!$pos1) {
echo 'Не найдено начало блока. break pos1=0.';
break;}

// echo 'Указатель 1: '.$pos1;

$pos2 = mb_strpos($conv, " руб",$pos1,"UTF-8");//позиция от начала файла по замене блока
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока. break pos2=0.';
break;}
$pos1 = $len + $pos1;
$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$text =  mb_substr($conv,$pos1,$size,"UTF-8");//выдираем блок -имя домена и цена
$pointer = $pos2 + 8 ;
// print "<br/>Блок: ".$text;
// print $pos1;
// preg_match_all('~ valign="middle">(.*?)<br></pre>~is', $conv, $text);
// print_r ($text);

$pos1 = mb_strpos($text, " - ",0,"UTF-8");//позиция от начала текста

$zone = mb_strtoupper(mb_substr($text,0,$pos1,"UTF-8"),"UTF-8");// берем зону
$pos1 = $pos1 + 3 ;
$size = $size - $pos1;
$price1 = mb_substr($text,$pos1,$size,"UTF-8");// берем цену регистрации

// регистратор R01 в массиве обозначается = 0 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)

// заносим данные цену регистрации

$data[$zone][0][$i] = $price1;
echo '<br/>Зона: '.$zone;
echo '<br/>Цена рег. : '.$price1;
}
while ($zone);

$stroka = "Продление доменного имени в зоне ";
$len = mb_strlen($stroka,"UTF-8");
$pointer = 0;
++$i;
}
while ($i < 2);

++$str;
}
while ($str);

echo '<br/>Селектор. : '.$a;


$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';


?>
<br/>
<br/>


</body></html>