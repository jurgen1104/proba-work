#!/usr/bin/perl -w
use strict;
use CGI::Carp qw(fatalsToBrowser);
use warnings FATAL => 'all';
use utf8;
use open qw(:std :utf8);

my $form = $ENV{'QUERY_STRING'};

print "Content-type: text/html\n\n";

if (!$form) {print "Нет данных";};

open(F1,"dataUsers.txt" )or die "Не могу открыть файл $!"; 
my @strings = <F1>;
close F1;
open(F1,">","dataUsers.txt" );
close F1;
open(F1,">>","dataUsers.txt" );

foreach  (@strings)
{
  if (! /\Q$form\E/ ) {print F1 ;};# удаляем найденный ИНН 
};

close F1;
print "OK!";