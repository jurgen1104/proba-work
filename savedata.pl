#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';
use utf8;
use open qw(:std :utf8);

my $form = () ;

read (STDIN,$form,$ENV{'CONTENT_LENGTH' }) ;

$form =~ tr/+/ /; # заменяем плюсы на пробелы

open(FILE,'>>', "dataUsers.txt") or die "Не могу открыть файл $!";  

print FILE $form ; # добавить строку
print FILE "\n"; # добавить символ в конец строки
close FILE; 
print "Content-type: text/html; charset=utf-8 \n\n";
print '<h2>Contact Form SAVED!</h2> ';