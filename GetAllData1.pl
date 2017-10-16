#!/usr/bin/perl -w
use warnings FATAL => 'all';
use strict;
use CGI::Carp qw(fatalsToBrowser);
use URI::Escape; 

use open qw(:utf8);
binmode(STDIN,':utf8');
#binmode(STDOUT,':utf8');

my $k = 0;
my $stroka = ();
my $i=0;
my @values = ();
my $values = ();
my @keys = ();
my $keys = ();

 open(F1,"<","dataUsers.txt" )or die "Не могу открыть файл $!";  #Открытие файла для чтения :encoding(UTF-8)
 

#@stroka=(<F1>);	#Чтение одной строки в массив если $ если @ то всего файла в массив

#close F1;
 
 #$stroka=@stroka ;
# $i = $stroka;

print "Content-type: text/html;charset=UTF-8\n\n";
print "<br> \n";
print "ВЫВОД ПОЛНОГО СПИСКА ИЗ БАЗЫ ДАННЫХ  \n";
print "<br><br><br> \n";

# while ( $k < $i )
 
  while ( <F1> )
{
 
 #@values=split(/&/,$stroka[$k]);# расщепление строки на поля значений 
 
 @values=split(/&/, );
 
$values = @values ;

#Для наглядности задачи сделано без цикла

@keys = split(/=/,$values[0]);  #расщепление данных на отдельные значения 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "ИНН : ". uri_unescape($keys[1]). "<br>";


@keys = split(/=/,$values[1]);  
$keys = @keys ;

if (!$keys[1]){$keys[1] ="";};
print "Организация : ". uri_unescape($keys[1]). "<br>";


@keys = split(/=/,$values[2]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Имя : ". uri_unescape($keys[1]). "<br>";


@keys = split(/=/,$values[3]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Фамилия : ". uri_unescape($keys[1])."<br>";


@keys = split(/=/,$values[4]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Адрес : ". uri_unescape($keys[1]). "<br>";

@keys = split(/=/,$values[5]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Юр. адрес : ".uri_unescape($keys[1]) . "<br>";

@keys = split(/=/,$values[6]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Тел : ". uri_unescape($keys[1]). "<br>";


@keys = split(/=/,$values[7]);
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print "Эл. почта : ". uri_unescape($keys[1]). "<br><br><br>";


$k++ ;
};


print "OK!";
