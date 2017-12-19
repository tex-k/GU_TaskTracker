<?php

namespace app\controllers;

use yii\web\Controller;

class CacheController extends Controller {

    public function actionCache() {

        $cache = \Yii::$app->cache;
        $data = $cache->get('mytime');

        if ($data === false) {
            $data = time();
            $cache->set('mytime', $data, 30);
        }

        echo $data . '<br>';
    }
}