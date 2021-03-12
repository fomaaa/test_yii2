<?php

namespace app\controllers;

use app\models\Currency;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use yii\filters\VerbFilter;

/**
 * @OA\Info(title="test API", version="1.0")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class ApiController extends AbstractApiController
{
    const PAGE_SIZE = 10;

    /**
     * @OA\Get(
     *   tags={"Currencies"},
     *   path="/currencies",
     *   summary="Возвращать список курсов валют с пагинацией",
     *   security={{"bearerAuth":{}}},
     * @OA\Parameter(
     *   name="page",
     *   description="Пагинация страниц",
     *   @OA\Schema(
     *     type="integer"
     *   ),
     *   in="query",
     *   required=false
     * ),
     *   @OA\Response(
     *       response="200",
     *       description="Successful operation"
     *   ),
     *   @OA\Response(
     *       response="404",
     *       description="Currencies not found"
     *   )
     * )
     */
    public function actionCurrencies()
    {
        $page = (int) (\Yii::$app->request->get('page', 0) - 1) * self::PAGE_SIZE;
        $currencies = Currency::find()->limit(self::PAGE_SIZE)->offset($page)->all();

        if (!$currencies) return $this->responseError('404', 'currency not found');

        $response = [
            'currencies' => $currencies,
            'total' => (int) Currency::find()->count(),
            'pageSize' => (int) self::PAGE_SIZE
        ];

        return $this->response('200', $response);
    }

    /**
     * @OA\Get(
     *   tags={"Currencies"},
     *   path="/currency/{id}",
     *   summary="Возвращает курс валюты для переданного id",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     description="ID",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *       response="200",
     *       description="Successful operation"
     *   ),
     *   @OA\Response(
     *       response="404",
     *       description="Currency not found"
     *   )
     * )
     */
    public function actionCurrency($id)
    {
        $currency = Currency::findOne($id);

        if (!$currency) return $this->responseError('404', 'currency not found');

        return $this->response('200', $currency->rate);
    }

}
