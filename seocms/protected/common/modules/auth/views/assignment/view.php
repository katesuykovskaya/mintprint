<?php
/* @var $this AssignmentController */
/* @var $model User */
/* @var $authItemDp AuthItemDataProvider */
/* @var $formModel AddAuthItemForm */
/* @var $form TbActiveForm */
/* @var $assignmentOptions array */

$this->breadcrumbs = array(
    Yii::t('AuthModule.main', 'Assignments') => array('index'),
    CHtml::value($model, $this->module->userNameColumn),
);
?>

<h1><?php echo CHtml::encode(CHtml::value($model, $this->module->userNameColumn)); ?>
    <small><?php echo Yii::t('AuthModule.main', 'Assignments'); ?></small>
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
?>

<div class="row">

    <div class="span6">

        <h3>
            <?php echo Yii::t('AuthModule.main', 'Permissions'); ?>
            <small><?php echo Yii::t('AuthModule.main', 'Items assigned to this user'); ?></small>
        </h3>

        <?php $this->widget(
            'bootstrap.widgets.TbGridView',
            array(
                'type' => 'striped condensed hover',
                'dataProvider' => $authItemDp,
                'emptyText' => Yii::t('AuthModule.main', 'This user does not have any assignments.'),
                'hideHeader' => true,
                'template' => "{items}",
                'columns' => array(
                    array(
                        'class' => 'AuthItemDescriptionColumn',
                        'active' => true,
                    ),
                    array(
                        'class' => 'AuthItemTypeColumn',
                        'active' => true,
                    ),
                    array(
                        'class' => 'AuthAssignmentRevokeColumn',
                        'userId' => $model->{$this->module->userIdColumn},
                    ),
                ),
            )
        ); ?>

        <?php if (!empty($assignmentOptions)): ?>

            <h4><?php echo Yii::t('AuthModule.main', 'Assign permission'); ?></h4>

            <?php $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm'
//                ,
//                array(
//                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
//                )
            ); ?>

            <?php echo $form->dropDownList($formModel, 'items', $assignmentOptions, array('label' => false)); ?>

            <?php echo CHtml::submitButton(
                Yii::t('AuthModule.main', 'Assign')
//                ,
//                array(
//                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
//                )
            ); ?>

            <?php $this->endWidget(); ?>

        <?php endif; ?>

    </div>

</div>