<?php

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Новый пользователь'];
?>
<div>
    <h1>Новый пользователь</h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>