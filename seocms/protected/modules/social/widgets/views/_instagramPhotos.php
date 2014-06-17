<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 26.05.14
 * Time: 17:30
 */
?>

    <?php $data = $photos['data'];
    foreach($data as $val): ?>
        <a class="image-wrap">
            <img src="<?=$val['images']['thumbnail']['url']?>" data-original="<?=$val['images']['standard_resolution']['url']?>"/>
            <div class="add-photo">+<span>добавить</span></div>
        </a>
    <?php endforeach;
    if(!empty($photos['pagination'])):?>
        <a class="instagram-more" href="<?=$photos['pagination']['next_url']?>">View more...</a>
    <?php endif; ?>

<script>
   $('.image-wrap').draggable({
       cursor: "move",
       scroll: false,
       helper: "clone",
       containment: ".content"
   });
</script>