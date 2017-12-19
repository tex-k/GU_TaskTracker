<?php

use yii\helpers\Html;

$this->title = 'Выполнение задачи ' . $model->name;

?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>Описание</h3>
    <div style="margin-bottom: 20px;"><?= Html::encode($model->description) ?></div>
    <?= $this->render('execute_form', ['model' => $model]) ?>
</div>

