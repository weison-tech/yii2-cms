<?php

namespace core\modules\file\widgets;

use yii\base\Widget;

/**
 * FileUploadButtonWidget creates an upload button / system.
 *
 * The button uploads files and stores the uploaded file guids to a given hidden field id.
 * The underlying module can use the guids to adobt these files.
 *
 * The related widget FileUploadListWidget can optionally used to display states
 * of the current upload progress.
 * @package core\modules\file\widgets
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class FileUploadButton extends Widget
{

    /**
     * @var String unique id of this uploader
     */
    public $uploaderId = "";

    /**
     * Hidden field which stores uploaded file guids
     * @var string
     */
    public $fileListFieldName = '';

    /**
     * The ActiveRecord which the uploaded files belongs to.
     * Leave empty when object not exists yet.
     * @var \yii\db\ActiveRecord
     */
    public $object = null;


    public $multiple = false;

    /**
     * Draws the Upload Button output.
     */
    public function run()
    {
        $objectModel = "";
        $objectId = "";
        if ($this->object !== null) {
            $objectModel = $this->object->className();
            $objectId = $this->object->getPrimaryKey();
        }

        return $this->render('fileUploadButton', array(
            'fileListFieldName' => $this->fileListFieldName,
            'uploaderId' => $this->uploaderId,
            'objectModel' => $objectModel,
            'objectId' => $objectId,
            'multiple' => $this->multiple,
        ));
    }

}
