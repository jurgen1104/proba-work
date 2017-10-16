// parser-webnames-price-domains
https://www.webnames.ru/billing/discount основная страница цен
копируется в файл webnames-all-price-domains.txt
в формате UTF-8 !!!

<html>
<head>
</head>
<body>

<br/>
<?php


// сначала запускается скрипт start-table-domains

// файл HTML для парсинга должен быть расположен на сервере под названием webnames-all-price-domains.txt
// вызов парсера будет из браузера

	


//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}



$pointer = 0;



//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-webnames/webnames-all-price-domains.txt");
if ($cont) {echo 'Данные из файла webnames-all-price-domains успешно загружены.';}
else {echo 'Ошибка при считывания файла webnames-all-price-domains' ;
break;
}
// $cont = file_get_contents("https://www.webnames.ru/domains/check");
// if ($cont) {echo 'Данные из файла tariffs-webnames успешно загружены.';}
// else {echo 'Ошибка при считывания файла tariffs-webnames' ;
// break;
// }

do {
// берем общий блок зоны и цены

$curr = mb_strpos($cont, "\n", $pointer, "UTF-8");//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок зоны и цены. break pos1=0.';
break;}


$size = $curr - $pointer ;

$line = mb_substr($cont,$pointer,$size, "UTF-8");//выдираем блок 

// препарируем блок данных на нужные символы

// если первый символ комментарий то выход из текущего цикла
if (!preg_match('/\#/',$line)) {
// $line = iconv("windows-1251", "UTF-8", $line);
// если нет слова 'Домены в зоне' то выход из текущего цикла
if (preg_match('/Домены в зоне/', $line)) {
echo '<br/>блок : '.$line;
// ищем первую точку в строке
// if (preg_match('/\./u', $line,$res,PREG_OFFSET_CAPTURE)) {
$locpoint = mb_strpos($line, ".",0, "UTF-8");
// $locpoint = $res[0][1];

$pos1 = mb_strpos($line, " ",$locpoint, "UTF-8");//находим первый пробел
echo '<br/>pos1 : '.$pos1;
if (!$pos1) {
echo 'Не найден пробел после блока зоны"> break pos1=0.';
break;}

$size = $pos1 - $locpoint;
$zone = mb_strtoupper(mb_substr($line,$locpoint,$size, "UTF-8"), "UTF-8");
// $zone = mb_strtoupper(iconv("windows-1251", "UTF-8", $zone), "UTF-8");
$locpoint = $pos1 +1;

if (preg_match('/Акция:/',$line)) {
$action = 1;
} else $action = 0;

$line = iconv("UTF-8", "windows-1251", $line);

//ищем первую цифру в строке и ее смещение
preg_match('/[1-9]|-/',$line,$match,PREG_OFFSET_CAPTURE);

if (($match[0][0] != "") and ($match[0][0] != "-")) {
$locpoint = $match[0][1];
echo '<br/>locpoint : '.$locpoint;


$pos1 = strpos($line, " ",$locpoint);//находим следующий пробел
if (!$pos1) {
echo 'Не найден пробел после блока цены"> break pos1=0.';
break;}

$size = $pos1 - $locpoint;
//выдираем блок цена регистрации в руб. заодно убираем запятую если есть
$price = preg_replace ("/,/", "", substr($line,$locpoint,$size));

// $pos1 = mb_strpos($price, ".", "UTF-8");//находим точку в цене если есть
// if ($pos1) {
// $price = mb_substr($price,0,$pos1, "UTF-8");
// }


//############################
// регистратор WEBNAMES в массиве обозначается = 4 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)
// заносим данные цену регистрации. Цены продления совпадает с ценой регистрации , но некоторые цены придется править следя за скидками  здесь https://www.webnames.ru/billing/discount 

$data[$zone][4][0] = $price;
echo '<br/>Зона: '.$zone;
echo '<br/>Цена рег. : '.$price;
// определяем скидки зон или акции
if ($action) {
	preg_match('/[1-9]|-/',$line,$match,PREG_OFFSET_CAPTURE,$pos1);
	if ($match[0][0] != "-") {
		$locpoint = $match[0][1];
		$pos1 = strpos($line, " ",$locpoint);//находим следующий пробел
		$size = $pos1 - $locpoint;
		$price = preg_replace ("/,/", "", substr($line,$locpoint,$size));
		}
	}
$data[$zone][4][1] = $price;
echo '<br/>Цена продл. : '.$price;
// }
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




<br/>
<br/>


</body></html>