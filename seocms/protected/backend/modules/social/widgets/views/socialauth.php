<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.03.14
 * Time: 14:21
 */

echo 'This is social widget: <hr />';

echo '<p>
    <a href="' . $socialArray['instagram']['authUrl'] . '?' . urldecode(http_build_query($socialArray['instagram']['auth'])) . '">
        <i class="fa fa-instagram fa-2x"></i>
    </a>';
echo '<a href="' . $socialArray['vk']['authUrl'] . '?' . urldecode(http_build_query($socialArray['vk']['auth'])) . '">
        <i class="fa fa-vk fa-2x"></i>
    </a>';
echo '<a href="' . $socialArray['fb']['authUrl'] . '?' . urldecode(http_build_query($socialArray['fb']['auth'])) . '">
        <i class="fa fa-facebook fa-2x"></i>
    </a>';
echo '<a href="' . $socialArray['google']['authUrl'] . '?' . urldecode(http_build_query($socialArray['google']['auth'])) . '">
        <i class="fa fa-google-plus fa-2x"></i>
    </a>
    </p>';