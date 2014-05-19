<?php
/**
 * @var $this DefaultController
 * @var $model VK
 */
 $this->widget('application.backend.modules.social.widgets.SocialPhotoWidget', array(
    'provider'=>$_GET['auth'],
    'config'=>$this->module->config,
    'url'=>'/backend/social/default/photosFromAlbum'
));