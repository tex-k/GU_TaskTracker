<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_team_id', 'fk_user_id', 'created_at', 'deadline', 'done_at', 'fk_adm_id'], 'integer'],
            [['name', 'description', 'report', 'done'], 'safe'],
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
    public function search($params, $team_id = null)
    {
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_team_id' => $team_id,
            'fk_user_id' => $this->fk_user_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }

    public function searchLW($params)
    {
        $query = Task::find()->where('done_at > ' . (time() - 7 * 24 * 60 * 60), ['done' => 'Выполнено']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_user_id' => $this->fk_user_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }

    public function searchFailed($params)
    {
        $query = Task::find()->where( ['done' => 'Не выполнено']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_user_id' => $this->fk_user_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
