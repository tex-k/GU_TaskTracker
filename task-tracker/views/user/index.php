<?php

use yii\helpers\Html;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (Yii::$app->user->isGuest)) ? Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) : '' ?>
    </p>

<?= \yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'summary' => false,
        'emptyText' => 'Нет записей',
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
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $data) {
                        if ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (Yii::$app->user->id == $data->id)) {
                            return Html::a('Просмотреть', '\user\view?id=' . $data->id);
                        } else {
                            return Html::a('', '' );
                        }
                    },
                    'update' => function ($url, $data) {
                        if ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (Yii::$app->user->id == $data->id)) {
                            return Html::a('Обновить', '\user\update?id=' . $data->id);
                        } else {
                            return Html::a('', '' );
                        }
                    },
                    'delete' => function ($url, $data) {
                        if ((\app\models\UserProfile::getCurrentStatus() == 'adm') || (Yii::$app->user->id == $data->id)) {
                            return Html::a('Удалить', '\user\delete?id=' . $data->id);
                        } else {
                            return Html::a('', '' );
                        }
                    }
                ]
            ]
        ]
    ]
); ?>