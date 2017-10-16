// parser-regru-reseller-price-domains
http://cccp-planeta.ru/registrator-REGRU/price/  основная страница цен

<html>
<head>
</head>
<body>

<br/>
<?php


// сначала запускается скрипт start-table-domains

// файл HTML для парсинга должен быть расположен на сервере под названием tariffs-regru-reseller.htm
// вызов парсера будет из браузера

	


//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}

// do {

$pointer = 0;
$i = 0;


//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-reseller-regru/tariffs-regru-reseller.htm");
if ($cont) {echo 'Данные из файла tariffs-regru успешно загружены.';}
else {echo 'Ошибка при считывания файла tariffs-regru' ;
break;
}


// $conv = iconv("KOI8-R", "windows-1251", $cont);
// $conv = iconv("windows-1252", "UTF-8", $cont);
// $locale = setlocale(LC_ALL, 'ru_RU.UTF-8');
    // echo "Current locale is '$locale'";  
	// $locale = setlocale(LC_ALL, 'ru_RU.WINDOWS-1251');
    // echo "Current locale is '$locale'";  
	



// делаем перебор зон и цен в блоке регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№

$stroka1 = 'b-table__cell_first">';
$len1 = strlen($stroka1);

$stroka2 = 'b-table__cell">';
$len2 = strlen($stroka2);

$stroka3 = 'b-table__cell_last">';
$len3 = strlen($stroka3);
// берем блок зоны

do {


$pos1 = strpos($cont, $stroka1,$pointer);//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока $stroka1. break pos1=0.';
break;}


$pos2 = strpos($cont, "<",$pos1);//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока "<". break pos2=0.';
break;}

$pos1 = $len1 + $pos1;
$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$zone = substr($cont,$pos1,$size);//выдираем блок зоны

$zone = iconv("windows-1251", "UTF-8", $zone);

$zone = preg_replace ("/idn в /iu", "",$zone);
// print "<br/>Зона: ".$zone;
$pointer = $pos2;


// берем блок цены



$pos1 = strpos($cont, $stroka2,$pointer);//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока $stroka2"> break pos1=0.';
break;}

$curr = $pos1 + $len2;
$pos2 = strpos($cont, "<",$curr);//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока $stroka2. break pos2=0.';
break;}


$size = $pos2 - $curr;
// $price = substr($cont,$curr,$size);
// $matches = substr($cont,$curr,$size);//выдираем блок цены
$price = preg_replace ("![^\d]*!", "",substr($cont,$curr,$size));
// echo '<br/>Цена: '.$price;
$pointer = $pos2;


// берем цену продления

$pos1 = strpos($cont, $stroka3,$pointer);//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока $stroka3"> break pos1=0.';
break;}

$curr = $pos1 + $len3;
$pos2 = strpos($cont, "<",$curr);//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока $stroka4. break pos2=0.';
break;}


$size = $pos2 - $curr;
// $price = substr($cont,$curr,$size);
// $matches = substr($cont,$curr,$size);//выдираем блок цены
$price1 = preg_replace ("![^\d]*!", "",substr($cont,$curr,$size));
// echo '<br/>Цена: '.$price;
$pointer = $pos2;

// реселлер регистратора REGRU в массиве обозначается = 3 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)
// заносим данные цену регистрации. Цены продления пока нет

$data[$zone][3][0] = $price;	
$data[$zone][3][1] = $price1;	
	echo '<br/>Зона: '.$zone;
	echo '<br/>Цена рег. : '.$price;
	echo '<br/>Цена продл. : '.$price1;
}
while ($price);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';
?>


<br/>
<br/>


</body></html>