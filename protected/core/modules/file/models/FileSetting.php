<?php
namespace core\modules\file\models;

use Yii;
use yii\base\Model;

/**
 * Class FileSetting
 * @package core\modules\file\models
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class FileSetting extends Model
{
    /**
     * @var int the upload max file size
     */
    public $max_file_size;

    /**
     * @var string, allowed file extensions, separate by comma
     */
    public $allowed_extensions;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_file_size', 'allowed_extensions'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $settingsManager = Yii::$app->getModule('file')->settings;

        $this->max_file_size = $settingsManager->get('maxFileSize') / 1024 / 1024;
        $this->allowed_extensions = $settingsManager->get('allowedExtensions');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'max_file_size' => Yii::t('FileModule.models_FileSetting', 'Max file size'),
            'allowed_extensions' => Yii::t('FileModule.models_FileSetting', 'Allowed extensions'),
        ];
    }

    /**
     * Saves the form
     * @return boolean
     */
    public function save()
    {
        $settingsManager = Yii::$app->getModule('file')->settings;
        $settingsManager->set('maxFileSize', $this->max_file_size * 1024 * 1024);
        $settingsManager->set('allowedExtensions', strtolower($this->allowed_extensions));

        return true;
    }
}
