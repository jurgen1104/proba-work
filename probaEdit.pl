#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';

use open qw(:utf8);
binmode(STDIN,':utf8');
#binmode(STDOUT,':utf8');если ставлю то выводит кракозябры  из print



my @values = ();
my $values = ();
my @keys = ();
my $keys = ();


my $form = () ;

read (STDIN,$form,$ENV{'CONTENT_LENGTH' }) ;

print "Content-type: text/html; charset=utf-8 \n\n";
if (!$form) {print "Нет входных данных!"; exit;  } ;


#создать новый файл
open(F2,">","temp-dataUsers.txt" );
close F2;

open(F2,">>","temp-dataUsers.txt" )or die "Не могу открыть temp файл $!";

open(F1,"dataUsers.txt" )or die "Не могу открыть файл $!"; 


#получаем ИНН
@values=split(/&/,$form);# расщепление строки на поля значений 

$values = @values ;

@keys = split(/=/,$values[0]);  #расщепление данных на отдельные значения 
$keys = @keys ;

my $data = $keys[1];
#проверка через ИНН

my $i = 0;

while (<F1>)
{ 
if (! /\Q$data\E/ ) {print F2 ;}
else { 

print F2 $form."\n";# записываем новые данные
$i++ ;
last  ;};
};


close F1;
close F2;

if ( $i > 0) {
unlink "dataUsers.txt";
rename "temp-dataUsers.txt", "dataUsers.txt";
print "Данные по ИНН - ЗАМЕНЕНЫ!"
}
else {
unlink "temp-dataUsers.txt";
print "Данные по ИНН для замены НЕ НАЙДЕНЫ!"
};
