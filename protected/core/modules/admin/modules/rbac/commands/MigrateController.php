<?php

namespace core\modules\admin\modules\rbac\commands;

use yii\console\controllers\BaseMigrateController;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\Console;

/**
 * Class MigrateController
 *
 * @package core\modules\admin\modules\rbac\commands
 *
 * Below are some common usages of this command:
 *
 * ```
 * # creates a new migration named 'create_rule'
 * yii rbac/migrate/create create_rule
 *
 * # applies ALL new migrations
 * yii rbac/migrate
 *
 * # reverts the last applied migration
 * yii rbac/migrate/down
 * ```
 */
class MigrateController extends BaseMigrateController
{
    /**
     * @var Connection The database connection
     */
    public $db = 'db';

    /**
     * @inheritdoc
     */
    public $migrationTable = '{{%auth_migration}}';

    /**
     * @inheritdoc
     */
    public $migrationPath = '@app/rbac/migrations';

    /**
     * @inheritdoc
     */
    public $templateFile = '@vendor/yii2mod/yii2-rbac/views/migration.php';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Instance::ensure($this->db, Connection::class);
        parent::init();
    }

    /**
     * @return array|string|Connection
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @inheritdoc
     */
    protected function getMigrationHistory($limit)
    {
        if ($this->db->schema->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationHistoryTable();
        }

        $history = (new Query())
            ->select(['apply_time'])
            ->from($this->migrationTable)
            ->orderBy(['apply_time' => SORT_DESC, 'version' => SORT_DESC])
            ->limit($limit)
            ->indexBy('version')
            ->column($this->db);

        unset($history[self::BASE_MIGRATION]);

        return $history;
    }

    /**
     * @inheritdoc
     */
    protected function addMigrationHistory($version)
    {
        $this->db->createCommand()->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
        ])->execute();
    }

    /**
     * @inheritdoc
     */
    protected function removeMigrationHistory($version)
    {
        $this->db->createCommand()->delete($this->migrationTable, [
            'version' => $version,
        ])->execute();
    }

    /**
     * Creates the migration history table.
     */
    protected function createMigrationHistoryTable()
    {
        $tableName = $this->db->schema->getRawTableName($this->migrationTable);

        $this->stdout("Creating migration history table \"$tableName\"...", Console::FG_YELLOW);

        $this->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'VARCHAR(180) NOT NULL PRIMARY KEY',
            'apply_time' => 'INTEGER',
        ])->execute();

        $this->db->createCommand()->insert($this->migrationTable, [
            'version' => self::BASE_MIGRATION,
            'apply_time' => time(),
        ])->execute();

        $this->stdout("Done.\n", Console::FG_GREEN);
    }
}
