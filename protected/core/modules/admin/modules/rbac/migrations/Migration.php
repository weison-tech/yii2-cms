<?php

namespace core\modules\admin\modules\rbac\migrations;

use yii\base\Component;
use yii\base\InvalidParamException;
use yii\db\MigrationInterface;
use yii\di\Instance;
use yii\rbac\DbManager;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\rbac\Rule;

/**
 * Class Migration
 *
 * @package core\modules\admin\modules\rbac\migrations
 */
class Migration extends Component implements MigrationInterface
{
    /**
     * @var string|DbManager The auth manager component ID that this migration should work with
     */
    public $authManager = 'authManager';

    /**
     * Initializes the migration.
     * This method will set [[authManager]] to be the 'authManager' application component, if it is `null`.
     */
    public function init()
    {
        $this->authManager = Instance::ensure($this->authManager, DbManager::class);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $transaction = $this->authManager->db->beginTransaction();
        try {
            if ($this->safeUp() === false) {
                $transaction->rollBack();

                return false;
            }
            $transaction->commit();
            $this->authManager->invalidateCache();

            return true;
        } catch (\Exception $e) {
            echo "Rolling transaction back\n";
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $transaction = $this->authManager->db->beginTransaction();
        try {
            if ($this->safeDown() === false) {
                $transaction->rollBack();

                return false;
            }
            $transaction->commit();
            $this->authManager->invalidateCache();

            return true;
        } catch (\Exception $e) {
            echo "Rolling transaction back\n";
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            echo $e->getTraceAsString() . "\n";
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * This method contains the logic to be executed when applying this migration.
     *
     * @return bool return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds
     */
    public function safeUp()
    {
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     *
     * @return bool return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds
     */
    public function safeDown()
    {
    }

    /**
     * Creates new permission.
     *
     * @param  string $name The name of the permission
     * @param  string $description The description of the permission
     * @param  string|null $ruleName The rule associated with the permission
     * @param  mixed|null $data The additional data associated with the permission
     *
     * @return Permission
     */
    protected function createPermission($name, $description = '', $ruleName = null, $data = null)
    {
        echo "    > create permission $name ...";
        $time = microtime(true);
        $permission = $this->authManager->createPermission($name);
        $permission->description = $description;
        $permission->ruleName = $ruleName;
        $permission->data = $data;
        $this->authManager->add($permission);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $permission;
    }

    /**
     * Creates new role.
     *
     * @param  string $name The name of the role
     * @param  string $description The description of the role
     * @param  string|null $ruleName The rule associated with the role
     * @param  mixed|null $data The additional data associated with the role
     *
     * @return Role
     */
    protected function createRole($name, $description = '', $ruleName = null, $data = null)
    {
        echo "    > create role $name ...";
        $time = microtime(true);
        $role = $this->authManager->createRole($name);
        $role->description = $description;
        $role->ruleName = $ruleName;
        $role->data = $data;
        $this->authManager->add($role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $role;
    }

    /**
     * Creates new rule.
     *
     * @param  string $ruleName The name of the rule
     * @param  string|array $definition The class of the rule
     *
     * @return Rule
     */
    protected function createRule($ruleName, $definition)
    {
        echo "    > create rule $ruleName ...";
        $time = microtime(true);
        if (is_array($definition)) {
            $definition['name'] = $ruleName;
        } else {
            $definition = [
                'class' => $definition,
                'name' => $ruleName,
            ];
        }
        /** @var Rule $rule */
        $rule = \Yii::createObject($definition);
        $this->authManager->add($rule);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $rule;
    }

    /**
     * Finds either role or permission or throws an exception if it is not found.
     *
     * @param  string $name
     *
     * @return Permission|Role|null
     */
    protected function findItem($name)
    {
        $item = $this->authManager->getRole($name);
        if ($item instanceof Role) {
            return $item;
        }
        $item = $this->authManager->getPermission($name);
        if ($item instanceof Permission) {
            return $item;
        }

        return null;
    }

    /**
     * Finds the role or throws an exception if it is not found.
     *
     * @param  string $name
     *
     * @return Role|null
     */
    protected function findRole($name)
    {
        $role = $this->authManager->getRole($name);
        if ($role instanceof Role) {
            return $role;
        }

        return null;
    }

    /**
     * Finds the permission or throws an exception if it is not found.
     *
     * @param  string $name
     *
     * @return Permission|null
     */
    protected function findPermission($name)
    {
        $permission = $this->authManager->getPermission($name);
        if ($permission instanceof Permission) {
            return $permission;
        }

        return null;
    }

    /**
     * Adds child.
     *
     * @param Item|string $parent Either name or Item instance which is parent
     * @param Item|string $child Either name or Item instance which is child
     */
    protected function addChild($parent, $child)
    {
        if (is_string($parent)) {
            $parent = $this->findItem($parent);
        }
        if (is_string($child)) {
            $child = $this->findItem($child);
        }
        echo "    > adding $child->name as child to $parent->name ...";
        $time = microtime(true);
        $this->authManager->addChild($parent, $child);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Removes child.
     *
     * @param Item|string $parent Either name or Item instance which is parent
     * @param Item|string $child Either name or Item instance which is child
     */
    protected function removeChild($parent, $child)
    {
        if (is_string($parent)) {
            $parent = $this->findItem($parent);
        }
        if (is_string($child)) {
            $child = $this->findItem($child);
        }
        echo "    > removing $child->name from $parent->name ...";
        $time = microtime(true);
        $this->authManager->removeChild($parent, $child);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Assigns a role to a user.
     *
     * @param string|Role $role
     * @param string|int $userId
     */
    protected function assign($role, $userId)
    {
        if (is_string($role)) {
            $role = $this->findRole($role);
        }
        echo "    > assigning $role->name to user $userId ...";
        $time = microtime(true);
        $this->authManager->assign($role, $userId);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Updates role.
     *
     * @param  string|Role $role
     * @param  string $description
     * @param  string $ruleName
     * @param  mixed $data
     *
     * @return Role
     */
    protected function updateRole($role, $description = '', $ruleName = null, $data = null)
    {
        if (is_string($role)) {
            $role = $this->findRole($role);
        }
        echo "    > update role $role->name ...";
        $time = microtime(true);
        $role->description = $description;
        $role->ruleName = $ruleName;
        $role->data = $data;
        $this->authManager->update($role->name, $role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $role;
    }

    /**
     * Remove role.
     *
     * @param  string $name
     */
    protected function removeRole($name)
    {
        $role = $this->authManager->getRole($name);
        if (empty($role)) {
            throw new InvalidParamException("Role '{$role}' does not exists");
        }
        echo "    > removing role $role->name ...";
        $time = microtime(true);
        $this->authManager->remove($role);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Updates permission.
     *
     * @param  string|Permission $permission
     * @param  string $description
     * @param  string $ruleName
     * @param  mixed $data
     *
     * @return Permission
     */
    protected function updatePermission($permission, $description = '', $ruleName = null, $data = null)
    {
        if (is_string($permission)) {
            $permission = $this->findPermission($permission);
        }
        echo "    > update permission $permission->name ...";
        $time = microtime(true);
        $permission->description = $description;
        $permission->ruleName = $ruleName;
        $permission->data = $data;
        $this->authManager->update($permission->name, $permission);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $permission;
    }

    /**
     * Remove permission.
     *
     * @param  string $name
     */
    protected function removePermission($name)
    {
        $permission = $this->authManager->getPermission($name);
        if (empty($permission)) {
            throw new InvalidParamException("Permission '{$permission}' does not exists");
        }
        echo "    > removing permission $permission->name ...";
        $time = microtime(true);
        $this->authManager->remove($permission);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    /**
     * Updates rule.
     *
     * @param  string $ruleName
     * @param  string $className
     *
     * @return Rule
     */
    protected function updateRule($ruleName, $className)
    {
        echo "    > update rule $ruleName ...";
        $time = microtime(true);
        /** @var Rule $rule */
        $rule = \Yii::createObject([
            'class' => $className,
            'name' => $ruleName,
        ]);
        $this->authManager->update($ruleName, $rule);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";

        return $rule;
    }

    /**
     * Remove rule.
     *
     * @param  string $ruleName
     */
    protected function removeRule($ruleName)
    {
        $rule = $this->authManager->getRule($ruleName);
        if (empty($rule)) {
            throw new InvalidParamException("Rule '{$ruleName}' does not exists");
        }
        echo "    > removing rule $rule->name ...";
        $time = microtime(true);
        $this->authManager->remove($rule);
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }
}
