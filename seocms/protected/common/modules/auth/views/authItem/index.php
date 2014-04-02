<?php
/* @var $this OperationController|TaskController|RoleController */
/* @var $dataProvider AuthItemDataProvider */

$this->breadcrumbs = array(
    $this->capitalize($this->getTypeText(true)),
);
?>
<div class="span8">
<h3 class="page-header"><?php echo $this->capitalize($this->getTypeText(true)); ?></h3>

<?php
//echo TbHtml::linkButton(
//    Yii::t('AuthModule.main', 'Add {type}', array('{type}' => $this->getTypeText())),
//    array(
//        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
//        'url' => array('create'),
//    )
//);
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'brand' => Yii::app()->name,
        'fixed' => false,
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array(
                    array(
                        'label' => 'Assignments',
                        'url' => array('/auth/assignment/index'),
                        'active' => $this instanceof AssignmentController,
                    ),
                    array(
                        'label' => 'roles',
                        'url' => array('/auth/role/index'),
                        'active' => $this instanceof RoleController,
                    ),
                    array(
                        'label' => 'tasks',
                        'url' => array('/auth/task/index'),
                        'active' => $this instanceof TaskController,
                    ),
                    array(
                        'label' => 'operations',
                        'url' => array('/auth/operation/index'),
                        'active' => $this instanceof OperationController,
                    ),
                )
            )
        )
    )
);

echo CHtml::link(Yii::t('backend','Создать'),['create'],['class'=>'btn']);
?>

<?php $this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'type' => 'striped hover',
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('AuthModule.main', 'No {type} found.', array('{type}' => $this->getTypeText(true))),
        'template' => "{items}\n{pager}",
        'columns' => array(
            array(
                'name' => 'name',
                'type' => 'raw',
                'header' => Yii::t('AuthModule.main', 'System name'),
                'htmlOptions' => array('class' => 'item-name-column'),
                'value' => "CHtml::link(\$data->name, array('view', 'name'=>\$data->name))",
            ),
            array(
                'name' => 'description',
                'header' => Yii::t('AuthModule.main', 'Description'),
                'htmlOptions' => array('class' => 'item-description-column'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonLabel' => Yii::t('AuthModule.main', 'View'),
                'viewButtonUrl' => "Yii::app()->controller->createUrl('view', array('name'=>\$data->name))",
                'updateButtonLabel' => Yii::t('AuthModule.main', 'Edit'),
                'updateButtonUrl' => "Yii::app()->controller->createUrl('update', array('name'=>\$data->name))",
                'deleteButtonLabel' => Yii::t('AuthModule.main', 'Delete'),
                'deleteButtonUrl' => "Yii::app()->controller->createUrl('delete', array('name'=>\$data->name))",
                'deleteConfirmation' => Yii::t('AuthModule.main', 'Are you sure you want to delete this item?'),
            ),
        ),
    )
); ?>
</div>