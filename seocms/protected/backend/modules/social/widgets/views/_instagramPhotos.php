<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 26.05.14
 * Time: 17:30
 */
$data = $photos['data'];
foreach($data as $val): ?>
    <img src="<?=$val['images']['thumbnail']['url']?>"/>
<?php endforeach;
if(!empty($photos['pagination'])):?>
    <a class="instagram-more" href="<?=$photos['pagination']['next_url']?>">View more...</a>
<?php endif; ?>