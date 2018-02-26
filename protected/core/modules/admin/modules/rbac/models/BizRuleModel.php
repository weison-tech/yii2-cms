<?php

namespace core\modules\admin\modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\rbac\Rule;

/**
 * Class BizRuleModel
 *
 * @package core\modules\admin\modules\rbac\models
 */
class BizRuleModel extends Model
{
    /**
     * @var string name of the rule
     */
    public $name;

    /**
     * @var int UNIX timestamp representing the rule creation time
     */
    public $createdAt;

    /**
     * @var int UNIX timestamp representing the rule updating time
     */
    public $updatedAt;

    /**
     * @var string Rule className
     */
    public $className;

    /**
     * @var \yii\rbac\ManagerInterface
     */
    protected $manager;

    /**
     * @var Rule
     */
    private $_item;

    /**
     * BizRuleModel constructor.
     *
     * @param \yii\rbac\Rule $item
     * @param array $config
     */
    public function __construct($item = null, $config = [])
    {
        $this->_item = $item;
        $this->manager = Yii::$app->authManager;

        if ($item !== null) {
            $this->name = $item->name;
            $this->className = get_class($item);
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'className'], 'trim'],
            [['name', 'className'], 'required'],
            ['className', 'string'],
            ['name', 'string', 'max' => 64],
            ['className', 'classExists'],
        ];
    }

    /**
     * Validate className
     */
    public function classExists()
    {
        if (!class_exists($this->className)) {
            $message = Yii::t('AdminModule.rbac_base', "Unknown class '{class}'", ['class' => $this->className]);
            $this->addError('className', $message);

            return;
        }

        if (!is_subclass_of($this->className, Rule::class)) {
            $message = Yii::t('AdminModule.rbac_base', "'{class}' must extend from 'yii\\rbac\\Rule' or its child class", [
                'class' => $this->className, ]);
            $this->addError('className', $message);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('AdminModule.rbac_base', 'Name'),
            'className' => Yii::t('AdminModule.rbac_base', 'Class Name'),
        ];
    }

    /**
     * Check if record is new
     *
     * @return bool
     */
    public function getIsNewRecord()
    {
        return $this->_item === null;
    }

    /**
     * Create object
     *
     * @param $id
     *
     * @return BizRuleModel|null
     */
    public static function find($id)
    {
        $item = Yii::$app->authManager->getRule($id);

        if ($item !== null) {
            return new static($item);
        }

        return null;
    }

    /**
     * Save rule
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $class = $this->className;
            if ($this->_item === null) {
                $this->_item = new $class();
                $isNew = true;
                $oldName = false;
            } else {
                $isNew = false;
                $oldName = $this->_item->name;
            }

            $this->_item->name = $this->name;

            if ($isNew) {
                $this->manager->add($this->_item);
            } else {
                $this->manager->update($oldName, $this->_item);
            }

            return true;
        }

        return false;
    }

    /**
     * @return null|Rule
     */
    public function getItem()
    {
        return $this->_item;
    }
}
