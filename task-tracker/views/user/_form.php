<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($model, 'login')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'name')->textInput() ?>
<?= ((\app\models\UserProfile::find()->where(['status' => 'adm'])->one() == null)
    || (\app\models\UserProfile::find()->where(['id' => $model->id])->one()->status == 'adm'))
    ? $form->field($model, 'status')->dropDownList(['base' => 'base', 'adm' => 'adm'])
    : $form->field($model, 'status')->dropDownList(['base' => 'base'])?>

<?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Добавление записи' : 'Редактирование записи') ?>

<?php \yii\widgets\ActiveForm::end(); ?>
