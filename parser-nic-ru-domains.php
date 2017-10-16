// parser-NIC-RU-price-domains главная страница
https://www.nic.ru/dns/contract-zao/  основная страница цен
https://www.nic.ru/dns/contract-zao/sup2_price.html тарифы на основные зоны 19 февраля 2015 г.
####################
другие цены сохраняются в отдельный файл price-all-nic.txt
https://www.nic.ru/dns/reglaments/tariff_all_dom.html тарифы международн зон
https://www.nic.ru/dns/reglaments/tariff_ntld.html тарифы на новые зоны 
и парсятся другим парсером!!!!!
№№№№№№№№№№№№№№№№№№№№№№№№№
<html>
<head>
</head>
<body>

<br/>
<?php
//здесь парсятся данные тарифы только на основные зоны https://www.nic.ru/dns/contract-zao/sup2_price.html
// на друге зоны используются другие скрипты

// сначала запускается скрипт start-table-domains


// вызов парсера будет из браузера
// №№№№№№№№№№№№№№№№№№№№№№
// ВНИМАНИЕ непонятный пока НЕУСТРАНИМЫЙ пропуск некоторых данных 
// нужно перепроверять результаты парсинга
// №№№№№№№№№№№№№№№№№№№3
	
$str = 1 ;

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
$cont = file_get_contents("http://nic.ru/dns/contract-zao/sup2_price.html");
if ($cont) {echo 'Данные из файла tariffs-'.$str.' успешно загружены.';}
else {echo 'Ошибка при считывания файла tariffs-'.$str ;
break;
}


// $conv = iconv("KOI8-R", "windows-1251", $cont);
$conv = iconv("windows-1251", "UTF-8", $cont);
// $locale = setlocale(LC_ALL, 'ru_RU.UTF-8');
    // echo "Current locale is '$locale'";  
	// $locale = setlocale(LC_ALL, 'ru_RU.WINDOWS-1251');
    // echo "Current locale is '$locale'";  
	

// грузим из файла data-izmenenia.txt дату последних изменений тарифов
$izmen = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-nic-ru/data-izmenenia.txt");
if ($izmen) {echo 'Данные из файла data-izmenenia.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-izmenenia.txt' ;
break;
}

// проверяем обновление документа
// №№№№№№№№№№№№№№№№№№№№№№№

$stroka = "Введено в действие с ";
$len = mb_strlen($stroka,"UTF-8");
// ищем в вебданных строку "Введено в действие с" и выдираем дату
$pos1 = mb_strpos($conv, $stroka,$pointer, "UTF-8");//позиция от начала файла 
if (!$pos1) {
echo 'Не найдено начало блока. break pos1=0.';
break;}
// сравниваем данные. если равны то выход
echo $pos1;

$pos2 = mb_strpos($conv, " г.",$pos1,"UTF-8");//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока. break pos2=0.';
break;}

$pos1 = $len + $pos1;
$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$izmen1 =  mb_substr($conv,$pos1,$size,"UTF-8");//выдираем блок дату создания документа
$pointer = $pos2 + 8 ;
print "<br/>Блок: ".$izmen1;
$result = strcmp($izmen,$izmen1);
if (!$result) {
echo 'Документ еще не обновлялся. Парсер завершен.';
break;}


// берем блок с тарифами в рублевой зоне
// №№№№№№№№№№№№№№№№№№№№№№№

$pos1 = mb_strpos($conv, "Тариф (руб.)",$pointer, "UTF-8");//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока "Тариф (руб.)". break pos1=0.';
break;}

$pos2 = mb_strpos($conv, "Тариф (USD)",$pos1,"UTF-8");//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока "Тариф (USD)". break pos2=0.';
break;}

$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$text =  mb_substr($conv,$pos1,$size,"UTF-8");//выдираем блок с рублевыми ценами




$string0 = "Регистрация одного домена";

$string1 = "Подача заявки";
$i = 0;
// в блоке с тарифами в рублях берем блок регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№

do {
$pointer = 0;
$pos1 = mb_strpos($text, $string0,$pointer, "UTF-8");//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока'. $string0.'. break pos1=0.';
break;}
$len0 = mb_strlen($string0,"UTF-8") + $pos1;

$pos2 = mb_strpos($text, $string1,$len0,"UTF-8");//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока '.$string1.'. break pos2=0.';
break;}


$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$regprice =  mb_substr($text,$pos1,$size,"UTF-8");//выдираем блок регистрации с рублевыми ценами


// делаем перебор зон и цен в блоке регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№

$stroka1 = "в домене ";
$len1 = mb_strlen($stroka1,"UTF-8");
$stroka2 = 'vmiddle">';
$len2 = mb_strlen($stroka1,"UTF-8");

// берем блок зоны

do {

$pos1 = mb_strpos($regprice, $stroka1,$pointer, "UTF-8");//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока "в домене ". break pos1=0.';
break;}

$pos2 = mb_strpos($regprice, "<",$pos1,"UTF-8");//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока "<". break pos2=0.';
break;}

$pos1 = $len1 + $pos1;
$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$zone =  trim(mb_substr($regprice,$pos1,$size,"UTF-8"));//выдираем блок зоны
// print "<br/>control:".$zone;
$pointer = $pos2;


// берем блок цены



$pos1 = mb_strpos($regprice, $stroka2,$pointer, "UTF-8");//позиция от начала файла
if (!$pos1) {
echo 'Не найдено начало блока vmiddle"> break pos1=0.';
break;}

$pos2 = mb_strpos($regprice, "<",$pos1,"UTF-8");//позиция от начала файла 
// echo 'Указатель 2: '.$pos2;
if (!$pos2) {
echo 'Не найдено начало блока "<". break pos2=0.';
break;}

$pos1 = $len2 + $pos1;
$size = $pos2 - $pos1;
// echo '<br/>Размер блока: '.$size;
$price =  mb_substr($regprice,$pos1,$size,"UTF-8");//выдираем блок цены

$pointer = $pos2;


// регистратор NICRU в массиве обозначается = 1 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)
// заносим данные цену регистрации



// проверяем в блоке зоны наличие нескольких зон .COM.RU, .NET.RU, .ORG.RU, .PP.RU

$pos2 = mb_strpos($zone, ", .",0, "UTF-8");//позиция от начала файла
if ($pos2) {
	echo 'В блоке есть дополнит. зоны. ';

	$pos1 = 0;
	
	do {
	$size = $pos2 - $pos1;
	$zone1 =  trim(mb_substr($zone,$pos1,$size,"UTF-8"));
	$data[$zone1][1][$i] = $price;	
	echo '<br/>Зона: '.$zone1;
	echo '<br/>Цена рег. : '.$price;
	$pos1 = $pos2 + 2;
	
	$pos2 = mb_strpos($zone, ", .",$pos1, "UTF-8");
	if (!$pos2) {
	$size = $pointer - $pos1;
	$zone1 =  trim(mb_substr($zone,$pos1,$size,"UTF-8"));
	
	$data[$zone1][1][$i] = $price;	
	echo '<br/>Зона: '.$zone1;
	echo '<br/>Цена рег. : '.$price;
	}
	}
	while ($pos2);
}
else {
$data[$zone][1][$i] = $price;
echo '<br/>Зона; '.$zone;
echo '<br/>Цена; '.$price;
}
}
while ($price);

$string0 = 'Продление регистрации одного домена';
$string1 = 'Продление регистрации';
++$i;
}
while ($i < 2);




$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-nic-ru/data-izmenenia.txt", $izmen1); // Запись в файл
if ($test) echo 'Данные в файл data-izmenenia.txt успешно занесены.';
else echo 'Ошибка при записи в файл data-izmenenia.txt.';

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';

?>
 

<br/>
<br/>


</body></html>