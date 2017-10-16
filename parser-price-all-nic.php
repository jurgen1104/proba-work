// parser-price-all-nic
price-all-nic.txt  основной файл цен выдранных из страниц
https://www.nic.ru/dns/reglaments/tariff_all_dom.html тарифы международн зон
https://www.nic.ru/dns/reglaments/tariff_ntld.html тарифы на новые зоны
<html>
<head>
</head>
<body>

<br/>
<?php


// сначала запускается скрипт start-table-domains

// файл для парсинга должен быть расположен на сервере под названием price-all-nic.txt
// вызов парсера будет из браузера

	


//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}



$pointer = 0;



//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-nic-ru/price-all-nic.txt");
if ($cont) {echo 'Данные из файла price-all-nic.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла price-all-nic.txt' ;
break;
}





// делаем перебор зон и цен в блоке регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№

// $stroka1 = 'class="tld nowrap"';
// $len1 = strlen($stroka1);

// $stroka2 = 'span>';
// $len2 = strlen($stroka2);

// $stroka3 = 'width="90">';
// $len3 = strlen($stroka3);
// берем блок зоны

do {


$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найдено начало блока $stroka1. break pos1=0.';
break;}

// $pos1 = strpos($cont, $stroka2,$curr);//позиция от начала файла   
// if (!$pos1) {
// echo 'Не найдено начало блока $stroka2. break pos1=0.';
// break;}
// echo '<br/>Указатель 1: '.$pos1;

// $pos2 = strpos($cont, "<",$pos1);//позиция от начала файла 
// echo '<br/>Указатель 2: '.$pos2;
// if (!$pos2) {
// echo 'Не найдено начало блока "<". break pos2=0.';
// break;}

// $pos1 = $len2 + $pos1;
$size = $curr - $pointer ;

// если пустая строка выход из текущего цикла
// if (!$size) {
// ++$pointer;
// break;}

$line = substr($cont,$pointer,$size);//выдираем блок зоны и цены


// echo '<br/>Размер блока: '.$size;

// препарируем блок данных на нужные символы

// если первый символ комментарий то выход из текущего цикла
if (!preg_match('/\#/',$line)) {
// $pointer = $curr+1;
// break;
// }

if (preg_match('/[a-zа-я]/i', $line)) {
$locpoint = 0;
$pos1 = strpos($line, " ",$locpoint);//находим первый пробел
if (!$pos1) {
echo 'Не найдено начало блока $stroka2"> break pos1=0.';
break;}


$size = $pos1 - $locpoint;
$zone = strtoupper(substr($line,$locpoint,$size));//выдираем блок зоны
$zone = iconv("windows-1251", "UTF-8", $zone);
$locpoint = $pos1 +1;

if (!preg_match('/\./', $zone)) { $zone = ".".$zone;}
echo '<br/>Зона: '.$zone;

if(strpos($line, "(",$locpoint)){
$pos1 = strpos($line, ")",$locpoint);//находим следующую скобку
$locpoint = $pos1;
}

preg_match('/[1-9]/',$line,$match,PREG_OFFSET_CAPTURE,$locpoint);//ищем первую цифру в строке и ее смещение
// print_r($match);
$locpoint = $match[0][1];
// echo '<br/>Смещение.:  '.$locpoint;



$pos1 = strpos($line, " ",$locpoint);//находим следующий пробел
if (!$pos1) {
echo 'Не найдено начало блока $stroka2"> break pos1=0.';
break;}

$size = $pos1 - $locpoint;
//выдираем блок цена регистрации в руб.
$price = preg_replace ("![^\d]*!", "", substr($line,$locpoint,$size));
echo '<br/>Цена регистр.:  '.$price;
$locpoint = $pos1 +1;

// пропускаем цену регистрации в долл.

$pos1 = strpos($line, " ",$locpoint);//находим след. пробел
if (!$pos1) {
echo 'Не найдено начало блока $stroka2"> break pos1=0.';
break;}

$locpoint = $pos1 +1;



$pos1 = strpos($line, " ",$locpoint);//находим след. пробел
if (!$pos1) {
echo 'Не найдено начало блока $stroka2"> break pos1=0.';
break;}

$size = $pos1 - $locpoint;
// выдираем цену продления в рублях
$price2 = preg_replace ("![^\d]*!", "", substr($line,$locpoint,$size));
echo 'Цена продл.: '.$price2 ;

//############################
// регистратор NICRU в массиве обозначается = 1 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)

$data[$zone][1][0] = $price;	
$data[$zone][1][1] = $price2;	
}
}
$pointer = $curr+1;
}
while ($line);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';

?>




<br/>
<br/>


</body></html>