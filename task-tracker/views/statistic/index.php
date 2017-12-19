<?php

use yii\helpers\Html;

$this->title = 'Страница статистики';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>
    <h3 style="margin-top: 30px;">Все задачи</h3>

<?= \yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
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
                'label' => 'Команда',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\Teams::find()->where(['id' => $data->fk_team_id])->one()->name;
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
                'label' => 'Администратор',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\UserProfile::find()->where(['id' => $data->fk_adm_id])->one()->login;
                }
            ],
            [
                'label' => 'Результат',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->done;
                }
            ],
        ]
    ]
) ?>

<h3 style="margin-top: 30px;">Задачи, закрытые за последнюю неделю</h3>
<?=\yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProviderLW,
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
                'label' => 'Команда',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\Teams::find()->where(['id' => $data->fk_team_id])->one()->name;
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
                'label' => 'Администратор',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\UserProfile::find()->where(['id' => $data->fk_adm_id])->one()->login;
                }
            ],
            [
                'label' => 'Результат',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->done;
                }
            ],
        ]
    ]
)?>

<h3 style="margin-top: 30px;">Просроченные задачи</h3>
<?=\yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProviderFailed,
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
                'label' => 'Команда',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\Teams::find()->where(['id' => $data->fk_team_id])->one()->name;
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
                'label' => 'Администратор',
                'format' => 'raw',
                'value' => function ($data) {
                    return \app\models\UserProfile::find()->where(['id' => $data->fk_adm_id])->one()->login;
                }
            ],
            [
                'label' => 'Результат',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->done;
                }
            ],
        ]
    ]
)?>
