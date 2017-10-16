#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';
use URI::Escape;
#use diagnostics; # comment this out when you are done debugging
#use utf8;
#use encoding 'utf8';
#use Encode qw(decode_utf8);
#use Encode;
use open qw(:utf8); # общая настройка для STDIN STDOUT
#binmode(STDIN,':utf8');
#binmode(STDOUT,':utf8'); # binmode используется
#поиск данных по совпадению с запросом от клиента

my @stroka = ();
my $stroka = ();
my @values = ();
my $values = ();
my @keys = ();
my $keys = ();

#my $form = $ENV{'QUERY_STRING'};
my $form = () ;

read (STDIN,$form,$ENV{'CONTENT_LENGTH' }) ;

print "Content-type: text/html;charset=UTF-8\n\n"; #без нее прога отказывается работать

if (!$form) {print "Нет входных данных!"; exit;  } ;

open(F1,"dataUsers.txt" )or die 'Не могу открыть файл'.$! ; 

#получаем поисковую фразу

my @data = split(/=/,$form);#расщепление данных на отдельные значения 

my $data = @data;

if (!$data[1]){print 'Не получены  данные для поиска'; exit;};


my $find = uri_unescape($data[1]);
#print utf8::is_utf8($find);
#$find = Encode::decode('utf8',$find);

#print  $find;


@stroka =  uri_unescape(<F1>); #показывает расшифрованный весь файл
$stroka = @stroka;
#$stroka = Encode::decode('utf8',$stroka);
my $i = 0;

print '<br>Найденные совпадения по запросу: "'.$find.'" <br><br>';

while ($stroka[$i])
{ 
#@stroka =  uri_unescape(<F1>); #показывает расшифрованный весь файл
#    @stroka = uri_unescape($_); #показывает расшифрованный весь файл
#    $stroka = @stroka;
#print $stroka ; #показывает количество строк =~ /\Q$find\E/i =~ m!$find!i
#  print  $stroka[$i]."\n"; 
#print utf8::is_utf8($stroka[$i]);


if ($stroka[$i] =~ m!$find!i ) {
    


 @values=split(/&/,$stroka[$i]);# расщепление строки на поля значений 
$values = @values ;

@keys = split(/=/,$values[0]);  #расщепление данных на отдельные значения 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'ИНН : '.$keys[1].'<br> ';


@keys = split(/=/,$values[1]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Организация : '.$keys[1].'<br>';


@keys = split(/=/,$values[2]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Имя : '.$keys[1].'<br>';


@keys = split(/=/,$values[3]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Фамилия : '.$keys[1].'<br>';


@keys = split(/=/,$values[4]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Адрес : '.$keys[1].'<br>';


@keys = split(/=/,$values[5]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Юр. адрес : '.$keys[1].'<br>';


@keys = split(/=/,$values[6]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Тел : '.$keys[1].'<br>';


@keys = split(/=/,$values[7]);
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Эл. почта : '.$keys[1].'<br><br><br>';

 };
 $i++ ;
 if ($i > 10){print '$i='.$i ; last;};#защита от неконтролируемого бесконечного цикла 
};

print '<br><br>Поиск в базе данных завершен';
close F1 ;
