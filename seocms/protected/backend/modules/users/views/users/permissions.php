<?php
    echo 'language = '.Yii::app()->language; echo '<br />';
    echo Yii::t('permissions','Options');echo '<br />';
?>

<h3 class="page-header">Permissions</h3>

<table class="table-bordered table-striped">
    <thead>
        <th><?php echo Yii::t('permissions','Operations');?></th>
        <?php 
        foreach ($newArr as $name=>$arr)
        {
            echo '<th>'; echo Yii::t('permissions',$name); echo '</th>';
        }
        ?>
        
    </thead>
        
    <tbody>
        <?php foreach ($all as $key=>$task) : ?>
        <tr>
            <td><?php echo Yii::t('permissions',$task->name);?></td>
            <?php foreach ($newArr as $action) :?>
            <td> <?php echo in_array($task->name, $action)? 'Yes' : '-';?></td>
            <?php endforeach;?>
            </tr>
            <?php endforeach;?>
    </tbody>
</table>

