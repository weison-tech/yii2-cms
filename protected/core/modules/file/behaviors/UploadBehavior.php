<?php
namespace core\modules\file\behaviors;

use yii\helpers\Url;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use core\modules\file\models\File;

/**
 * Class UploadBehavior
 * @package core\modules\file\behaviors
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class UploadBehavior extends Behavior
{
    /**
     * @var string Model attribute that contain uploaded file information
     * or array of files information
     */
    public $attribute = 'file';

    /**
     * @var bool whether or not multiple files.
     */
    public $multiple = false;

    /**
     * Bind Event handles to ActiveRecord Event
     * @return array
     */
    public function events()
    {
        $multipleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindMultiple',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertMultiple',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateMultiple',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        $singleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindSingle',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertSingle',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateSingle',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        return $this->multiple ? $multipleEvents : $singleEvents;
    }


    /**
     * Save file relation when create new model record.
     * @return void
     */
    public function afterInsertSingle()
    {
        $this->afterUpdateSingle();
    }

    /**
     * Save all files relations when create new model record.
     * @return void
     */
    public function afterInsertMultiple()
    {
        $this->afterUpdateMultiple();
    }

    /**
     * Save all files relations when update model record.
     */
    public function afterUpdateMultiple()
    {
        $new_files = $this->owner->{$this->attribute};
        if ($new_files) {
            $guids = ArrayHelper::getColumn($new_files, 'guid');

            //Find all old file
            $field = $this->attribute;
            $object_id = $this->owner->getPrimaryKey();
            $object_model = $this->owner->className();

            $files = File::find()->where([
                'object_id' => $object_id,
                'object_model' => $object_model,
                'object_field' => $field
            ])->all();

            $oldGuids = [];
            if ($files) {
                foreach ($files as $of) {
                    if (!in_array($of->guid, $guids)) {
                        //Delete old files that not contain in guids
                        $of->delete();
                    } else {
                        //Update the order.
                        foreach($new_files as $n) {
                            if ($of->guid == $n['guid'] && $of->sort != $n['order']) {
                                $of->sort = $n['order'] ?: 0;
                                $of->save();
                            }
                        }
                    }
                    $oldGuids[] = $of->guid;
                }
            }

            //Add new file not save before.
            foreach ($new_files as $n) {
                if (!in_array($n['guid'], $oldGuids)) {
                    $f = File::find()->where(['guid' => $n['guid']])->one();
                    $f->object_model = $object_model;
                    $f->object_id = $object_id;
                    $f->object_field = $field;
                    $f->sort = $n['order'] ?: 0;
                    $f->save();
                }
            }
        }
    }

    /**
     * Save single file relation when after update model record.
     * @return void
     */
    public function afterUpdateSingle()
    {
        //Find old file
        $field = $this->attribute;
        $object_id = $this->owner->getPrimaryKey();
        $object_model = $this->owner->className();

        $file = File::find()->where([
            'object_id' => $object_id,
            'object_model' => $object_model,
            'object_field' => $field
        ])->one();

        $new_files = $this->owner->{$this->attribute};
        if ($file) {
            if ($new_files) {
                if ($file->guid != $new_files['guid']) {
                    $file->guid = $new_files['guid'];
                    $file->save();
                }
            } else {
                $file->delete();
            }
        } else {
            if ($new_files) {
                $f = File::find()->where(['guid' => $new_files['guid']])->one();
                $f->object_model = $object_model;
                $f->object_id = $object_id;
                $f->object_field = $field;
                $f->sort = 0;
                $f->save();
            }
        }
    }

    /**
     * If the model record deleted, delete all it's files.
     * @return void
     */
    public function afterDelete()
    {
        $field = $this->attribute;
        $object_id = $this->owner->getPrimaryKey();
        $object_model = $this->owner->className();

        $files = File::find()->where([
            'object_id' => $object_id,
            'object_model' => $object_model,
            'object_field' => $field
        ])->all();

        foreach ($files as $file) {
            $file->delete();
        }
    }

    /**
     * Return all files to frontend.
     * @return void
     */
    public function afterFindMultiple()
    {
        $field = $this->attribute;
        $object_id = $this->owner->getPrimaryKey();
        $object_model = $this->owner->className();

        $files = File::find()->where([
            'object_id' => $object_id,
            'object_model' => $object_model,
            'object_field' => $field
        ])->all();

        $results = array();
        if ($files) {
            foreach ($files as $file) {
                $results[] = $this->prepareData($file);
            }

            $this->owner->{$this->attribute} = $results;
        }
    }

    /**
     * Overwrite the parent Behavior to ignore the base_url attribute.
     * @return void
     */
    public function afterFindSingle()
    {
        $field = $this->attribute;
        $object_id = $this->owner->getPrimaryKey();
        $object_model = $this->owner->className();

        $file = File::find()->where([
            'object_id' => $object_id,
            'object_model' => $object_model,
            'object_field' => $field
        ])->one();

        if ($file) {
            $data = $this->prepareData($file);
            $this->owner->{$this->attribute} = $data;
        }
    }

    /**
     * Prepare the data return to frontend.
     * @param $file
     * @return mixed
     */
    public function prepareData($file)
    {
        $result['deleteType'] = '';
        $result['deleteUrl'] = Url::to(['/file/file/delete', ['guid' => $file->guid]]);
        $result['error'] = false;
        $result['guid'] = $file->guid;
        $result['mimeBaseType'] = '';
        $result['mimeIcon'] = '';
        $result['mimeSubType'] = '';
        $result['name'] = '';
        $result['size'] = '';
        $result['thumbnailUrl'] = '';
        $result['title'] = '';
        $result['url'] = $file->getPreviewImageUrl(200, 200);

        if ($this->multiple) {
            $result['order'] = $file->sort ?: 0;
        }

        return $result;
    }
}
