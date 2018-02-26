<?php

namespace core\modules\admin\modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\rbac\Item;
use yii\rbac\Rule;

/**
 * Class AuthItemModel
 * This is the model class for table "AuthItem".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 * @property Item $item
 */
class AuthItemModel extends Model
{
    /**
     * @var string auth item name
     */
    public $name;

    /**
     * @var int auth item type
     */
    public $type;

    /**
     * @var string auth item description
     */
    public $description;

    /**
     * @var string biz rule name
     */
    public $ruleName;

    /**
     * @var null|string additional data
     */
    public $data;

    /**
     * @var \yii\rbac\ManagerInterface
     */
    protected $manager;

    /**
     * @var Item
     */
    private $_item;

    /**
     * AuthItemModel constructor.
     *
     * @param Item|null $item
     * @param array $config
     */
    public function __construct($item = null, $config = [])
    {
        $this->_item = $item;
        $this->manager = Yii::$app->authManager;

        if ($item !== null) {
            $this->name = $item->name;
            $this->type = $item->type;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : Json::encode($item->data);
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'data', 'ruleName'], 'trim'],
            [['name', 'type'], 'required'],
            ['ruleName', 'checkRule'],
            [['name'], 'checkUnique', 'when' => function () {
                return $this->isNewRecord || ($this->_item->name != $this->name);
            }],
            ['type', 'integer'],
            [['description', 'data', 'ruleName'], 'default'],
            ['name', 'string', 'max' => 64],
        ];
    }

    /**
     * Check role is unique
     */
    public function checkUnique()
    {
        $value = $this->name;
        if ($this->manager->getRole($value) !== null || $this->manager->getPermission($value) !== null) {
            $message = Yii::t('yii', '{attribute} "{value}" has already been taken.');
            $params = [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $value,
            ];
            $this->addError('name', Yii::$app->getI18n()->format($message, $params, Yii::$app->language));
        }
    }

    /**
     * Check for rule
     */
    public function checkRule()
    {
        $name = $this->ruleName;

        if (!$this->manager->getRule($name)) {
            try {
                $rule = Yii::createObject($name);
                if ($rule instanceof Rule) {
                    $rule->name = $name;
                    $this->manager->add($rule);
                } else {
                    $this->addError('ruleName', Yii::t('AdminModule.rbac_base', 'Invalid rule "{value}"', ['value' => $name]));
                }
            } catch (\Exception $exc) {
                $this->addError('ruleName', Yii::t('AdminModule.rbac_base', 'Rule "{value}" does not exists', ['value' => $name]));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('AdminModule.rbac_base', 'Name'),
            'type' => Yii::t('AdminModule.rbac_base', 'Type'),
            'description' => Yii::t('AdminModule.rbac_base', 'Description'),
            'ruleName' => Yii::t('AdminModule.rbac_base', 'Rule Name'),
            'data' => Yii::t('AdminModule.rbac_base', 'Data'),
        ];
    }

    /**
     * Check if is new record.
     *
     * @return bool
     */
    public function getIsNewRecord()
    {
        return $this->_item === null;
    }

    /**
     * Find role
     *
     * @param string $id
     *
     * @return null|\self
     */
    public static function find($id)
    {
        $item = Yii::$app->authManager->getRole($id);

        if ($item !== null) {
            return new self($item);
        }

        return null;
    }

    /**
     * Save role to [[\yii\rbac\authManager]]
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            if ($this->_item === null) {
                if ($this->type == Item::TYPE_ROLE) {
                    $this->_item = $this->manager->createRole($this->name);
                } else {
                    $this->_item = $this->manager->createPermission($this->name);
                }
                $isNew = true;
                $oldName = false;
            } else {
                $isNew = false;
                $oldName = $this->_item->name;
            }

            $this->_item->name = $this->name;
            $this->_item->description = $this->description;
            $this->_item->ruleName = $this->ruleName;
            $this->_item->data = Json::decode($this->data);

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
     * Add child to Item
     *
     * @param array $items
     *
     * @return int
     */
    public function addChildren($items)
    {
        if ($this->_item) {
            foreach ($items as $name) {
                $child = $this->manager->getPermission($name);
                if (empty($child) && $this->type == Item::TYPE_ROLE) {
                    $child = $this->manager->getRole($name);
                }
                $this->manager->addChild($this->_item, $child);
            }
        }

        return true;
    }

    /**
     * Remove child from an item
     *
     * @param array $items
     *
     * @return int
     */
    public function removeChildren($items)
    {
        if ($this->_item !== null) {
            foreach ($items as $name) {
                $child = $this->manager->getPermission($name);
                if (empty($child) && $this->type == Item::TYPE_ROLE) {
                    $child = $this->manager->getRole($name);
                }
                $this->manager->removeChild($this->_item, $child);
            }
        }

        return true;
    }

    /**
     * Get all available and assigned roles, permission and routes
     *
     * @return array
     */
    public function getItems()
    {
        $available = [];
        $assigned = [];

        if ($this->type == Item::TYPE_ROLE) {
            foreach (array_keys($this->manager->getRoles()) as $name) {
                $available[$name] = 'role';
            }
        }
        foreach (array_keys($this->manager->getPermissions()) as $name) {
            $available[$name] = $name[0] == '/' ? 'route' : 'permission';
        }

        foreach ($this->manager->getChildren($this->_item->name) as $item) {
            $assigned[$item->name] = $item->type == 1 ? 'role' : ($item->name[0] == '/' ? 'route' : 'permission');
            unset($available[$item->name]);
        }

        unset($available[$this->name]);

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }

    /**
     * @return null|Item
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     * Get type name
     *
     * @param mixed $type
     *
     * @return string|array
     */
    public static function getTypeName($type = null)
    {
        $result = [
            Item::TYPE_PERMISSION => 'Permission',
            Item::TYPE_ROLE => 'Role',
        ];

        if ($type === null) {
            return $result;
        }

        return $result[$type];
    }
}
