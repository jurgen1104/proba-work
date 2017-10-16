// создание таблицы html-php Самое начало.
<html>
<head>
</head>
<body>

<br/>

<?php

// устанавливаем предпочтительные или приоритетные зоны для отображения в таблице
//остальные зоны добавляются программно в произвольном порядке
$zone = array();

$zone[".RU"] = "";
$zone[".РФ"] = "";
$zone[".SU"] = "";
$zone[".MOSCOW"] = "";
$zone[".МОСКВА"] = "";
$zone[".COM"] = "";
$zone[".NET"] = "";
$zone[".ORG"] = "";
$zone[".BIZ"] = "";
$zone[".INFO"] = "";
$zone[".NAME"] = "";
$zone[".TEL"] = "";
$zone[".TV"] = "";
$zone[".MOBI"] = "";
$zone[".ASIA"] = "";
$zone[".US"] = "";
$zone[".IN"] = "";
$zone[".CC"] = "";
$zone[".WS"] = "";
$zone[".BZ"] = "";
$zone[".ME"] = "";
$zone[".KZ"] = "";
$zone[".PRO"] = "";




$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt", serialize($zone)); // Запись в файл
if ($test) echo 'Данные таблицы в файл успешно занесены.';
else echo 'Ошибка при записи таблицы в файл.';


?>


</body></html>