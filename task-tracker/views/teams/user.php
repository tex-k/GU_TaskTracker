<?php

use yii\helpers\Html;

$this->title = 'Выбор пользователя ';
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Выбор пользователя';
$team_id = $model->id;
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php
echo \yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => '\yii\grid\SerialColumn'],
            [
                'label' => 'ID',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->id;
                }
            ],
            [
                'label' => 'Логин',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->login;
                }
            ],
            [
                'label' => 'Имя',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->name;
                }
            ],
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->status;
                }
            ],
            [
                'class' => '\yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url, $user) use($team_id) {
                        return Html::a('Добавить', ['add-user', 'id_user' => $user->id, 'id_team' => $team_id]);
                    }
                ]
            ]
        ]
    ]
); ?>