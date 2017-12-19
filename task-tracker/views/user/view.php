<?php

$this->title = $model->login;
$this->params['breadcrumbs'][] = [
    'template' => "<li><a href='\user'>{link}</a></li>",
    'label' => 'Пользователи'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title?></h1>

<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'login',
        'password',
        'email:email',
        'status'
    ]
]); ?>