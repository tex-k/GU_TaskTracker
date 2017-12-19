<?php

namespace app\controllers;

use app\models\UserProfile;
use Yii;
use app\models\Task;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($team_id)
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post())) {
            $model->fk_adm_id = UserProfile::find()->where(['status' => 'adm'])->one()->id;
            $model->fk_team_id = $team_id;
            $model->created_at = time();
            $model->deadline = time() + $model->deadline * 24 * 60 * 60 - date('h', time()) * 60 * 60 + date('i', time()) * 60 + date('s', time());
            $model->save();
            return $this->redirect(['..\teams\view?id=' . $team_id, 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'team_id' => $team_id
            ]);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
