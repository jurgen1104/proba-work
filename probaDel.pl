#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';

use open qw(:utf8);
binmode(STDIN,':utf8');
#binmode(STDOUT,':utf8');если ставлю то выводит кракозябры  из print


my $form = $ENV{'QUERY_STRING'};

print "Content-type: text/html;charset=UTF-8\n\n";

if (!$form) {print "Нет входных данных!"; exit;  } ;
#создать новый файл
open(F2,">","temp-dataUsers.txt" );
close F2;

open(F2,">>","temp-dataUsers.txt" )or die "Не могу открыть temp файл $!";

open(F1,"dataUsers.txt" )or die "Не могу открыть файл $!"; 

my $i = 0;
while (<F1>)
{ 
if (! /\Q$form\E/ ) {print F2 ;}
else { $i++ ;};# удаляем найденный ИНН 
};

close F1;
close F2;

if ( $i > 0) {
unlink "dataUsers.txt";
rename "temp-dataUsers.txt", "dataUsers.txt";
print "Данные по ИНН - УДАЛЕНЫ!"
}
else {
unlink "temp-dataUsers.txt";
print "Данные по ИНН для удаления НЕ НАЙДЕНЫ!"
};




