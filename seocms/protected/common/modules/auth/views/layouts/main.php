<?php
/* @var $this AuthController */
?>

<div class="auth-module">

    <?php $this->widget(
        'bootstrap.widgets.TbNavbar',
        array(
//            'type' => TbHtml::NAV_TYPE_TABS,
//            'type'=> 'tabs',
            'brand'=>Yii::app()->name,
            'items' => array(
                array(
//                    'label' => Yii::t('AuthModule.main', 'Assignments'),
                    'label' => 'Assignments',
                    'url' => array('/auth/assignment/index'),
                    'active' => $this instanceof AssignmentController,
                ),
                array(
//                    'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_ROLE, true)),
                    'label' => 'roles',
                    'url' => array('/auth/role/index'),
                    'active' => $this instanceof RoleController,
                ),
                array(
//                    'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_TASK, true)),
                    'label' => 'tasks',
                    'url' => array('/auth/task/index'),
                    'active' => $this instanceof TaskController,
                ),
                array(
//                    'label' => $this->capitalize($this->getItemTypeText(CAuthItem::TYPE_OPERATION, true)),
                    'label' => 'operations',
                    'url' => array('/auth/operation/index'),
                    'active' => $this instanceof OperationController,
                ),
            ),
        )
    );?>

    <?php echo $content; ?>

</div>