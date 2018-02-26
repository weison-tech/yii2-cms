<?php
namespace core\modules\file\actions;

use Yii;
use yii\web\UploadedFile;
use core\libs\Helpers;
use yii\db\ActiveRecord;

/**
 * Class UploadSimpleAction
 * @package core\modules\file\actions
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class UploadSimpleAction extends BaseAction
{
    /**
     * @return array
     * @throws \HttpException
     */
    public function run()
    {
        //Set return data format to json
        Yii::$app->response->format = 'json';

        // Object which the uploaded file(s) belongs to (optional)
        $object = null;
        $objectModel = Yii::$app->request->get('objectModel');
        $objectId = Yii::$app->request->get('objectId');
        if (
            $objectModel != "" &&
            $objectId != "" &&
            Helpers::CheckClassType($objectModel, ActiveRecord::class)
        ) {
            $object = $objectModel::findOne(['id' => $objectId]);
        }

        $files = array();
        foreach (UploadedFile::getInstancesByName('files') as $cFile) {
            $files[] = $this->handleFileUpload($cFile, $object);
        }

        return ['files' => $files];
    }
}
