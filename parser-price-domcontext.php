// parser-price-domcontext
price-domains-domcontext.txt  основной файл цен

<html>
<head>
</head>
<body>

<br/>
<?php


// сначала запускается скрипт start-table-domains

// файл для парсинга должен быть расположен на сервере под названием price-domains-domcontext.txt
// вызов парсера будет из браузера

	


//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {echo 'Данные из файла data-table.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла data-table.txt' ;
exit();
}



$pointer = 0;



//грузим данные из файла
$cont = file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/parser-reseller-domcontext/price-domains-domcontext.txt");
if ($cont) {echo 'Данные из файла price-domains-domcontext.txt успешно загружены.';}
else {echo 'Ошибка при считывания файла price-domains-domcontext.txt' ;
exit();
}





// делаем перебор зон и цен в блоке регистрации доменов
// №№№№№№№№№№№№№№№№№№№№№№№


do {
++$i;

$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок зоны и цены. break pos1=0.';
break;}


$size = $curr - $pointer ;

$line = substr($cont,$pointer,$size);//выдираем блок 


// echo '<br/>Размер блока: '.$size;

// препарируем блок данных на нужные символы

// если первый символ комментарий то выход из текущего цикла
if (!preg_match('/\#|[1-9]/',$line)) {
// $pointer = $curr+1;
// break;
// }


$line = iconv("windows-1251", "UTF-8", $line);
if (preg_match('/[a-zа-я]/', $line)) {
// print_r($res);
// $locpoint = $res[0][1];
// $pos1 = strpos($line, "\n",$locpoint);//находим первый пробел
// if (!$pos1) {
// echo 'Не найден \n после блока зоны"> break pos1=0.';
// break;}


// $size = $pos1 - $locpoint;
// $zone = trim(substr($line,$locpoint,$size));
$res = trim($line);
$zone = ".".$res ;
$zone = mb_strtoupper($zone, "UTF-8");

// $zone = strtoupper(substr($line,$locpoint,$size));//выдираем блок зоны
// $zone = iconv("windows-1251", "UTF-8", $zone);
do {
$pointer = $curr +1;

$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок зоны и цены. break pos1=0.';
break(3);}


$size = $curr - $pointer ;

$line = substr($cont,$pointer,$size);//выдираем блок 

}
while (!preg_match('/[1-9]/',$line)) ;//ищем первую цифру в строке и ее смещение

// $locpoint = $match[0][1];
// echo '<br/>Смещение.:  '.$locpoint;


// $pos1 = strpos($line, "\n",$locpoint);//находим следующий пробел
// if (!$pos1) {
// echo 'Не найден \n после блока цены"> break pos1=0.';
// break;}

// $size = $pos1 - $locpoint;
//выдираем блок цена регистрации в руб.
// $price = preg_replace ("/,/", "", substr($line,$locpoint,$size));
$price = preg_replace ("![^\d]*!", "",$line);
// $price = preg_replace ("![^\d]*!", "", substr($line,0,$size));

// $pos1 = strpos($price, ".");//находим точку в цене
// if ($pos1) {
// $price = substr($price,0,$pos1);
// }
do {
$pointer = $curr +1;

$curr = strpos($cont, "\n", $pointer);//позиция от начала файла
if (!$curr) {
echo 'Не найден общий блок цены. break pos1=0.';
break(3);}


$size = $curr - $pointer ;

$line = substr($cont,$pointer,$size);//выдираем блок 

}
while (!preg_match('/[1-9]/',$line)) ;//ищем первую цифру в строке и ее смещение


// $locpoint = $match[0][1];
// $pos1 = strpos($line, "\n",$locpoint);//находим следующий пробел
// if (!$pos1) {
// echo 'Не найден \n после блока цены продления"> break pos1=0.';
// break;}

// $size = $pos1 - $locpoint;
//выдираем блок цена продления в руб.
// $price = preg_replace ("/,/", "", substr($line,$locpoint,$size));
// $price2 = preg_replace ("![^\d]*!", "", substr($line,0,$size));
$price2 = preg_replace ("![^\d]*!", "",$line);

// определяем скидки зон чтобы не устанавливать цену продления на них
// цену продления придется устанавливать вручную
//############################
// $line = iconv("windows-1251", "UTF-8", $line);
// if (!preg_match('/great pricing|распродаже/',$line,$res)) {
// $data[$zone][5][1] = $price;
// }

// } else print_r ($res);
// $data[$zone][5][0] = $price;	
//############################
// регистратор DomainContext в массиве обозначается = 6 , при желании можно менять. Массив - (зона, регистратор, цена рег., цена продл.)

$data[$zone][6][0] = $price;	
$data[$zone][6][1] = $price2;
echo '<br/>Зона: '.$zone;
echo '<br/>Цена регистр.:  '.$price;
echo '<br/>Цена продл.:  '.$price2;
}
}

$pointer = $curr +1;
}
while ($line);

$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($data)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';
echo '<br/>Циклы: '.$i;
?>

<br/>
<br/>

<br/>
<br/>


</body></html>