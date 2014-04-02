<?php
 return array (
  'class' => 'ext.yii-mail.YiiMail',
  'transportType' => 'smtp',
  'transportOptions' => 
  array (
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'username' => 'blog@root.zt.ua',
    'password' => '1AgNQ4Q#',
    'encryption' => 'tls',
  ),
  'charset' => 'utf8',
  'adminEmail' => 'root@root.zt.ua',
  'mailGroup' => 
  array (
    0 => 'info@root.zt.ua',
    1 => 'blog@root.zt.ua',
    2 => '',
  ),
  'mailheader' => 
  array (
    'ru' => '<p>ru header</p>
<p><img title="girl" src="http://twoends.homehttp://test.home/uploads/images.jpeg" alt="girl" width="787" height="91" /></p>',
    'en' => '<p>english header</p>',
    'uk' => '<p><span style="text-decoration: underline; color: #3366ff;"><em><strong><span style="text-decoration: underline;">ukr header</span></strong></em></span></p>
<p>&nbsp;</p>
<hr />
<p>&nbsp;</p>',
  ),
  'mailfooter' => 
  array (
    'ru' => '<p>ru footer<img title="a" src="http://twoends.homehttp://test.home/uploads/1323rfwaef.jpeg" alt="q" width="284" height="177" /></p>',
    'en' => '<p>english footer</p>',
    'uk' => '<p><span style="text-decoration: underline; color: #ff9900;"><em><strong>ukr footer</strong></em></span></p>
<hr />
<p><span style="text-decoration: underline; color: #ffff00;"><em><strong><img title="pic" src="http://twoends.homehttp://test.home/uploads/1323rfwaef.jpeg" alt="pic" width="793" height="177" /></strong></em></span></p>',
  ),
);