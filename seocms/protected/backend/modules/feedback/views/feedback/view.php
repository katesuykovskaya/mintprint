<?php
/* @var $this FeedbackController */
/* @var $model Feedback */
?>

<h3 class="page-header" xmlns="http://www.w3.org/1999/html"><?php echo Yii::t('backend','Просмотр сообщения')?></h3>

<fieldset>
    <legend><?=$model->subject;?></legend>

    <div class="span5">

        <label for="sender_name"><?=Yii::t('backend','Отправитель')?></label>
        <input type="text" id="sender_name"value="<?=$model->sender_name;?>" readonly />

        <label for="sender_mail"><?=Yii::t('backend','E-mail отправителя')?></label>
        <input type="text" id="sender_mail"value="<?=$model->sender_mail;?>" readonly />

    <?php if($model->phone !== '') :?>
        <label for="phone"><?=Yii::t('backend','Телефон отправителя')?></label>
        <input type="text" id="phone"value="<?=$model->phone;?>" readonly />
    <?php endif?>

<!--        <label for="subject">--><?//=Yii::t('backend','Тема сообщения')?><!--</label>-->
<!--        <input type="text" id="subject"value="--><?//=$model->subject;?><!--" readonly />-->

        <label for="body"><?=Yii::t('backend','Текст сообщения')?></label>
        <?=CHtml::textArea('body',$model->body,array('rows'=>'10','style'=>'width:400px;'))?>
    </div>

    <div>
        <?php if(is_array($files)) :?>
            <table class="table table-bordered table-striped" style="width: 400px;">
                <thead>
                <th><?=Yii::t('backend','Превью')?></th><th><?=Yii::t('backend','Информация о файле')?></th>
                </thead>
                <tbody>
                <?php foreach($files as $file) :?>
                    <tr>
                        <td rowspan="3"><img src="/uploads/thumbnail/<?=$file['name']?>" /></td>
                        <td><?=Yii::t('backend','Имя файла')?>: <?=$file['name']?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('backend','Тип файла')?>: <?=$file['type']?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('backend','Url файла')?>: <?=$file['url']?></td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>
        <?php endif?>
    </div>

</fieldset>
<hr />

<a href="<?=$this->createUrl('/backend/feedback/feedback/maillist',array('language'=>Yii::app()->language))?>" class="btn"><?=Yii::t('backend','Назад')?></a>