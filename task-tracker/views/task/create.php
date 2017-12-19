<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Новая задача';
$team_name = \app\models\Teams::find()->where(['id' => $team_id])->one()->name;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['..\teams']];
$this->params['breadcrumbs'][] = ['label' => $team_name, 'url' => ['..\teams\view', 'id' => $team_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'team_id' => $team_id
    ]) ?>

</div>
