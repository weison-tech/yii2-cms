<?php
namespace core\modules\file\actions;

use yii\db\ActiveRecord;
use yii\base\Action;
use yii\helpers\Url;
use core\libs\MimeHelper;
use core\modules\file\models\File;

/**
 * Class BaseAction
 * @package core\modules\file\actions
 * @author xiaomalover <xiaomalover@gmail.com>
 */
abstract class BaseAction extends Action
{
    /**
     * Handles a single upload by given UploadedFile and returns an array of information.
     *
     * The 'error' attribute of the array, indicates there was an error.
     * Information on error:
     *       - error: true
     *       - errorMessage: some message
     *       - name: name of the file
     *       - size: file size
     *
     * Information on success:
     *      - error: false
     *      - name: name of the uploaded file
     *      - size: file size
     *      - guid: of the file
     *      - url: url to the file
     *      - thumbnailUrl: url to the thumbnail if exists
     *
     * @param \yii\web\UploadedFile $cFile
     * @param ActiveRecord $object
     * @return array Information about the uploaded file
     */
    protected function handleFileUpload($cFile, ActiveRecord $object = null)
    {
        $output = array();

        $file = new File();
        //Set the UploadedFile information to File model.
        $file->setUploadedFile($cFile);

        //Set the object information to File model.
        if ($object != null) {
            $file->object_id = $object->getPrimaryKey();
            $file->object_model = $object->className();
        }

        //Validate and save File model.
        if ($file->validate() && $file->save()) {
            $output['error'] = false;
            $output['guid'] = $file->guid;
            $output['name'] = $file->file_name;
            $output['title'] = $file->title;
            $output['size'] = $file->size;
            $output['mimeIcon'] = MimeHelper::getMimeIconClassByExtension($file->getExtension());
            $output['mimeBaseType'] = $file->getMimeBaseType();
            $output['mimeSubType'] = $file->getMimeSubType();
            $output['url'] = $file->getUrl("");
            $output['thumbnailUrl'] = $file->getPreviewImageUrl(200, 200);
        } else {
            $output['error'] = true;
            $output['errors'] = $this->formatErrors($file->getErrors());
        }

        $output['name'] = $file->file_name;
        $output['size'] = $file->size;
        $output['deleteUrl'] = Url::to(['/file/file/delete', ['guid' => $file->guid]]);
        $output['deleteType'] = "";
        $output['thumbnailUrl'] = "";

        return $output;
    }

    /**
     * Convert error array to string
     * @param $errors
     * @return string
     */
    protected function formatErrors($errors)
    {
        $err_string = "";
        if (is_array($errors)) {
           foreach ($errors as $error) {
               $err_string .= $err_string ?  ";" . $error[0] : $error[0];
           }
        }
        return $err_string;
    }
}
