<?php
/* @var $this OperationController|TaskController|RoleController */
/* @var $item CAuthItem */
/* @var $ancestorDp AuthItemDataProvider */
/* @var $descendantDp AuthItemDataProvider */
/* @var $formModel AddAuthItemForm */
/* @var $form TbActiveForm */
/* @var $childOptions array */

$this->breadcrumbs = array(
    $this->capitalize($this->getTypeText(true)) => array('index'),
    $item->description,
);
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

<div class="title-row clearfix">

    <h1 class="pull-left">
        <?php echo CHtml::encode($item->description); ?>
        <small><?php echo $this->getTypeText(); ?></small>
    </h1>

<?php

//echo TbHtml::buttonGroup(
//        array(
//            array(
//                'label' => Yii::t('AuthModule.main', 'Edit'),
//                'url' => array('update', 'name' => $item->name),
//            ),
//            array(
//                'icon' => 'trash',
//                'url' => array('delete', 'name' => $item->name),
//                'htmlOptions' => array(
//                    'confirm' => Yii::t('AuthModule.main', 'Are you sure you want to delete this item?'),
//                ),
//            ),
//        ),
//        array('class' => 'pull-right')
//    );
    $this->widget(
        'bootstrap.widgets.TbButtonGroup',
        array(
            'buttons' => array(
                array(
                    'label' => Yii::t('AuthModule.main', 'Edit'),
                    'url' => array('update', 'name' => $item->name),
                ),
                array(
                    'icon' => 'trash',
                    'url' => array('delete', 'name' => $item->name),
                    'htmlOptions' => array(
                        'confirm' => Yii::t('AuthModule.main', 'Are you sure you want to delete this item?'),
                    ),
                ),
            ),
        )
    );
    ?>

</div>

<?php $this->widget(
    'zii.widgets.CDetailView',
    array(
        'data' => $item,
        'attributes' => array(
            array(
                'name' => 'name',
                'label' => Yii::t('AuthModule.main', 'System name'),
            ),
            array(
                'name' => 'description',
                'label' => Yii::t('AuthModule.main', 'Description'),
            ),
            /*
            array(
                'name' => 'bizrule',
                'label' => Yii::t('AuthModule.main', 'Business rule'),
            ),
            array(
                'name' => 'data',
                'label' => Yii::t('AuthModule.main', 'Data'),
            ),
            */
        ),
    )
); ?>

<hr/>

<div class="row">

    <div class="span6">

        <h3>
            <?php echo Yii::t('AuthModule.main', 'Ancestors'); ?>
            <small><?php echo Yii::t('AuthModule.main', 'Permissions that inherit this item'); ?></small>
        </h3>

        <?php $this->widget(
            'bootstrap.widgets.TbGridView',
            array(
                'type' => 'striped condensed hover',
                'dataProvider' => $ancestorDp,
                'emptyText' => Yii::t('AuthModule.main', 'This item does not have any ancestors.'),
                'template' => "{items}",
                'hideHeader' => true,
                'columns' => array(
                    array(
                        'class' => 'AuthItemDescriptionColumn',
                        'itemName' => $item->name,
                    ),
                    array(
                        'class' => 'AuthItemTypeColumn',
                        'itemName' => $item->name,
                    ),
                    array(
                        'class' => 'AuthItemRemoveColumn',
                        'itemName' => $item->name,
                    ),
                ),
            )
        ); ?>

    </div>

    <div class="span6">

        <h3>
            <?php echo Yii::t('AuthModule.main', 'Descendants'); ?>
            <small><?php echo Yii::t('AuthModule.main', 'Permissions granted by this item'); ?></small>
        </h3>

        <?php $this->widget(
            'bootstrap.widgets.TbGridView',
            array(
                'type' => 'striped condensed hover',
                'dataProvider' => $descendantDp,
                'emptyText' => Yii::t('AuthModule.main', 'This item does not have any descendants.'),
                'hideHeader' => true,
                'template' => "{items}",
                'columns' => array(
                    array(
                        'class' => 'AuthItemDescriptionColumn',
                        'itemName' => $item->name,
                    ),
                    array(
                        'class' => 'AuthItemTypeColumn',
                        'itemName' => $item->name,
                    ),
                    array(
                        'class' => 'AuthItemRemoveColumn',
                        'itemName' => $item->name,
                    ),
                ),
            )
        );
        ?>

    </div>

</div>

<div class="row">

    <div class="span6 offset6">

        <?php if (!empty($childOptions)): ?>

            <h4><?php echo Yii::t('AuthModule.main', 'Add child'); ?></h4>

            <?php $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm'
      /*          array(
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                )*/
            ); ?>

            <?php
                //echo $form->dropDownListControlGroup($formModel, 'items', $childOptions, array('label' => false));
                echo $form->dropDownList($formModel, 'items', $childOptions, array());
            ?>

            <?php echo CHtml::submitButton(
                Yii::t('AuthModule.main', 'Add'),
                array(
//                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'class'=>'btn'
                )
            ); ?>

            <?php $this->endWidget(); ?>

        <?php endif; ?>

    </div>

</div>