<?php
 return array (
  'class' => 'ext.yii-mail.YiiMail',
  'transportType' => 'smtp',
  'transportOptions' => 
  array (
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'kate.s@seotm.com',
    'password' => 'rfnzceqrjdcrfz2013',
    'encryption' => 'tls',
  ),
  'charset' => 'utf8',
  'adminEmail' => 'sidorenko.a@seotm.com',
  'mailGroup' => 
  array (
    0 => 'sidorenko.a@seotm.com',
  ),
  'mailheader' => 
  array (
    'ru' => '<p>ru header++++</p>',
  ),
  'mailfooter' => 
  array (
    'ru' => '<p>ru footer</p>',
  ),
);