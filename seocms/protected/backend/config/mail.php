<?php
 return array (
  'class' => 'ext.yii-mail.YiiMail',
  'transportType' => 'smtp',
  'transportOptions' => 
  array (
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'alexey.smolanov@seotm.com',
    'password' => 'superyii2013',
    'encryption' => 'tls',
  ),
  'charset' => 'utf8',
  'adminEmail' => 'root@root.zt.ua',
  'mailGroup' => 
  array (
    0 => '',
  ),
  'mailheader' => 
  array (
    'en' => '',
    'ru' => '<p>ru header</p>
<p>&nbsp;</p>
<p>girllll</p>
<p>&nbsp;</p>',
  ),
  'mailfooter' => 
  array (
    'en' => '',
    'ru' => '<p>ru footer</p>
<p>&nbsp;</p>
<p>&nbsp;</p>',
  ),
);