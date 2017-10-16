<?php
  if($_POST['control']=="") {
$to      = 'jurgenicolaev@gmail.com'; // тут указываем адрес КОМУ мы отправляем письмо
$subject = 'Invest'; // тема письма
$message = 'Имя - '.$_POST['Name']. ' Фамилия - '.$_POST['Surname']. 'Адрес - '.$_POST['Address']. 'Моб. тел. - '.$_POST['mobile']. 'Сумма - '.$_POST['amount']. 'Срок - '.$_POST['long']. 'Проценты получать - '.$_POST['interest']. 'Счет в банке - '.$_POST['account']. 'Email - '.$_POST['email']  ; // собственно, само письмо

$message = wordwrap($message, 70);
 
mail($to, $subject, $message);

};

Header('Refresh: 2; URL=interest-rates-cd-deposits.html');
echo "Thank you. Your inquiry has been sent.";
exit;
?>