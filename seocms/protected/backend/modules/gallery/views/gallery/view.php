<?php
/* @var $this GalleryController */
/* @var $model Gallery */
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>

<h3 class="page-header"><?php echo $model->translation[Yii::app()->language]->t_title; ?></h3>

<div class="row">
<div id="message" class="span5 offset1">
    <?php if(Yii::app()->user->hasFlash('remove-success')) : ?>

        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('remove-success');?>
        </div>

    <?php elseif(Yii::app()->user->hasFlash('remove-error')) : ?>

        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('remove-error');?>
        </div>

    <?php endif?>

    <?php if(Yii::app()->user->hasFlash('category-success')) : ?>

        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('category-success');?>
        </div>

    <?php elseif(Yii::app()->user->hasFlash('category-error')) : ?>

        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('category-error');?>
        </div>

    <?php endif?>

    <?php if(Yii::app()->user->hasFlash('update-success')) : ?>

        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('update-success');?>
        </div>

    <?php elseif(Yii::app()->user->hasFlash('update-error')) : ?>

        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo Yii::app()->user->getFlash('update-error');?>
        </div>

    <?php endif?>
</div>
</div>

<?php if($model->lft == 1) : ?>

<div class="span12 clearfix">
<div class="row">
    <ul class="breadcrumb span6">
        <li><?=CHtml::link(Yii::t('backend','Все галереи'),$this->createUrl('/backend/gallery/gallery/index',['language'=>Yii::app()->language]))?></li>
        <li><span class="divider">/</span><?=$model->translation[Yii::app()->language]->t_title;?></li>
    </ul>
</div>
    <?=CHtml::link(Yii::t('backend','Создать событие'),'',['id'=>'createCategory','class'=>'btn'])?>
    <h5 class="page-header"><?=Yii::t('backend','События')?>:</h5>

    <?php if(empty($categories)) :?>
        <?php echo Yii::t('backend','Нет событий');?>
    <?php else :?>
        <?php foreach($categories as $category) :?>

            <div class="well span4">
                <a href="<?=$this->createUrl('/backend/gallery/gallery/view',['id'=>$category->id])?>">
                    <h4 class="page-header"><?=$category->translation[Yii::app()->language]->t_title?></h4>
                    <p><?=Yii::t('backend','Дата создания: ').$category->translation[Yii::app()->language]->t_createdate?></p>
                    <p><?=Yii::t('backend','Элементов').': '.count($category->children()->findAll())?></p>
                </a>
                <a href="#" id="delete" data-prompt="<?=Yii::t('backend','Удалить событие со всеми файлами в нем?')?>" data-id="<?=$category->id?>"><i class="icon-remove icon-2x"></i></a>
                <a href="#" id="editMe" data-id="<?=$category->id?>"><i class="icon-edit icon-2x"></i></a>
            </div>

        <?php endforeach ?>
    <?php endif?>
</div>

<?php endif ?>

<?php
$categoryForm = [];
    foreach(Yii::app()->params['languages'] as $key=>$language){
        $categoryForm[$key]['label'] = $language['lang'];
        $categoryForm[$key]['content'] = CHtml::label(Yii::t('backend','Название категории'),'GalleryTranslate_t_title_'.$language['langcode']).
                                         CHtml::textField('GalleryTranslate[t_title]['.$language['langcode'].']','',['class'=>'input-xlarge']);
        if(Yii::app()->language == $key) $categoryForm[$key]['active'] = true;
    }
?>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?=Yii::t('backend','Новое событие')?></h3>
    </div>
    <div class="modal-body">
        <form id="category-form">
            <input type="hidden" name="root" value="<?=$model->id?>">
        <?php
        $this->widget(
            'bootstrap.widgets.TbTabs',
            array(
                'type' => 'tabs', // 'tabs' or 'pills'
                'tabs' => $categoryForm
            )
        );
        ?>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=Yii::t('backend','Отмена')?></button>
        <button id="modalSave" class="btn btn-primary"><?=Yii::t('backend','Создать')?></button>
    </div>
</div>

<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="editModalLabel"><?=Yii::t('backend','Изменение данных')?></h3>
    </div>
    <div class="modal-body">
        <form id="edit-category-form">
            <?php
                $this->widget(
                    'bootstrap.widgets.TbTabs',
                    array(
                        'type' => 'tabs', // 'tabs' or 'pills'
                        'tabs' => $categoryForm
                    )
                );
            ?>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=Yii::t('backend','Отмена')?></button>
        <button id="editModalSave" class="btn btn-primary"><?=Yii::t('backend','Сохранить')?></button>
    </div>
</div>

<?php if($model->lft != 1) :?>

    <?php
        $parent = $model->parent()->find();
        $children = $model->with(['translation'=>['order'=>'t_createdate DESC']])->children()->findAll();
    ?>
<div class="row">
<div class="span10">

    <div class="row">
        <ul class="breadcrumb span6">
            <li><?=CHtml::link(Yii::t('backend','Все галереи'),$this->createUrl('/backend/gallery/gallery/index',['language'=>Yii::app()->language]))?></li>
            <li><span class="divider">/</span><?=CHtml::link($parent->translation[Yii::app()->language]->t_title,$this->createUrl('/backend/gallery/gallery/view',['id'=>$parent->id,'language'=>Yii::app()->language]))?></li>
            <li><span class="divider">/</span><?=$model->translation[Yii::app()->language]->t_title;?></li>
        </ul>
    </div>

    <a href="#" id="video" class="btn" style="margin-bottom: 20px"
       data-language="<?=Yii::app()->language?>">
        <?=Yii::t('backend','Добавить видео')?>
    </a>
    <div id="videoBlock" class="hidden">
        <div id="embedIt">
            <p><label for="GalleryTranslate_title_<?=Yii::app()->language?>"><?=Yii::t('backend','Название видео')?></label></p>
            <input type="text" name="GalleryTranslate[title][<?=Yii::app()->language?>]" id="GalleryTranslate_title_<?=Yii::app()->language?>" class="input-xxlarge" />
            <p><label for="GalleryTranslate_embed_<?=Yii::app()->language?>"><?=Yii::t('backend','Вставьте ссылку на видео с YouTube')?></label></p>
            <textarea name="GalleryTranslate[embed][<?=Yii::app()->language?>]"
            id="GalleryTranslate_embed_<?=Yii::app()->language?>"
            style="height:150px;margin-top:20px;margin-bottom:40px;" class="input-xxlarge"></textarea>
            <div style="margin-bottom: 40px">
                <a href="#" id="videoSubmit" class="btn"
                data-language="<?=Yii::app()->language?>" data-parent="<?=$model->id?>">
                    <?=Yii::t('backend','Прикрепить видео')?>
                </a>
            </div>
        </div>
    </div>
    <table id="sortable" class="table table-striped table-bordered" data-root="<?=$model->id?>" data-filter="">
        <tbody class="files">
        <?php foreach($children as $child) :?>
            <?php $image = is_file(Yii::getPathOfAlias("webroot").$child->translation[Yii::app()->language]->t_file) ?
                Yii::app()->easyImage->thumbOf(Yii::getPathOfAlias("webroot").$child->translation[Yii::app()->language]->t_file,
                [
                    "resize" => array("width"=>100,"master"=>EasyImage::RESIZE_WIDTH),
                    "savePath"=>"/galleries/".$model->id."/",
                    "quality" => 80,
                ]) : false ?>
            <tr data-id="<?=$child->id?>">
                <td class="centered"><?=$child->nodeType?></td>
                <td class="centered"><span class="preview"><?= $image ? '<a href="'.$child->translation[Yii::app()->language]->t_file.'" data-gallery>'.$image.'</a>': '' ?></span></td>
                <td class="centered"><?=$child->translation[Yii::app()->language]->t_title?></td>
                <td class="centered"><?=$child->translation[Yii::app()->language]->t_createdate?></td>
                <td class="centered"><?=CHtml::link('<i class="icon-edit icon-large"></i>',$this->createUrl('/backend/gallery/gallery/imageEdit',['id'=>$child->id,'language'=>Yii::app()->language]))?></td>
                <td class="centered"><a href="#" id="removeImage" data-id="<?=$child->id?>" data-prompt="<?=Yii::t('backend','Удалить?')?>"><i class="icon-remove icon-large"></i></a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
</div>
<div class="span10">
    <?php
        $filesToken = sha1(uniqid(mt_rand(),true));
        $entity = 'Gallery';
        $webroot = Yii::getPathOfAlias('webroot');
        $this->widget('application.backend.modules.gallery.widgets.FileUploadWidget',array(
            'entity'=>$entity,
            'entity_id'=> !$model->isNewRecord ? $model->id : null,
            'versions'=>array('thumbnail',''),
            'tempUrl'=>$webroot.'/galleries/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
            'uploadUrl'=>$webroot.'/galleries/',
            'webUrl'=>'/galleries/tmp/'.$filesToken.DIRECTORY_SEPARATOR,
            'filePath'=>$webroot.'/galleries/'.$entity.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR,
        ));
        echo CHtml::link(Yii::t('backend','Сохранить'),'#',['id'=>'saveFiles','class'=>'btn','data-tmp'=>Yii::app()->session['files']['files']['webUrl'],'data-id'=>$model->id]);
    ?>
</div>
<?php endif ?>

<script>
    $(document).on("click","#createCategory",function(e){
        e.preventDefault();
        $("#myModal").modal('show');
        $("#modalSave").on("click",function(){
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/createCategory",
                data:$("#category-form").serialize(),
                success:function(){
                    $("#myModal").modal('hide');
                    window.location.reload();
                }
            });
        });
    });

    $(document).on("click","#saveFiles",function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"/backend/gallery/gallery/savefiles",
            data:{
                url:$(this).data('tmp'),
                nodeId:$(this).data('id')
            },
            success:function(){
                window.location.reload();
            }
        });
    });

    $(function() {
        $( "#sortable" ).sortable({
            items: "tr"
        });

        if($("#message") != undefined){
            $("#message").fadeOut(4000);
        }

    });

    $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        $.ajax({
            type:"POST",
            url:"/backend/gallery/gallery/sort",
            beforeSend:function(){
                $("#loader").html('<img src="/img/loader.gif" />');
            },
            data:{
                current:ui.item.data("id"),
                previous:ui.item.prev().data("id"),
                next:ui.item.next().data("id"),
                root:$("#sortable").data("root")
            },
            complete:function(){
                $("#loader").html('');
            }
        });
    });

    $(document).on("click","#removeImage",function(e){
        e.preventDefault();
        if(confirm($(this).data("prompt"))){
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/removeNode",
                data:{
                    id:$(this).data("id")
                },
                success:function(){
                    window.location.reload();
                }
            });
        }
    });

    $(document).on("click","#video",function(e){
        e.preventDefault();
        $("#videoBlock").removeClass("hidden");
    });

    $(document).on("click","#videoSubmit",function(e){
        e.preventDefault();
        var src = $("#GalleryTranslate_embed_"+$(this).data("language")).val();
        var splitted = src.split('v=');
        var videoId = splitted[splitted.length-1];
        $.ajax({
            type:"POST",
            url:"/backend/gallery/gallery/submitVideo",
            data:{
                embedCode: $("#GalleryTranslate_embed_"+$(this).data("language")).val(),
                videoId: videoId,
                parent: $(this).data("parent"),
                title: $("#GalleryTranslate_title_"+$(this).data("language")).val()
            },
            success:function(){
                window.location.reload();
            }
        });
    });

    $(document).on("click","#delete",function(e){
        e.preventDefault();
        if(confirm($(this).data("prompt"))){
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/removeNode",
                data:{
                    id:$(this).data("id"),
                    role:"category"
                },
                success:function(){
                    window.location.reload();
                }
            });
        }
    });

    $(document).on("click","#editMe",function(e){
        e.preventDefault();
        var id = $(this).data("id");
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/eventEdit",
                data:{
                    id:$(this).data("id")
                },
                success:function(response){
                    var resp = JSON.parse(response);
                    $("#edit-category-form").append('<input type="hidden" name="id" value="'+id+'" />');
                    $("#edit-category-form #GalleryTranslate_t_title_ru").val(resp.ru.t_title);
                    $("#edit-category-form #GalleryTranslate_t_title_en").val(resp.en.t_title);
                }
            });
        $("#editModal").modal('show');
        $("#editModalSave").on("click",function(){
            $.ajax({
                type:"POST",
                url:"/backend/gallery/gallery/updateEvent",
                data:$("#edit-category-form").serialize(),
                success:function(){
                    $("#myModal").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
</script>