<?php

namespace core\modules\admin\modules\rbac\models\search;

use dosamigos\arrayquery\ArrayQuery;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

/**
 * Class BizRuleSearch
 *
 * @package core\modules\admin\modules\rbac\models\search
 */
class BizRuleSearch extends Model
{
    /**
     * @var string name of the rule
     */
    public $name;

    /**
     * @var int the default page size
     */
    public $pageSize = 25;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $query = new ArrayQuery(Yii::$app->authManager->getRules());

        if ($this->load($params) && $this->validate()) {
            $query->addCondition('name', $this->name ? "~{$this->name}" : null);
        }

        return new ArrayDataProvider([
            'allModels' => $query->find(),
            'sort' => [
                'attributes' => ['name'],
            ],
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);
    }
}
