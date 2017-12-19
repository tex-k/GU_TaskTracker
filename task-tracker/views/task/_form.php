<?php

use app\models\UserProfile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

function getUser($team_id)   {
    $users = [];
    $records = \app\models\UserTeam::find()->all();
    foreach ($records as $record):
        if ($record->fk_team_id == $team_id) {
            $allUsers = \app\models\UserProfile::find()->all();
            foreach ($allUsers as $user):
                if ($user->id == $record->fk_user_id) {
                    array_push($users, $user);
                }
            endforeach;
        }
    endforeach;
    return $users;
}

function day() {
    $dates = [];
    $date = '';
    $yearNow = date('y', time());
    $monthNow = date('m', time());
    $dayNow = date('d', time());
    $year = $yearNow;
    $month = $monthNow;
    $day = $dayNow;

    for ($y = 0; $y < 2; $y++) {
        $year = $yearNow + $y;
        for ($m = 0; $m < (12 - $monthNow + 1); $m++) {
            $month = $monthNow + $m;
            for ($d = 0; $d < (daysInMonth($month) - $dayNow + 1); $d++) {
                $day = $dayNow + $d;
                $date = $day . '.' . $month . '.' . $year;
                array_push($dates, $date);
            }
            $dayNow = 1;
        }
        $monthNow = 1;
    }

    return $dates;
}

function daysInMonth($month) {
    if (($month == 1) || ($month == 3) || ($month == 5) || ($month == 7) || ($month == 8) || ($month == 10) ||($month == 12)) {
        return 31;
    } elseif ($month == 2) {
        return 28;
    } else {
        return 30;
    }
}
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fk_user_id')->dropDownList(ArrayHelper::map(getUser($team_id), 'id', 'name'))  ?>

    <?= $form->field($model, 'deadline')->dropDownList(day()) ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success', 'team_id' => $team_id]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
