<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Teams */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userName = \app\models\UserProfile::find()->one()->name;
$team_id = $model->id;
?>
<div class="teams-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]); ?>

    <?php
    if ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (\app\models\UserTeam::isCurrentUserInTeam($team_id))) {
        echo "<h3>Участники</h3>";

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'emptyText' => 'Нет записей',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'ID',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->id;
                    }
                ],
                [
                    'label' => 'Участники',
                    'format' => 'raw',
                    'value' => function ($data, $id) {
                        $records = \app\models\UserTeam::find()->all();
                        foreach ($records as $record):
                            if ($record->id == $id) {
                                $users = \app\models\UserProfile::find()->all();
                                foreach ($users as $user):
                                    if ($user->id == $record->fk_user_id) {
                                        return $user->login;
                                    }
                                endforeach;
                            }
                        endforeach;
                    }],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $data) use ($team_id) {
                            if (\app\models\UserProfile::getCurrentStatus() == 'adm') {
                                return Html::a('Удалить из команды', '\teams\delete-user?id=' . $data->id . '&team_id=' . $team_id);
                            } else {
                                return '';
                            }
                        }
                    ]
                ],
            ],
        ]);
        if (\app\models\UserProfile::getCurrentStatus() == 'adm') {
            echo Html::a('Добавить пользователя', ['view-users', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }

        echo "<h3>Задачи</h3>";

        echo \yii\grid\GridView::widget(
            [
                'dataProvider' => $dataProviderTask,
                'summary' => false,
                'emptyText' => 'Нет записей',
                'rowOptions' => function($data) {
                    if ($data->done == 'Не выполнено') {
                        return ['class' => 'danger'];
                    } elseif ($data->done == 'Выполнено') {
                        return ['style' => 'background-color: lightgreen'];
                    } else {
                        return '';
                    }
                },
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
                        'label' => 'Название',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->name;
                        }
                    ],
                    [
                        'label' => 'Исполнитель',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return \app\models\UserProfile::find()->where(['id' => $data->fk_user_id])->one()->login;
                        }
                    ],
                    [
                        'label' => 'Создана',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('d.m.y', $data->created_at);
                        }
                    ],
                    [
                        'label' => 'Выполнить до',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('d.m.y', $data->deadline);
                        }
                    ],
                    [
                        'label' => 'Результат',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return ($data->done != null) ? $data->done : '';
                        }
                    ],
                    [
                        'label' => 'Дата выполнения',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return ($data->done_at != null) ? date('d.m.y', $data->done_at) : '';
                        }
                    ],
                    [
                        'label' => 'Администратор',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return \app\models\UserProfile::find()->where(['id' => $data->fk_adm_id])->one()->login;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete} {view}',
                        'buttons' => [
                            'delete' => function ($url, $data) use ($team_id) {
                                if (\app\models\UserProfile::getCurrentStatus() == 'adm') {
                                    return Html::a('Удалить', '\teams\delete-task?id=' . $data->id . '&team_id=' . $team_id);
                                } else {
                                    return '';
                                }
                            },
                            'view' => function ($url, $data) use ($team_id) {
                                if ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (Yii::$app->user->id == $data->fk_user_id))
                                return Html::a('Просмотреть', '\teams\view-task?id=' . $data->id . '&team_id=' . $team_id);
                            }
                        ]
                    ]
                ]
            ]
        );
        if (\app\models\UserProfile::getCurrentStatus() == 'adm') {
            echo Html::a('Добавить задачу', ['..\task\create', 'team_id' => $model->id], ['class' => 'btn btn-primary']);
        }
    }
    ?>

</div>
