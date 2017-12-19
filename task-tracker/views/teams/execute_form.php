<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>

<?= $form->field($model, 'report')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton('Выполнить', ['class' => 'btn btn-success', 'id' => $model->id]) ?>
    </div>
<?php ActiveForm::end(); ?>