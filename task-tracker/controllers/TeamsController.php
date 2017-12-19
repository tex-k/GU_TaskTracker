<?php

namespace app\controllers;

use app\models\Task;
use app\models\TaskSearch;
use app\models\User;
use app\models\UserProfile;
use app\models\UserSearch;
use app\models\UserTeam;
use app\models\UserTeamSearch;
use Yii;
use app\models\Teams;
use app\models\TeamsSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamsController implements the CRUD actions for Teams model.
 */
class TeamsController extends Controller
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
     * Lists all Teams models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teams model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new UserTeamSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $id);

        $searchModelTask = new TaskSearch();
        $dataProviderTask = $searchModelTask->search(\Yii::$app->request->queryParams, $id);

        $tasks = Task::find()->where(['fk_team_id' => $id])->all();

        foreach ($tasks as $task) {
            if (($task->deadline <= time()) && ($task->done == null)) {
                $task->done = 'Не выполнено';
                $task->save();
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelTask' => $searchModelTask,
            'dataProviderTask' => $dataProviderTask
        ]);
    }

    /**
     * Creates a new Teams model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teams();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Teams model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Teams model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDel($id)
    {
        $records = \app\models\UserTeam::find()->all();
        foreach ($records as $record):
            if ($record->fk_team_id == $id) {
                UserTeam::findOne($record->id)->delete();
            }
        endforeach;

        $records = Task::find()->all();
        foreach ($records as $record):
            if ($record->fk_team_id == $id) {
                Task::findOne($record->id)->delete();
            }
        endforeach;

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionViewUsers($id)
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('user', [
            'model' => $this->findModel($id),
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'team_id' => $id
        ]);
    }

    public function actionAddUser($id_user, $id_team)
    {
        $model = new UserTeam();
        $model->fk_team_id = $id_team;
        $model->fk_user_id = $id_user;
        $model->save();
        return Yii::$app->response->redirect(["/teams/view?id=$id_team"]);
    }

    public function actionDeleteUser($id, $team_id)
    {
        $tasks = Task::find()->where(['fk_user_id' => UserTeam::find()->where(['id' => $id])->one()->fk_user_id])->all();

        foreach ($tasks as $task) {
            $task->delete();
        }

        UserTeam::findOne($id)->delete();

        return $this->redirect(['view', 'id' => $team_id]);
    }

    /**
     * Finds the Teams model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teams the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDeleteTask($id, $team_id)
    {
        $this->findTask($id)->delete();

        return $this->redirect(['view', 'id' => $team_id]);
    }

    public function actionViewTask($id, $team_id) {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $team_id);

        return $this->render('task', [
            'model' => $this->findTask($id),
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExecute($id) {
        $model = new Task();
        $task = Task::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $task->report = $model->report;
            $task->done = 'Выполнено';
            $task->done_at = time();
            $task->save();
            return $this->redirect(['view', 'id' => $task->fk_team_id]);
        } else {
            return $this->render('execute', [
                'model' => $this->findTask($id)
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Teams::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findTask($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
