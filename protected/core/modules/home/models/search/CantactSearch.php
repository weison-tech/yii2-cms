<?php

namespace core\modules\home\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\modules\home\models\Contact;

/**
 * CantactSearch represents the model behind the search form about `core\modules\home\models\Contact`.
 */
class CantactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'status'], 'integer'],
            [['name', 'company', 'mobile', 'email', 'demand'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Contact::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //Exclude the soft deleted recorders.
        $query->andFilterWhere(['<>', 'status', self::STATUS_DELETED]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'demand', $this->demand]);

        return $dataProvider;
    }
}
