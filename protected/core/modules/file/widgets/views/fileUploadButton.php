<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsVar('fileuploader_error_modal_title',
    Yii::t('FileModule.widgets_FileUploadButtonWidget', '<strong>Upload</strong> error'));
$this->registerJsVar('fileuploader_error_modal_btn_close',
    Yii::t('FileModule.widgets_FileUploadButtonWidget', 'Close'));
$this->registerJsVar('fileuploader_error_modal_errormsg',
    Yii::t('FileModule.widgets_FileUploadButtonWidget', 'Could not upload File:'));
?>

<?php echo Html::hiddenInput(
        'fileUploaderHiddenGuidField[' . $uploaderId. ']', '',
        array('id' => "fileUploaderHiddenField_" . $uploaderId)
); ?>

<style>
    .fileinput-button {
        position: relative;
        overflow: hidden;
    }

    .fileinput-button input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        transform: translate(-300px, 0) scale(4);
        font-size: 23px;
        direction: ltr;
        cursor: pointer;
    }
</style>

<img src="" id="showImg_<?= $uploaderId ?>" style="width: 30px; height: 30px; display: none;"/>

<span class="btn btn-info fileinput-button tt" data-toggle="tooltip" data-placement="bottom" title="">
    <i class="fa fa-cloud-upload"></i>

    <input id="fileUploaderButton_<?php echo $uploaderId; ?>" type="file" name="files[]"
       data-url="<?php echo Url::to([
           '/file/file/upload-simple',
           'objectModel' => $objectModel,
           'objectId' => $objectId
       ]); ?>"
       <?= $multiple ? 'multiple' : '' ?>
    >
</span>

<script src="/static/js/fileuploader.js"></script>
<script>
    $(function () {
        'use strict';
        installUploader("<?php echo $uploaderId; ?>", "<?php echo $multiple; ?>");
    })

</script>
