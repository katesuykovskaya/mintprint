<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Настройка отправки почты')?></li>
    </ul>
</div>

<h3 class="page-header"><?=Yii::t('backend','Настройка отправки почты')?></h3>

<?php
     $arr = include $file;

     echo CHtml::form('', 'POST',array('name'=>'myForm'));

     echo CHtml::checkBox('useMail', $arr['transportType']=='php'? true : false);
     echo CHtml::label(Yii::t('backend','Использовать PHP mail()'),'useMail');
     echo '<br />';
     
     echo CHtml::label(Yii::t('backend','Хост'), 'host');
     echo CHtml::textField('host',isset($arr['transportOptions']['host']) ? $arr['transportOptions']['host'] : '',['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Порт'), 'port');
     echo CHtml::textField('port',isset($arr['transportOptions']['port']) ? $arr['transportOptions']['port'] : '',['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Имя пользователя'), 'username');
     echo CHtml::textField('username',isset($arr['transportOptions']['username']) ? $arr['transportOptions']['username'] : '',['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Пароль'), 'password');
     echo CHtml::textField('password',isset($arr['transportOptions']['password']) ? $arr['transportOptions']['password'] : '',['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Шифрование'), 'encryption');
     echo CHtml::textField('encryption',isset($arr['transportOptions']['encryption']) ? $arr['transportOptions']['encryption'] : '',['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Кодировка'), 'charset');
     echo CHtml::textField('charset',$arr['charset'],['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Почтовый адрес администратора'), 'adminEmail');
     echo CHtml::textField('adminEmail',$arr['adminEmail'],['class'=>'input-xxlarge']);
     echo '<br />';

     echo CHtml::label(Yii::t('backend','Группа рассылки'), 'mailGroup');
     echo CHtml::textArea('mailGroup',implode(';',$arr['mailGroup']),['class'=>'input-xxlarge']);
     echo '<br />';

         $this->widget('bootstrap.widgets.TbTabs', array(
            'type'=>'tabs', // 'tabs' or 'pills'
            'tabs'=>
                $this->tabsArray($model,$param = false),
    ));
            echo '<hr />';


     echo CHtml::submitButton(Yii::t('backend','Изменить'),['class'=>'btn']);

     echo CHtml::endForm();

     echo '<hr />'; 
?>
