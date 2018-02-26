<?php if (count($files) != 0) : ?>
    <?php foreach ($files as $file) : ?>
        <?php if ($file->getMimeBaseType() == "image") : ?>
            <img id="<?php echo $showerId; ?>" src='<?php echo $file->getPreviewImageUrl($width, $height); ?>'>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
