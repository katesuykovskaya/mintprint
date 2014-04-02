<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 09.09.13
 * Time: 18:12
 * To change this template use File | Settings | File Templates.
 */
?>

<h3 class="page-header">PHP file browser</h3>

<?php
    $files = scandir($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'/uploads');

    echo '<pre>';
    print_r($files);
    echo '</pre>';
?>

<?php foreach($files as $key=>$image):?>
        <?php if(!is_dir($image)): ?>
            <img src="<?='/uploads/thumbnail/'.$image?>" />
        <?php endif;?>
<?php endforeach;?>