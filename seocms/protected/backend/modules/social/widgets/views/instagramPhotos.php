<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 26.05.14
 * Time: 17:15
 * @var $photos array
 * @var $this SocialPhotoWidget
 */?>
<h2>Instagram</h2>
<div id="photosinstagram">
   <?php $this->render('_instagramPhotos', array('photos'=>$photos))?>
</div>