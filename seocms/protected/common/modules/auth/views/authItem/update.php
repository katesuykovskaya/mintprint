<?php
/* @var $this OperationController|TaskController|RoleController */
/* @var $model AuthItemForm */
/* @var $item CAuthItem */
/* @var $form TbActiveForm */

$this->breadcrumbs = array(
    $this->capitalize($this->getTypeText(true)) => array('index'),
    $item->description => array('view', 'name' => $item->name),
    Yii::t('AuthModule.main', 'Edit'),
);
?>

<h1>
    <?php echo CHtml::encode($item->description); ?>
    <small><?php echo $this->getTypeText(); ?></small>
</h1>

<?php
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

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm'
//    ,
//    array(
//        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
//    )
); ?>

<?php echo $form->hiddenField($model, 'type'); ?>
<?php
//echo $form->textFieldControlGroup(
//    $model,
//    'name',
//    array(
//        'disabled' => true,
//        'title' => Yii::t('AuthModule.main', 'System name cannot be changed after creation.'),
//    )
//);
echo $form->label($model,'name');
echo $form->textField(
    $model,
    'name',
    array(
        'disabled' => true,
        'title' => Yii::t('AuthModule.main', 'System name cannot be changed after creation.'),
    )
);
?>
<?php
    echo $form->label($model,'description');
    echo $form->textField($model, 'description'); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton(
            Yii::t('AuthModule.main', 'Save'),
            array(
//                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'class'=>'btn'
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('AuthModule.main', 'Cancel'),
            $this->createUrl('/auth/role/view',['name'=>$item->name])
//            array(
//                'view/name/'.$item->name,
//            )
        ); ?>
    </div>

<?php $this->endWidget(); ?>