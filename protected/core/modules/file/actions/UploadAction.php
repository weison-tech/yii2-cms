<?php
namespace core\modules\file\actions;

use Yii;
use yii\web\Response;
use yii\web\UploadedFile;
use core\libs\Helpers;
use yii\db\ActiveRecord;

/**
 * Class UploadAction
 * @package core\modules\file\actions
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class UploadAction extends BaseAction
{
    /**
     * @var string
     */
    public $fileparam = 'file';

    /**
     * @var bool
     */
    public $multiple = true;

    /**
     * @var bool
     */
    public $disableCsrf = true;

    /**
     * @var string
     */
    public $responseFormat = Response::FORMAT_JSON;

    /**
     * Init the return format, file param ...
     */
    public function init()
    {
        Yii::$app->response->format = $this->responseFormat;

        if (Yii::$app->request->get('fileparam')) {
            $this->fileparam = Yii::$app->request->get('fileparam');
        }

        if ($this->disableCsrf) {
            Yii::$app->request->enableCsrfValidation = false;
        }
    }

    /**
     * @return array
     * @throws \HttpException
     */
    public function run()
    {
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

        $result = array();
        foreach (UploadedFile::getInstancesByName($this->fileparam) as $cFile) {
            $result['files'][] = $this->handleFileUpload($cFile, $object);
        }

        return $this->multiple ? $result : array_shift($result);
    }
}
