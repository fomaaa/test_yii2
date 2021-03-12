<?php

namespace app\controllers;

use yii\web\Response;

class SiteController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionError()
    {
        \Yii::$app->response->statusCode = 404;

        return ['message', 'page not found'];
    }
}
