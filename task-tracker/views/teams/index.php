<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Команды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teams-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= (\app\models\UserProfile::getCurrentStatus() == 'adm') ? Html::a('Создать команду', ['create'], ['class' => 'btn btn-success']) : '' ?>
    </p>
    <?= GridView::widget([
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
                'label' => 'Название команды',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->name;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => (\app\models\UserProfile::getCurrentStatus() == 'adm') ? '{view} {update} {delete}' : '{view}',
                'buttons' => [
                    'view' => function ($url, $data) {
                        return Html::a('Просмотреть', '\teams\view?id=' . $data->id);
                    },
                    'update' => function ($url, $data) {
                        return Html::a('Обновить', '\teams\update?id=' . $data->id);
                    },
                    'delete' => function ($url, $data) {
                        return Html::a('Удалить', '\teams\del?id=' . $data->id);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
