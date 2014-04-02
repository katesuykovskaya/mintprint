<?php
/* @var $this AssignmentController */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="span8">
<h3 class="page-header"><?php echo Yii::t('AuthModule.main', 'Assignments'); ?></h3>
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

$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'type' => 'striped hover',
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('AuthModule.main', 'No assignments found.'),
        'template' => "{items}\n{pager}",
        'columns' => array(
            array(
                'header' => Yii::t('AuthModule.main', 'User'),
                'class' => 'AuthAssignmentNameColumn',
            ),
            array(
                'header' => Yii::t('AuthModule.main', 'Assigned items'),
                'class' => 'AuthAssignmentItemsColumn',
            ),
            array(
                'class' => 'AuthAssignmentViewColumn',
            ),
        ),
    )
); ?>
</div>