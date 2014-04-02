<?php
/* @var $this OperationController|TaskController|RoleController */
/* @var $model AuthItemForm */
/* @var $form TbActiveForm */

$this->breadcrumbs = array(
    $this->capitalize($this->getTypeText(true)) => array('index'),
    Yii::t('AuthModule.main', 'New {type}', array('{type}' => $this->getTypeText())),
);
?>

    <h1><?php echo Yii::t('AuthModule.main', 'New {type}', array('{type}' => $this->getTypeText())); ?></h1>

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
//    array(
//        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
//    )
); ?>

<?php echo $form->hiddenField($model, 'type'); ?>
<?php echo $form->label($model, 'name'); ?>

<?php echo $form->textField($model, 'name'); ?>
<br />
<?php echo $form->label($model, 'description'); ?>
<?php echo $form->textField($model, 'description'); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton(
            Yii::t('AuthModule.main', 'Create'),
            array(
                'class' =>'btn',
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('AuthModule.main', 'Cancel'),
            array(
                'index',
            ),
            array('class'=>'btn')
        ); ?>
    </div>

<?php $this->endWidget(); ?>