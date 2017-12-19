<?php

namespace app\controllers;

use app\models\Task;
use app\models\TaskSearch;
use yii\web\Controller;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        $model = new TaskSearch();
        $dataProvider = $model->search(\Yii::$app->request->queryParams);

        $modelLW = new TaskSearch();
        $dataProviderLW = $modelLW->searchLW(\Yii::$app->request->queryParams);

        $modelFailed = new TaskSearch();
        $dataProviderFailed = $modelFailed->searchFailed(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'modelLW' => $modelLW,
            'dataProviderLW' => $dataProviderLW,
            'modelFailed' => $modelFailed,
            'dataProviderFailed' => $dataProviderFailed
        ]);
    }
}