<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class UserTeamSearch extends UserTeam{

    public function rules()
    {
        return [
            [['id', 'fk_team_id', 'fk_user_id'], 'safe']
        ];
    }

    public function search($params, $team_id) {

        $query = UserTeam::find();

        $dataProvider = new ActiveDataProvider (
            [
                'query' => $query
            ]
        );

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fk_team_id' => $team_id,
            'fk_user_id' => $this->fk_user_id,
        ]);

        return $dataProvider;
    }
}