<?php

use app\models\Teams;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$team_id = \app\models\Task::find()->where(['id' => $model->id])->one()->fk_team_id;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Teams::find()->where(['id' => $team_id])
    ->one()->name, 'url' => ['view', 'id' => $team_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'label' => 'Исполнитель',
            'format' => 'raw',
            'value' => function ($data) {
                return \app\models\UserProfile::find()->where(['id' => $data->fk_user_id])->one()->name;
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
        'description',
        [
            'label' => 'Отчёт',
            'format' => 'raw',
            'value' => function ($data) {
                return ($data->report != null) ? $data->report : '';
            }
        ],
        [
            'label' => 'Результат',
            'format' => 'raw',
            'options' => ['class' => 'danger'],
            'value' => function ($data) {
                return ($data->done == 'Не выполнено') ? "<span class='text-danger'>$data->done</span>" : "<span style='color: #00aa00' '>$data->done</span>";
            }
        ],
        [
            'label' => 'Дата выполнения',
            'format' => 'raw',
            'value' => function ($data) {
                return ($data->done_at != null) ? date('d.m.y', $data->done_at) : '';
            }
        ]
    ],
]);

if ((Yii::$app->user->id == $model->fk_user_id) && ($model->done == null)) {
    echo Html::a('Выполнить задачу', ['execute', 'id' => $model->id], ['class' => 'btn btn-primary']);
}
?>