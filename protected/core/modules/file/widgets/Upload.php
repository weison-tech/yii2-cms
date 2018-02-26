<?php
namespace core\modules\file\widgets;

use yii\db\ActiveRecord;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\InputWidget;

/**
 * Class Upload
 * @package core\modules\file\widgets
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class Upload extends InputWidget
{
    /**
     * @var ActiveRecord|null The object witch this widget belongs to.
     */
    public $objectModel = null;

    /**
     * @var int|null The object's id witch this widget belongs to.
     */
    public $objectId = null;

    /**
     * @var
     */
    public $files;

    /**
     * @var array|\ArrayObject
     */
    public $url;

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var bool
     */
    public $showPreviewFilename = false;

    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * @var bool
     */
    public $sortable = false;

    /**
     * @var int min file size in bytes
     */
    public $minFileSize;

    /**
     * @var int
     */
    public $maxNumberOfFiles = 1;

    /**
     * @var int max file size in bytes
     */
    public $maxFileSize;

    /**
     * @var string regexp
     */
    public $acceptFileTypes;

    /**
     * @var bool preview image file or not in the upload box.
     */
    public $previewImage = true;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->maxNumberOfFiles > 1 || $this->multiple) {
            $this->multiple = true;
        }

        if ($this->hasModel()) {
            $this->name = $this->name ?: Html::getInputName($this->model, $this->attribute);
            $this->value = $this->value ?: Html::getAttributeValue($this->model, $this->attribute);
        }

        if (!array_key_exists('name', $this->clientOptions)) {
            $this->clientOptions['name'] = $this->name;
        }

        if ($this->multiple && $this->value && !is_array($this->value)) {
            throw new InvalidArgumentException('In "multiple" mode, value must be an array.');
        }

        if (!array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->getFileInputName();
        }

        if ($this->objectModel && $this->objectId) {
            $this->url['objectModel'] = $this->objectModel;
            $this->url['objectId'] = $this->objectId;
        }

        if (!$this->files && $this->value) {
            $this->files = $this->multiple ? $this->value : [$this->value];
        }

        $this->clientOptions = ArrayHelper::merge(
            [
                'url' => Url::to($this->url),
                'multiple' => $this->multiple,
                'sortable' => $this->sortable,
                'maxNumberOfFiles' => $this->maxNumberOfFiles,
                'maxFileSize' => $this->maxFileSize,
                'minFileSize' => $this->minFileSize,
                'acceptFileTypes' => $this->acceptFileTypes,
                'files' => $this->files,
                'previewImage' => $this->previewImage,
                'showPreviewFilename' => $this->showPreviewFilename,
                'messages' => [
                    'maxNumberOfFiles' => Yii::t('FileModule.widgets_base', 'Maximum number of files exceeded'),
                    'acceptFileTypes' => Yii::t('FileModule.widgets_base', 'File type not allowed'),
                    'maxFileSize' => Yii::t('FileModule.widgets_base', 'File is too large'),
                    'minFileSize' => Yii::t('FileModule.widgets_base', 'File is too small'),
                ]
            ],
            $this->clientOptions
        );
    }

    /**
     * @return string
     */
    public function getFileInputName()
    {
        return sprintf('_fileinput_%s', $this->id);
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $content = Html::beginTag('div');
        $content .= Html::hiddenInput($this->name, null, [
            'class' => 'empty-value',
            'id' => $this->options['id']
        ]);
        $content .= Html::fileInput($this->getFileInputName(), null, [
            'name' => $this->getFileInputName(),
            'id' => $this->getId(),
            'multiple' => $this->multiple
        ]);
        $content .= Html::endTag('div');
        return $content;
    }

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        UploadAsset::register($this->getView());
        $options = Json::encode($this->clientOptions);
        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }
        $this->getView()->registerJs("jQuery('#{$this->getId()}').yiiUploadKit({$options});");
    }
}
