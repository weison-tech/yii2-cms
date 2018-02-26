<?php
namespace core\modules\file\widgets;

/**
 * This widget is used show files
 * Class ShowFiles
 * @package core\modules\file\widgets
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class ShowFiles extends \yii\base\Widget
{

    /**
     * Object to show files from
     */
    public $object = null;

    /**
     * @var string show widget id, use in single mode to hide old files.
     */
    public $showerId;

    /**
     * @var int the width
     */
    public $width = 30;

    /**
     * @var int the height
     */
    public $height = 30;

    /**
     * Executes the widget.
     */
    public function run()
    {
        if ($this->object != null) {
            $files = \core\modules\file\models\File::getFilesOfObject($this->object);
            return $this->render('showFiles', array('files' => $files,
                'width' => $this->width,
                'height' => $this->height,
                'showerId' => $this->showerId,
            ));
        }
    }
}
