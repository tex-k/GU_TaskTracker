<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class UserSearch extends UserProfile {

    public function rules()
    {
        return [
            [['id', 'login', 'password', 'email', 'name', 'status'], 'safe']
        ];
    }

    public function search($params) {

        $query = UserProfile::find();

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
            'login' => $this->login,
            'password' => $this->password,
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status
        ]);

        return $dataProvider;
    }
}