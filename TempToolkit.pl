 # Программа декодирования HTML-формы может выглядеть, например, так:

#!/usr/bin/perl

# Декодирование данных формы, переданных методом GET $form_data = $ENV{'QUERY_STRING'};

# преобразование цепочек %hh в соответствующие символы $form_data-=- s/%(..)/pack ("С", hex ($1))/eg; i преобразование плюсов в пробелы $form_data =~ tr/+/ /;

# разбиение на пары имя=значение @pairs = split (/&/, $form_data);

# выделение из каждой пары имени и значения поля формы и сохранение

# их в ассоциативном массиве $fom_fields



 # Если данные формы переданы методом POST, то в приведенном тексте следует заменить оператор присваивания

# $form_data = $ENV{'QUERY_STRING'};

# оператором

# read(STDIN,$fom_data,$ENV{'CONTENT_LENGTH' }} ;

# считывающим из стандартного ввода программы CONTENT_LENGTH байтов, составляющих содержимое запроса клиента, в переменную $form_data.


#!/usr/bin/perl
#!/usr/local/bin/perl # <-- ПРОВЕРЬТЕ ЭТО

# Read and parse input from the web form

# use CGI qw(:param)

#!/usr/bin/perlml 
use Template;

# вариант без использования CGI
# read(STDIN,$form_data,$ENV{'CONTENT_LENGTH' }} ;

# @pairs = split(/&/, $form_data);# разбиваем запрос на пары ключ=значение
# foreach $pair (@pairs) {
    # ($name, $value) = split(/=/, $pair); ## пробегаемся по всем парам 
	# # ключ в переменной $name, значение 
# # в переменной $value
    # $value =~ tr/+/ /; # заменяем плюсы на пробелы
	 # $input{$name} = $value; # организуем хэш
# }
# После включения этого кода в Ваши скрипты Вам остается только использовать хэш $input указывая в фигурных скобках имя параметра. Например значение $input{par1} будет равно "1",$input{par2} будет равно "val" итд. 

my $Qstring = Template->new;
# $Qstring=new CGI;
$INN=$Qstring->param("userINN");
$UserName=$Qstring->param("userName");
$UserFamily=$Qstring->param("userFamily");
$UserAddr=$Qstring->param("userAddr");
$OrgAddr=$Qstring->param("orgaddr");
$Organ=$Qstring->param("orgName");
$Email=$Qstring->param("userEmail");
$Tel=$Qstring->param("userTel");


print "ИНН : " $INN "\n";
print "Имя : " $UserName "\n";
print "Фамилия : " $UserFamily "\n";
print "Адрес : " $UserAddr "\n";
print "Юр. адрес : " $OrgAddr "\n";
print "Название : " $Organ "\n";
print "Эл. почта : " $Email "\n";
print "Тел : " $Tel "\n";


exit

    # my $tt = Template->new;
	
	
	# $tt->process('my_proba', \%data)
        # || die $tt->error;