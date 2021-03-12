<?php

namespace app\controllers;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii;

abstract class AbstractApiController extends \yii\web\Controller
{
    private $user;
    private $token;

    public function behaviors()
    {
       return [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'currencies' => ['get'],
                    'currency'   => ['get'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'GET,DELETE,HEAD,OPTIONS,POST,PUT');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', '*');
            Yii::$app->response->statusCode = 204;
            Yii::$app->end();
        } else {
            \Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return parent::beforeAction($action);
    }

    protected function response($statusCode, $data)
    {
        $this->setStatusCode($statusCode);

        return $data;
    }

    protected function responseError($statusCode, $message)
    {
        $this->setStatusCode($statusCode);
        Yii::$app->response->data = ['message' => $message];

        return;
    }

    private function setStatusCode($statusCode)
    {
        Yii::$app->response->statusCode = $statusCode;
    }
}
