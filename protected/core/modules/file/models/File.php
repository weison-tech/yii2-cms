<?php
namespace core\modules\file\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\base\Exception;
use yii\db\ActiveRecord;
use core\libs\MimeHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\components\behaviors\PolymorphicRelation;
use core\components\behaviors\GUID;
use core\modules\file\libs\ImageConverter;
use core\components\console\Application as ConsoleApp;

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $guid
 * @property string $file_name
 * @property string $title
 * @property string $mime_type
 * @property string $size
 * @property string $sort
 * @property string $object_model
 * @property integer $object_id
 * @property integer $object_field
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @package core\modules\file\models
 */

class File extends ActiveRecord
{

    // Configuration
    protected $folder_uploads = "file";

    /**
     * Uploaded File or File Content
     * @var UploadedFile
     */
    private $uploadedFile = null;

    /**
     * New content of the file
     * @var string
     */
    public $newFileContent = null;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * Returns all files belongs to a given Object.
     * @TODO Add caching
     * @param ActiveRecord $object
     * @return array of File instances
     */
    public static function getFilesOfObject(ActiveRecord $object)
    {
        return self::findAll(array('object_id' => $object->getPrimaryKey(), 'object_model' => $object->class));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(['created_by', 'updated_by', 'size'], 'integer'),
            array(['guid'], 'string', 'max' => 45),
            array(['mime_type'], 'string', 'max' => 150),
            array('filename', 'validateExtension'),
            array('filename', 'validateSize'),
            array(
                'mime_type',
                'match',
                'not' => true,
                'pattern' => '/[^a-zA-Z0-9\.ä\/\-]/',
                'message' => Yii::t('FileModule.models_File', 'Invalid Mime-Type')
            ),
            array(['file_name', 'title'], 'string', 'max' => 255),
            array(['created_at', 'updated_at'], 'safe'),
        );
    }

    /**
     * Behaviors of this model.
     * @return array
     */
    public function behaviors()
    {
        $behaviors  = [
            [
                'class' => GUID::class,
            ],
            [
                'class' => TimestampBehavior::class,
            ],
        ];

        //If in console application do not apply BlameableBehavior.
        if (!Yii::$app instanceof ConsoleApp) {
            $behaviors[] = [
                'class' => BlameableBehavior::class,
                'value' => Yii::$app->admin->getId() ?: Yii::$app->user->getId(),
            ];
        }
        return $behaviors;
    }

    /**
     * Set title before save.
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->sanitizeFilename();

        if ($this->title == "") {
            $this->title = $this->file_name;
        }

        return parent::beforeSave($insert);
    }

    /**
     * When delete the File model record
     * delete all the files belongs to it.
     * @return bool
     */
    public function beforeDelete()
    {
        $path = $this->getPath();

        //Make really sure, that we don't delete something else :-)
        if ($this->guid != "" && $this->folder_uploads != "" && is_dir($path)) {
            //Get all files.
            $files = glob($path . DIRECTORY_SEPARATOR . "*");
            foreach ($files as $file) {
                if (is_file($file)) {
                    //Delete file.
                    unlink($file);
                }
            }
            //Remove the folder.
            rmdir($path);
        }

        return parent::beforeDelete();
    }


    /**
     * After save model, save file.
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Set new uploaded file
        if ($this->uploadedFile !== null && $this->uploadedFile instanceof UploadedFile) {
            $newFilename = $this->getStoredFilePath() . '.' . $this->uploadedFile->extension;
            if (is_uploaded_file($this->uploadedFile->tempName)) {
                move_uploaded_file($this->uploadedFile->tempName, $newFilename);
                @chmod($newFilename, 0744);
            }

            /**
             * For uploaded jpeg files convert them again - to handle special
             * exif attributes (e.g. orientation)
             */
            if ($this->uploadedFile->type == 'image/jpeg') {
                ImageConverter::TransformToJpeg($newFilename, $newFilename);
            }
        }

        // Set file by given contents
        if ($this->newFileContent != null) {
            $newFilename = $this->getStoredFilePath();
            file_put_contents($newFilename, $this->newFileContent);
            @chmod($newFilename, 0744);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns the Path of the File
     */
    public function getPath()
    {
        $main_path = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR
            . "uploads" . DIRECTORY_SEPARATOR . $this->folder_uploads;
        if (!is_dir($main_path)) {
            mkdir($main_path);
        }

        $path = $main_path . DIRECTORY_SEPARATOR . $this->guid;
        if (!is_dir($path)) {
            mkdir($path);
        }

        return $path;
    }

    /**
     * Returns the Url of the File
     * @param string $suffix the sub folder.
     * @param boolean $absolute whether create absolute url.
     * @return string the url of file.
     */
    public function getUrl($suffix = "")
    {
        $file = $suffix ? $suffix : 'file';
        return '/uploads/file/' . $this->guid . '/' . $file . '.' . $this->getExtension();
    }

    /**
     * Returns the filename
     * @param string $suffix
     * @return string
     */
    public function getFilename($suffix = "")
    {
        // without prefix
        if ($suffix == "") {
            return $this->file_name;
        }

        $fileParts = pathinfo($this->file_name);

        return $fileParts['filename'] . "_" . $suffix . "." . $fileParts['extension'];
    }

    /**
     * Returns the filename without filename extension
     * @return string
     */
    public function getName()
    {
        $name = $this->file_name;
        $tmp = explode(".", $name);
        unset($tmp[count($tmp) - 1]);
        return implode(".", $tmp);
    }

    /**
     * Returns path and filename
     * @param string $suffix the suffix of this File stored in.
     * @return string storedFilePath.
     */
    public function getStoredFilePath($suffix = '')
    {
        $suffix = preg_replace("/[^a-z0-9_]/i", "", $suffix);
        $file = ($suffix == '') ? 'file' : $suffix;
        return $this->getPath() . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * @return string mime base type.
     */
    public function getMimeBaseType()
    {
        if ($this->mime_type != "") {
            list($baseType, $subType) = explode('/', $this->mime_type);
            return $baseType;
        }

        return "";
    }

    /**
     * @return string mime sub type.
     */
    public function getMimeSubType()
    {
        if ($this->mime_type != "") {
            list($baseType, $subType) = explode('/', $this->mime_type);
            return $subType;
        }

        return "";
    }

    /**
     * Get preview image url.
     * If preview image size not exist create if first.
     * @param int $maxWidth the preview maxWidth
     * @param int $maxHeight the preview maxHeight
     * @return string the preview url.
     */
    public function getPreviewImageUrl($maxWidth = 1000, $maxHeight = 1000)
    {
        $suffix = 'pi_' . $maxWidth . "x" . $maxHeight;

        //The origin file.
        $originalFilename = $this->getStoredFilePath() . '.' . $this->getExtension();

        //The resize file path
        $previewFilename = $this->getStoredFilePath($suffix) . '.' . $this->getExtension();

        // already generated

        if (is_file($previewFilename)) {
            return $this->getUrl($suffix);
        }

        // Check file exists & has valid mime type
        if ($this->getMimeBaseType() != "image" || !is_file($originalFilename)) {
            return "";
        }

        $imageInfo = @getimagesize($originalFilename);

        // Check if we got any dimensions - invalid image
        if (!isset($imageInfo[0]) || !isset($imageInfo[1])) {
            return "";
        }

        // Check if image type is supported
        if ($imageInfo[2] != IMAGETYPE_PNG && $imageInfo[2] != IMAGETYPE_JPEG && $imageInfo[2] != IMAGETYPE_GIF) {
            return "";
        }

        // Create the preview image.
        ImageConverter::Resize(
            $originalFilename,
            $previewFilename,
            array('mode' => 'max', 'width' => $maxWidth, 'height' => $maxHeight)
        );

        return $this->getUrl($suffix);
    }

    /**
     * Get origin file
     * @param string $suffix
     * @return string
     */
    public function getOriginImageUrl($suffix = 'file')
    {
        //The resize file path
        $previewFilename = $this->getStoredFilePath($suffix) . '.' . $this->getExtension();

        // already generated
        if (is_file($previewFilename)) {
            return $this->getUrl($suffix);
        }
        return "";
    }

    /**
     * Get the file extension.
     * @return string file extension name
     */
    public function getExtension()
    {
        $fileParts = pathinfo($this->file_name);
        if (isset($fileParts['extension'])) {
            return $fileParts['extension'];
        }
        return '';
    }

    /**
     * Set the UploadedFile information to File model.
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        $this->file_name = $uploadedFile->name;
        $this->mime_type = $uploadedFile->type;
        $this->size = $uploadedFile->size;
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * Sanitize the file name before save.
     */
    public function sanitizeFilename()
    {
        //Trim the file name.
        $this->file_name = trim($this->file_name);

        // Ensure max length
        $pathInfo = pathinfo($this->file_name);
        if (strlen($pathInfo['filename']) > 60) {
            $pathInfo['filename'] = substr($pathInfo['filename'], 0, 60);
        }

        $this->file_name = $pathInfo['filename'];

        if ($this->file_name == "") {
            $this->file_name = "Unnamed";
        }

        if (isset($pathInfo['extension'])) {
            $this->file_name .= "." . trim($pathInfo['extension']);
        }
    }

    /**
     * Validate extension
     * @param $attribute
     * @param $params
     */
    public function validateExtension($attribute, $params)
    {
        //Get the allow extension from setting.
        $allowedExtensions = Yii::$app->getModule('file')->settings->get('allowedExtensions');

        if ($allowedExtensions != "") {
            $extension = $this->getExtension();
            $extension = trim(strtolower($extension));

            $allowed = array_map(
                'trim',
                explode(",", Yii::$app->getModule('file')->settings->get('allowedExtensions'))
            );

            if (!in_array($extension, $allowed)) {
                $this->addError($attribute, Yii::t('FileModule.models_File', 'This file type is not allowed!'));
            }
        }
    }

    /**
     * Validate size.
     * @param $attribute
     * @param $params
     */
    public function validateSize($attribute, $params)
    {
        if ($this->size > Yii::$app->getModule('file')->settings->get('maxFileSize')) {
            $this->addError(
                $attribute,
                Yii::t(
                    'FileModule.models_File',
                    'Maximum file size ({maxFileSize}) has been exceeded!',
                    array("{maxFileSize}" => Yii::$app->formatter->asSize(Yii::$app->getModule('file')->settings->get('maxFileSize')))
                )
            );
        }

        // check if the file can be processed with php image manipulation tools in case it is an image
        if (
            isset($this->uploadedFile) &&
            in_array(
                $this->uploadedFile->type,
                [
                    image_type_to_mime_type(IMAGETYPE_PNG),
                    image_type_to_mime_type(IMAGETYPE_GIF),
                    image_type_to_mime_type(IMAGETYPE_JPEG)
                ]
            ) &&
            !ImageConverter::allocateMemory($this->uploadedFile->tempName, true)
        ) {
            $this->addError(
                $attribute,
                Yii::t(
                    'FileModule.models_File',
                    'Image dimensions are too big to be processed with current server memory limit!'
                )
            );
        }
    }

    /**
     * Attaches a given list of files to an record
     * This is used when uploading files before the record is created yet.
     * @param ActiveRecord $object is a ActiveRecord
     * @param string $files is a comma separated list of newly uploaded file guids
     * @param string $field the img field.
     * @param boolean $multiple whether the file is multiple to object.
     * @throws Exception
     */
    public static function attachPrecreated($object, $files, $field = 'img', $multiple = false)
    {
        if (!$object instanceof ActiveRecord) {
            throw new Exception('Invalid object given - require instance of \yii\db\ActiveRecord!');
        }

        $guids = explode(",", $files);

        if (!$multiple) {
            $old_files = File::find()->where([
                'object_model' => $object->class,
                'object_id' => $object->getPrimaryKey(),
                'object_field' => $field,
            ])->andWhere(['not in', 'guid', $guids])->all();
            if ($old_files) {
                foreach ($old_files as $of) {
                    $of->delete();
                }
            }
        }

        // Attach Files
        foreach ($guids as $fileGuid) {
            $file = self::findOne(['guid' => trim($fileGuid)]);
            if ($file != null && $file->object_model == "") {
                $file->object_model = $object->className();
                $file->object_id = $object->getPrimaryKey();
                $file->object_field = $field;
                if (!$file->save()) {
                    throw new Exception("Could not save pre created file!");
                }
            }
        }
    }

    /**
     * Get the file info array
     * @return array
     */
    public function getInfoArray()
    {
        $info = [];

        $info['error'] = false;
        $info['guid'] = $this->guid;
        $info['name'] = $this->file_name;
        $info['title'] = $this->title;
        $info['size'] = $this->size;
        $info['mimeIcon'] = MimeHelper::getMimeIconClassByExtension($this->getExtension());
        $info['mimeBaseType'] = $this->getMimeBaseType();
        $info['mimeSubType'] = $this->getMimeSubType();
        $info['url'] = $this->getUrl("", false);
        $info['thumbnailUrl'] = $this->getPreviewImageUrl(200, 200);

        return $info;
    }

}
