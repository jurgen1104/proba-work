    # отображение введеных данных пользователем в форму
	#!/usr/bin/perl
    use CGI;
     
    my $cgi = new CGI;
    print $cgi->header(-charset => "utf-8");
    print $cgi->start_html(-title => "Данные формы");
    print "Никакие данные по методу GET не переданы!" unless $cgi->param();
    print "Значение $_ равно ", $cgi->param($_), "<br />\n" for $cgi->param();
    print $cgi->end_html();
	
	
	# if (!$cgi->param()) # массив имен параметров пуст
# {
# print "Никакие данные по методу GET не переданы!"; # и по методу POST тоже :)
# }
 
# foreach my $name ($cgi->param)
# {
# print "Значение ".$name." равно ".$cgi->param($name)."<br />
# "; # Выводим браузеру имя поля формы и его значение.
# }
# print $cgi->end_html();