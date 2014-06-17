<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chosen1
 * Date: 18.10.13
 * Time: 17:54
 * To change this template use File | Settings | File Templates.
 */

echo '<span class="icon-stack">'.CHtml::link('<i class="icon-twitter icon-dark icon-large"></i>','https://api.twitter.com/oauth/authenticate?oauth_token='.$oauthToken);
echo '</span>';
echo '<span class="icon-stack">'.CHtml::link('<i class="icon-facebook icon-dark icon-large"></i>','https://www.facebook.com/dialog/oauth?client_id=414721841962588&redirect_uri='.rawurlencode('http://twoends.home:81/backend/social/fbauth'));
echo '</span>';
echo '<span class="icon-stack">'.CHtml::link('<i class="icon-vk icon-dark icon-large"></i>','https://oauth.vk.com/authorize?client_id=3485057&scope=&redirect_uri='.rawurlencode('http://twoends.home:81/backend/social/vkauth').'&response_type=code&v=5.2');
echo '</span>';
echo '<span class="icon-stack">'.CHtml::link('<i class="icon-google-plus icon-dark icon-large"></i>','#');
echo '</span>';