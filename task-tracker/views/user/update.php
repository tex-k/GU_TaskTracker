<?php

$this->title = $model->login;
$this->params['breadcrumbs'][] = [
    'template' => "<li><a href='\user'>{link}</a></li>",
    'label' => 'Пользователи'
];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<div>
    <h1><?=$this->title?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>