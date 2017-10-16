<?php

 for($i = 0; $i < 1001; $i++) {
	if ($i % 3 == 0)
	{
		if($i % 5 != 0)
		{
		$cnt = str_split($i);
		$summ = 0;
		for ($k=0; $k < count($cnt); $k++) 
		{
		$summ += $cnt[$k];	
		}
			if ($summ < 10)
			{
			echo $i;
			}
		}
	}
}
 ?>
 
 $la = $domain[$i][0];
 print "<option value='$i'>.$la";
 }




 for($i = 0; $i < count($domain); $i++) {
 $la = $domain[$i][0];
 print "<option value='$i'>.$la";
 }


?>