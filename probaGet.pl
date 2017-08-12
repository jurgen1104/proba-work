#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';
use URI::Escape;

use open qw(:utf8);
binmode(STDIN,':utf8');
#binmode(STDOUT,':utf8');если ставлю то выводит кракозябры  из print

my @stroka= ();
my @values = ();
my $values = ();
my @keys = ();
my $keys = ();

#my $form = $ENV{'QUERY_STRING'};
my $form = () ;

read (STDIN,$form,$ENV{'CONTENT_LENGTH' }) ;

print "Content-type: text/html;charset=UTF-8\n\n";

open(F1,"<","dataUsers.txt" )or die 'Не могу открыть файл'.$! ; 

while (<F1>)
{ 
if ( /\Q$form\E/ ) {
    
#my @stroka=uri_unescape();	#Чтение одной строки в массив если $ если @ то всего файла в массив





 
 @values=split(/&/, );# расщепление строки на поля значений 
$values = @values ;
#$values = uri_unescape(@values)

@keys = split(/=/,$values[0]);  #расщепление данных на отдельные значения 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'ИНН : '.$keys[1].'<br> ';


@keys = split(/=/,$values[1]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Организация : '.uri_unescape($keys[1]).'<br>';


@keys = split(/=/,$values[2]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Имя : '.uri_unescape($keys[1]).'<br>';


@keys = split(/=/,$values[3]);  
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Фамилия : '.uri_unescape($keys[1]).'<br>';


@keys = split(/=/,$values[4]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Адрес : '.uri_unescape($keys[1]).'<br>';


@keys = split(/=/,$values[5]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Юр. адрес : '.uri_unescape($keys[1]) .'<br>';


@keys = split(/=/,$values[6]); 
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Тел : '.uri_unescape($keys[1]).'<br>';


@keys = split(/=/,$values[7]);
$keys = @keys ;
if (!$keys[1]){$keys[1] ="";};
print 'Эл. почта : '.uri_unescape($keys[1]).'<br>';

 ;};

};
print 'Поиск в базе данных завершен';
close F1 ;


