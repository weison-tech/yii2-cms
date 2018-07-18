<?php
use yii\helpers\Url;
?>
<a href="<?= Url::to(['/admin']) ?>" class="logo">
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    <?= $name ?>
</a>