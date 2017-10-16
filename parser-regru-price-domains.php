// parser-regru-price-domains
https://www.reg.ru/company/prices - здесь указана цена продления
заносим цеы в файл regru-all-price-domains.txt

<html>
<head>
</head>
<body>

<br/>
<?php


// сначала запускается скрипт start-table-domains

// файл для парсинга должен быть расположен на сервере под названием regru-all-price-domains.txt
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
// $cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-regru/tariffs-regru.htm");
// if ($cont) {echo 'Данные из файла tariffs-regru успешно загружены.';}
// else {echo 'Ошибка при считывания файла tariffs-regru' ;
// break;
// }

$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-regru/regru-all-price-domains.txt");
if ($cont) {echo 'Данные из файла regru-all-price-domains успешно загружены.';}
else {echo 'Ошибка при считывания файла regru-all-price-domains' ;
break;
}


do {


$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок зоны. break pos1=0.';
break;}


$size = $curr - $pointer ;

$line = substr($cont,$pointer,$size);//выдираем блок 


// echo '<br/>Размер блока: '.$size;

// препарируем блок данных на нужные символы

// если первый символ комментарий то выход из текущего цикла
if (!preg_match('/\#/',$line)) {
// $pointer = $curr+1;
// break;
// }

if (preg_match('/\./', $line,$res,PREG_OFFSET_CAPTURE)) {
// print_r($res);
$locpoint = $res[0][1];



$size = $curr - $locpoint;
$zone = trim(preg_replace ("/[0-9]|-|%/", "",substr($line,$locpoint,$size)));
$zone = mb_strtoupper(iconv("windows-1251", "UTF-8", $zone), "UTF-8");


$pointer = $curr +1;

$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок цены. break pos1=0.';
break;}


$size = $curr - $pointer ;

$line = substr($cont,$pointer,$size);//выдираем блок цен

// отсутствие цены в файле указывается  0
// поэтому если первая цифра 0 или вообще нет цифр то выход
preg_match('/[0-9]/',$line,$match,PREG_OFFSET_CAPTURE);

if (($match[0][0] != "") and ($match[0][0] != "0")) {


//находим косую черту
preg_match('/\//',$line,$match,PREG_OFFSET_CAPTURE);
$locpoint = $match[0][1];

$size = $locpoint;
//выдираем блок цена регистрации в руб.


$price = preg_replace ("![^\d]*!", "", substr($line,0,$size));

// $locpoint = $pos1 +1;
// выдираем блок продления в руб.


$size = $curr - $locpoint;

$price2 = preg_replace ("![^\d]*!", "", substr($line,$locpoint,$size));
//############################
// регистратор REGRU в массиве обозначается = 2 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)



$data[$zone][2][0] = $price;	
$data[$zone][2][1] = $price2;
echo '<br/>Зона: '.$zone;
echo '<br/>Цена регистр.:  '.$price;
echo '<br/>Цена продлен.:  '.$price2;
}
}
}
$pointer = $curr +1;
}
while ($line);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';



?>





















// $conv = iconv("KOI8-R", "windows-1251", $cont);
// $conv = iconv("windows-1252", "UTF-8", $cont);
// $locale = setlocale(LC_ALL, 'ru_RU.UTF-8');
    // echo "Current locale is '$locale'";  
	// $locale = setlocale(LC_ALL, 'ru_RU.WINDOWS-1251');
    // echo "Current locale is '$locale'";  
	



// делаем перебор зон и цен в блоке регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№

$stroka1 = 'b-table-tlds__item-name">';

$len1 = strlen($stroka1);
$stroka2 = 'list-item">1';

$len2 = strlen($stroka2);


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
echo 'Не найдено начало блока "&nbsp;". break pos2=0.';
break;}


$size = $pos2 - $curr;
// $price = substr($cont,$curr,$size);
// $matches = substr($cont,$curr,$size);//выдираем блок цены
$price = preg_replace ("![^\d]*!", "",substr($cont,$curr,$size));
// echo '<br/>Цена: '.$price;
$pointer = $pos2;


// регистратор REGRU в массиве обозначается = 2 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)
// заносим данные цену регистрации. Цены продления пока нет

$data[$zone][2][$i] = $price;	
	echo '<br/>Зона: '.$zone;
	echo '<br/>Цена рег. : '.$price;
}
while ($price);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';
?>


<br/>
<br/>


</body></html>