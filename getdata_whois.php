// �������� ����� �� iana � �������� ������� ������
<html>
<head>
</head>
<body>

<br/>
<?php

$fp = fopen($_SERVER['DOCUMENT_ROOT']."/php/whois/basedomains.txt", 'wb');//��������� ���� � ��������� ������� �����������
fclose($fp); //�������� �����

function browser($url) {
$url="http://www.iana.org/domains/root/db";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
$html = curl_exec($ch);
curl_close($ch);
return $html;
}
// �������� ���������� ���������� ��� ������ �� �������� browser($url) � ������ $text
preg_match_all('~<span class="domain tld"><a href="/domains/root/db/(.*?)</a>~is', browser($url), $text);



foreach ($text as $value) {
//$result=implode("\n",$text);
$test = file_put_contents($_SERVER['DOCUMENT_ROOT']."/php/whois/basedomains.txt", implode("\n",$value)); // ������ � ����
}
if ($test) echo '������ � ���� ������� ��������.';
else echo '������ ��� ������ � ����.';








// �������� ���������� ���������� ������ ����� �� ������� $text
//$stroka = str_replace('.html">',"", array_slice($text[1], 0, 3)); //������� ������ ��� ������

//print $stroka ;
//strstr(array_slice($text[1], 0, 3), '.');

?>

</body></html>