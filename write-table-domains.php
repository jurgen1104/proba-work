
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">


table, tbody {
display: block;
}
tbody {

height: 800px;
overflow: auto;
}

</style>

  <script type="text/javascript">
  (function(){
var Q, d;
Q={};
d=document;
 
onload=function(){
Q.cont=d.getElementById("core").style;
Q.scr=d.getElementById("mnu");
Q.scT=Q.scr.offsetTop;
Q.scH=Q.scr.offsetHeight;
Q.scr.style.width=Q.scr.offsetWidth+'px';
 
 };
 
onscroll=function(){
var s=d.documentElement.scrollTop||d.body.scrollTop;
if(s>Q.scT){
Q.cont.marginTop=Q.scH+'px';
Q.scr.className="stop";}
else{
Q.cont.marginTop=0;
Q.scr.className="";};
 
d.getElementById("mnb").innerHTML=Q.scT+' '+Q.scH+' '+s;
 
 };
 
 
 })();

 </script>
</head>
<body>

Мониторинг цен регистраторов доменов.
<br/>
Здесь представлены цены только от официальных ICANN https://www.icann.org/ и CCTLD (Россия) http://www.cctld.ru/ аккредитованных регистраторов доменов и их реселлеров.
<br/>Чтобы быстро найти нужную вам зону используйте встроенную функцию поиска в меню у вашего браузера.
<br/>
<br/> Красным цветом выделены самые низкие цены регистрации. Зеленым фоном выделены самые низкие цены в сумме пары - регистрация/продление.
<br/>Информация обновляется автоматически при изменении цен у регистраторов. Цены указаны в рублях.
<br/>

<table border ="1" >
<thead>
<tr><td style="width:140px;">Зоны</td><td style="width:80px;">Реселлер<br/>R01-RU</td><td style="width:40px;">Регистратор<br/>RU-CENTER</td><td style="width:40px;">Регистратор<br/>REGRU</td><td style="width:40px;">Реселлер<br/>REGRU</td><td style="width:40px;">Регистратор<br/>WEBNAMES</td><td style="width:40px;">Регистратор<br/>101DOMAIN</td>
<td style="width:40px;">Реселлер<br/>DCONTEXT</td>
</tr>
</thead>
<tbody>
<tr><td style="width:140px;"></td><td style="width:80px;"></td><td style="width:40px;"></td><td style="width:40px;"></td><td style="width:40px;"></td><td style="width:40px;"></td><td style="width:40px;"></td></tr>

<!--table-enter -->
<?php
$com = 7; //число регистраторов. отсчет с нуля. обязательно менять при необходимости.


//грузим данные из файла
$data = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT']."/php/table-domains/data-table.txt"));
if ($data) {}
else {echo 'Ошибка при считывания файла data-table.txt' ;
break;
}

// проверяем наличие у зоны цен на регистрацию, если есть то выводим
// в таблицу
// параллельно проверка на самую низкую цену из всех регистраторов
// параллельно проверка на выгодные цены пары - регистр. и продление


for (Reset($data); ($i = key($data)); Next ($data)) {
	  // выбираем самую низкую цену регистрации для зоны и самую низкую цену за регистр. и продление
	  $price = 0;
	  $price2 = 0;
		// $price2 = $price2 + $data[$i][0][1] + 0;
	  for($r = 0; $r < $com; $r++) {
	  if ($data[$i][$r][0] > 0) {
		if(($price == 0) or ($price > $data[$i][$r][0])){
		$price = $data[$i][$r][0];
		}
		// $price2 = $data[$i][0][0] + 0;
		// $price2 = $price2 + $data[$i][0][1] + 0;
		if($data[$i][$r][1] > 0) {
		// $a = $data[$i][$r][0] + 0;
		// $a = $a + $data[$i][$r][1] + 0;
			if (($price2 == 0) or ($price2 > $data[$i][$r][0] + $data[$i][$r][1])) {
			$price2 = $data[$i][$r][0] + $data[$i][$r][1];
			}
		}
		}
	  }
	 
	  echo '<tr itemprop="offers" itemscope itemtype="http://schema.org/Offer"><td itemprop="name">'.$i.'</td>';
	  // составляем таблицу с подсветкой низких цен
	  for($r = 0; $r < $com; $r++) {
	  if ($data[$i][$r][0] > 0) {
		// $a = $data[$i][$r][0] + 0;
		// $a = $a + $data[$i][$r][1] + 0;
		// if ($data[$i][$r][1] > 0) {
		if (($data[$i][$r][1] > 0) and ($price2 == $data[$i][$r][0] + $data[$i][$r][1])) {
		echo '<td style="background:green">';
		} else echo '<td>';
		// }
		if($price == $data[$i][$r][0]){
			echo '<b itemprop="price" style="color:red">'.$data[$i][$r][0].'</b>/'.$data[$i][$r][1].'</td>';
		}else echo $data[$i][$r][0].'/'.$data[$i][$r][1].'</td>'; 	
	}else echo '<td>-</td>';
	}
		 echo '</tr>';
}


?>
<!--table-enter -->
</tbody>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
</body></html>