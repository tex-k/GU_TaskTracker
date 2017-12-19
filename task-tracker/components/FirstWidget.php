<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class FirstWidget extends Widget
{
    public $message;

    public function init() {
        parent::init();
        if ($this->message === null) {
            $this->message = 'First';
        }
    }

    public function run() {

        return '<h1>' . Html::encode($this->message) . '</h1>';
    }

}