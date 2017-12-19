<?php

namespace app\controllers;

use app\models\Task;
use app\models\UserProfile;
use app\models\UserSearch;
use app\models\UserTeam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller {

    public function actionIndex() {

        $model = new UserSearch();
        $dataProvider = $model->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate() {

        $model = new UserProfile();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionView($id) {

        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id) {

        $records = \app\models\UserTeam::find()->all();
        foreach ($records as $record):
            if ($record->fk_user_id == $id) {
                UserTeam::findOne($record->id)->delete();
            }
        endforeach;

        $records = Task::find()->all();
        foreach ($records as $record):
            if ($record->fk_user_id == $id) {
                Task::findOne($record->id)->delete();
            }
        endforeach;

        $this->findModel($id)->delete();

        return $this->redirect('index');
    }

    protected function findModel($id) {

        if (($model = UserProfile::findOne($id)) != null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Страница не существует');
        }
    }
}