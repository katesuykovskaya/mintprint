<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Главная'),$this->createUrl('backend',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=CHtml::link(Yii::t('backend','Мультиязычность. Словарь.'),$this->createUrl('backend/multilanguage/source/admin',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=Yii::t('backend','Настройки языков приложения')?></li>
    </ul>
</div>

<h4 class="page-header"><?php echo Yii::t('backend','Настройки языков приложения');?></h4>

<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal" style="margin-bottom: 20px;"><?=Yii::t('backend','Новый язык')?></a>

<table class="table table-striped table-bordered" id="langTable">
    <thead>
        <th><?=Yii::t('backend','Язык')?></th>
        <th><?=Yii::t('backend','Информация')?></th>
    </thead>
    <tbody>
    <?php foreach(Yii::app()->params['languages'] as $language) :?>
        <tr class="<?=$language['langcode']?>">
            <td rowspan="5"  id="td_flag_<?=$language['langcode']?>">
                <?=CHtml::image("/img/icons/flags/16/$language[countrycode].png").' '.$language['lang']?>
                <span class="pull-right" id="buttons_<?=$language['langcode']?>">
                    <i class="icon-trash" id="delLang" data-lang="<?=$language['langcode']?>"></i>
                    <i class="icon-pencil" id="editLang" data-lang="<?=$language['langcode']?>"></i>
                </span>
            </td>

        </tr>
        <tr class="<?=$language['langcode']?>"><td id="td_langcode_<?=$language['langcode']?>"><?=Yii::t('backend','CLDR код языка: ').$language['langcode']?></td></tr>
        <tr class="<?=$language['langcode']?>"><td id="td_lang_<?=$language['langcode']?>"><?=Yii::t('backend','Язык: ').$language['lang']?></td></tr>
        <tr class="<?=$language['langcode']?>"><td id="td_country_<?=$language['langcode']?>"><?=Yii::t('backend','Страна: ').$language['country']?></td></tr>
        <tr class="<?=$language['langcode']?>"><td id="td_countrycode_<?=$language['langcode']?>"><?=Yii::t('backend','Код Страны: ').$language['countrycode']?></td></tr>
    <?php endforeach?>
    </tbody>
</table>
<?php
    echo CHtml::beginForm('','POST',array('name'=>'langForm','id'=>'langForm'));
    foreach(Yii::app()->params['languages'] as $key=>$lang){
        echo CHtml::hiddenField($key.'[langcode]',$lang['langcode'],array('class'=>'form-'.$lang['langcode']));
        echo CHtml::hiddenField($key.'[lang]',$lang['lang'],array('class'=>'form-'.$lang['langcode']));
        echo CHtml::hiddenField($key.'[country]',$lang['country'],array('class'=>'form-'.$lang['langcode']));
        echo CHtml::hiddenField($key.'[countrycode]',$lang['countrycode'],array('class'=>'form-'.$lang['langcode']));
    }
    echo CHtml::submitButton(Yii::t('backend','Сохранить изменения'),array('style'=>'display:none;','id'=>'saveChanges','class'=>'btn'));
    echo CHtml::endForm();

?>

<div id="myModal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?=Yii::t('backend','Добавление нового языка')?></h3>
    </div>
    <div class="modal-body">
            <label for="langcode"><?=Yii::t('backend','CLDR код языка')?></label>
            <input type="text" name="langcode" id="langcode" placeholder="<?=Yii::t('backend','Введите CLDR код языка')?>" />

            <label for="lang"><?=Yii::t('backend','Язык')?></label>
            <input type="text" name="lang" id="lang" placeholder="<?=Yii::t('backend','Введите название языка')?>" />

            <label for="country"><?=Yii::t('backend','Страна')?></label>
            <input type="text" name="country" id="country" placeholder="<?=Yii::t('backend','Введите название страны')?>" />

            <label for="countrycode"><?=Yii::t('backend','Код Страны')?></label>
            <input type="text" name="countrycode" id="countrycode" placeholder="<?=Yii::t('backend','Введите код страны')?>" />

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn"><?=Yii::t('backend','Отмена')?></a>
        <a id="saveLang" href="#" class="btn btn-primary" data-scenario="insert"><?=Yii::t('backend','Сохранить')?></a>
    </div>
</div>

<script>
    $(document).on("click","#saveLang",function(e){
        e.preventDefault();

        var editLang = $("#saveLang").data("lang");
        var langcode = document.getElementById('langcode').value;
        var lang = document.getElementById('lang').value;
        var country = document.getElementById('country').value;
        var countrycode = document.getElementById('countrycode').value.toUpperCase();
        var form = document.getElementById('langForm');

        var newLangCode = '<input class="form-'+langcode+'" type="hidden" name="'+langcode+'[langcode]" id="'+langcode+'_langcode" value="'+langcode+'" />';
        var newLang = '<input class="form-'+langcode+'" type="hidden" name="'+langcode+'[lang]" id="'+langcode+'_lang" value="'+lang+'" />';
        var newCountry = '<input class="form-'+langcode+'" type="hidden" name="'+langcode+'[country]" id="'+langcode+'_country" value="'+country+'" />';
        var newCountrycode = '<input class="form-'+langcode+'" type="hidden" name="'+langcode+'[countrycode]" id="'+langcode+'_countrycode" value="'+countrycode+'" />';


        var scenario = $('#saveLang').data("scenario");

        if(scenario === 'insert'){

            var newRow = "<tr class='"+langcode+"'><td rowspan='5'><img src='/img/icons/flags/16/"+countrycode+".png' />"+lang+
                "<span class='pull-right'><i class='icon-trash' id='delLang' data-lang='"+langcode+"'></i> "+
                "<i class='icon-pencil' id='editLang' data-lang='"+langcode+"'></i>"+
                "</span></td></tr>"+
                "<tr class='"+langcode+"'><td>langcode: "+langcode+"</td></tr>"+
                "<tr class='"+langcode+"'><td>lang: "+lang+"</td></tr>"+
                "<tr class='"+langcode+"'><td>country: "+country+"</td></tr>"+
                "<tr class='"+langcode+"'><td>countrycode: "+countrycode+"</td></tr>";
            $('#langTable').prepend(newRow);
            $('#saveChanges').css("display","block");
            $(':input','#myModal').val("");
            $('#myModal').modal('hide');

        } else {
            $('#td_langcode_'+editLang).html('langcode: '+langcode);
            $('#td_lang_'+editLang).html('lang: '+lang);
            $('#td_country_'+editLang).html('country: '+country);
            $('#td_countrycode_'+editLang).html('countrycode: '+countrycode);
            $('#td_flag_'+editLang).html(' ' +
                '<img src="/img/icons/flags/16/'+countrycode+'.png" /> '+lang+
                '<span class="pull-right" id="buttons_'+langcode+'">'+
                '<i class="icon-trash" id="delLang" data-lang="'+langcode+'"></i> '+
                '<i class="icon-pencil" id="editLang" data-lang="'+langcode+'"></i>'+
                '</span>');

            $('.form-'+editLang).remove();

            $('#saveLang').data("scenario","insert");
            $('#saveChanges').css("display","block");
            $(':input','#myModal').val("");
            $('#myModal').modal('hide');

        }
        /*prepend hidden rows has to be here because of deleting rows in upper code*/
        $(form).prepend(newCountrycode);
        $(form).prepend(newCountry);
        $(form).prepend(newLang);
        $(form).prepend(newLangCode);

    });

    $(document).on("click","#delLang",function(){
        var langClass = $(this).data("lang");
        if(confirm('<?=Yii::t('backend','Удалить?')?>')){
            $('.'+langClass).remove();
            $('.form-'+langClass).remove();
            $('#saveChanges').css("display","block");
        }
    });

    $(document).on("click","#editLang",function(){

        var thisLang = $(this).data("lang");
        var eLangcode = document.getElementById(thisLang+'_langcode').value;
        var eLang = document.getElementById(thisLang+'_lang').value;
        var eCountry = document.getElementById(thisLang+'_country').value;
        var eCountrycode = document.getElementById(thisLang+'_countrycode').value;

        $('#saveLang').data("scenario","update");
        $('#saveLang').data("lang",thisLang);

        $('#langcode').val(eLangcode);
        $('#lang').val(eLang);
        $('#country').val(eCountry);
        $('#countrycode').val(eCountrycode);
        $('#myModal').modal('show');

    });

    $(document).on("click","#saveChanges",function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"/backend/multilanguage/source/manage",
            data: $('#langForm').serialize(),
            success:function(response){
                var resp = JSON.parse(response);
                $('#saveChanges').css("display","none");
            }
        });
    });
</script>
